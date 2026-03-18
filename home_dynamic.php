<?php
// Page title
$page_title = "Home - Mfano Bora Africa Ltd";

require_once __DIR__ . '/../configs/database.php';

try {
    $event_stmt = $pdo->prepare("SELECT id, title, description, banner_url, event_date FROM events ORDER BY event_date DESC");
    $event_stmt->execute();
    $events = $event_stmt->fetchAll(PDO::FETCH_ASSOC);

    $news_stmt = $pdo->prepare("SELECT id, title, content, thumbnail, created_at FROM news ORDER BY created_at DESC");
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

    $upcoming_stmt = $pdo->prepare("SELECT * FROM events WHERE event_date >= CURDATE() ORDER BY event_date ASC LIMIT 1");
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

$service_slides = [
  ['tag'=>'EA Transport Awards',   'img'=>'/assets/images/awards.jpg',       'title'=>'EA Transport, Logistics & Road Safety Awards',
   'body'=>'Recognising excellence and innovation in the transport sector across East Africa.', 'link'=>'/events/'],
  ['tag'=>'Industrial Attachment', 'img'=>'/assets/images/attachment.jpeg',  'title'=>'Industrial Attachments Kenya',
   'body'=>'Well-structured programmes for ICT, logistics and administration students. Apply online.', 'link'=>'/notices/'],
  ['tag'=>'Road Safety Club',      'img'=>'/assets/images/road_safety.png',  'title'=>'Road Safety Club in Kenya',
   'body'=>'Nationwide awareness campaigns and school outreach nurturing responsible road users.', 'link'=>'/events/'],
  ['tag'=>'Smart Drivers Club',    'img'=>'/assets/images/smart_driver.png', 'title'=>'Smart Drivers Club',
   'body'=>'Empowering drivers with skills, safety knowledge and responsible road behaviour.', 'link'=>'/events/'],
];
?>

<head>
  <meta charset="UTF-8" name="description" content="Mfano Bora Africa Ltd — Road Safety, Driver Training, Logistics Consulting and Skills Development across Kenya.">
  <title>Home - Mfano Bora Africa Ltd</title>
  <link rel="stylesheet" href="/assets/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Bebas+Neue&display=swap" rel="stylesheet">
<style>
.mba-dyn * { box-sizing: border-box; }
.mba-dyn {
  --amber: #E8A020;
  --amber-bright: #FFB733;
  --navy: #060D1F;
  --navy-2: #0D1A35;
  --navy-3: #122040;
  --white: #FFFFFF;
  --muted: rgba(255,255,255,0.5);
  font-family: 'Space Grotesk', sans-serif;
  background: var(--navy);
  color: var(--white);
  overflow-x: hidden;
}

/* ── HERO ── */
.dyn-hero {
  min-height: 90vh;
  position: relative;
  display: grid;
  grid-template-columns: 1fr 420px;
  gap: 4rem;
  align-items: center;
  padding: 7rem 4rem 5rem;
  overflow: hidden;
}
.dyn-hero-grid {
  position: absolute; inset: 0;
  background-image: linear-gradient(rgba(232,160,32,0.04) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(232,160,32,0.04) 1px, transparent 1px);
  background-size: 60px 60px;
  mask-image: radial-gradient(ellipse 80% 60% at 50% 50%, black 40%, transparent 100%);
  animation: gridPulse 6s ease-in-out infinite;
}
@keyframes gridPulse { 0%,100%{opacity:0.6} 50%{opacity:1} }
.dyn-hero-glow {
  position: absolute; top: 10%; left: 50%; transform: translateX(-50%);
  width: 800px; height: 500px;
  background: radial-gradient(ellipse, rgba(232,160,32,0.12) 0%, transparent 70%);
  pointer-events: none;
}
.dyn-hero-left { position: relative; z-index: 1; }
.dyn-pretitle { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.75rem; }
.dyn-pretitle-dot { width: 8px; height: 8px; background: var(--amber); border-radius: 50%; animation: blink 2s ease-in-out infinite; }
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }
.dyn-pretitle-text { font-size: 0.75rem; font-weight: 600; letter-spacing: 0.16em; text-transform: uppercase; color: var(--amber); }
.dyn-hero-title {
  font-family: 'Bebas Neue', sans-serif;
  font-size: clamp(4rem, 8vw, 7rem);
  line-height: 0.92; letter-spacing: 0.02em; margin-bottom: 1.75rem;
}
.dyn-hero-title .thin { color: rgba(255,255,255,0.2); }
.dyn-hero-title .gold { color: var(--amber); }
.dyn-hero-desc { font-size: 1rem; line-height: 1.75; color: rgba(255,255,255,0.6); max-width: 520px; margin-bottom: 2.5rem; font-weight: 300; }
.dyn-hero-btns { display: flex; gap: 1rem; }
.dyn-btn-amber { display: inline-flex; align-items: center; gap: 0.6rem; background: var(--amber); color: var(--navy); padding: 0.95rem 2.2rem; border-radius: 6px; font-weight: 700; font-size: 0.95rem; text-decoration: none; transition: background 0.2s, transform 0.2s; }
.dyn-btn-amber:hover { background: var(--amber-bright); transform: translateY(-2px); }
.dyn-btn-ghost { display: inline-flex; align-items: center; gap: 0.6rem; background: transparent; color: var(--white); padding: 0.95rem 2.2rem; border-radius: 6px; border: 1px solid rgba(255,255,255,0.2); font-weight: 500; font-size: 0.95rem; text-decoration: none; transition: border-color 0.2s; }
.dyn-btn-ghost:hover { border-color: rgba(255,255,255,0.5); }

