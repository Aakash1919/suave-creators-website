import sharp from 'sharp';
import fs from 'fs';
import path from 'path';

const TARGET_MIN = 80 * 1024;
const TARGET_MAX = 90 * 1024;

sharp.cache(false);
sharp.concurrency(1);

async function compressToWebp(inputPath, outputPath) {
  const absIn = path.resolve(inputPath);
  const absOut = path.resolve(outputPath);
  const original = fs.readFileSync(absIn);
  const meta = await sharp(original, { limitInputPixels: false, pages: 1 }).metadata();

  let lo = 40;
  let hi = 95;
  let best = null;
  let bestQuality = null;
  let bestWidth = meta.width;

  const encode = async (buf, width, quality) => {
    let pipeline = sharp(buf, { limitInputPixels: false, pages: 1 });
    if (width && width < meta.width) {
      pipeline = pipeline.resize({ width, withoutEnlargement: true });
    }
    return pipeline.webp({ quality, effort: 6 }).toBuffer();
  };

  for (let i = 0; i < 14; i++) {
    const q = Math.round((lo + hi) / 2);
    const buf = await encode(original, null, q);
    console.log(`  q=${q} -> ${(buf.length / 1024).toFixed(1)} KB`);
    if (buf.length <= TARGET_MAX) {
      best = buf;
      bestQuality = q;
      lo = q + 1;
    } else {
      hi = q - 1;
    }
  }

  if (!best || best.length > TARGET_MAX) {
    let scale = 0.95;
    while (scale >= 0.5) {
      const w = Math.round(meta.width * scale);
      for (let q = 90; q >= 40; q -= 5) {
        const buf = await encode(original, w, q);
        console.log(`  resize ${Math.round(scale * 100)}% q=${q} -> ${(buf.length / 1024).toFixed(1)} KB`);
        if (buf.length <= TARGET_MAX) {
          best = buf;
          bestQuality = q;
          bestWidth = w;
          if (buf.length >= TARGET_MIN) {
            fs.writeFileSync(absOut, best);
            return { size: best.length, quality: bestQuality, width: bestWidth };
          }
          break;
        }
      }
      if (best && best.length <= TARGET_MAX && best.length >= TARGET_MIN) break;
      scale -= 0.05;
    }
  }

  if (!best) {
    throw new Error(`Could not compress ${inputPath} under ${TARGET_MAX} bytes`);
  }

  fs.writeFileSync(absOut, best);
  return { size: best.length, quality: bestQuality, width: bestWidth };
}

const jobs = [
  'public/assets/case-studies/turbo-trans/ttc_caseStudy.webp',
  'public/assets/media/it-solutions-banner.webp',
  'public/assets/media/ecommerce-banner.webp',
];

console.log('=== compress webp ===');
for (const file of jobs) {
  const bak = file + '.bak';
  if (!fs.existsSync(bak)) fs.copyFileSync(file, bak);
  const before = fs.statSync(bak).size;
  console.log(`\n${file} (${(before / 1024).toFixed(1)} KB)`);
  const result = await compressToWebp(bak, file);
  console.log(
    `  DONE ${(result.size / 1024).toFixed(1)} KB @ q=${result.quality}` +
      (result.width ? ` w=${result.width}` : '')
  );
}

const gif = 'public/assets/product/hero_banner.gif';
const gifBak = gif + '.bak';
const gifWebp = 'public/assets/product/hero_banner.webp';
if (!fs.existsSync(gifBak)) fs.copyFileSync(gif, gifBak);

console.log(`\n${gif} (${(fs.statSync(gifBak).size / 1024).toFixed(1)} KB) -> static webp (first frame)`);
const gifMeta = await sharp(gifBak, { limitInputPixels: false, pages: 1 }).metadata();
console.log(`  first frame ${gifMeta.width}x${gifMeta.height}`);
const gifResult = await compressToWebp(gifBak, gifWebp);
console.log(
  `  DONE ${(gifResult.size / 1024).toFixed(1)} KB @ q=${gifResult.quality}` +
    (gifResult.width ? ` w=${gifResult.width}` : '')
);

console.log('\n=== final ===');
for (const f of [...jobs, gifWebp]) {
  console.log(`${f}: ${(fs.statSync(f).size / 1024).toFixed(1)} KB`);
}
