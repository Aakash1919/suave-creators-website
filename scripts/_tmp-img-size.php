<?php

$files = [
    'public/assets/case-studies/ai-sales-coaching/ai_sales_coach.webp',
    'public/assets/case-studies/ai-sales-coaching/ai_sales_left.webp',
    'public/assets/case-studies/ai-sales-coaching/ai_sales_right.webp',
    'public/assets/case-studies/suave-crm-outreach/outreach-before-after-hero.png',
    'public/assets/case-studies/suave-crm-outreach/outreach_left.webp',
    'public/assets/case-studies/suave-crm-outreach/outreach_right.webp',
];

foreach ($files as $f) {
    if (! file_exists($f)) {
        echo $f." MISSING\n";
        continue;
    }
    $info = @getimagesize($f);
    echo $f.' '.($info ? $info[0].'x'.$info[1].' '.$info['mime'] : 'NO SIZE').' '.filesize($f)." bytes\n";
}
