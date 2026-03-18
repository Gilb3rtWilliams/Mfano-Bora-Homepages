<?php
// Page title
$page_title = "Home - Mfano Bora Africa Ltd";

// Include database configuration
require_once __DIR__ . '/../configs/database.php';

try {
    $event_stmt = $pdo->prepare("
        SELECT id, title, description, banner_url, event_date 
        FROM events 
        ORDER BY event_date DESC
    ");
    $event_stmt->execute();
    $events = $event_stmt->fetchAll(PDO::FETCH_ASSOC);

    $news_stmt = $pdo->prepare("
        SELECT id, title, content, thumbnail, created_at 
        FROM news 
        ORDER BY created_at DESC
    ");
    $news_stmt->execute();
    $news_items = $news_stmt->fetchAll(PDO::FETCH_ASSOC);

    $priority_stmt = $pdo->prepare("
        SELECT id, title, content AS description, NULL AS subtitle, custom_url,
               CONCAT('/news_and_events/?id=', id) AS url, created_at
        FROM news WHERE priority = 1
        UNION ALL
        SELECT id, title, description, NULL AS subtitle, custom_url,
               CONCAT('/events/?id=', id) AS url, event_date AS created_at
        FROM events WHERE priority = 1
        ORDER BY created_at DESC LIMIT 3
    ");
    $priority_stmt->execute();
    $priority_items = $priority_stmt->fetchAll(PDO::FETCH_ASSOC);

    try {
        $stmt = $pdo->prepare("SELECT * FROM home_slides WHERE status = 1 ORDER BY display_order ASC");
        $stmt->execute();
        $slides = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) { $slides = []; }

    $other_priority_stmt = $pdo->prepare("
        SELECT id, title, content AS description, NULL AS subtitle, custom_url,
               CONCAT('/news_and_events/?id=', id) AS url, created_at
        FROM news WHERE priority > 1
        UNION ALL
        SELECT id, title, description, NULL AS subtitle, custom_url,
               CONCAT('/events/?id=', id) AS url, event_date AS created_at
        FROM events WHERE priority > 1
        ORDER BY created_at DESC
    ");
    $other_priority_stmt->execute();
    $other_priority_items = $other_priority_stmt->fetchAll(PDO::FETCH_ASSOC);
    $priority_items = array_merge($priority_items, $other_priority_items);

    $upcoming_stmt = $pdo->prepare("
        SELECT * FROM events WHERE event_date >= CURDATE() ORDER BY event_date ASC LIMIT 1
    ");
    $upcoming_stmt->execute();
    $event = $upcoming_stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $events = []; $news_items = []; $priority_items = []; $event = null; $slides = [];
}

function slugify($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}
function newsUrl($id, $title) {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    return "/notices/{$id}-{$slug}";
}
?>

<head>
  <meta charset="UTF-8" name="description" content="Mfano Bora Africa Ltd — Road Safety, Driver Training, Logistics Consulting and Skills Development across Kenya.">
  <title>Home - Mfano Bora Africa Ltd</title>
  <link rel="stylesheet" href="/assets/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
/* ── PLAYFUL DESIGN RESET (scoped to .mba-playful) ── */
.mba-playful * { box-sizing: border-box; }
.mba-playful {
  --gold: #E8A020;
  --navy: #1A2C5B;
  --lime: #C8E63C;
  --coral: #FF6B4A;
  --cream: #FDF8EF;
  --dark: #0F1A2E;
  font-family: 'DM Sans', sans-serif;
  background: var(--cream);
  color: var(--dark);
  overflow-x: hidden;
}

/* ── HERO ── */
.mba-hero {
  min-height: 88vh;
  background: var(--dark);
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0;
  position: relative;
  overflow: hidden;
  padding-top: 2rem;
}
.mba-hero-blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.18;
  pointer-events: none;
}
.mba-hero-blob-1 { width:500px;height:500px;background:var(--gold);top:-100px;left:-100px; }
.mba-hero-blob-2 { width:400px;height:400px;background:var(--coral);bottom:-80px;right:10%; }

.mba-hero-left {
  position: relative; z-index: 1;
  padding: 5rem 3rem 4rem 4rem;
  display: flex; flex-direction: column; justify-content: center;
}
.mba-hero-tag {
  display: inline-flex; align-items: center; gap: 0.5rem;
  background: rgba(255,255,255,0.08);
  border: 1px solid rgba(255,255,255,0.15);
  border-radius: 100px;
  padding: 0.4rem 1rem;
  font-size: 0.78rem; font-weight: 600; letter-spacing: 0.08em;
  text-transform: uppercase; color: var(--gold);
  margin-bottom: 1.75rem; width: fit-content;
}
.mba-hero-tag::before { content:'●'; font-size:0.5rem; animation: pulse 2s infinite; }
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.3} }

.mba-hero-title {
  font-family: 'Syne', sans-serif;
  font-size: clamp(2.8rem, 5vw, 4.5rem);
  font-weight: 800; line-height: 1.05;
  color: #fff; margin-bottom: 1.5rem;
}
.mba-hero-title .gold { color: var(--gold); }
.mba-hero-title .outline {
  -webkit-text-stroke: 2px rgba(255,255,255,0.3);
  color: transparent;
}

.mba-hero-sub {
  font-size: 1rem; color: rgba(255,255,255,0.55);
  line-height: 1.75; max-width: 460px;
  margin-bottom: 2.5rem; font-weight: 300;
}
.mba-hero-btns { display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 3rem; }
.mba-btn-gold {
  background: var(--gold); color: var(--dark);
  padding: 0.9rem 2rem; border-radius: 100px;
  font-weight: 700; font-size: 0.9rem;
  text-decoration: none; border: 2px solid var(--gold);
  transition: transform 0.2s, box-shadow 0.2s;
}
.mba-btn-gold:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(232,160,32,0.4); }
.mba-btn-ghost {
  background: transparent; color: #fff;
  padding: 0.9rem 2rem; border-radius: 100px;
  font-weight: 500; font-size: 0.9rem;
  text-decoration: none; border: 2px solid rgba(255,255,255,0.25);
  transition: border-color 0.2s;
}
.mba-btn-ghost:hover { border-color: rgba(255,255,255,0.6); }

.mba-hero-stats { display: flex; gap: 2.5rem; }
.mba-hero-stat .num {
  font-family: 'Syne', sans-serif;
  font-size: 2rem; font-weight: 800; color: var(--gold); line-height: 1;
}
.mba-hero-stat .label {
  font-size: 0.75rem; color: rgba(255,255,255,0.4);
  margin-top: 0.25rem; text-transform: uppercase; letter-spacing: 0.06em;
}

/* Hero right — live slides from DB */
.mba-hero-right {
  position: relative; z-index: 1;
  display: flex; align-items: center;
  padding: 3rem 3rem 3rem 2rem;
}
.mba-slide-stack {
  position: relative;
  width: 100%; max-width: 520px;
  margin: 0 auto;
}
.mba-slide-card {
  border-radius: 20px;
  overflow: hidden;
  border: 2px solid rgba(255,255,255,0.1);
  position: relative;
  display: none;
}
.mba-slide-card.active { display: block; }
.mba-slide-card img {
  width: 100%; height: 360px; object-fit: cover; display: block;
}
.mba-slide-caption {
  position: absolute; bottom: 0; left: 0; right: 0;
  background: linear-gradient(transparent, rgba(15,26,46,0.92));
  padding: 2rem 1.5rem 1.5rem;
}
.mba-slide-caption h3 {
  font-family: 'Syne', sans-serif;
  font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 0.5rem;
}
.mba-slide-caption p { font-size: 0.82rem; color: rgba(255,255,255,0.65); line-height: 1.5; margin-bottom: 0.75rem; }
.mba-slide-caption a {
  display: inline-block;
  background: var(--gold); color: var(--dark);
  padding: 0.4rem 1rem; border-radius: 100px;
  font-size: 0.78rem; font-weight: 700; text-decoration: none;
}
.mba-slide-dots {
  display: flex; gap: 0.4rem; justify-content: center; margin-top: 1rem;
}
.mba-dot {
  width: 8px; height: 8px; border-radius: 50%;
  background: rgba(255,255,255,0.2); border: none; cursor: pointer;
  transition: background 0.2s, transform 0.2s; padding: 0;
}
.mba-dot.active { background: var(--gold); transform: scale(1.4); }

/* ── AUDIENCE CARDS ── */
.mba-audience {
  background: var(--cream);
  padding: 5rem 4rem;
}
.mba-section-label {
  font-size: 0.72rem; font-weight: 700; letter-spacing: 0.14em;
  text-transform: uppercase; color: var(--gold);
  margin-bottom: 0.5rem;
}
.mba-section-title {
  font-family: 'Syne', sans-serif;
  font-size: clamp(1.8rem, 3vw, 2.5rem); font-weight: 800;
  color: var(--dark); line-height: 1.15; margin-bottom: 0.75rem;
}
.mba-section-sub { font-size: 0.95rem; color: #666; line-height: 1.7; max-width: 480px; margin-bottom: 3rem; }

.mba-audience-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 1.5rem; }
.mba-acard {
  background: var(--dark);
  border-radius: 20px; padding: 2.5rem;
  border: 2px solid rgba(255,255,255,0.06);
  cursor: pointer;
  transition: transform 0.3s, border-color 0.3s;
}
.mba-acard:hover { transform: translateY(-6px); border-color: var(--gold); }
.mba-acard-icon { font-size: 2.5rem; margin-bottom: 1rem; }
.mba-acard h3 {
  font-family: 'Syne', sans-serif; font-size: 1.05rem; font-weight: 700;
  color: #fff; margin-bottom: 0.75rem;
}
.mba-acard p { font-size: 0.875rem; color: rgba(255,255,255,0.5); line-height: 1.7; margin-bottom: 1.25rem; }
.mba-acard a {
  color: var(--gold); font-size: 0.85rem; font-weight: 600;
  text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;
  transition: gap 0.2s;
}
.mba-acard a:hover { gap: 0.6rem; }

/* ── SERVICES SLIDESHOW ── */
.mba-services { background: var(--dark); padding: 5rem 4rem; }
.mba-ss-wrap { overflow-x: hidden; border-radius: 20px; border: 2px solid rgba(255,255,255,0.08); margin-top: 2.5rem; }
.mba-ss-track { display: flex; }
.mba-ss-slide { flex: 0 0 100%; min-width: 0; display: flex; flex-direction: row; min-height: 400px; }
.mba-ss-img { flex: 1; position: relative; background-size: cover; background-position: center; min-height: 400px; }
.mba-ss-img-overlay { position: absolute; inset: 0; background: linear-gradient(to right, rgba(15,26,46,0.2), transparent); }
.mba-ss-img-label { position: absolute; bottom: 1.25rem; left: 1.25rem; }
.mba-ss-tag {
  background: var(--gold); color: var(--dark);
  padding: 0.35rem 1rem; border-radius: 100px;
  font-weight: 700; font-size: 0.78rem;
  border: 2px solid var(--dark); font-family: 'Syne', sans-serif;
}
.mba-ss-body {
  flex: 1; background: rgba(255,255,255,0.04);
  padding: 3rem 2.5rem; display: flex; flex-direction: column;
  justify-content: center; border-left: 1px solid rgba(255,255,255,0.08);
}
.mba-ss-num {
  font-family: 'Syne', sans-serif; font-size: 3.5rem; font-weight: 800;
  color: rgba(255,255,255,0.05); line-height: 1; margin-bottom: 0.5rem;
}
.mba-ss-body h3 { font-family: 'Syne', sans-serif; font-size: 1.4rem; font-weight: 700; color: #fff; margin-bottom: 0.75rem; line-height: 1.2; }
.mba-ss-body p { font-size: 0.92rem; color: rgba(255,255,255,0.58); line-height: 1.75; margin-bottom: 1.5rem; }
.mba-ss-link { display: inline-flex; align-items: center; gap: 0.4rem; color: var(--lime); text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: gap 0.2s; width: fit-content; }
.mba-ss-link:hover { gap: 0.75rem; }
.mba-ss-controls { display: flex; align-items: center; justify-content: center; gap: 1.5rem; margin-top: 1.25rem; }
.mba-ss-btn { background: rgba(255,255,255,0.08); border: 2px solid rgba(255,255,255,0.15); color: #fff; width: 44px; height: 44px; border-radius: 50%; cursor: pointer; font-size: 1rem; display: flex; align-items: center; justify-content: center; transition: background 0.2s; }
.mba-ss-btn:hover { background: var(--gold); border-color: var(--gold); color: var(--dark); }
.mba-ss-dots { display: flex; gap: 0.5rem; align-items: center; }
.mba-ss-dot { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,0.2); border: none; cursor: pointer; transition: background 0.2s, transform 0.2s; padding: 0; }
.mba-ss-dot.active { background: var(--gold); transform: scale(1.4); }

/* ── NEWS & EVENTS ── */
.mba-hne { background: var(--cream); padding: 5rem 4rem; }
.mba-hne-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-top: 2.5rem; }
.mba-hne-col h3 { font-family: 'Syne', sans-serif; font-size: 1.1rem; font-weight: 700; color: var(--dark); margin-bottom: 1.25rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--gold); }
.mba-hne-item { padding: 0.9rem 0; border-bottom: 1px solid rgba(15,26,46,0.08); }
.mba-hne-item .date { font-size: 0.75rem; color: #999; margin-bottom: 0.25rem; }
.mba-hne-item a { color: var(--dark); text-decoration: none; font-size: 0.9rem; font-weight: 500; line-height: 1.4; transition: color 0.2s; }
.mba-hne-item a:hover { color: var(--gold); }
.mba-hne-more { display: inline-flex; align-items: center; gap: 0.3rem; margin-top: 1rem; color: var(--gold); font-weight: 600; font-size: 0.875rem; text-decoration: none; }

/* ── ABOUT ── */
.mba-about { background: var(--dark); padding: 5rem 4rem; }
.mba-about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; margin-top: 2.5rem; }
.mba-about-img { border-radius: 20px; overflow: hidden; border: 2px solid rgba(255,255,255,0.08); }
.mba-about-img img { width: 100%; height: 340px; object-fit: cover; display: block; }
.mba-about-text p { font-size: 0.95rem; color: rgba(255,255,255,0.6); line-height: 1.8; margin-bottom: 1.25rem; }
.mba-about-text a { display: inline-flex; align-items: center; gap: 0.4rem; background: var(--gold); color: var(--dark); padding: 0.8rem 1.75rem; border-radius: 100px; font-weight: 700; font-size: 0.875rem; text-decoration: none; margin-top: 0.5rem; transition: transform 0.2s; }
.mba-about-text a:hover { transform: translateY(-2px); }

