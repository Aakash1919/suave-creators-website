const fs = require('fs');
const path = '.cursor/skills/suave-frontend/SKILL.md';
let c = fs.readFileSync(path, 'utf8');
const needle = 'projects uses `layout=showcase`';
if (!c.includes(needle)) {
  const alt = 'projects `#projects` uses `layout: showcase`';
  console.log(c.includes(alt) ? 'already updated' : 'NOT FOUND');
  process.exit(c.includes(alt) ? 0 : 1);
}
const old =
  'projects uses `layout=showcase`; team and HR (`#team-hr`) uses `layout=cards` (4 pastel stacked cards, no side visual); other modules use panel visual';
const neu =
  'projects `#projects` uses `layout: showcase` — four media cards with top image/`product-module__showcase-image-placeholder` when `items[].image` is empty, floating icon badge, title + copy, no side visual; set each `items[].image` under `assets/product/` when screenshots land; team and HR (`#team-hr`) uses `layout=cards` (4 pastel stacked cards, no side visual); other modules use panel visual';
fs.writeFileSync(path, c.replace(old, neu));
console.log('updated');
