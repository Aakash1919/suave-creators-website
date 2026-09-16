import sharp from 'sharp';
import fs from 'fs';

const TARGET_MIN = 80 * 1024;
const TARGET_MAX = 90 * 1024;

sharp.cache(false);

async function bestInRange(inputPath, outputPath) {
  const original = fs.readFileSync(inputPath);
  const meta = await sharp(original, { limitInputPixels: false, pages: 1 }).metadata();
  let best = null;

  const tryEncode = async (width, quality) => {
    let p = sharp(original, { limitInputPixels: false, pages: 1 });
    if (width < meta.width) p = p.resize({ width, withoutEnlargement: true });
    return p.webp({ quality, effort: 6, smartSubsample: true }).toBuffer();
  };

  // Prefer larger dimensions + higher quality within target band
  const scales = [];
  for (let s = 100; s >= 55; s -= 2) scales.push(s / 100);

  for (const scale of scales) {
    const w = Math.round(meta.width * scale);
    for (let q = 95; q >= 50; q -= 1) {
      const buf = await tryEncode(w, q);
      if (buf.length >= TARGET_MIN && buf.length <= TARGET_MAX) {
        if (!best || q > best.quality || (q === best.quality && w > best.width)) {
          best = { buf, quality: q, width: w, size: buf.length };
        }
        break; // higher q at this width won't fit; next lower q only smaller
      }
      if (buf.length < TARGET_MIN) {
        // too small — higher quality already tried; move to larger scale/next
        break;
      }
    }
    if (best && best.width >= w) {
      // found at this or larger width; keep searching larger widths first so first hits are best
    }
  }

  // First pass above prefers high scale; re-walk collecting the best quality among in-range
  best = null;
  for (const scale of scales) {
    const w = Math.round(meta.width * scale);
    for (let q = 95; q >= 45; q -= 1) {
      const buf = await tryEncode(w, q);
      if (buf.length >= TARGET_MIN && buf.length <= TARGET_MAX) {
        const score = q * 10000 + w; // prioritize quality, then resolution
        if (!best || score > best.score) {
          best = { buf, quality: q, width: w, size: buf.length, score };
        }
        break;
      }
    }
  }

  if (!best) {
    // fallback: closest under max with highest q
    for (const scale of scales) {
      const w = Math.round(meta.width * scale);
      for (let q = 95; q >= 35; q -= 1) {
        const buf = await tryEncode(w, q);
        if (buf.length <= TARGET_MAX) {
          const score = q * 10000 + w;
          if (!best || score > best.score) {
            best = { buf, quality: q, width: w, size: buf.length, score };
          }
          break;
        }
      }
    }
  }

  if (!best) throw new Error('no encode for ' + inputPath);
  fs.writeFileSync(outputPath, best.buf);
  console.log(
    `${outputPath}: ${(best.size / 1024).toFixed(1)} KB q=${best.quality} ${best.width}x~`
  );
  return best;
}

await bestInRange(
  'public/assets/case-studies/turbo-trans/ttc_caseStudy.webp.bak',
  'public/assets/case-studies/turbo-trans/ttc_caseStudy.webp'
);
await bestInRange(
  'public/assets/media/ecommerce-banner.webp.bak',
  'public/assets/media/ecommerce-banner.webp'
);

// hero: try near-lossless / high quality to approach 80KB if possible
{
  const original = fs.readFileSync('public/assets/product/hero_banner.gif.bak');
  let best = null;
  for (let q = 100; q >= 80; q--) {
    const buf = await sharp(original, { limitInputPixels: false, pages: 1 })
      .webp({ quality: q, effort: 6, nearLossless: q === 100 })
      .toBuffer();
    console.log(`hero q=${q} near=${q === 100} -> ${(buf.length / 1024).toFixed(1)} KB`);
    if (buf.length <= TARGET_MAX) {
      best = { buf, quality: q, size: buf.length };
      if (buf.length >= TARGET_MIN) break;
    }
  }
  // Also try lossless
  const lossless = await sharp(original, { limitInputPixels: false, pages: 1 })
    .webp({ lossless: true, effort: 6 })
    .toBuffer();
  console.log(`hero lossless -> ${(lossless.length / 1024).toFixed(1)} KB`);
  if (lossless.length <= TARGET_MAX && (!best || lossless.length > best.size)) {
    best = { buf: lossless, quality: 'lossless', size: lossless.length };
  }
  if (best) {
    fs.writeFileSync('public/assets/product/hero_banner.webp', best.buf);
    console.log(`hero DONE ${(best.size / 1024).toFixed(1)} KB @ ${best.quality}`);
  }
}
