import os
import math
from PIL import Image, ImageDraw, ImageFont, ImageFilter

def get_font(size, bold=False, semibold=False):
    if bold:
        candidates = ['C:/Windows/Fonts/segoeuib.ttf', 'C:/Windows/Fonts/arialbd.ttf']
    elif semibold:
        candidates = ['C:/Windows/Fonts/segoeuisb.ttf', 'C:/Windows/Fonts/segoeuib.ttf', 'C:/Windows/Fonts/arialbd.ttf']
    else:
        candidates = ['C:/Windows/Fonts/segoeui.ttf', 'C:/Windows/Fonts/arial.ttf']
    
    for c in candidates:
        if os.path.exists(c):
            return ImageFont.truetype(c, size)
    return ImageFont.load_default()

def draw_pill_badge(draw, x, y, text, font, bg_color, text_color, px=14, py=6):
    bbox = font.getbbox(text)
    tw = bbox[2] - bbox[0]
    th = bbox[3] - bbox[1]
    box = [x, y, x + tw + px * 2, y + th + py * 2]
    radius = (box[3] - box[1]) // 2
    draw.rounded_rectangle(box, radius=radius, fill=bg_color)
    draw.text((x + px - bbox[0], y + py - bbox[1]), text, font=font, fill=text_color)
    return box

def draw_check_icon(draw, x, y, size=16, color=(52, 211, 153, 255), width=3):
    # draws a clean checkmark at (x, y)
    p1 = (x, y + size * 0.5)
    p2 = (x + size * 0.35, y + size * 0.85)
    p3 = (x + size, y + size * 0.15)
    draw.line([p1, p2], fill=color, width=width)
    draw.line([p2, p3], fill=color, width=width)

def draw_trend_arrow(draw, x, y, size=14, color=(52, 211, 153, 255), width=3):
    # draws an up-right arrow ↗
    p1 = (x, y + size)
    p2 = (x + size, y)
    draw.line([p1, p2], fill=color, width=width)
    draw.line([(x + size * 0.4, y), p2], fill=color, width=width)
    draw.line([(x + size, y + size * 0.6), p2], fill=color, width=width)

