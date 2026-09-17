import sharp from 'sharp';
import fs from 'fs';
import path from 'path';

const TARGET_MIN = 80 * 1024;
const TARGET_MAX = 90 * 1024;

sharp.cache(false);
sharp.concurrency(1);

async function encode(buf, meta, width, quality, effort = 4) {
  let p = sharp(buf, { limitInputPixels: false, pages: 1 });
  if (width && width < meta.width) {
    p = p.resize({ width, withoutEnlargement: true, kernel: 'lanczos3' });
  }
  return p.webp({ quality, effort, smartSubsample: true }).toBuffer();
}

/** Highest quality that fits under TARGET_MAX at this width. */
async function maxQualityUnderCap(buf, meta, width) {
  let lo = 35;
  let hi = 95;
  let best = null;
  while (lo <= hi) {
    const q = Math.round((lo + hi) / 2);
    const out = await encode(buf, meta, width, q, 4);
    if (out.length <= TARGET_MAX) {
      best = { buf: out, quality: q, width, size: out.length };
      lo = q + 1;
    } else {
      hi = q - 1;
    }
  }
  return best;
}

async function bestInRange(inputPath, outputPath) {
  const original = fs.readFileSync(inputPath);
  const meta = await sharp(original, { limitInputPixels: false, pages: 1 }).metadata();
  let best = null;

  const consider = (cand) => {
    if (!cand || cand.size > TARGET_MAX) return;
    const inBand = cand.size >= TARGET_MIN ? 1 : 0;
    // Prefer in-band, then higher quality, then larger width
    const score = inBand * 1e12 + cand.quality * 1e6 + cand.width;
    if (!best || score > best.score) {
      best = { ...cand, score };
    }
  };

  // Coarse widths: full, then step down. Favor quality over pixels.
  const widths = new Set([meta.width]);
  for (let pct = 96; pct >= 50; pct -= 4) {
    widths.add(Math.round(meta.width * (pct / 100)));
  }

  for (const w of [...widths].sort((a, b) => b - a)) {
    const cand = await maxQualityUnderCap(original, meta, w);
    if (!cand) {
      process.stdout.write(`  w=${w} — still over cap at q=35\n`);
      continue;
    }
    process.stdout.write(
      `  w=${w} q=${cand.quality} -> ${(cand.size / 1024).toFixed(1)} KB\n`
    );
    consider(cand);
    // Early exit: if we already have high quality in-band (>=88), stop
    if (best && best.size >= TARGET_MIN && best.quality >= 88) break;
  }

  if (!best) throw new Error('Could not compress ' + inputPath);

  // Final encode at effort 6 for slightly better compression at same q/size target
  let final = await encode(original, meta, best.width, best.quality, 6);
  if (final.length > TARGET_MAX) {
    // nudge quality down until under cap
    for (let q = best.quality - 1; q >= 35; q--) {
      final = await encode(original, meta, best.width, q, 6);
      if (final.length <= TARGET_MAX) {
        best = { ...best, buf: final, quality: q, size: final.length };
        break;
      }
    }
  } else if (final.length < TARGET_MIN) {
    // try bump quality up while staying <= max
    let last = final;
    let lastQ = best.quality;
    for (let q = best.quality + 1; q <= 95; q++) {
      const bumped = await encode(original, meta, best.width, q, 6);
      if (bumped.length > TARGET_MAX) break;
      last = bumped;
      lastQ = q;
      if (bumped.length >= TARGET_MIN) break;
    }
    best = { ...best, buf: last, quality: lastQ, size: last.length };
  } else {
    best = { ...best, buf: final, size: final.length };
  }

  fs.writeFileSync(outputPath, best.buf);
  return best;
}

const jobs = [
  'public/assets/case-studies/ai-sales-coaching/ai_sales_right.webp',
  'public/assets/case-studies/ai-sales-coaching/ai-sales-left.webp',
  'public/assets/case-studies/ai-sales-coaching/ai-sales-coach.webp',
  'public/assets/case-studies/suave-crm-outreach/outreach-before-after-hero.webp',
  'public/assets/case-studies/suave-crm-tasks/the-suave-app-task-banner.webp',
];

console.log('=== compress webp to 80-90 KB (quality-first) ===');
for (const file of jobs) {
  const abs = path.resolve(file);
  if (!fs.existsSync(abs)) {
    console.error(`MISSING ${file}`);
    continue;
  }
  const bak = file + '.bak';
  // Always compress from original backup if present
  if (!fs.existsSync(bak)) fs.copyFileSync(file, bak);
  const before = fs.statSync(bak).size;
  const meta = await sharp(bak, { limitInputPixels: false, pages: 1 }).metadata();
  console.log(`\n${file}`);
  console.log(`  before ${(before / 1024).toFixed(1)} KB ${meta.width}x${meta.height}`);
  const result = await bestInRange(bak, file);
  console.log(
    `  DONE ${(result.size / 1024).toFixed(1)} KB @ q=${result.quality} w=${result.width}`
  );
}