/* Hero panel — DB slides */
.dyn-hero-panel { position: relative; z-index: 1; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; overflow: hidden; }
.dyn-panel-header { padding: 1rem 1.25rem; border-bottom: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; gap: 0.75rem; }
.dyn-panel-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--amber); }
.dyn-panel-header span { font-size: 0.75rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--muted); }
.dyn-slide-list { padding: 0.75rem; display: flex; flex-direction: column; gap: 0.5rem; }
.dyn-slide-item { padding: 0.9rem 1rem; border-radius: 10px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07); display: flex; align-items: center; gap: 0.9rem; cursor: pointer; transition: background 0.2s, border-color 0.2s, transform 0.2s; text-decoration: none; color: inherit; }
.dyn-slide-item:hover { background: rgba(232,160,32,0.1); border-color: rgba(232,160,32,0.3); transform: translateX(4px); }
.dyn-slide-icon { width: 38px; height: 38px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; background: rgba(232,160,32,0.15); }
.dyn-slide-text h4 { font-size: 0.85rem; font-weight: 600; margin-bottom: 0.15rem; }
.dyn-slide-text p { font-size: 0.72rem; color: var(--muted); }
.dyn-slide-arrow { margin-left: auto; color: rgba(255,255,255,0.2); font-size: 0.875rem; transition: color 0.2s, transform 0.2s; }
.dyn-slide-item:hover .dyn-slide-arrow { color: var(--amber); transform: translateX(3px); }
.dyn-panel-footer { padding: 1rem 1.25rem; border-top: 1px solid rgba(255,255,255,0.08); font-size: 0.72rem; color: var(--muted); text-align: center; }

/* Ticker */
.dyn-ticker { background: var(--amber); color: var(--navy); padding: 0.7rem 0; overflow: hidden; display: flex; }
.dyn-ticker-inner { display: flex; white-space: nowrap; animation: ticker 25s linear infinite; }
.dyn-ticker-item { display: inline-flex; align-items: center; gap: 1rem; padding: 0 2rem; font-family: 'Bebas Neue', sans-serif; font-size: 1rem; letter-spacing: 0.08em; }
.dyn-ticker-sep { opacity: 0.4; }
@keyframes ticker { from{transform:translateX(0)} to{transform:translateX(-50%)} }

/* ── AUDIENCE ── */
.dyn-audience { padding: 7rem 4rem; background: var(--navy); }
.dyn-section-eyebrow { display: flex; align-items: center; gap: 1rem; margin-bottom: 0.75rem; }
.dyn-eyebrow-line { width: 32px; height: 2px; background: var(--amber); }
.dyn-eyebrow-text { font-size: 0.72rem; font-weight: 600; letter-spacing: 0.16em; text-transform: uppercase; color: var(--amber); }
.dyn-section-title { font-family: 'Bebas Neue', sans-serif; font-size: clamp(2.5rem, 5vw, 4rem); line-height: 1; letter-spacing: 0.03em; margin-bottom: 0.75rem; }
.dyn-section-sub { font-size: 1rem; color: var(--muted); line-height: 1.7; max-width: 480px; margin-bottom: 3rem; font-weight: 300; }