def draw_progress_bar(draw, x, y, w, h, percent, fill_color, bg_color=(20, 30, 50, 255)):
    draw.rounded_rectangle([x, y, x + w, y + h], radius=h//2, fill=bg_color)
    fill_w = max(h, int(w * (percent / 100.0)))
    draw.rounded_rectangle([x, y, x + fill_w, y + h], radius=h//2, fill=fill_color)


# -------------------------------------------------------------
# 1. Turbo Trans Corporation
# -------------------------------------------------------------
def gen_turbo_trans():
    out_dir = 'public/assets/case-studies/turbo-trans'
    os.makedirs(out_dir, exist_ok=True)
    
    # 1. Photo Tile: 400x440
    W, H = 400, 440
    img = Image.new('RGBA', (W, H), (11, 17, 32, 255))
    draw = ImageDraw.Draw(img)
    draw.rounded_rectangle([10, 10, W-10, H-10], radius=24, fill=(15, 23, 42, 255), outline=(30, 41, 59, 255), width=2)
    
    draw_pill_badge(draw, 30, 30, "DISPATCH ACTIVE", get_font(13, bold=True), (16, 185, 129, 45), (52, 211, 153, 255), px=12, py=5)
    draw_pill_badge(draw, 260, 30, "ON TRACK", get_font(13, bold=True), (59, 130, 246, 45), (96, 165, 250, 255), px=12, py=5)
    
    draw.text((30, 75), "Shipment #TR-9482", font=get_font(26, bold=True), fill=(248, 250, 252, 255))
    draw.text((30, 112), "Chicago, USA  →  Rotterdam, NL", font=get_font(17, semibold=True), fill=(148, 163, 184, 255))
    
    draw.rounded_rectangle([30, 150, W-30, 275], radius=18, fill=(8, 13, 27, 255), outline=(30, 41, 59, 255), width=1)
    draw.line([(70, 205), (W-70, 205)], fill=(59, 130, 246, 255), width=4)
    draw.ellipse([60, 195, 80, 215], fill=(59, 130, 246, 255), outline=(255, 255, 255, 255), width=3)
    draw.ellipse([180, 195, 200, 215], fill=(168, 85, 247, 255), outline=(255, 255, 255, 255), width=3)
    draw.ellipse([W-80, 195, W-60, 215], fill=(52, 211, 153, 255), outline=(255, 255, 255, 255), width=3)
    
    draw.text((56, 168), "ORD", font=get_font(15, bold=True), fill=(226, 232, 240, 255))
    draw.text((155, 168), "Air Freight", font=get_font(14, bold=True), fill=(192, 132, 252, 255))
    draw.text((W-84, 168), "RTM", font=get_font(15, bold=True), fill=(226, 232, 240, 255))
    
    draw.text((50, 235), "Dept: 08:30 AM", font=get_font(14, semibold=True), fill=(148, 163, 184, 255))
    draw.text((W-160, 235), "ETA: 18:45 PM", font=get_font(14, bold=True), fill=(52, 211, 153, 255))
    
    draw.rounded_rectangle([30, 295, W-30, 410], radius=18, fill=(19, 29, 53, 255), outline=(37, 51, 77, 255), width=1)
    draw.text((50, 315), "3.4x Faster", font=get_font(32, bold=True), fill=(52, 211, 153, 255))
    draw.text((50, 360), "Lead Response & Dispatch Flow", font=get_font(16, semibold=True), fill=(226, 232, 240, 255))
    
    img.convert('RGB').save(os.path.join(out_dir, 'turbo-trans-dispatch-fleet-tile.webp'), 'WEBP', quality=95)
    
    # 2. Chart Tile: 410x330
    W_c, H_c = 410, 330
    img_c = Image.new('RGBA', (W_c, H_c), (11, 17, 32, 255))
    draw_c = ImageDraw.Draw(img_c)
    draw_c.rounded_rectangle([10, 10, W_c-10, H_c-10], radius=24, fill=(15, 23, 42, 255), outline=(30, 41, 59, 255), width=2)
    
    draw_c.text((32, 32), "Pipeline Visibility", font=get_font(26, bold=True), fill=(248, 250, 252, 255))
    draw_c.text((32, 70), "Real-time fleet tracking & dispatch rate", font=get_font(15, semibold=True), fill=(148, 163, 184, 255))
    
    draw_c.text((32, 120), "Fleet On-Time Rate", font=get_font(16, semibold=True), fill=(226, 232, 240, 255))
    draw_c.text((W_c-75, 120), "98%", font=get_font(17, bold=True), fill=(52, 211, 153, 255))
    draw_progress_bar(draw_c, 32, 150, W_c-64, 18, 98, (52, 211, 153, 255))
    
    draw_c.text((32, 205), "Automated Dispatch", font=get_font(16, semibold=True), fill=(226, 232, 240, 255))
    draw_c.text((W_c-75, 205), "92%", font=get_font(17, bold=True), fill=(96, 165, 250, 255))
    draw_progress_bar(draw_c, 32, 235, W_c-64, 18, 92, (59, 130, 246, 255))
    
    img_c.convert('RGB').save(os.path.join(out_dir, 'turbo-trans-pipeline-chart-tile.webp'), 'WEBP', quality=95)
    print("Turbo Trans generated.")


# -------------------------------------------------------------
# 2. AI Sales Coaching Platform
# -------------------------------------------------------------
def gen_ai_sales_coaching():
    out_dir = 'public/assets/case-studies/ai-sales-coaching'
    os.makedirs(out_dir, exist_ok=True)
    
    # 1. Photo Tile: 400x440
    W, H = 400, 440
    img = Image.new('RGBA', (W, H), (11, 17, 32, 255))
    draw = ImageDraw.Draw(img)
    draw.rounded_rectangle([10, 10, W-10, H-10], radius=24, fill=(15, 23, 42, 255), outline=(30, 41, 59, 255), width=2)
    
    draw_pill_badge(draw, 30, 30, "AI SIMULATION", get_font(13, bold=True), (168, 85, 247, 45), (192, 132, 252, 255), px=12, py=5)
    draw_pill_badge(draw, 270, 30, "● LIVE", get_font(13, bold=True), (16, 185, 129, 45), (52, 211, 153, 255), px=12, py=5)
    
    raw_right_path = 'public/assets/case-studies/ai-sales-coaching/ai_sales_right.webp'
    if os.path.exists(raw_right_path):
        im_raw = Image.open(raw_right_path)
        crop_bot = im_raw.crop((750, 260, 1130, 640))
        crop_bot_resized = crop_bot.resize((150, 150), Image.Resampling.LANCZOS)
        
        mask = Image.new('L', (150, 150), 0)
        mask_draw = ImageDraw.Draw(mask)
        mask_draw.ellipse((0, 0, 150, 150), fill=255)
        
        draw.ellipse([W//2 - 82, 85 - 7, W//2 + 82, 85 + 157], fill=(30, 27, 75, 255), outline=(139, 92, 246, 180), width=3)
        img.paste(crop_bot_resized, (W//2 - 75, 85), mask)
    
    draw.rounded_rectangle([30, 255, W-30, 380], radius=18, fill=(19, 29, 53, 255), outline=(37, 51, 77, 255), width=1)
    draw.text((48, 272), "\"How does this boost our win rate?\"", font=get_font(17, bold=True), fill=(248, 250, 252, 255))
    
    wave_x = 48
    wave_y = 330
    draw.text((wave_x, wave_y - 20), "Live Voice Analysis", font=get_font(13, semibold=True), fill=(148, 163, 184, 255))
    
    bar_heights = [8, 14, 22, 12, 28, 34, 18, 26, 38, 24, 16, 30, 36, 20, 14, 22, 10]
    for i, bh in enumerate(bar_heights):
        bx = wave_x + i * 18
        draw.rounded_rectangle([bx, wave_y + 16 - bh//2, bx + 6, wave_y + 16 + bh//2], radius=3, fill=(168, 85, 247, 255))
    
    draw.text((30, 400), "Objection Handling Scored in Real-Time", font=get_font(14, semibold=True), fill=(148, 163, 184, 255))
    
    img.convert('RGB').save(os.path.join(out_dir, 'ai-sales-coach-live-practice-tile.webp'), 'WEBP', quality=95)
    
    # 2. Chart Tile: 410x330
    W_c, H_c = 410, 330
    img_c = Image.new('RGBA', (W_c, H_c), (11, 17, 32, 255))
    draw_c = ImageDraw.Draw(img_c)
    draw_c.rounded_rectangle([10, 10, W_c-10, H_c-10], radius=24, fill=(15, 23, 42, 255), outline=(30, 41, 59, 255), width=2)
    
    draw_c.text((32, 30), "Team Performance Score", font=get_font(20, semibold=True), fill=(148, 163, 184, 255))
    draw_c.text((32, 65), "88", font=get_font(56, bold=True), fill=(248, 250, 252, 255))
    draw_c.text((115, 88), "/ 100", font=get_font(24, bold=True), fill=(100, 116, 139, 255))
    
    # Badge with custom drawn up-right arrow
    badge_box = draw_pill_badge(draw_c, 240, 78, "    +28% Boost", get_font(16, bold=True), (16, 185, 129, 45), (52, 211, 153, 255), px=14, py=6)
    draw_trend_arrow(draw_c, 250, 88, size=12, color=(52, 211, 153, 255), width=2)
    
    draw_c.text((32, 170), "Practice Completion", font=get_font(16, semibold=True), fill=(226, 232, 240, 255))
    draw_c.text((W_c-75, 170), "94%", font=get_font(17, bold=True), fill=(192, 132, 252, 255))
    draw_progress_bar(draw_c, 32, 200, W_c-64, 18, 94, (168, 85, 247, 255))
    
    draw_c.text((32, 250), "Call Pitch Alignment", font=get_font(16, semibold=True), fill=(226, 232, 240, 255))
    draw_c.text((W_c-75, 250), "91%", font=get_font(17, bold=True), fill=(52, 211, 153, 255))
    draw_progress_bar(draw_c, 32, 280, W_c-64, 18, 91, (52, 211, 153, 255))
    
    img_c.convert('RGB').save(os.path.join(out_dir, 'ai-sales-coach-score-chart-tile.webp'), 'WEBP', quality=95)
    print("AI Sales Coach generated.")


# -------------------------------------------------------------
# 3. Suave CRM - Outreach
# -------------------------------------------------------------
def gen_outreach():
    out_dir = 'public/assets/case-studies/suave-crm-outreach'
    os.makedirs(out_dir, exist_ok=True)
    
    # 1. Photo Tile: 400x440
    W, H = 400, 440
    img = Image.new('RGBA', (W, H), (11, 17, 32, 255))
    draw = ImageDraw.Draw(img)
    draw.rounded_rectangle([10, 10, W-10, H-10], radius=24, fill=(15, 23, 42, 255), outline=(30, 41, 59, 255), width=2)
    
    # Map area container
    map_box = [25, 25, W-25, 265]
    draw.rounded_rectangle(map_box, radius=18, fill=(8, 12, 24, 255), outline=(30, 41, 59, 255), width=1)
    
    # Clean vector road network
    roads = [
        [(25, 80), (130, 80), (190, 140), (W-25, 140)],
        [(80, 25), (80, 180), (160, 265)],
        [(200, 25), (200, 140), (280, 265)],
        [(25, 200), (200, 200), (290, 160), (W-25, 160)],
        [(270, 40), (330, 100), (330, 265)]
    ]
    for r in roads:
        draw.line(r, fill=(24, 36, 62, 255), width=4)
    
    # Glowing active route
    route = [(80, 80), (140, 80), (190, 140), (260, 180), (330, 160)]
    draw.line(route, fill=(59, 130, 246, 255), width=5)
    
    # Map Pins
    pins = [
        (80, 80, (59, 130, 246)),
        (190, 140, (168, 85, 247)),
        (260, 180, (52, 211, 153)),
        (330, 160, (59, 130, 246)),
        (140, 200, (251, 191, 36))
    ]
    for px, py, col in pins:
        draw.ellipse([px-14, py-14, px+14, py+14], fill=(col[0], col[1], col[2], 60))
        draw.ellipse([px-6, py-6, px+6, py+6], fill=col, outline=(255, 255, 255, 255), width=2)
    
    draw_pill_badge(draw, 40, 40, "LOCAL DISCOVERY", get_font(12, bold=True), (15, 23, 42, 230), (226, 232, 240, 255), px=10, py=4)
    
    # Floating Bottom Lead Card
    draw.rounded_rectangle([25, 280, W-25, 415], radius=18, fill=(19, 29, 53, 255), outline=(37, 51, 77, 255), width=1)
    
    draw_pill_badge(draw, W-140, 298, "PROSPECT", get_font(12, bold=True), (16, 185, 129, 45), (52, 211, 153, 255), px=10, py=4)
    draw.text((45, 298), "Cafe Delhi Heights", font=get_font(22, bold=True), fill=(248, 250, 252, 255))
    draw.text((45, 332), "Connaught Place, New Delhi", font=get_font(15, semibold=True), fill=(148, 163, 184, 255))
    
    draw_pill_badge(draw, 45, 368, "Status: Lead Qualified", get_font(14, bold=True), (59, 130, 246, 255), (255, 255, 255, 255), px=14, py=5)
    
    img.convert('RGB').save(os.path.join(out_dir, 'outreach-map-discovery-tile.webp'), 'WEBP', quality=95)
    
    # 2. Chart Tile: 410x330
    W_c, H_c = 410, 330
    img_c = Image.new('RGBA', (W_c, H_c), (11, 17, 32, 255))
    draw_c = ImageDraw.Draw(img_c)
    draw_c.rounded_rectangle([10, 10, W_c-10, H_c-10], radius=24, fill=(15, 23, 42, 255), outline=(30, 41, 59, 255), width=2)
    
    draw_pill_badge(draw_c, 32, 32, "AI ANALYSIS COMPLETE", get_font(13, bold=True), (168, 85, 247, 45), (192, 132, 252, 255), px=12, py=5)
    
    draw_c.text((32, 80), "Acme Corp.", font=get_font(28, bold=True), fill=(248, 250, 252, 255))
    draw_c.text((32, 118), "Enterprise Software • Target Tier 1", font=get_font(16, semibold=True), fill=(148, 163, 184, 255))
    
    # 2 Big high-impact checklist items with custom checkmarks
    draw_c.rounded_rectangle([32, 160, W_c-32, 225], radius=14, fill=(19, 29, 53, 255), outline=(37, 51, 77, 255), width=1)
    draw_check_icon(draw_c, 48, 182, size=16, color=(52, 211, 153, 255), width=3)
    draw_c.text((76, 176), "High Buyer Intent Detected (94%)", font=get_font(16, bold=True), fill=(52, 211, 153, 255))
    
    draw_c.rounded_rectangle([32, 240, W_c-32, 305], radius=14, fill=(19, 29, 53, 255), outline=(37, 51, 77, 255), width=1)
    draw_check_icon(draw_c, 48, 262, size=16, color=(96, 165, 250, 255), width=3)
    draw_c.text((76, 256), "VP of Sales Reached Directly", font=get_font(16, bold=True), fill=(96, 165, 250, 255))
    
    img_c.convert('RGB').save(os.path.join(out_dir, 'outreach-ai-analysis-tile.webp'), 'WEBP', quality=95)
    print("Outreach generated.")


# -------------------------------------------------------------
# 4. Suave CRM - Tasks
# -------------------------------------------------------------
def gen_tasks():
    out_dir = 'public/assets/case-studies/suave-crm-tasks'
    os.makedirs(out_dir, exist_ok=True)
    
    # 1. Photo Tile: 400x440
    W, H = 400, 440
    img = Image.new('RGBA', (W, H), (11, 17, 32, 255))
    draw = ImageDraw.Draw(img)
    draw.rounded_rectangle([10, 10, W-10, H-10], radius=24, fill=(15, 23, 42, 255), outline=(30, 41, 59, 255), width=2)
    
    draw.text((30, 30), "Sprint Tasks", font=get_font(24, bold=True), fill=(248, 250, 252, 255))
    draw_pill_badge(draw, 245, 28, "ACTIVE SPRINT", get_font(13, bold=True), (59, 130, 246, 45), (96, 165, 250, 255), px=12, py=5)
    
    # Task Card 1 (In Progress)
    draw.rounded_rectangle([30, 80, W-30, 230], radius=18, fill=(19, 29, 53, 255), outline=(37, 51, 77, 255), width=1)
    draw_pill_badge(draw, 48, 98, "IN PROGRESS", get_font(12, bold=True), (59, 130, 246, 50), (96, 165, 250, 255), px=10, py=4)
    draw_pill_badge(draw, W-135, 98, "HIGH PRIORITY", get_font(12, bold=True), (239, 68, 68, 45), (248, 113, 113, 255), px=10, py=4)
    draw.text((48, 140), "Homepage Redesign", font=get_font(22, bold=True), fill=(248, 250, 252, 255))
    draw.text((48, 180), "Assignee: Alex M. • Due May 15", font=get_font(15, semibold=True), fill=(148, 163, 184, 255))
    
    # Task Card 2 (Completed)
    draw.rounded_rectangle([30, 250, W-30, 400], radius=18, fill=(19, 29, 53, 255), outline=(37, 51, 77, 255), width=1)
    draw_pill_badge(draw, 48, 268, "COMPLETED", get_font(12, bold=True), (16, 185, 129, 45), (52, 211, 153, 255), px=10, py=4)
    draw_pill_badge(draw, W-135, 268, "REVIEW DONE", get_font(12, bold=True), (168, 85, 247, 45), (192, 132, 252, 255), px=10, py=4)
    draw.text((48, 310), "AI Sprint Assistant Engine", font=get_font(22, bold=True), fill=(248, 250, 252, 255))
    draw.text((48, 350), "Assignee: Sarah K. • Unblocked", font=get_font(15, semibold=True), fill=(148, 163, 184, 255))
    
    img.convert('RGB').save(os.path.join(out_dir, 'tasks-kanban-board-tile.webp'), 'WEBP', quality=95)
    
    # 2. Chart Tile: 410x330
    W_c, H_c = 410, 330
    img_c = Image.new('RGBA', (W_c, H_c), (11, 17, 32, 255))
    draw_c = ImageDraw.Draw(img_c)
    draw_c.rounded_rectangle([10, 10, W_c-10, H_c-10], radius=24, fill=(15, 23, 42, 255), outline=(30, 41, 59, 255), width=2)
    
    draw_c.text((32, 32), "Sprint Velocity", font=get_font(26, bold=True), fill=(248, 250, 252, 255))
    draw_c.text((32, 70), "Real-time task burn-down & sprint pace", font=get_font(15, semibold=True), fill=(148, 163, 184, 255))
    
    draw_c.text((32, 120), "Tasks On Schedule", font=get_font(16, semibold=True), fill=(226, 232, 240, 255))
    draw_c.text((W_c-75, 120), "94%", font=get_font(17, bold=True), fill=(52, 211, 153, 255))
    draw_progress_bar(draw_c, 32, 150, W_c-64, 18, 94, (52, 211, 153, 255))
    
    draw_c.text((32, 205), "Sprint Completion Rate", font=get_font(16, semibold=True), fill=(226, 232, 240, 255))
    draw_c.text((W_c-75, 205), "88%", font=get_font(17, bold=True), fill=(96, 165, 250, 255))
    draw_progress_bar(draw_c, 32, 235, W_c-64, 18, 88, (59, 130, 246, 255))
    
    img_c.convert('RGB').save(os.path.join(out_dir, 'tasks-drawer-metric-tile.webp'), 'WEBP', quality=95)
    print("Tasks generated.")


# -------------------------------------------------------------
# 5. ShowNoShow
# -------------------------------------------------------------
def gen_shownoshow():
    out_dir = 'public/assets/case-studies/shownoshow'
    os.makedirs(out_dir, exist_ok=True)
    
    # 1. Photo Tile: 400x440
    W, H = 400, 440
    img = Image.new('RGBA', (W, H), (248, 250, 252, 255))
    draw = ImageDraw.Draw(img)
    draw.rounded_rectangle([10, 10, W-10, H-10], radius=24, fill=(255, 255, 255, 255), outline=(226, 232, 240, 255), width=2)
    
    draw.text((W//2, 45), "Hair Studio Appointment", font=get_font(22, bold=True), fill=(15, 23, 42, 255), anchor="mm")
    draw.text((W//2, 75), "Today • 4:00 PM", font=get_font(16, semibold=True), fill=(100, 116, 139, 255), anchor="mm")
    
    # Green Check Circle
    cx, cy, cr = W//2, 175, 55
    draw.ellipse([cx-cr, cy-cr, cx+cr, cy+cr], fill=(220, 252, 231, 255))
    draw.line([(cx-22, cy), (cx-6, cy+18)], fill=(22, 163, 74, 255), width=7)
    draw.line([(cx-6, cy+18), (cx+24, cy-18)], fill=(22, 163, 74, 255), width=7)
    
    draw.text((W//2, 260), "Confirmed & Secured!", font=get_font(24, bold=True), fill=(15, 23, 42, 255), anchor="mm")
    draw.text((W//2, 292), "Deposit Protected with ShowCheck", font=get_font(16, semibold=True), fill=(71, 85, 105, 255), anchor="mm")
    
    # Action Button
    draw.rounded_rectangle([40, 340, W-40, 405], radius=16, fill=(37, 99, 235, 255))
    draw.text((W//2, 372), "Check In Now", font=get_font(20, bold=True), fill=(255, 255, 255, 255), anchor="mm")
    
    img.convert('RGB').save(os.path.join(out_dir, 'show-check-confirmed-tile.webp'), 'WEBP', quality=95)
    
    # 2. Chart Tile: 410x330
    W_c, H_c = 410, 330
    img_c = Image.new('RGBA', (W_c, H_c), (11, 17, 32, 255))
    draw_c = ImageDraw.Draw(img_c)
    draw_c.rounded_rectangle([10, 10, W_c-10, H_c-10], radius=24, fill=(15, 23, 42, 255), outline=(30, 41, 59, 255), width=2)
    
    draw_pill_badge(draw_c, 32, 30, "SMART REFUNDS", get_font(13, bold=True), (59, 130, 246, 45), (96, 165, 250, 255), px=12, py=5)
    
    draw_c.text((32, 75), "You Save: $261", font=get_font(42, bold=True), fill=(52, 211, 153, 255))
    draw_c.text((32, 130), "Per $10,000 in monthly customer deposits", font=get_font(16, semibold=True), fill=(148, 163, 184, 255))
    
    draw_c.rounded_rectangle([32, 175, W_c-32, 290], radius=16, fill=(19, 29, 53, 255), outline=(37, 51, 77, 255), width=1)
    draw_c.text((50, 195), "Traditional Processing: $290 Fees", font=get_font(16, semibold=True), fill=(248, 113, 113, 255))
    draw_c.text((50, 240), "ShowCheck Smart Refund: $29 Fees", font=get_font(18, bold=True), fill=(52, 211, 153, 255))
    
    img_c.convert('RGB').save(os.path.join(out_dir, 'show-check-savings-chart-tile.webp'), 'WEBP', quality=95)
    print("ShowNoShow generated.")


# -------------------------------------------------------------
# 6. Teerrath
# -------------------------------------------------------------
def gen_teerrath():
    out_dir = 'public/assets/case-studies/teerrath'
    os.makedirs(out_dir, exist_ok=True)
    
    # 1. Photo Tile: 400x440
    W, H = 400, 440
    img = Image.new('RGBA', (W, H), (24, 18, 12, 255))
    draw = ImageDraw.Draw(img)
    draw.rounded_rectangle([10, 10, W-10, H-10], radius=24, fill=(35, 25, 16, 255), outline=(90, 60, 25, 255), width=2)
    
    draw_pill_badge(draw, 30, 30, "AI VEDIC SCAN", get_font(13, bold=True), (180, 83, 9, 60), (251, 191, 36, 255), px=12, py=5)
    draw_pill_badge(draw, 260, 30, "< 2 MINS", get_font(13, bold=True), (180, 83, 9, 60), (251, 191, 36, 255), px=12, py=5)
    
    raw_path = 'public/assets/case-studies/teerrath/spiritual-energy-scan-hero.png'
    if os.path.exists(raw_path):
        im_raw = Image.open(raw_path)
        crop_med = im_raw.crop((700, 65, 890, 255)).convert('RGBA')
        med_size = 145
        crop_med_res = crop_med.resize((med_size, med_size), Image.Resampling.LANCZOS)
        
        # Circular mask
        circ_mask = Image.new('L', (med_size, med_size), 0)
        circ_draw = ImageDraw.Draw(circ_mask)
        circ_draw.ellipse([0, 0, med_size, med_size], fill=255)
        
        # Halo ring behind mandala
        draw.ellipse([W//2 - med_size//2 - 6, 75 - 6, W//2 + med_size//2 + 6, 75 + med_size + 6], fill=(50, 35, 20, 255), outline=(217, 119, 6, 220), width=3)
        img.paste(crop_med_res, (W//2 - med_size//2, 75), circ_mask)
    
    draw.rounded_rectangle([30, 245, W-30, 410], radius=18, fill=(45, 30, 18, 255), outline=(100, 65, 30, 255), width=1)
    draw.text((W//2, 280), "Vedic Energy Matrix", font=get_font(24, bold=True), fill=(254, 240, 138, 255), anchor="mm")
    draw.text((W//2, 318), "6 Sacred Life Areas Analyzed via AI", font=get_font(16, semibold=True), fill=(217, 119, 6, 255), anchor="mm")
    draw.text((W//2, 360), "Dev • Mantra • Daan • Yantra Sadhna", font=get_font(15, semibold=True), fill=(253, 230, 138, 255), anchor="mm")
    
    img.convert('RGB').save(os.path.join(out_dir, 'teerrath-energy-scan-tile.webp'), 'WEBP', quality=95)
    
    # 2. Chart Tile: 410x330
    W_c, H_c = 410, 330
    img_c = Image.new('RGBA', (W_c, H_c), (24, 18, 12, 255))
    draw_c = ImageDraw.Draw(img_c)
    draw_c.rounded_rectangle([10, 10, W_c-10, H_c-10], radius=24, fill=(35, 25, 16, 255), outline=(90, 60, 25, 255), width=2)
    
    draw_c.text((32, 32), "Vedic Sadhna Harmony", font=get_font(26, bold=True), fill=(254, 240, 138, 255))
    draw_c.text((32, 70), "Personalized spiritual remedies score", font=get_font(15, semibold=True), fill=(217, 119, 6, 255))
    
    draw_c.text((32, 120), "Dev & Mantra Sadhna", font=get_font(16, semibold=True), fill=(253, 230, 138, 255))
    draw_c.text((W_c-75, 120), "96%", font=get_font(17, bold=True), fill=(251, 191, 36, 255))
    draw_progress_bar(draw_c, 32, 150, W_c-64, 18, 96, (245, 158, 11, 255), bg_color=(50, 35, 20, 255))
    
    draw_c.text((32, 205), "Daan & Yantra Alignment", font=get_font(16, semibold=True), fill=(253, 230, 138, 255))
    draw_c.text((W_c-75, 205), "92%", font=get_font(17, bold=True), fill=(251, 191, 36, 255))
    draw_progress_bar(draw_c, 32, 235, W_c-64, 18, 92, (217, 119, 6, 255), bg_color=(50, 35, 20, 255))
    
    img_c.convert('RGB').save(os.path.join(out_dir, 'teerrath-insight-chart-tile.webp'), 'WEBP', quality=95)
    print("Teerrath generated.")


# -------------------------------------------------------------
# 7. CABVI
# -------------------------------------------------------------
def gen_cabvi():
    out_dir = 'public/assets/case-studies/cabvi'
    os.makedirs(out_dir, exist_ok=True)
    
    # 1. Photo Tile: 400x440
    W, H = 400, 440
    img = Image.new('RGBA', (W, H), (11, 17, 32, 255))
    draw = ImageDraw.Draw(img)
    draw.rounded_rectangle([10, 10, W-10, H-10], radius=24, fill=(15, 23, 42, 255), outline=(30, 41, 59, 255), width=2)
    
    draw_pill_badge(draw, 30, 30, "AI MATCHING", get_font(13, bold=True), (59, 130, 246, 45), (96, 165, 250, 255), px=12, py=5)
    draw_pill_badge(draw, 230, 30, "98.4% CONFIDENCE", get_font(13, bold=True), (16, 185, 129, 45), (52, 211, 153, 255), px=12, py=5)
    
    # Center Item Match Card
    draw.rounded_rectangle([30, 80, W-30, 240], radius=18, fill=(19, 29, 53, 255), outline=(37, 51, 77, 255), width=1)
    draw.text((50, 105), "SUPPLIER ITEM #4912", font=get_font(13, bold=True), fill=(148, 163, 184, 255))
    draw.text((50, 135), "Commercial Paper Towels", font=get_font(22, bold=True), fill=(248, 250, 252, 255))
    draw.text((50, 175), "SKU: CAB-PT-24 • 24 Pack Coreless", font=get_font(15, semibold=True), fill=(96, 165, 250, 255))
    draw.text((50, 205), "Status: Verified Catalog Spec", font=get_font(14, semibold=True), fill=(52, 211, 153, 255))
    
    # Bottom Benefit Card with checkmark
    draw.rounded_rectangle([30, 260, W-30, 410], radius=18, fill=(19, 29, 53, 255), outline=(37, 51, 77, 255), width=1)
    draw_check_icon(draw, 50, 290, size=18, color=(52, 211, 153, 255), width=3)
    draw.text((78, 285), "Exact Dimension & Spec Match", font=get_font(19, bold=True), fill=(52, 211, 153, 255))
    draw.text((50, 325), "Instant 1-Click Verification & Sync", font=get_font(16, semibold=True), fill=(226, 232, 240, 255))
    draw.text((50, 365), "Eliminates Manual Order Errors", font=get_font(15, semibold=True), fill=(148, 163, 184, 255))
    
    img.convert('RGB').save(os.path.join(out_dir, 'cabvi-product-matching-tile.webp'), 'WEBP', quality=95)
    
    # 2. Chart Tile: 410x330
    W_c, H_c = 410, 330
    img_c = Image.new('RGBA', (W_c, H_c), (11, 17, 32, 255))
    draw_c = ImageDraw.Draw(img_c)
    draw_c.rounded_rectangle([10, 10, W_c-10, H_c-10], radius=24, fill=(15, 23, 42, 255), outline=(30, 41, 59, 255), width=2)
    
    draw_c.text((32, 32), "Procurement Speed", font=get_font(26, bold=True), fill=(248, 250, 252, 255))
    draw_c.text((32, 70), "Find-Qualify-Record cycle optimization", font=get_font(15, semibold=True), fill=(148, 163, 184, 255))
    
    draw_c.text((32, 120), "Catalog Match Speed", font=get_font(16, semibold=True), fill=(226, 232, 240, 255))
    draw_c.text((W_c-75, 120), "+70%", font=get_font(17, bold=True), fill=(52, 211, 153, 255))
    draw_progress_bar(draw_c, 32, 150, W_c-64, 18, 70, (52, 211, 153, 255))
    
    draw_c.text((32, 205), "Data Re-entry Saved", font=get_font(16, semibold=True), fill=(226, 232, 240, 255))
    draw_c.text((W_c-75, 205), "+75%", font=get_font(17, bold=True), fill=(96, 165, 250, 255))
    draw_progress_bar(draw_c, 32, 235, W_c-64, 18, 75, (59, 130, 246, 255))
    
    img_c.convert('RGB').save(os.path.join(out_dir, 'cabvi-efficiency-chart-tile.webp'), 'WEBP', quality=95)
    print("CABVI generated.")


if __name__ == '__main__':
    gen_turbo_trans()
    gen_ai_sales_coaching()
    gen_outreach()
    gen_tasks()
    gen_shownoshow()
    gen_teerrath()
    gen_cabvi()
    print("All 14 case study hero tiles regenerated successfully.")