/* ── MISSION / VALUES ── */
.mba-mv { background: var(--cream); padding: 5rem 4rem; }
.mba-mv-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 2.5rem; }
.mba-mv-card { background: var(--dark); border-radius: 20px; padding: 2.5rem; border: 2px solid rgba(255,255,255,0.06); }
.mba-mv-card h3 { font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 700; color: var(--gold); margin-bottom: 0.75rem; }
.mba-mv-card p { font-size: 0.9rem; color: rgba(255,255,255,0.55); line-height: 1.75; }

.mba-values { margin-top: 3rem; }
.mba-values-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 1.25rem; margin-top: 1.5rem; }
.mba-val { background: #fff; border-radius: 16px; padding: 1.75rem; border: 2px solid rgba(15,26,46,0.07); transition: border-color 0.2s; }
.mba-val:hover { border-color: var(--gold); }
.mba-val h4 { font-family: 'Syne', sans-serif; font-size: 0.9rem; font-weight: 700; color: var(--dark); margin-bottom: 0.5rem; }
.mba-val p { font-size: 0.83rem; color: #666; line-height: 1.65; }

/* ── CTA ── */
.mba-cta { background: var(--gold); padding: 4rem; text-align: center; }
.mba-cta h2 { font-family: 'Syne', sans-serif; font-size: 2.2rem; font-weight: 800; color: var(--dark); margin-bottom: 0.75rem; }
.mba-cta p { color: rgba(15,26,46,0.65); max-width: 480px; margin: 0 auto 2rem; line-height: 1.7; }
.mba-cta a { display: inline-flex; align-items: center; gap: 0.5rem; background: var(--dark); color: #fff; padding: 0.9rem 2.2rem; border-radius: 100px; font-weight: 700; font-size: 0.9rem; text-decoration: none; transition: transform 0.2s; }
.mba-cta a:hover { transform: translateY(-2px); }

/* ── POPUP ── */
#eventPopup { position:fixed;bottom:20px;right:20px;background:rgba(255,255,255,0.97);border:1px solid #ccc;box-shadow:0 8px 18px rgba(0,0,0,0.2);z-index:9999;width:200px;border-radius:12px;font-family:'DM Sans',sans-serif;padding:14px;text-align:center; }
#eventPopup img { max-width:100%;max-height:80px;margin-bottom:8px;border-radius:6px; }
#eventPopup h3 { margin:6px 0;color:#333;font-size:0.95em;font-weight:700;line-height:1.2; }
#eventPopup p { font-size:0.82em;color:#555;line-height:1.3;margin:4px 0; }
.popup-close { position:absolute;top:4px;right:8px;cursor:pointer;font-size:16px;color:#999; }
.popup-btn-row { display:flex;justify-content:center;gap:8px;margin-top:10px; }
.popup-btn { padding:7px 14px;background:var(--gold);color:var(--dark);text-decoration:none;border:none;border-radius:100px;font-size:0.8em;font-weight:700;cursor:pointer; }
.popup-close-btn { background:#6c757d;color:#fff; }
@keyframes bounceFromBottom { 0%{transform:translateY(0)}50%{transform:translateY(-60px)}100%{transform:translateY(0)} }
.bounce { animation:bounceFromBottom 3s ease-in-out; }

/* ── RESPONSIVE ── */
@media (max-width: 900px) {
  .mba-hero { grid-template-columns: 1fr; }
  .mba-hero-right { display: none; }
  .mba-hero-left { padding: 4rem 2rem; }
  .mba-audience-grid, .mba-hne-grid, .mba-about-grid, .mba-mv-grid { grid-template-columns: 1fr; }
  .mba-values-grid { grid-template-columns: 1fr 1fr; }
  .mba-audience, .mba-services, .mba-hne, .mba-about, .mba-mv, .mba-cta { padding: 3rem 1.5rem; }
  .mba-ss-slide { flex-direction: column; }
  .mba-ss-img { min-height: 240px; }
}
</style>
</head>

<?php
// Service slides data (static — matches the real services)
$service_slides = [
  ['tag'=>'EA Transport Awards',   'img'=>'/assets/images/awards.jpg',       'title'=>'EA Transport, Logistics & Road Safety Awards',
   'body'=>'Recognising excellence and innovation in transport across East Africa.', 'link'=>'/events/'],
  ['tag'=>'Industrial Attachment', 'img'=>'/assets/images/attachment.jpeg',  'title'=>'Industrial Attachments Kenya',
   'body'=>'Well-structured programmes for ICT, logistics and administration students. Apply online.', 'link'=>'/notices/'],
  ['tag'=>'Road Safety Club',      'img'=>'/assets/images/road_safety.png',  'title'=>'Road Safety Club in Kenya',
   'body'=>'Nationwide awareness campaigns and school outreach nurturing responsible road users.', 'link'=>'/events/'],
  ['tag'=>'Smart Drivers Club',    'img'=>'/assets/images/smart_driver.png', 'title'=>'Smart Drivers Club',
   'body'=>'Empowering drivers with skills, safety knowledge and responsible road behaviour.', 'link'=>'/events/'],
];
?>

<div class="mba-playful">

<!-- ══════════════════ HERO ══════════════════ -->
<section class="mba-hero">
  <div class="mba-hero-blob mba-hero-blob-1"></div>
  <div class="mba-hero-blob mba-hero-blob-2"></div>

  <div class="mba-hero-left">
    <div class="mba-hero-tag">Road Safety · Skills · Community</div>
    <h1 class="mba-hero-title">
      Safer roads,<br>
      <span class="gold">stronger</span><br>
      <span class="outline">communities.</span>
    </h1>
    <p class="mba-hero-sub">
      Mfano Bora Africa brings together road safety education, professional driver training,
      logistics consulting, and skills development — raising the standard of life in Kenya.
    </p>
    <div class="mba-hero-btns">
      <a href="/events/" class="mba-btn-gold">Explore Our Work →</a>
      <a href="/contact-us/" class="mba-btn-ghost">Get in Touch</a>
    </div>
    <div class="mba-hero-stats">
      <div class="mba-hero-stat"><div class="num">24+</div><div class="label">Years of Service</div></div>
      <div class="mba-hero-stat"><div class="num">500+</div><div class="label">Road Safety Clubs</div></div>
      <div class="mba-hero-stat"><div class="num">4</div><div class="label">Service Pillars</div></div>
    </div>
  </div>

  <!-- Hero right: DB slides as card stack -->
  <div class="mba-hero-right">
    <div class="mba-slide-stack">
      <?php if (!empty($slides)): ?>
        <?php foreach ($slides as $i => $slide): ?>
          <div class="mba-slide-card <?= $i === 0 ? 'active' : '' ?>">
            <img src="<?= htmlspecialchars($slide['image_path']) ?>"
                 alt="<?= htmlspecialchars($slide['image_alt'] ?? $slide['title']) ?>">
            <div class="mba-slide-caption">
              <h3><?= htmlspecialchars($slide['title']) ?></h3>
              <p><?= strip_tags($slide['description']) ?></p>
              <?php if (!empty($slide['cta_text']) && !empty($slide['cta_link'])): ?>
                <a href="<?= htmlspecialchars($slide['cta_link']) ?>"><?= htmlspecialchars($slide['cta_text']) ?></a>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="mba-slide-card active" style="background:rgba(255,255,255,0.05);min-height:360px;display:flex;align-items:center;justify-content:center;">
          <p style="color:rgba(255,255,255,0.3);font-size:0.9rem;">No slides available</p>
        </div>
      <?php endif; ?>
      <div class="mba-slide-dots" id="heroDots">
        <?php foreach ($slides as $i => $_): ?>
          <button class="mba-dot <?= $i===0?'active':'' ?>" onclick="heroGo(<?= $i ?>)"></button>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════ FIND YOUR PATH ══════════════════ -->
<section class="mba-audience">
  <div class="mba-section-label">Find Your Path</div>
  <h2 class="mba-section-title">Who are you here for?</h2>
  <p class="mba-section-sub">We serve people with very different goals. Pick your path and we'll take you straight to what matters.</p>
  <div class="mba-audience-grid">
    <div class="mba-acard">
      <div class="mba-acard-icon">🎓</div>
      <h3>Students & Attachment Seekers</h3>
      <p>Structured industrial attachment programmes for ICT, logistics and administration. Apply through our portal and gain real-world experience.</p>
      <a href="/notices/">Find opportunities →</a>
    </div>
    <div class="mba-acard">
      <div class="mba-acard-icon">🏢</div>
      <h3>Corporate & Business Partners</h3>
      <p>Fleet safety audits, logistics consulting, and employee training that protect your people and improve your bottom line.</p>
      <a href="/contact-us/">Partner with us →</a>
    </div>
    <div class="mba-acard">
      <div class="mba-acard-icon">🌍</div>
      <h3>Community Members</h3>
      <p>Join the Smart Driver Club, take part in awareness campaigns, and help build a culture of safety on Kenya's roads.</p>
      <a href="/events/">Join the movement →</a>
    </div>
  </div>
</section>

<!-- ══════════════════ SERVICES SLIDESHOW ══════════════════ -->
<section class="mba-services">
  <div class="mba-section-label" style="color:var(--gold)">Our Work in Action</div>
  <h2 class="mba-section-title" style="color:#fff">See what we <span style="color:var(--lime)">actually</span> do.</h2>
  <p class="mba-section-sub" style="color:rgba(255,255,255,0.5)">Each service area changes real lives. Here's a glimpse.</p>

  <div class="mba-ss-wrap" id="servWrap">
    <div class="mba-ss-track">
      <?php foreach ($service_slides as $i => $s): ?>
      <div class="mba-ss-slide">
        <div class="mba-ss-img" style="background-image:url('<?= htmlspecialchars($s['img']) ?>');">
          <div class="mba-ss-img-overlay"></div>
          <div class="mba-ss-img-label"><span class="mba-ss-tag"><?= htmlspecialchars($s['tag']) ?></span></div>
        </div>
        <div class="mba-ss-body">
          <div class="mba-ss-num"><?= str_pad($i+1,2,'0',STR_PAD_LEFT) ?></div>
          <h3><?= htmlspecialchars($s['title']) ?></h3>
          <p><?= htmlspecialchars($s['body']) ?></p>
          <a href="<?= htmlspecialchars($s['link']) ?>" class="mba-ss-link">Learn More →</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="mba-ss-controls">
    <button class="mba-ss-btn" onclick="ssPrev('servWrap')">←</button>
    <div class="mba-ss-dots" id="servDots">
      <?php foreach ($service_slides as $i => $_): ?>
        <button class="mba-ss-dot <?= $i===0?'active':'' ?>" onclick="ssGo('servWrap',<?= $i ?>)"></button>
      <?php endforeach; ?>
    </div>
    <button class="mba-ss-btn" onclick="ssNext('servWrap')">→</button>
  </div>
</section>

<!-- ══════════════════ NEWS & EVENTS ══════════════════ -->
<section class="mba-hne">
  <div class="mba-section-label">What's Happening</div>
  <h2 class="mba-section-title">Latest Notices & Events</h2>
  <div class="mba-hne-grid">
    <div class="mba-hne-col">
      <h3>Latest Notices</h3>
      <?php foreach ($news_items as $n): ?>
        <div class="mba-hne-item">
          <a href="<?= newsUrl($n['id'], $n['title']) ?>"><?= htmlspecialchars($n['title']) ?></a>
        </div>
      <?php endforeach; ?>
      <a href="/notices/" class="mba-hne-more">More Notices →</a>
    </div>
    <div class="mba-hne-col">
      <h3>Upcoming Events</h3>
      <?php foreach ($events as $e):
        $slug = slugify($e['title']);
        $eventUrl = "/events/{$e['id']}-{$slug}";
      ?>
        <div class="mba-hne-item">
          <div class="date"><?= date("F j, Y", strtotime($e['event_date'])) ?></div>
          <a href="<?= htmlspecialchars($eventUrl) ?>"><?= htmlspecialchars($e['title']) ?></a>
        </div>
      <?php endforeach; ?>
      <a href="/events/" class="mba-hne-more">View All →</a>
    </div>
  </div>
</section>

<!-- ══════════════════ ABOUT ══════════════════ -->
<section class="mba-about">
  <div class="mba-section-label" style="color:var(--gold)">About Us</div>
  <h2 class="mba-section-title" style="color:#fff">24 years of raising<br><span style="color:var(--gold)">Kenya's standard.</span></h2>
  <div class="mba-about-grid">
    <div class="mba-about-img">
      <img src="/assets/images/our-history.png" alt="Our History">
    </div>
    <div class="mba-about-text">
      <p>Mfano Bora Africa Limited is the leading consulting firm in Logistics. We provide integrated supply chain management consulting services that optimise operations across planning, sourcing, distribution and customer service.</p>
      <p>We are also the home of the <strong style="color:var(--gold)">East Africa Transport, Logistics & Road Safety Awards</strong> for the past 24 years — recognising excellence and innovation in the logistics and supply chain industry.</p>
      <p>Through our Road Safety Education programmes, we currently have more than 500 Road Safety Clubs across the region.</p>
      <a href="/contact-us/">Get in Touch →</a>
    </div>
  </div>
</section>

<!-- ══════════════════ MISSION & VALUES ══════════════════ -->
<section class="mba-mv">
  <div class="mba-section-label">Our Foundation</div>
  <h2 class="mba-section-title">Mission, Vision & Values</h2>
  <div class="mba-mv-grid">
    <div class="mba-mv-card">
      <h3>Our Mission</h3>
      <p>To relentlessly focus on helping our partners succeed by serving their logistics needs through unparalleled expertise, technological agility, and continuous innovation.</p>
    </div>
    <div class="mba-mv-card">
      <h3>Our Vision</h3>
      <p>To be the leading logistics consultant in Africa, recognised for excellence, innovation, and commitment to safety and sustainability.</p>
    </div>
  </div>
  <div class="mba-values">
    <div class="mba-values-grid">
      <div class="mba-val"><h4>Preservation of Human Life</h4><p>Protecting and saving lives is our highest priority. Every action we take is guided by the principle that human life is priceless.</p></div>
      <div class="mba-val"><h4>Whole Community Participation</h4><p>We encourage the active involvement of individuals, families, organisations, and authorities to create safer communities.</p></div>
      <div class="mba-val"><h4>Partnership</h4><p>We build strong, mutually beneficial relationships with stakeholders to share resources, expertise, and achieve greater impact.</p></div>
      <div class="mba-val"><h4>Capacity Development</h4><p>We equip people with the skills, knowledge, and tools they need to prevent accidents and respond to emergencies.</p></div>
      <div class="mba-val"><h4>Sustainability</h4><p>We aim for long-term solutions that improve safety while enhancing the social and economic well-being of communities.</p></div>
      <div class="mba-val"><h4>Road Accidents Are Avoidable</h4><p>With education, enforcement, and infrastructure, road accidents can be significantly reduced and often prevented entirely.</p></div>
    </div>
  </div>
</section>

<!-- ══════════════════ CTA ══════════════════ -->
<section class="mba-cta">
  <h2>Ready to connect with us?</h2>
  <p>Whether you're a student, a business, or a community advocate — there's a place for you at Mfano Bora Africa.</p>
  <a href="/contact-us/">Get in Touch →</a>
</section>

</div><!-- end .mba-playful -->

<!-- ══════════════════ POPUP ══════════════════ -->
<?php if ($event): ?>
<div id="eventPopup" class="bounce">
  <span class="popup-close" onclick="closePopup()">&times;</span>
  <div class="popup-content">
    <?php if (!empty($event['banner_url'])): ?>
      <img src="<?= htmlspecialchars('/' . ltrim($event['banner_url'], '/')) ?>" alt="Event Banner">
    <?php endif; ?>
    <h3><?= htmlspecialchars($event['title']) ?></h3>
    <p style="font-size:12px;color:#777;"><strong>Date:</strong> <?= date('F j, Y', strtotime($event['event_date'])) ?></p>
    <div class="popup-btn-row">
      <a href="/events/" class="popup-btn">View More</a>
      <button class="popup-btn popup-close-btn" onclick="closePopup()">Close</button>
    </div>
  </div>
</div>
<?php endif; ?>

<script>
// ── Hero slideshow ──
var heroIdx = 0;
var heroCards = document.querySelectorAll('.mba-slide-card');
var heroDots  = document.querySelectorAll('#heroDots .mba-dot');

function heroGo(n) {
  heroCards.forEach(function(c){ c.classList.remove('active'); });
  heroDots.forEach(function(d){ d.classList.remove('active'); });
  heroIdx = n;
  if (heroCards[n]) heroCards[n].classList.add('active');
  if (heroDots[n])  heroDots[n].classList.add('active');
}
if (heroCards.length) {
  setInterval(function(){ heroGo((heroIdx + 1) % heroCards.length); }, 6000);
}

// ── Services slideshow ──
var ssState = {};
var ssTimers = {};

function ssInit(wrapId, total) {
  ssState[wrapId] = { cur: 0, total: total };
  ssTimers[wrapId] = setInterval(function(){ ssNext(wrapId); }, 5000);
}
function ssGo(wrapId, idx) {
  ssState[wrapId].cur = idx;
  var w = document.getElementById(wrapId);
  if (w) w.scrollLeft = idx * w.offsetWidth;
  var dotsId = wrapId.replace('Wrap','Dots');
  var dotsEl = document.getElementById(dotsId);
  if (dotsEl) dotsEl.querySelectorAll('.mba-ss-dot, .ss-dot').forEach(function(d,i){
    d.classList.toggle('active', i === idx);
  });
  clearInterval(ssTimers[wrapId]);
  ssTimers[wrapId] = setInterval(function(){ ssNext(wrapId); }, 5000);
}
function ssNext(wrapId) { ssGo(wrapId, (ssState[wrapId].cur + 1) % ssState[wrapId].total); }
function ssPrev(wrapId) { ssGo(wrapId, (ssState[wrapId].cur - 1 + ssState[wrapId].total) % ssState[wrapId].total); }

window.addEventListener('load', function() {
  ssInit('servWrap', <?= count($service_slides) ?>);
});

// ── Popup ──
window.closePopup = function() {
  var p = document.getElementById('eventPopup');
  if (p) p.style.display = 'none';
};
(function(){
  var popup = document.getElementById('eventPopup');
  if (popup) {
    setInterval(function(){
      popup.classList.add('bounce');
      popup.addEventListener('animationend', function h(){
        popup.classList.remove('bounce');
        popup.removeEventListener('animationend', h);
      });
    }, 20000);
  }
})();
</script>