.dyn-audience-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 1.5rem; }
.dyn-acard { border-radius: 16px; overflow: hidden; border: 1px solid rgba(255,255,255,0.08); cursor: pointer; transition: transform 0.3s; }
.dyn-acard:hover { transform: translateY(-8px); }
.dyn-acard-head { height: 120px; position: relative; display: flex; align-items: flex-end; padding: 1.25rem; }
.dyn-acard:nth-child(1) .dyn-acard-head { background: linear-gradient(135deg,#1A2C5B,#0D1A35); }
.dyn-acard:nth-child(2) .dyn-acard-head { background: linear-gradient(135deg,#3A1A05,#6B3210); }
.dyn-acard:nth-child(3) .dyn-acard-head { background: linear-gradient(135deg,#0A2A1A,#0F3D25); }
.dyn-acard-icon { font-size: 2.5rem; opacity: 0.5; position: absolute; top: 1rem; right: 1.25rem; }
.dyn-acard-tag { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; padding: 0.3rem 0.75rem; border-radius: 4px; background: rgba(255,255,255,0.15); color: rgba(255,255,255,0.8); }
.dyn-acard-body { background: rgba(255,255,255,0.04); padding: 1.5rem; border-top: 1px solid rgba(255,255,255,0.06); }
.dyn-acard-body h3 { font-weight: 600; font-size: 1rem; margin-bottom: 0.6rem; }
.dyn-acard-body p { font-size: 0.875rem; color: var(--muted); line-height: 1.65; margin-bottom: 1rem; }
.dyn-acard-link { display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.8rem; font-weight: 600; color: var(--amber); text-decoration: none; transition: gap 0.2s; }
.dyn-acard-link:hover { gap: 0.6rem; }

/* ── SERVICES SLIDESHOW ── */
.dyn-services { padding: 7rem 4rem; background: var(--navy-3); border-top: 1px solid rgba(255,255,255,0.05); }
.dyn-ss-wrap { overflow-x: hidden; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08); margin-top: 2.5rem; }
.dyn-ss-track { display: flex; }
.dyn-ss-slide { flex: 0 0 100%; min-width: 0; display: flex; flex-direction: row; min-height: 420px; }
.dyn-ss-img { flex: 3; position: relative; min-height: 420px; background-size: cover; background-position: center; }
.dyn-ss-overlay { position: absolute; inset: 0; background: linear-gradient(to right, rgba(6,13,31,0.1), rgba(6,13,31,0.55)); }
.dyn-ss-img-content { position: absolute; bottom: 2rem; left: 2rem; }
.dyn-ss-badge { display: inline-block; background: var(--amber); color: var(--navy); padding: 0.3rem 0.85rem; border-radius: 4px; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 0.6rem; }
.dyn-ss-img-title { font-family: 'Bebas Neue', sans-serif; font-size: 2.2rem; line-height: 1; letter-spacing: 0.03em; color: var(--white); text-shadow: 0 2px 12px rgba(0,0,0,0.5); }
.dyn-ss-body { flex: 2; background: rgba(255,255,255,0.04); border-left: 1px solid rgba(255,255,255,0.08); padding: 3rem 2.5rem; display: flex; flex-direction: column; justify-content: center; gap: 1rem; }
.dyn-ss-counter { font-family: 'Bebas Neue', sans-serif; font-size: 2.5rem; color: var(--amber); line-height: 1; }
.dyn-ss-counter span { color: rgba(255,255,255,0.2); font-size: 1.5rem; }
.dyn-ss-body p { font-size: 0.9rem; color: rgba(255,255,255,0.6); line-height: 1.8; font-weight: 300; }
.dyn-ss-link { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.85rem; font-weight: 600; color: var(--amber); text-decoration: none; transition: gap 0.2s; width: fit-content; }
.dyn-ss-link:hover { gap: 0.7rem; }
.dyn-progress { height: 2px; background: rgba(255,255,255,0.08); margin-top: 1.25rem; border-radius: 2px; overflow: hidden; }
.dyn-progress-bar { height: 100%; background: var(--amber); width: 25%; border-radius: 2px; transition: width 0.4s ease; }
.dyn-ss-controls { display: flex; align-items: center; justify-content: flex-end; gap: 1rem; margin-top: 1rem; }
.dyn-ss-btn { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); color: var(--white); width: 42px; height: 42px; border-radius: 8px; cursor: pointer; font-size: 1rem; transition: background 0.2s; display: flex; align-items: center; justify-content: center; }
.dyn-ss-btn:hover { background: var(--amber); border-color: var(--amber); color: var(--navy); }
.dyn-ss-dots { display: flex; gap: 0.4rem; align-items: center; }
.dyn-ss-dot { width: 7px; height: 7px; border-radius: 50%; background: rgba(255,255,255,0.2); border: none; cursor: pointer; transition: background 0.2s, transform 0.2s; padding: 0; }
.dyn-ss-dot.active { background: var(--amber); transform: scale(1.4); }

/* ── NEWS & EVENTS ── */
.dyn-hne { padding: 7rem 4rem; background: var(--navy-2); border-top: 1px solid rgba(255,255,255,0.05); }
.dyn-hne-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-top: 2.5rem; }
.dyn-hne-col h3 { font-family: 'Bebas Neue', sans-serif; font-size: 1.4rem; letter-spacing: 0.05em; color: var(--amber); margin-bottom: 1.25rem; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(232,160,32,0.3); }
.dyn-hne-item { padding: 0.9rem 0; border-bottom: 1px solid rgba(255,255,255,0.06); }
.dyn-hne-item .date { font-size: 0.72rem; color: rgba(255,255,255,0.3); margin-bottom: 0.25rem; }
.dyn-hne-item a { color: rgba(255,255,255,0.8); text-decoration: none; font-size: 0.875rem; font-weight: 500; line-height: 1.4; transition: color 0.2s; }
.dyn-hne-item a:hover { color: var(--amber); }
.dyn-hne-more { display: inline-flex; align-items: center; gap: 0.3rem; margin-top: 1rem; color: var(--amber); font-weight: 600; font-size: 0.875rem; text-decoration: none; }

/* ── ABOUT ── */
.dyn-about { padding: 7rem 4rem; background: var(--navy); }
.dyn-about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; margin-top: 2.5rem; }
.dyn-about-img { border-radius: 16px; overflow: hidden; border: 1px solid rgba(255,255,255,0.08); }
.dyn-about-img img { width: 100%; height: 340px; object-fit: cover; display: block; }
.dyn-about-text p { font-size: 0.95rem; color: rgba(255,255,255,0.6); line-height: 1.8; margin-bottom: 1.25rem; font-weight: 300; }
.dyn-about-text a { display: inline-flex; align-items: center; gap: 0.5rem; background: var(--amber); color: var(--navy); padding: 0.85rem 2rem; border-radius: 6px; font-weight: 700; font-size: 0.9rem; text-decoration: none; margin-top: 0.5rem; transition: background 0.2s, transform 0.2s; }
.dyn-about-text a:hover { background: var(--amber-bright); transform: translateY(-2px); }

/* ── MISSION / VALUES ── */
.dyn-mv { padding: 7rem 4rem; background: var(--navy-3); }
.dyn-mv-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 2.5rem; }
.dyn-mv-card { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07); border-radius: 16px; padding: 2.5rem; }
.dyn-mv-card h3 { font-family: 'Bebas Neue', sans-serif; font-size: 1.4rem; letter-spacing: 0.05em; color: var(--amber); margin-bottom: 1rem; }
.dyn-mv-card p { font-size: 0.9rem; color: rgba(255,255,255,0.55); line-height: 1.75; }
.dyn-values-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 1.25rem; margin-top: 2rem; }
.dyn-val { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07); border-radius: 12px; padding: 1.5rem; transition: border-color 0.2s; }
.dyn-val:hover { border-color: rgba(232,160,32,0.3); }
.dyn-val h4 { font-size: 0.875rem; font-weight: 600; color: var(--white); margin-bottom: 0.5rem; }
.dyn-val p { font-size: 0.82rem; color: rgba(255,255,255,0.4); line-height: 1.65; }

/* ── CTA ── */
.dyn-cta { padding: 7rem 4rem; text-align: center; position: relative; overflow: hidden; }
.dyn-cta::before { content:''; position:absolute; inset:0; background: radial-gradient(ellipse 70% 70% at 50% 100%, rgba(232,160,32,0.1) 0%, transparent 70%); pointer-events: none; }
.dyn-cta h2 { font-family: 'Bebas Neue', sans-serif; font-size: clamp(3rem, 6vw, 5rem); margin-bottom: 1.5rem; position: relative; }
.dyn-cta h2 .gold { color: var(--amber); }
.dyn-cta h2 .thin { color: rgba(255,255,255,0.2); }
.dyn-cta p { color: var(--muted); max-width: 460px; margin: 0 auto 2.5rem; line-height: 1.7; font-weight: 300; position: relative; }
.dyn-cta-btns { display: flex; gap: 1rem; justify-content: center; position: relative; }

/* ── POPUP ── */
#eventPopup { position:fixed;bottom:20px;right:20px;background:rgba(15,26,46,0.96);border:1px solid rgba(232,160,32,0.3);box-shadow:0 8px 24px rgba(0,0,0,0.5);z-index:9999;width:200px;border-radius:12px;font-family:'Space Grotesk',sans-serif;padding:14px;text-align:center; }
#eventPopup img { max-width:100%;max-height:80px;margin-bottom:8px;border-radius:6px; }
#eventPopup h3 { margin:6px 0;color:#fff;font-size:0.9em;font-weight:600;line-height:1.2; }
#eventPopup p { font-size:0.78em;color:rgba(255,255,255,0.5);line-height:1.3;margin:4px 0; }
.popup-close { position:absolute;top:4px;right:8px;cursor:pointer;font-size:16px;color:rgba(255,255,255,0.4); }
.popup-btn-row { display:flex;justify-content:center;gap:8px;margin-top:10px; }
.popup-btn { padding:7px 14px;background:var(--amber);color:var(--navy);text-decoration:none;border:none;border-radius:6px;font-size:0.8em;font-weight:700;cursor:pointer; }
.popup-close-btn { background:rgba(255,255,255,0.1);color:#fff; }
@keyframes bounceFromBottom { 0%{transform:translateY(0)}50%{transform:translateY(-60px)}100%{transform:translateY(0)} }
.bounce { animation:bounceFromBottom 3s ease-in-out; }

/* ── RESPONSIVE ── */
@media (max-width: 900px) {
  .dyn-hero { grid-template-columns: 1fr; padding: 5rem 1.5rem 3rem; }
  .dyn-hero-panel { display: none; }
  .dyn-audience-grid, .dyn-hne-grid, .dyn-about-grid, .dyn-mv-grid { grid-template-columns: 1fr; }
  .dyn-values-grid { grid-template-columns: 1fr 1fr; }
  .dyn-audience, .dyn-services, .dyn-hne, .dyn-about, .dyn-mv, .dyn-cta { padding: 4rem 1.5rem; }
  .dyn-ss-slide { flex-direction: column; }
  .dyn-ss-img { min-height: 240px; }
}
</style>
</head>

<div class="mba-dyn">

<!-- ══════════════════ HERO ══════════════════ -->
<section class="dyn-hero">
  <div class="dyn-hero-grid"></div>
  <div class="dyn-hero-glow"></div>

  <div class="dyn-hero-left">
    <div class="dyn-pretitle">
      <div class="dyn-pretitle-dot"></div>
      <span class="dyn-pretitle-text">Changing Kenya. One road at a time.</span>
    </div>
    <h1 class="dyn-hero-title">
      <div>SAFER</div>
      <div class="thin">ROADS,</div>
      <div class="gold">STRONGER</div>
      <div>COMMUNITIES.</div>
    </h1>
    <p class="dyn-hero-desc">
      Mfano Bora Africa brings together road safety education, professional driver training,
      logistics consulting, and skills development — united by one purpose: raising the
      standard of life in Kenya.
    </p>
    <div class="dyn-hero-btns">
      <a href="/events/" class="dyn-btn-amber">Explore Our Work →</a>
      <a href="/contact-us/" class="dyn-btn-ghost">Get in Touch</a>
    </div>
  </div>

  <!-- Panel: shows DB slides as links -->
  <div class="dyn-hero-panel">
    <div class="dyn-panel-header">
      <div class="dyn-panel-dot"></div>
      <span>Our Core Services</span>
    </div>
    <div class="dyn-slide-list">
      <?php if (!empty($slides)): ?>
        <?php foreach (array_slice($slides, 0, 4) as $slide): ?>
          <a href="<?= htmlspecialchars($slide['cta_link'] ?? '#') ?>" class="dyn-slide-item">
            <div class="dyn-slide-icon">🔗</div>
            <div class="dyn-slide-text">
              <h4><?= htmlspecialchars($slide['title']) ?></h4>
              <p><?= htmlspecialchars(mb_substr(strip_tags($slide['description']), 0, 50)) ?>...</p>
            </div>
            <span class="dyn-slide-arrow">→</span>
          </a>
        <?php endforeach; ?>
      <?php else: ?>
        <a href="/events/" class="dyn-slide-item"><div class="dyn-slide-icon">🏆</div><div class="dyn-slide-text"><h4>EA Transport Awards</h4><p>Excellence in East Africa transport</p></div><span class="dyn-slide-arrow">→</span></a>
        <a href="/notices/" class="dyn-slide-item"><div class="dyn-slide-icon">🎓</div><div class="dyn-slide-text"><h4>Industrial Attachments</h4><p>ICT, logistics & admin programmes</p></div><span class="dyn-slide-arrow">→</span></a>
        <a href="/events/" class="dyn-slide-item"><div class="dyn-slide-icon">🛡️</div><div class="dyn-slide-text"><h4>Road Safety Club</h4><p>Nationwide awareness campaigns</p></div><span class="dyn-slide-arrow">→</span></a>
        <a href="/events/" class="dyn-slide-item"><div class="dyn-slide-icon">🚗</div><div class="dyn-slide-text"><h4>Smart Drivers Club</h4><p>Skills, safety & responsible driving</p></div><span class="dyn-slide-arrow">→</span></a>
      <?php endif; ?>
    </div>
    <div class="dyn-panel-footer">Select a service to learn more</div>
  </div>
</section>

<!-- Ticker -->
<div class="dyn-ticker">
  <div class="dyn-ticker-inner">
    <span class="dyn-ticker-item">EA Transport Awards <span class="dyn-ticker-sep">✦</span></span>
    <span class="dyn-ticker-item">Industrial Attachments Kenya <span class="dyn-ticker-sep">✦</span></span>
    <span class="dyn-ticker-item">Road Safety Club <span class="dyn-ticker-sep">✦</span></span>
    <span class="dyn-ticker-item">Smart Drivers Club <span class="dyn-ticker-sep">✦</span></span>
    <span class="dyn-ticker-item">EA Transport Awards <span class="dyn-ticker-sep">✦</span></span>
    <span class="dyn-ticker-item">Industrial Attachments Kenya <span class="dyn-ticker-sep">✦</span></span>
    <span class="dyn-ticker-item">Road Safety Club <span class="dyn-ticker-sep">✦</span></span>
    <span class="dyn-ticker-item">Smart Drivers Club <span class="dyn-ticker-sep">✦</span></span>
  </div>
</div>

<!-- ══════════════════ FIND YOUR PATH ══════════════════ -->
<section class="dyn-audience">
  <div class="dyn-section-eyebrow"><div class="dyn-eyebrow-line"></div><span class="dyn-eyebrow-text">Find Your Path</span></div>
  <h2 class="dyn-section-title">WHO ARE YOU <span style="color:rgba(255,255,255,0.2)">HERE FOR?</span></h2>
  <p class="dyn-section-sub">We serve people with very different goals. Pick your path and we'll take you straight to what matters for you.</p>
  <div class="dyn-audience-grid">
    <div class="dyn-acard">
      <div class="dyn-acard-head"><span class="dyn-acard-icon">🎓</span><span class="dyn-acard-tag">Students & Interns</span></div>
      <div class="dyn-acard-body"><h3>Students & Attachment Seekers</h3><p>Structured industrial attachment programmes and career development built to launch your professional journey.</p><a href="/notices/" class="dyn-acard-link">Find opportunities →</a></div>
    </div>
    <div class="dyn-acard">
      <div class="dyn-acard-head"><span class="dyn-acard-icon">🏢</span><span class="dyn-acard-tag">Corporate</span></div>
      <div class="dyn-acard-body"><h3>Corporate & Business Partners</h3><p>Fleet safety audits, logistics consulting, and employee road safety training that protects your people and your bottom line.</p><a href="/contact-us/" class="dyn-acard-link">Partner with us →</a></div>
    </div>
    <div class="dyn-acard">
      <div class="dyn-acard-head"><span class="dyn-acard-icon">🌍</span><span class="dyn-acard-tag">Community</span></div>
      <div class="dyn-acard-body"><h3>Community Members</h3><p>Join the Smart Driver Club, participate in awareness campaigns, and help build a culture of safety on Kenya's roads.</p><a href="/events/" class="dyn-acard-link">Join the movement →</a></div>
    </div>
  </div>
</section>

<!-- ══════════════════ SERVICES SLIDESHOW ══════════════════ -->
<section class="dyn-services">
  <div class="dyn-section-eyebrow"><div class="dyn-eyebrow-line"></div><span class="dyn-eyebrow-text">Work in Action</span></div>
  <h2 class="dyn-section-title">REAL WORK. <span style="color:var(--amber)">REAL IMPACT.</span></h2>
  <p class="dyn-section-sub" style="margin-bottom:0;">Each service is a direct response to a real need in Kenya.</p>

  <div class="dyn-ss-wrap" id="dynServWrap">
    <div class="dyn-ss-track">
      <?php foreach ($service_slides as $i => $s): ?>
      <div class="dyn-ss-slide">
        <div class="dyn-ss-img" style="background-image:url('<?= htmlspecialchars($s['img']) ?>');">
          <div class="dyn-ss-overlay"></div>
          <div class="dyn-ss-img-content">
            <span class="dyn-ss-badge"><?= htmlspecialchars($s['tag']) ?></span>
            <h3 class="dyn-ss-img-title"><?= htmlspecialchars($s['title']) ?></h3>
          </div>
        </div>
        <div class="dyn-ss-body">
          <div class="dyn-ss-counter"><?= str_pad($i+1,2,'0',STR_PAD_LEFT) ?> <span>/ <?= str_pad(count($service_slides),2,'0',STR_PAD_LEFT) ?></span></div>
          <p><?= htmlspecialchars($s['body']) ?></p>
          <a href="<?= htmlspecialchars($s['link']) ?>" class="dyn-ss-link">Learn More →</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="dyn-progress"><div class="dyn-progress-bar" id="dynProgress"></div></div>
  <div class="dyn-ss-controls">
    <button class="dyn-ss-btn" onclick="dynPrev()">←</button>
    <div class="dyn-ss-dots" id="dynServDots">
      <?php foreach ($service_slides as $i => $_): ?>
        <button class="dyn-ss-dot <?= $i===0?'active':'' ?>" onclick="dynGo(<?= $i ?>)"></button>
      <?php endforeach; ?>
    </div>
    <button class="dyn-ss-btn" onclick="dynNext()">→</button>
  </div>
</section>

<!-- ══════════════════ NEWS & EVENTS ══════════════════ -->
<section class="dyn-hne">
  <div class="dyn-section-eyebrow"><div class="dyn-eyebrow-line"></div><span class="dyn-eyebrow-text">What's Happening</span></div>
  <h2 class="dyn-section-title">LATEST <span style="color:var(--amber)">NEWS & EVENTS</span></h2>
  <div class="dyn-hne-grid">
    <div class="dyn-hne-col">
      <h3>Latest Notices</h3>
      <?php foreach ($news_items as $n): ?>
        <div class="dyn-hne-item">
          <a href="<?= newsUrl($n['id'], $n['title']) ?>"><?= htmlspecialchars($n['title']) ?></a>
        </div>
      <?php endforeach; ?>
      <a href="/notices/" class="dyn-hne-more">More Notices →</a>
    </div>
    <div class="dyn-hne-col">
      <h3>Upcoming Events</h3>
      <?php foreach ($events as $e):
        $slug = slugify($e['title']);
        $eventUrl = "/events/{$e['id']}-{$slug}";
      ?>
        <div class="dyn-hne-item">
          <div class="date"><?= date("F j, Y", strtotime($e['event_date'])) ?></div>
          <a href="<?= htmlspecialchars($eventUrl) ?>"><?= htmlspecialchars($e['title']) ?></a>
        </div>
      <?php endforeach; ?>
      <a href="/events/" class="dyn-hne-more">View All →</a>
    </div>
  </div>
</section>

<!-- ══════════════════ ABOUT ══════════════════ -->
<section class="dyn-about">
  <div class="dyn-section-eyebrow"><div class="dyn-eyebrow-line"></div><span class="dyn-eyebrow-text">About Us</span></div>
  <h2 class="dyn-section-title">24 YEARS OF <span style="color:var(--amber)">RAISING KENYA'S STANDARD.</span></h2>
  <div class="dyn-about-grid">
    <div class="dyn-about-img"><img src="/assets/images/our-history.png" alt="Our History"></div>
    <div class="dyn-about-text">
      <p>Mfano Bora Africa Limited is the leading consulting firm in Logistics, providing integrated supply chain management consulting services that optimise operations across planning, sourcing, distribution and customer service.</p>
      <p>We are the home of the <strong style="color:var(--amber)">East Africa Transport, Logistics & Road Safety Awards</strong> for the past 24 years, and currently operate more than 500 Road Safety Clubs across the region.</p>
      <a href="/contact-us/">Get in Touch →</a>
    </div>
  </div>
</section>

<!-- ══════════════════ MISSION & VALUES ══════════════════ -->
<section class="dyn-mv">
  <div class="dyn-section-eyebrow"><div class="dyn-eyebrow-line"></div><span class="dyn-eyebrow-text">Our Foundation</span></div>
  <h2 class="dyn-section-title">MISSION, VISION <span style="color:rgba(255,255,255,0.2)">&</span> <span style="color:var(--amber)">VALUES</span></h2>
  <div class="dyn-mv-grid">
    <div class="dyn-mv-card"><h3>Our Mission</h3><p>To relentlessly focus on helping our partners succeed by serving their logistics needs through unparalleled expertise, technological agility, and continuous innovation.</p></div>
    <div class="dyn-mv-card"><h3>Our Vision</h3><p>To be the leading logistics consultant in Africa, recognised for excellence, innovation, and commitment to safety and sustainability.</p></div>
  </div>
  <div class="dyn-values-grid" style="margin-top:2rem;">
    <div class="dyn-val"><h4>Preservation of Human Life</h4><p>Protecting and saving lives is our highest priority.</p></div>
    <div class="dyn-val"><h4>Whole Community Participation</h4><p>Active involvement of individuals and authorities to create safer communities.</p></div>
    <div class="dyn-val"><h4>Partnership</h4><p>Strong relationships with stakeholders to share resources and achieve greater impact.</p></div>
    <div class="dyn-val"><h4>Capacity Development</h4><p>Equipping people with skills and knowledge to prevent accidents.</p></div>
    <div class="dyn-val"><h4>Sustainability</h4><p>Long-term solutions improving safety and community well-being.</p></div>
    <div class="dyn-val"><h4>Road Accidents Are Avoidable</h4><p>With education and infrastructure, accidents can be significantly reduced.</p></div>
  </div>
</section>

<!-- ══════════════════ CTA ══════════════════ -->
<section class="dyn-cta">
  <h2><span class="thin">LET'S</span> <span class="gold">BUILD</span><br><span class="thin">SOMETHING</span> TOGETHER.</h2>
  <p>Whether you're a student, a business, or a community advocate — there's a place for you at Mfano Bora Africa.</p>
  <div class="dyn-cta-btns">
    <a href="/contact-us/" class="dyn-btn-amber">Get in Touch →</a>
    <a href="/events/" class="dyn-btn-ghost">View Events</a>
  </div>
</section>

</div><!-- end .mba-dyn -->

<!-- ══════════════════ POPUP ══════════════════ -->
<?php if ($event): ?>
<div id="eventPopup" class="bounce">
  <span class="popup-close" onclick="closePopup()">&times;</span>
  <div class="popup-content">
    <?php if (!empty($event['banner_url'])): ?>
      <img src="<?= htmlspecialchars('/' . ltrim($event['banner_url'], '/')) ?>" alt="Event Banner">
    <?php endif; ?>
    <h3><?= htmlspecialchars($event['title']) ?></h3>
    <p style="font-size:12px;"><strong>Date:</strong> <?= date('F j, Y', strtotime($event['event_date'])) ?></p>
    <div class="popup-btn-row">
      <a href="/events/" class="popup-btn">View More</a>
      <button class="popup-btn popup-close-btn" onclick="closePopup()">Close</button>
    </div>
  </div>
</div>
<?php endif; ?>

<script>
// ── Services slideshow ──
var dynCur = 0;
var dynTotal = <?= count($service_slides) ?>;
var dynTimer;

function dynGo(idx) {
  dynCur = idx;
  var w = document.getElementById('dynServWrap');
  if (w) w.scrollLeft = idx * w.offsetWidth;
  document.querySelectorAll('.dyn-ss-dot').forEach(function(d,i){ d.classList.toggle('active', i===idx); });
  var prog = document.getElementById('dynProgress');
  if (prog) prog.style.width = ((idx+1)/dynTotal*100) + '%';
  clearInterval(dynTimer);
  dynTimer = setInterval(function(){ dynGo((dynCur+1)%dynTotal); }, 5000);
}
function dynNext() { dynGo((dynCur+1)%dynTotal); }
function dynPrev() { dynGo((dynCur-1+dynTotal)%dynTotal); }

window.addEventListener('load', function(){
  dynTimer = setInterval(function(){ dynGo((dynCur+1)%dynTotal); }, 5000);
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
