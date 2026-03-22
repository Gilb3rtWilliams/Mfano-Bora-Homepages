<?php
// ── STANDALONE PREVIEW MODE (no database required) ──
$page_title = "Home - Mfano Bora Africa Ltd";
$slides = [];
$events = [];
$news_items = [];
$priority_items = [];
$event = null;

function slugify($text) {
  $text = strtolower(trim($text));
  $text = preg_replace('/[^a-z0-9]+/', '-', $text);
  return trim($text, '-');
}
function formatNoticeContent($text) {
  return nl2br(htmlspecialchars($text));
}
function newsUrl($id, $title) {
  $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
  return "/notices/{$id}-{$slug}";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Mfano Bora Africa — Road safety, driver training, logistics consulting and skills development across Kenya and East Africa.">
  <title>Home - Mfano Bora Africa Ltd</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Source+Sans+3:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    /* ════════════════════════════════════════
       GLOBAL RESET & CSS VARIABLES
    ════════════════════════════════════════ */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --gold: #C8910A;
      --gold-light: #F5D380;
      --gold-pale: #FBF3DC;
      --navy: #0D1E3D;
      --navy-mid: #1A3260;
      --navy-light: #E8EDF5;
      --white: #FFFFFF;
      --off-white: #F9F7F3;
      --text: #1A1A2E;
      --text-mid: #4A5568;
      --text-light: #8896A8;
      --rule: #E2E8F0;
    }

    html { scroll-behavior: smooth; }
    body {
      font-family: 'Source Sans 3', sans-serif;
      background: var(--white);
      color: var(--text);
      overflow-x: hidden;
    }

    /* ════════════════════════════════════════
       TOP BAR
    ════════════════════════════════════════ */
    .mb-topbar {
      background: var(--navy);
      padding: 0.4rem 2.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 1.5rem;
      font-size: 0.78rem;
      color: rgba(255,255,255,0.55);
    }
    .mb-topbar-left { letter-spacing: 0.03em; }
    .mb-topbar-right { display: flex; gap: 1.5rem; }
    .mb-topbar a {
      color: var(--gold-light);
      text-decoration: none;
      transition: color 0.2s;
    }
    .mb-topbar a:hover { color: #fff; }
    .mb-topbar span { color: rgba(255,255,255,0.3); }

    /* ════════════════════════════════════════
       MAIN NAVIGATION
    ════════════════════════════════════════ */
    .mb-nav {
      position: sticky;
      top: 0;
      z-index: 1000;
      background: var(--white);
      border-bottom: 1px solid var(--rule);
      box-shadow: 0 1px 12px rgba(0,0,0,0.06);
      padding: 0 2.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 72px;
    }
    .mb-nav-brand {
      display: flex;
      align-items: center;
      gap: 0.85rem;
      text-decoration: none;
    }
    .mb-nav-brand img {
      height: 48px;
      width: auto;
      object-fit: contain;
    }
    .mb-nav-logo-circle {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: var(--navy);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .mb-nav-brand-text { display: flex; flex-direction: column; }
    .mb-nav-brand-text .name {
      font-family: 'Playfair Display', serif;
      font-size: 0.95rem;
      font-weight: 700;
      color: var(--navy);
      line-height: 1.2;
    }
    .mb-nav-brand-text .tagline {
      font-size: 0.68rem;
      color: var(--text-light);
      letter-spacing: 0.05em;
      text-transform: uppercase;
    }

    /* Nav links */
    .mb-nav-links {
      display: flex;
      align-items: center;
      list-style: none;
      gap: 0;
      height: 72px;
    }
    .mb-nav-links > li {
      position: relative;
      height: 100%;
      display: flex;
      align-items: center;
    }
    .mb-nav-links > li > a,
    .mb-nav-links > li > span {
      display: flex;
      align-items: center;
      gap: 0.3rem;
      padding: 0 1rem;
      height: 100%;
      color: var(--text-mid);
      text-decoration: none;
      font-size: 0.875rem;
      font-weight: 500;
      cursor: pointer;
      border-bottom: 3px solid transparent;
      transition: color 0.2s, border-color 0.2s;
      white-space: nowrap;
    }
    .mb-nav-links > li > a:hover,
    .mb-nav-links > li > span:hover,
    .mb-nav-links > li > a.active {
      color: var(--navy);
      border-bottom-color: var(--gold);
    }
    .mb-nav-links > li > a .arrow,
    .mb-nav-links > li > span .arrow {
      font-size: 0.6rem;
      opacity: 0.6;
      margin-left: 0.1rem;
    }

    /* Dropdowns */
    .mb-dropdown {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background: var(--white);
      min-width: 200px;
      border-top: 3px solid var(--gold);
      border-radius: 0 0 8px 8px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.12);
      list-style: none;
      z-index: 100;
    }
    .mb-nav-links > li:hover .mb-dropdown { display: block; }
    .mb-dropdown li a {
      display: block;
      padding: 0.75rem 1.25rem;
      color: #444;
      text-decoration: none;
      font-size: 0.85rem;
      border-bottom: 1px solid #f5f5f5;
      transition: background 0.2s, color 0.2s;
    }
    .mb-dropdown li:last-child a { border-bottom: none; }
    .mb-dropdown li a:hover { background: #fffaf0; color: var(--gold); }

    /* Nav actions */
    .mb-nav-actions { display: flex; gap: 0.75rem; align-items: center; }
    .mb-nav-btn-outline {
      padding: 0.55rem 1.25rem;
      border: 1.5px solid var(--navy);
      border-radius: 4px;
      color: var(--navy);
      text-decoration: none;
      font-size: 0.875rem;
      font-weight: 600;
      transition: background 0.2s, color 0.2s;
    }
    .mb-nav-btn-outline:hover { background: var(--navy); color: #fff; }
    .mb-nav-btn-solid {
      padding: 0.55rem 1.4rem;
      background: var(--gold);
      border: 1.5px solid var(--gold);
      border-radius: 4px;
      color: #fff;
      text-decoration: none;
      font-size: 0.875rem;
      font-weight: 600;
      transition: background 0.2s;
    }
    .mb-nav-btn-solid:hover { background: #A87508; }

    /* Hamburger */
    .mb-hamburger {
      display: none;
      flex-direction: column;
      gap: 5px;
      cursor: pointer;
      padding: 0.5rem;
    }
    .mb-hamburger span {
      display: block;
      width: 24px;
      height: 2px;
      background: #333;
      transition: all 0.3s;
    }

    @media (max-width: 1024px) {
      .mb-nav-links { display: none; }
      .mb-nav-actions { display: none; }
      .mb-hamburger { display: flex; }
      .mb-nav-links.open {
        display: flex;
        flex-direction: column;
        height: auto;
        position: absolute;
        top: 72px;
        left: 0;
        right: 0;
        background: #fff;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        padding: 1rem 0;
        gap: 0;
      }
      .mb-nav-links.open > li { height: auto; }
      .mb-nav-links.open > li > a,
      .mb-nav-links.open > li > span {
        padding: 0.75rem 2rem;
        border-bottom: 1px solid #f0f0f0;
        height: auto;
        width: 100%;
      }
      .mb-dropdown { position: static; box-shadow: none; border-top: none; border-radius: 0; display: none !important; }
    }

    /* ════════════════════════════════════════
       HERO
    ════════════════════════════════════════ */
    .corp-hero {
      background: var(--navy);
      min-height: 88vh;
      display: grid;
      grid-template-columns: 55% 45%;
      position: relative;
      overflow: hidden;
    }
    .corp-hero::after {
      content: '';
      position: absolute;
      top: 0; right: 0;
      width: 48%; height: 100%;
      background: var(--gold-pale);
      clip-path: polygon(12% 0%, 100% 0%, 100% 100%, 0% 100%);
      z-index: 0;
    }
    .corp-hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image: radial-gradient(circle, rgba(200,145,10,0.08) 1px, transparent 1px);
      background-size: 32px 32px;
      z-index: 0;
    }
    .corp-hero-left {
      position: relative; z-index: 1;
      padding: 6rem 3rem 5rem 3.5rem;
      display: flex; flex-direction: column; justify-content: center;
    }
    .corp-hero-eyebrow {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 2rem;
    }
    .corp-hero-eyebrow-line { width: 40px; height: 2px; background: var(--gold); }
    .corp-hero-eyebrow span {
      font-size: 0.78rem;
      font-weight: 600;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--gold-light);
    }
    .corp-hero-headline {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2.8rem, 4vw, 4rem);
      font-weight: 700;
      color: var(--white);
      line-height: 1.15;
      margin-bottom: 1.75rem;
    }
    .corp-hero-headline em { font-style: italic; color: var(--gold-light); }
    .corp-hero-sub {
      font-size: 1.05rem;
      color: rgba(255,255,255,0.65);
      line-height: 1.75;
      max-width: 460px;
      margin-bottom: 2.5rem;
      font-weight: 300;
    }
    .corp-hero-actions {
      display: flex; gap: 1rem; flex-wrap: wrap;
      margin-bottom: 3.5rem;
    }
    .corp-btn-primary {
      background: var(--gold);
      color: var(--white);
      padding: 0.85rem 2.2rem;
      border-radius: 4px;
      text-decoration: none;
      font-weight: 600;
      font-size: 0.95rem;
      transition: background 0.2s, transform 0.2s;
    }
    .corp-btn-primary:hover { background: #A87508; transform: translateY(-1px); }
    .corp-btn-ghost {
      background: transparent;
      color: var(--white);
      padding: 0.85rem 2.2rem;
      border: 1.5px solid rgba(255,255,255,0.3);
      border-radius: 4px;
      text-decoration: none;
      font-weight: 500;
      font-size: 0.95rem;
      transition: border-color 0.2s, background 0.2s;
    }
    .corp-btn-ghost:hover { border-color: rgba(255,255,255,0.7); background: rgba(255,255,255,0.07); }

    .corp-hero-stats {
      display: flex; gap: 2.5rem;
      padding-top: 2.5rem;
      border-top: 1px solid rgba(255,255,255,0.12);
    }
    .corp-hero-stat .num {
      font-family: 'Playfair Display', serif;
      font-size: 2.2rem;
      font-weight: 700;
      color: var(--gold-light);
      line-height: 1;
    }
    .corp-hero-stat .label {
      font-size: 0.8rem;
      color: rgba(255,255,255,0.5);
      margin-top: 0.3rem;
    }

    /* Hero right — service list cards */
    .corp-hero-right {
      position: relative; z-index: 1;
      padding: 5rem 3rem 5rem 5rem;
      display: flex; flex-direction: column; justify-content: center;
    }
    .corp-services-list { display: flex; flex-direction: column; gap: 1rem; }
    .corp-service-row {
      background: var(--white);
      border-radius: 8px;
      padding: 1.25rem 1.5rem;
      display: flex;
      align-items: center;
      gap: 1.25rem;
      box-shadow: 0 2px 16px rgba(13,30,61,0.08);
      transition: transform 0.2s, box-shadow 0.2s;
      cursor: pointer;
      text-decoration: none;
    }
    .corp-service-row:hover { transform: translateX(4px); box-shadow: 0 4px 24px rgba(13,30,61,0.14); }
    .corp-service-icon {
      width: 44px; height: 44px; flex-shrink: 0;
      background: var(--navy-light);
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.3rem;
    }
    .corp-service-row h4 { font-weight: 600; font-size: 0.95rem; color: var(--navy); margin-bottom: 0.2rem; }
    .corp-service-row p { font-size: 0.8rem; color: var(--text-light); }
    .corp-service-arrow { margin-left: auto; color: var(--gold); font-size: 1.1rem; }

    /* ════════════════════════════════════════
       INTRO QUOTE BAND
    ════════════════════════════════════════ */
    .corp-intro-band {
      background: var(--off-white);
      border-top: 1px solid var(--rule);
      border-bottom: 1px solid var(--rule);
      padding: 3.5rem 3rem;
      text-align: center;
    }
    .corp-intro-band p {
      font-family: 'Playfair Display', serif;
      font-size: 1.4rem;
      font-weight: 600;
      color: var(--navy-mid);
      max-width: 720px;
      margin: 0 auto;
      line-height: 1.6;
    }
    .corp-intro-band p em { color: var(--gold); font-style: italic; }

    /* ════════════════════════════════════════
       AUDIENCE SECTION
    ════════════════════════════════════════ */
    .corp-audience { padding: 6rem 3rem; background: var(--white); }
    .corp-section-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-bottom: 3rem;
      padding-bottom: 1.5rem;
      border-bottom: 1px solid var(--rule);
    }
    .corp-section-header-left .eyebrow {
      font-size: 0.75rem; font-weight: 600;
      letter-spacing: 0.1em; text-transform: uppercase;
      color: var(--gold); margin-bottom: 0.5rem;
    }
    .corp-section-header-left h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.2rem; font-weight: 700;
      color: var(--navy); line-height: 1.2;
    }
    .corp-section-header p {
      font-size: 0.9rem; color: var(--text-light);
      max-width: 280px; line-height: 1.65; text-align: right;
    }
    .corp-audience-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 2rem;
    }
    .corp-audience-card {
      border: 1px solid var(--rule);
      border-radius: 8px;
      overflow: hidden;
      transition: box-shadow 0.3s;
    }
    .corp-audience-card:hover { box-shadow: 0 8px 40px rgba(13,30,61,0.1); }
    .corp-audience-card-header {
      padding: 2rem;
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
    }
    .corp-audience-card:nth-child(1) .corp-audience-card-header { background: var(--navy); }
    .corp-audience-card:nth-child(2) .corp-audience-card-header { background: var(--gold); }
    .corp-audience-card:nth-child(3) .corp-audience-card-header { background: var(--off-white); }
    .corp-audience-icon { font-size: 2.2rem; }
    .corp-audience-tag {
      font-size: 0.7rem; font-weight: 700;
      letter-spacing: 0.08em; text-transform: uppercase;
      padding: 0.3rem 0.7rem; border-radius: 3px;
    }
    .corp-audience-card:nth-child(1) .corp-audience-tag { background: rgba(255,255,255,0.15); color: rgba(255,255,255,0.8); }
    .corp-audience-card:nth-child(2) .corp-audience-tag { background: rgba(255,255,255,0.3); color: var(--navy); }
    .corp-audience-card:nth-child(3) .corp-audience-tag { background: var(--navy-light); color: var(--navy); }
    .corp-audience-card-body { padding: 1.75rem 2rem; background: var(--white); }
    .corp-audience-card-body h3 {
      font-family: 'Playfair Display', serif;
      font-size: 1.15rem; font-weight: 700;
      color: var(--navy); margin-bottom: 0.75rem;
    }
    .corp-audience-card-body p {
      font-size: 0.875rem; color: var(--text-mid);
      line-height: 1.7; margin-bottom: 1.25rem;
    }
    .corp-audience-link {
      display: inline-flex; align-items: center; gap: 0.4rem;
      font-size: 0.875rem; font-weight: 600;
      color: var(--gold); text-decoration: none;
      border-bottom: 1px solid transparent;
      transition: border-color 0.2s;
    }
    .corp-audience-link:hover { border-bottom-color: var(--gold); }

    /* ════════════════════════════════════════
       PILLARS
    ════════════════════════════════════════ */
    .corp-pillars { background: var(--navy); padding: 6rem 3rem; }
    .corp-pillars-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-bottom: 3rem;
    }
    .corp-pillars-header .eyebrow {
      font-size: 0.75rem; font-weight: 700;
      letter-spacing: 0.1em; text-transform: uppercase;
      color: var(--gold-light); margin-bottom: 0.5rem;
    }
    .corp-pillars-header h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.2rem; font-weight: 700;
      color: #fff; line-height: 1.2;
    }
    .corp-pillars-header p {
      font-size: 0.9rem; color: rgba(255,255,255,0.45);
      max-width: 300px; text-align: right; line-height: 1.65;
    }
    .corp-pillars-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 0;
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 8px;
      overflow: hidden;
    }
    .corp-pillar {
      padding: 2.5rem 2rem;
      border-right: 1px solid rgba(255,255,255,0.1);
      transition: background 0.3s;
    }
    .corp-pillar:last-child { border-right: none; }
    .corp-pillar:hover { background: rgba(255,255,255,0.04); }
    .corp-pillar-num {
      font-family: 'Playfair Display', serif;
      font-size: 3rem;
      color: rgba(200,145,10,0.3);
      font-weight: 700;
      line-height: 1;
      margin-bottom: 1.25rem;
    }
    .corp-pillar h3 { font-weight: 600; font-size: 1rem; color: #fff; margin-bottom: 0.75rem; line-height: 1.3; }
    .corp-pillar p { font-size: 0.85rem; color: rgba(255,255,255,0.5); line-height: 1.65; }
    .corp-pillar-link {
      display: block;
      margin-top: 1.25rem;
      font-size: 0.8rem;
      color: var(--gold-light);
      text-decoration: none;
      font-weight: 600;
    }
    .corp-pillar-link:hover { text-decoration: underline; }

    /* ════════════════════════════════════════
       NEWS & EVENTS
    ════════════════════════════════════════ */
    .corp-hne { padding: 6rem 3rem; background: var(--white); }
    .corp-hne-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-bottom: 3rem;
      padding-bottom: 1.5rem;
      border-bottom: 1px solid var(--rule);
    }
    .corp-hne-header .eyebrow {
      font-size: 0.75rem; font-weight: 600;
      letter-spacing: 0.1em; text-transform: uppercase;
      color: var(--gold); margin-bottom: 0.5rem;
    }
    .corp-hne-header h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.2rem; font-weight: 700;
      color: var(--navy); line-height: 1.2;
    }
    .corp-hne-header a {
      font-size: 0.875rem; font-weight: 600;
      color: var(--gold); text-decoration: none;
      border-bottom: 1px solid transparent;
      transition: border-color 0.2s;
    }
    .corp-hne-header a:hover { border-bottom-color: var(--gold); }
    .corp-hne-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 3rem;
    }
    .corp-hne-col h3 {
      font-family: 'Playfair Display', serif;
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--navy);
      margin-bottom: 1.5rem;
      padding-bottom: 0.75rem;
      border-bottom: 2px solid var(--gold);
      display: inline-block;
    }
    .corp-hne-item {
      padding: 1rem 0;
      border-bottom: 1px solid var(--rule);
    }
    .corp-hne-item:last-of-type { border-bottom: none; }
    .corp-hne-item .date {
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 0.35rem;
    }
    .corp-hne-item a {
      color: var(--navy);
      text-decoration: none;
      font-weight: 500;
      font-size: 0.9rem;
      line-height: 1.5;
      transition: color 0.2s;
    }
    .corp-hne-item a:hover { color: var(--gold); }
    .corp-hne-more {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      margin-top: 1.5rem;
      font-size: 0.875rem;
      font-weight: 600;
      color: var(--gold);
      text-decoration: none;
      border-bottom: 1px solid transparent;
      transition: border-color 0.2s;
    }
    .corp-hne-more:hover { border-bottom-color: var(--gold); }

    /* ════════════════════════════════════════
       SERVICES SLIDESHOW
    ════════════════════════════════════════ */
    .corp-slideshow {
      background: var(--off-white);
      border-top: 1px solid var(--rule);
      border-bottom: 1px solid var(--rule);
      padding: 5rem 3rem;
    }
    .corp-slideshow-inner { max-width: 1100px; margin: 0 auto; }
    .corp-ss-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      gap: 3rem;
      margin-bottom: 2.5rem;
      padding-bottom: 1.5rem;
      border-bottom: 1px solid var(--rule);
    }
    .corp-ss-header .eyebrow {
      font-size: 0.72rem; font-weight: 700;
      letter-spacing: 0.12em; text-transform: uppercase;
      color: var(--gold); margin-bottom: 0.5rem;
    }
    .corp-ss-header h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2rem; font-weight: 700;
      color: var(--navy); line-height: 1.2;
    }
    .corp-ss-sub {
      font-size: 0.9rem; color: var(--text-light);
      max-width: 320px; line-height: 1.7;
      text-align: right; align-self: flex-end;
    }
    .corp-ss-wrap {
      overflow-x: hidden;
      border-radius: 8px;
      border: 1px solid var(--rule);
      box-shadow: 0 4px 32px rgba(13,30,61,0.07);
    }
    .corp-ss-track { display: flex; }
    .corp-ss-slide {
      flex: 0 0 100%;
      min-width: 0;
      display: flex;
      flex-direction: row;
      min-height: 380px;
      background: var(--white);
    }
    .corp-ss-img {
      flex: 1;
      position: relative;
      min-height: 380px;
      background-size: cover;
      background-position: center;
      background-color: var(--navy-light);
    }
    .corp-ss-img-inner-label { position: absolute; bottom: 1rem; left: 1.25rem; }
    .corp-ss-badge {
      background: var(--gold);
      color: var(--white);
      padding: 0.3rem 0.85rem;
      border-radius: 3px;
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: 0.06em;
      text-transform: uppercase;
    }
    .corp-ss-content {
      flex: 1;
      padding: 3rem 2.5rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      border-left: 1px solid var(--rule);
    }
    .corp-ss-content-num {
      font-size: 0.75rem; font-weight: 600;
      letter-spacing: 0.1em; color: var(--text-light);
      text-transform: uppercase; margin-bottom: 1rem;
    }
    .corp-ss-content h3 {
      font-family: 'Playfair Display', serif;
      font-size: 1.45rem; font-weight: 700;
      color: var(--navy); margin-bottom: 1rem; line-height: 1.3;
    }
    .corp-ss-content p {
      font-size: 0.9rem; color: var(--text-mid);
      line-height: 1.75; margin-bottom: 1.5rem;
    }
    .corp-ss-cta-link {
      display: inline-flex; align-items: center; gap: 0.4rem;
      font-size: 0.875rem; font-weight: 600;
      color: var(--gold); text-decoration: none;
      transition: gap 0.2s; width: fit-content;
    }
    .corp-ss-cta-link:hover { gap: 0.65rem; }
    .corp-ss-controls {
      display: flex; align-items: center;
      justify-content: center; gap: 1.25rem;
      margin-top: 1.25rem;
    }
    .corp-ss-arr {
      background: var(--white);
      border: 1px solid var(--rule);
      color: var(--navy);
      width: 40px; height: 40px;
      border-radius: 50%;
      cursor: pointer;
      font-size: 1rem;
      transition: background 0.2s, border-color 0.2s;
      display: flex; align-items: center; justify-content: center;
    }
    .corp-ss-arr:hover { background: var(--navy); color: #fff; border-color: var(--navy); }
    .corp-ss-dots { display: flex; gap: 0.4rem; align-items: center; }
    .corp-ss-dot {
      width: 8px; height: 8px;
      border-radius: 50%;
      background: var(--rule);
      border: none;
      cursor: pointer;
      transition: background 0.2s, transform 0.2s;
      padding: 0;
    }
    .corp-ss-dot.active { background: var(--gold); transform: scale(1.4); }

    /* ════════════════════════════════════════
       ABOUT
    ════════════════════════════════════════ */
    .corp-about { background: var(--navy); padding: 6rem 3rem; }
    .corp-about-eyebrow {
      font-size: 0.75rem; font-weight: 700;
      letter-spacing: 0.1em; text-transform: uppercase;
      color: var(--gold-light); margin-bottom: 0.75rem;
    }
    .corp-about h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.2rem; font-weight: 700;
      color: #fff; line-height: 1.2; margin-bottom: 3rem;
    }
    .corp-about h2 em { color: var(--gold-light); font-style: italic; }
    .corp-about-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 4rem;
      align-items: center;
    }
    .corp-about-img {
      border-radius: 8px;
      overflow: hidden;
      border: 1px solid rgba(255,255,255,0.1);
    }
    .corp-about-img img {
      width: 100%;
      height: 380px;
      object-fit: cover;
      display: block;
    }
    .corp-about-text p {
      font-size: 0.95rem;
      color: rgba(255,255,255,0.65);
      line-height: 1.8;
      margin-bottom: 1.25rem;
      font-weight: 300;
    }
    .corp-about-text p strong { color: var(--gold-light); }
    .corp-about-link {
      display: inline-flex; align-items: center; gap: 0.4rem;
      margin-top: 0.75rem;
      font-size: 0.875rem; font-weight: 600;
      color: var(--gold-light); text-decoration: none;
      border-bottom: 1px solid transparent;
      transition: border-color 0.2s;
    }
    .corp-about-link:hover { border-bottom-color: var(--gold-light); }
    .corp-about-read-more-content { display: none; }
    .corp-about-read-more-content.open { display: block; }

    /* ════════════════════════════════════════
       MISSION & VALUES
    ════════════════════════════════════════ */
    .corp-mv { padding: 6rem 3rem; background: var(--white); }
    .corp-mv-header {
      text-align: center;
      margin-bottom: 4rem;
    }
    .corp-mv-header .eyebrow {
      font-size: 0.75rem; font-weight: 600;
      letter-spacing: 0.1em; text-transform: uppercase;
      color: var(--gold); margin-bottom: 0.75rem;
    }
    .corp-mv-header h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.2rem; font-weight: 700;
      color: var(--navy); line-height: 1.2;
    }
    .corp-mv-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
      margin-bottom: 4rem;
    }
    .corp-mv-card {
      padding: 2.5rem;
      border: 1px solid var(--rule);
      border-radius: 8px;
      background: var(--off-white);
      transition: box-shadow 0.3s;
    }
    .corp-mv-card:hover { box-shadow: 0 8px 40px rgba(13,30,61,0.08); }
    .corp-mv-card h3 {
      font-family: 'Playfair Display', serif;
      font-size: 1.25rem; font-weight: 700;
      color: var(--navy); margin-bottom: 1rem;
    }
    .corp-mv-card p { font-size: 0.9rem; color: var(--text-mid); line-height: 1.75; }

    .corp-values-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.5rem; font-weight: 700;
      color: var(--navy);
      margin-bottom: 2rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid var(--rule);
    }
    .corp-values-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
    }
    .corp-val {
      padding: 1.75rem;
      border: 1px solid var(--rule);
      border-radius: 8px;
      position: relative;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .corp-val:hover { border-color: var(--gold); box-shadow: 0 4px 20px rgba(200,145,10,0.08); }
    .corp-val::before {
      content: '';
      position: absolute;
      top: 0; left: 0;
      width: 3px; height: 100%;
      background: var(--gold);
      border-radius: 8px 0 0 8px;
      opacity: 0;
      transition: opacity 0.2s;
    }
    .corp-val:hover::before { opacity: 1; }
    .corp-val h4 { font-size: 0.9rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem; }
    .corp-val p { font-size: 0.82rem; color: var(--text-mid); line-height: 1.65; }

    /* ════════════════════════════════════════
       CTA
    ════════════════════════════════════════ */
    .corp-cta {
      background: var(--gold-pale);
      border-top: 1px solid rgba(200,145,10,0.2);
      padding: 5rem 3rem;
      text-align: center;
    }
    .corp-cta .eyebrow {
      font-size: 0.78rem; font-weight: 600;
      letter-spacing: 0.1em; text-transform: uppercase;
      color: var(--gold); margin-bottom: 1rem;
    }
    .corp-cta h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.8rem; font-weight: 700;
      color: var(--navy); margin-bottom: 1rem; line-height: 1.2;
    }
    .corp-cta p {
      color: var(--text-mid);
      max-width: 480px;
      margin: 0 auto 2.5rem;
      line-height: 1.7;
    }
    .corp-cta-buttons { display: flex; gap: 1rem; justify-content: center; }
    .corp-cta-btn-primary {
      background: var(--navy);
      color: #fff;
      padding: 0.95rem 2.5rem;
      border-radius: 4px;
      text-decoration: none;
      font-weight: 600;
      transition: background 0.2s;
    }
    .corp-cta-btn-primary:hover { background: #0A1830; }
    .corp-cta-btn-outline {
      background: transparent;
      color: var(--navy);
      padding: 0.95rem 2.5rem;
      border-radius: 4px;
      border: 1.5px solid var(--navy);
      text-decoration: none;
      font-weight: 600;
      transition: background 0.2s;
    }
    .corp-cta-btn-outline:hover { background: rgba(13,30,61,0.08); }

    /* ════════════════════════════════════════
       FOOTER
    ════════════════════════════════════════ */
    .mb-footer {
      background: #111827;
      color: rgba(255,255,255,0.7);
      font-size: 0.875rem;
      line-height: 1.7;
    }
    .mb-footer-top {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1.5fr 1.5fr;
      gap: 3rem;
      padding: 4rem 2.5rem 3rem;
      max-width: 1300px;
      margin: 0 auto;
    }
    .mb-footer-brand img { height: 52px; margin-bottom: 1rem; }
    .mb-footer-brand p { font-size: 0.85rem; color: rgba(255,255,255,0.5); line-height: 1.7; max-width: 260px; }
    .mb-footer-col h4 {
      font-size: 0.8rem; font-weight: 700;
      letter-spacing: 0.1em; text-transform: uppercase;
      color: var(--gold); margin-bottom: 1.25rem;
    }
    .mb-footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 0.5rem; }
    .mb-footer-col ul li a {
      color: rgba(255,255,255,0.6);
      text-decoration: none;
      font-size: 0.85rem;
      transition: color 0.2s;
    }
    .mb-footer-col ul li a:hover { color: var(--gold); }

    /* Newsletter */
    .mb-newsletter-form { display: flex; gap: 0.5rem; margin-top: 0.75rem; }
    .mb-newsletter-form input {
      flex: 1;
      padding: 0.6rem 1rem;
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.15);
      border-radius: 6px;
      color: #fff;
      font-size: 0.85rem;
      outline: none;
      transition: border-color 0.2s;
    }
    .mb-newsletter-form input::placeholder { color: rgba(255,255,255,0.35); }
    .mb-newsletter-form input:focus { border-color: var(--gold); }
    .mb-newsletter-form button {
      padding: 0.6rem 1.25rem;
      background: var(--gold);
      color: #111827;
      border: none;
      border-radius: 6px;
      font-weight: 700;
      font-size: 0.82rem;
      cursor: pointer;
      transition: background 0.2s;
      white-space: nowrap;
    }
    .mb-newsletter-form button:hover { background: #A87508; }

    /* Hours */
    .mb-hours { list-style: none; display: flex; flex-direction: column; gap: 0.4rem; margin-top: 0.25rem; }
    .mb-hours li { font-size: 0.83rem; color: rgba(255,255,255,0.55); }

    /* Contact */
    .mb-footer-contact { display: flex; flex-direction: column; gap: 0.6rem; }
    .mb-footer-contact-item { display: flex; align-items: flex-start; gap: 0.6rem; font-size: 0.83rem; color: rgba(255,255,255,0.6); }
    .mb-footer-contact-item .icon { font-size: 0.9rem; margin-top: 0.1rem; flex-shrink: 0; color: var(--gold); }

    /* Social */
    .mb-social { display: flex; gap: 0.75rem; margin-top: 1rem; flex-wrap: wrap; }
    .mb-social a {
      width: 34px; height: 34px;
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.12);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      transition: background 0.2s, border-color 0.2s;
    }
    .mb-social a:hover { background: var(--gold); border-color: var(--gold); }
    .mb-social a img { width: 15px; height: 15px; filter: invert(1); }

    /* Footer bottom */
    .mb-footer-bottom {
      border-top: 1px solid rgba(255,255,255,0.08);
      padding: 1.25rem 2.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 0.5rem;
      max-width: 1300px;
      margin: 0 auto;
      font-size: 0.8rem;
      color: rgba(255,255,255,0.35);
    }
    .mb-footer-bottom a { color: rgba(255,255,255,0.45); text-decoration: none; transition: color 0.2s; }
    .mb-footer-bottom a:hover { color: var(--gold); }

    /* Acknowledgement in footer */
    .mb-acknowledgement {
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 8px;
      padding: 1.5rem;
      align-self: start;
    }
    .mb-credit-label { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--gold); margin-bottom: 0.35rem; }
    .mb-credit-name { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: 1rem; }
    .mb-credit-links { display: flex; flex-direction: column; gap: 0.4rem; }
    .mb-credit-links a {
      display: flex; align-items: center; gap: 0.5rem;
      font-size: 0.8rem; color: rgba(255,255,255,0.55);
      text-decoration: none; transition: color 0.2s;
    }
    .mb-credit-links a:hover { color: var(--gold); }
    .mb-credit-links a span { font-size: 0.85rem; }

    /* Cookie banner */
    .mb-cookie-banner {
      position: fixed;
      bottom: 0; left: 0; right: 0;
      z-index: 9999;
      background: #1f2937;
      border-top: 3px solid var(--gold);
      padding: 1.25rem 2.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 2rem;
      flex-wrap: wrap;
      box-shadow: 0 -4px 20px rgba(0,0,0,0.3);
    }
    .mb-cookie-banner p { font-size: 0.875rem; color: rgba(255,255,255,0.75); max-width: 600px; line-height: 1.6; }
    .mb-cookie-btns { display: flex; gap: 0.75rem; flex-wrap: wrap; }
    .mb-cookie-btn {
      padding: 0.55rem 1.25rem;
      border-radius: 6px;
      font-size: 0.82rem;
      font-weight: 700;
      cursor: pointer;
      border: none;
      transition: background 0.2s;
    }
    .mb-cookie-btn.accept { background: var(--gold); color: #111827; }
    .mb-cookie-btn.accept:hover { background: #A87508; }
    .mb-cookie-btn.decline { background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.75); }
    .mb-cookie-btn.decline:hover { background: rgba(255,255,255,0.18); }

    /* ════════════════════════════════════════
       ACKNOWLEDGEMENT BANNER
    ════════════════════════════════════════ */
    .gw-ack {
      position: fixed;
      bottom: 0; left: 0; right: 0;
      z-index: 10000;
      background: var(--navy);
      border-top: 3px solid var(--gold);
      padding: 1rem 2.5rem;
      box-shadow: 0 -4px 20px rgba(0,0,0,0.3);
      transform: translateY(100%);
      animation: gwSlideIn 0.5s 1.2s forwards;
    }
    @keyframes gwSlideIn { to { transform: translateY(0); } }
    .gw-ack-inner {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 2rem;
      max-width: 1300px;
      margin: 0 auto;
      flex-wrap: wrap;
    }
    .gw-ack-left { display: flex; align-items: center; gap: 1rem; }
    .gw-ack-avatar {
      width: 40px; height: 40px;
      border-radius: 50%;
      background: var(--gold);
      color: var(--navy);
      display: flex; align-items: center; justify-content: center;
      font-weight: 800;
      font-size: 0.85rem;
      flex-shrink: 0;
    }
    .gw-ack-name {
      font-weight: 700;
      color: #fff;
      font-size: 0.9rem;
      min-width: 280px;
      white-space: nowrap;
    }
    .gw-cursor {
      display: inline-block;
      animation: gwBlink 0.7s infinite;
      color: var(--gold-light);
    }
    @keyframes gwBlink { 0%,100%{opacity:1} 50%{opacity:0} }
    .gw-ack-role { font-size: 0.75rem; color: rgba(255,255,255,0.5); margin-top: 0.15rem; }
    .gw-ack-links { display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; }
    .gw-ack-link {
      display: flex; align-items: center; gap: 0.4rem;
      font-size: 0.8rem;
      color: rgba(255,255,255,0.6);
      text-decoration: none;
      transition: color 0.2s;
    }
    .gw-ack-link:hover { color: var(--gold-light); }
    .gw-ack-icon { font-size: 0.9rem; }
    .gw-si { width: 14px; height: 14px; filter: invert(1) opacity(0.6); }
    .gw-ack-link:hover .gw-si { filter: invert(1) opacity(1); }
    .gw-ack-close {
      background: none;
      border: none;
      color: rgba(255,255,255,0.45);
      font-size: 1.1rem;
      cursor: pointer;
      padding: 0.25rem 0.5rem;
      transition: color 0.2s;
      margin-left: auto;
      flex-shrink: 0;
    }
    .gw-ack-close:hover { color: #fff; }

    /* ════════════════════════════════════════
       EVENT POPUP
    ════════════════════════════════════════ */
    #eventPopup {
      display: none;
      position: fixed;
      bottom: 2rem; right: 2rem;
      z-index: 9998;
      background: var(--white);
      border: 1px solid var(--rule);
      border-radius: 8px;
      box-shadow: 0 16px 48px rgba(13,30,61,0.18);
      max-width: 320px;
      overflow: hidden;
    }
    #eventPopup.show { display: block; }
    @keyframes popupBounce {
      0%,100%{transform:translateY(0)} 30%{transform:translateY(-8px)} 60%{transform:translateY(-4px)}
    }
    #eventPopup.bounce { animation: popupBounce 0.6s ease; }
    .popup-close {
      position: absolute;
      top: 0.75rem; right: 1rem;
      font-size: 1.25rem;
      color: var(--text-light);
      cursor: pointer;
      line-height: 1;
      transition: color 0.2s;
    }
    .popup-close:hover { color: var(--navy); }
    .popup-content { padding: 1.5rem; }
    .popup-content img { width: 100%; border-radius: 4px; margin-bottom: 1rem; display: block; }
    .popup-content h3 { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 0.4rem; }
    .popup-content p { font-size: 0.8rem; color: var(--text-light); margin-bottom: 1rem; }
    .popup-btn-row { display: flex; gap: 0.5rem; }
    .popup-btn {
      flex: 1;
      padding: 0.55rem 0.75rem;
      border-radius: 4px;
      font-size: 0.82rem;
      font-weight: 600;
      text-align: center;
      text-decoration: none;
      cursor: pointer;
      border: none;
      transition: background 0.2s;
    }
    .popup-btn:first-child { background: var(--gold); color: var(--white); }
    .popup-btn:first-child:hover { background: #A87508; }
    .popup-close-btn { background: var(--rule); color: var(--navy); }
    .popup-close-btn:hover { background: #d0d9e6; }

    /* ════════════════════════════════════════
       RESPONSIVE
    ════════════════════════════════════════ */
    @media (max-width: 1024px) {
      .corp-hero { grid-template-columns: 1fr; min-height: auto; }
      .corp-hero::after { display: none; }
      .corp-hero-right { padding: 3rem; }
      .corp-hero-left { padding: 4rem 3rem 3rem; }
      .corp-audience-grid { grid-template-columns: 1fr; }
      .corp-pillars-grid { grid-template-columns: 1fr 1fr; }
      .corp-mv-grid { grid-template-columns: 1fr; }
      .corp-values-grid { grid-template-columns: 1fr 1fr; }
      .corp-hne-grid { grid-template-columns: 1fr; }
      .corp-about-grid { grid-template-columns: 1fr; }
      .mb-topbar { flex-direction: column; gap: 0.5rem; text-align: center; padding: 0.75rem 1.5rem; }
      .mb-footer-top { grid-template-columns: 1fr 1fr; gap: 2rem; padding: 2.5rem 1.5rem; }
    }
    @media (max-width: 600px) {
      .corp-hero { padding: 0; }
      .corp-hero-left, .corp-hero-right { padding: 2.5rem 1.5rem; }
      .corp-audience, .corp-pillars, .corp-slideshow, .corp-about, .corp-mv, .corp-hne, .corp-cta { padding: 4rem 1.5rem; }
      .corp-pillars-grid, .corp-values-grid { grid-template-columns: 1fr; }
      .corp-ss-slide { flex-direction: column; }
      .corp-ss-img { min-height: 200px; }
      .corp-ss-content { border-left: none; border-top: 1px solid var(--rule); }
      .corp-cta h2 { font-size: 2rem; }
      .corp-cta-buttons { flex-direction: column; align-items: center; }
      .mb-footer-top { grid-template-columns: 1fr; }
      .mb-footer-bottom { flex-direction: column; text-align: center; }
      .mb-cookie-banner { padding: 1rem 1.25rem; }
      .mb-topbar-right { display: none; }
      .gw-ack { padding: 1rem 1.25rem; }
      .gw-ack-links { display: none; }
    }
  </style>
</head>
<body>

<!-- ════════════════════════════════════════
     TOP BAR
════════════════════════════════════════ -->
<div class="mb-topbar">
  <div class="mb-topbar-left">Mfano Bora Africa Company Limited &middot; Nairobi, Kenya</div>
  <div class="mb-topbar-right">
    <a href="https://www.mfanoboraafrica.com/contact-us/">Contact Us</a>
    <span>|</span>
    <a href="https://www.mfanoboraafrica.com/smart_drivers_club/">Smart Driver Club</a>
    <span>|</span>
    <a href="https://www.mfanoboraafrica.com/employment/">Careers</a>
  </div>
</div>

<!-- ════════════════════════════════════════
     NAVIGATION
════════════════════════════════════════ -->
<nav class="mb-nav">
  <a href="https://www.mfanoboraafrica.com/" class="mb-nav-brand">
    <div class="mb-nav-logo-circle">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C8910A" stroke-width="2.5">
        <circle cx="12" cy="12" r="9"/>
        <path d="M8 12s1.5-3 4-3 4 3 4 3"/>
        <path d="M8 12s1.5 3 4 3 4-3 4-3"/>
      </svg>
    </div>
    <div class="mb-nav-brand-text">
      <span class="name">Mfano Bora Africa Company Limited</span>
      <span class="tagline">Setting the Standard</span>
    </div>
  </a>

  <ul class="mb-nav-links" id="mbNavLinks">
    <li>
      <span>Road Safety <span class="arrow">▾</span></span>
      <ul class="mb-dropdown">
        <li><a href="https://www.mfanoboraafrica.com/road_safety_club/">Road Safety Club</a></li>
        <li><a href="https://www.mfanoboraafrica.com/smart_drivers_club/">Smart Drivers Club</a></li>
      </ul>
    </li>
    <li>
      <span>Training <span class="arrow">▾</span></span>
      <ul class="mb-dropdown">
        <li><a href="https://www.mfanoboraafrica.com/attachment/">Industrial Attachment</a></li>
        <li><a href="https://www.mfanoboraafrica.com/internship/">Internship</a></li>
        <li><a href="https://www.mfanoboraafrica.com/computer_packages/">Computer Packages</a></li>
      </ul>
    </li>
    <li><a href="https://www.mfanoboraafrica.com/transport_awards/">EA Awards</a></li>
    <li>
      <span>About <span class="arrow">▾</span></span>
      <ul class="mb-dropdown">
        <li><a href="https://www.mfanoboraafrica.com/gallery/">Gallery</a></li>
        <li><a href="https://www.mfanoboraafrica.com/mentorship/">Mentorship</a></li>
        <li><a href="https://www.mfanoboraafrica.com/employment/">Employment</a></li>
      </ul>
    </li>
    <li><a href="/notices/">Notices</a></li>
    <li><a href="/events/">Events</a></li>
  </ul>

  <div class="mb-nav-actions">
    <a href="https://www.mfanoboraafrica.com/contact-us/" class="mb-nav-btn-outline">Contact</a>
    <a href="https://www.mfanoboraafrica.com/attachment/" class="mb-nav-btn-solid">Apply Now</a>
  </div>

  <div class="mb-hamburger" id="mbHamburger">
    <span></span><span></span><span></span>
  </div>
</nav>

<!-- ════════════════════════════════════════
     HERO
════════════════════════════════════════ -->
<section class="corp-hero">
  <div class="corp-hero-left">
    <div class="corp-hero-eyebrow">
      <div class="corp-hero-eyebrow-line"></div>
      <span>Road Safety &middot; Skills &middot; Community</span>
    </div>
    <h1 class="corp-hero-headline">
      Elevating standards<br>across Kenya's roads<br>and <em>communities.</em>
    </h1>
    <p class="corp-hero-sub">Mfano Bora Africa is a multi-discipline organisation dedicated to road safety education, professional driver training, logistics consulting, and skills development — shaping a safer, more capable Kenya.</p>
    <div class="corp-hero-actions">
      <a href="https://www.mfanoboraafrica.com/transport_awards/" class="corp-btn-primary">Discover Our Work</a>
      <a href="#" class="corp-btn-ghost">Download Profile</a>
    </div>
    <div class="corp-hero-stats">
      <div class="corp-hero-stat">
        <div class="num">24+</div>
        <div class="label">Years of Service</div>
      </div>
      <div class="corp-hero-stat">
        <div class="num">500+</div>
        <div class="label">Road Safety Clubs</div>
      </div>
      <div class="corp-hero-stat">
        <div class="num">E.A.</div>
        <div class="label">Nationwide Reach</div>
      </div>
    </div>
  </div>

  <div class="corp-hero-right">
    <div class="corp-services-list">
      <a href="https://www.mfanoboraafrica.com/transport_awards/" class="corp-service-row">
        <div class="corp-service-icon">🏆</div>
        <div>
          <h4>EA Transport Awards</h4>
          <p>Recognising excellence across East Africa</p>
        </div>
        <span class="corp-service-arrow">→</span>
      </a>
      <a href="https://www.mfanoboraafrica.com/attachment/" class="corp-service-row">
        <div class="corp-service-icon">🎓</div>
        <div>
          <h4>Industrial Attachments</h4>
          <p>ICT, logistics &amp; administration programmes</p>
        </div>
        <span class="corp-service-arrow">→</span>
      </a>
      <a href="https://www.mfanoboraafrica.com/road_safety_club/" class="corp-service-row">
        <div class="corp-service-icon">🛡️</div>
        <div>
          <h4>Road Safety Club</h4>
          <p>Nationwide awareness &amp; school campaigns</p>
        </div>
        <span class="corp-service-arrow">→</span>
      </a>
      <a href="https://www.mfanoboraafrica.com/smart_drivers_club/" class="corp-service-row">
        <div class="corp-service-icon">🚗</div>
        <div>
          <h4>Smart Drivers Club</h4>
          <p>Skills, safety knowledge &amp; responsible driving</p>
        </div>
        <span class="corp-service-arrow">→</span>
      </a>
    </div>
  </div>
</section>

<!-- ════════════════════════════════════════
     INTRO BAND
════════════════════════════════════════ -->
<div class="corp-intro-band">
  <p>"We believe that <em>better roads, better drivers, and better-equipped people</em> are the foundation of a stronger Kenya."</p>
</div>

<!-- ════════════════════════════════════════
     AUDIENCE SECTION
════════════════════════════════════════ -->
<section class="corp-audience">
  <div class="corp-section-header">
    <div class="corp-section-header-left">
      <div class="eyebrow">Find Your Path</div>
      <h2>How can we help you?</h2>
    </div>
    <p>Whether you're a student, a business, or a community advocate — our work is built around you.</p>
  </div>
  <div class="corp-audience-grid">
    <div class="corp-audience-card">
      <div class="corp-audience-card-header">
        <span class="corp-audience-icon">🎓</span>
        <span class="corp-audience-tag">Students &amp; Interns</span>
      </div>
      <div class="corp-audience-card-body">
        <h3>Students &amp; Attachment Seekers</h3>
        <p>Access structured industrial attachment programmes and career development opportunities designed to prepare you for the professional world.</p>
        <a href="https://www.mfanoboraafrica.com/attachment/" class="corp-audience-link">View programmes →</a>
      </div>
    </div>
    <div class="corp-audience-card">
      <div class="corp-audience-card-header">
        <span class="corp-audience-icon">🏢</span>
        <span class="corp-audience-tag">Corporate</span>
      </div>
      <div class="corp-audience-card-body">
        <h3>Corporate &amp; Business Partners</h3>
        <p>From fleet safety audits to logistics consulting and employee road safety training — we help businesses reduce risk and improve performance.</p>
        <a href="https://www.mfanoboraafrica.com/contact-us/" class="corp-audience-link">Explore partnerships →</a>
      </div>
    </div>
    <div class="corp-audience-card">
      <div class="corp-audience-card-header">
        <span class="corp-audience-icon">🌍</span>
        <span class="corp-audience-tag">Community</span>
      </div>
      <div class="corp-audience-card-body">
        <h3>Community Members</h3>
        <p>Join the Smart Driver Club, participate in road safety awareness campaigns, and become part of a growing movement making Kenya's roads safer.</p>
        <a href="https://www.mfanoboraafrica.com/smart_drivers_club/" class="corp-audience-link">Join the movement →</a>
      </div>
    </div>
  </div>
</section>

<!-- ════════════════════════════════════════
     FOUR PILLARS
════════════════════════════════════════ -->
<section class="corp-pillars">
  <div class="corp-pillars-header">
    <div>
      <div class="eyebrow">Our Core Work</div>
      <h2>Four disciplines.<br>One commitment.</h2>
    </div>
    <p>Every programme we run connects back to raising the standard of life in Kenya.</p>
  </div>
  <div class="corp-pillars-grid">
    <div class="corp-pillar">
      <div class="corp-pillar-num">01</div>
      <h3>Road Safety Education</h3>
      <p>We partner with schools, organisations, and communities to embed a culture of road safety through structured education and awareness campaigns.</p>
      <a href="https://www.mfanoboraafrica.com/road_safety_club/" class="corp-pillar-link">Learn More →</a>
    </div>
    <div class="corp-pillar">
      <div class="corp-pillar-num">02</div>
      <h3>Driver Training &amp; Licensing</h3>
      <p>Our certified driver training programmes equip participants with the knowledge, skills, and attitudes needed to navigate Kenya's roads safely and confidently.</p>
      <a href="https://www.mfanoboraafrica.com/smart_drivers_club/" class="corp-pillar-link">Learn More →</a>
    </div>
    <div class="corp-pillar">
      <div class="corp-pillar-num">03</div>
      <h3>Logistics Consulting</h3>
      <p>We provide integrated supply chain management consulting services that optimise operations across planning, sourcing, distribution, and customer service.</p>
      <a href="https://www.mfanoboraafrica.com/contact-us/" class="corp-pillar-link">Learn More →</a>
    </div>
    <div class="corp-pillar">
      <div class="corp-pillar-num">04</div>
      <h3>Skills Development</h3>
      <p>Through industrial attachments, computer packages, mentorship, and career readiness programmes, we build capable professionals across East Africa.</p>
      <a href="https://www.mfanoboraafrica.com/attachment/" class="corp-pillar-link">Learn More →</a>
    </div>
  </div>
</section>

<!-- ════════════════════════════════════════
     NEWS & EVENTS
════════════════════════════════════════ -->
<section class="corp-hne">
  <div class="corp-hne-header">
    <div>
      <div class="eyebrow">What's Happening</div>
      <h2>Latest Notices &amp; Events</h2>
    </div>
    <a href="/notices/">View All →</a>
  </div>
  <div class="corp-hne-grid">
    <div class="corp-hne-col">
      <h3>Latest Notices</h3>
      <?php if (!empty($news_items)): ?>
        <?php foreach ($news_items as $n): ?>
          <div class="corp-hne-item">
            <a href="<?= newsUrl($n['id'], $n['title']) ?>"><?= htmlspecialchars($n['title']) ?></a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="corp-hne-item"><a href="/notices/">Road Safety Awareness Campaign — Q1 2026</a></div>
        <div class="corp-hne-item"><a href="/notices/">New Industrial Attachment Intake Open</a></div>
        <div class="corp-hne-item"><a href="/notices/">EA Transport Awards — Call for Nominations</a></div>
        <div class="corp-hne-item"><a href="/notices/">Smart Drivers Club Expansion Update</a></div>
      <?php endif; ?>
      <a href="/notices/" class="corp-hne-more">More Notices →</a>
    </div>
    <div class="corp-hne-col">
      <h3>Upcoming Events</h3>
      <?php if (!empty($events)): ?>
        <?php foreach ($events as $e):
          $slug = slugify($e['title']);
          $eventUrl = "/events/{$e['id']}-{$slug}";
        ?>
          <div class="corp-hne-item">
            <div class="date"><?= date("F j, Y", strtotime($e['event_date'])) ?></div>
            <a href="<?= htmlspecialchars($eventUrl) ?>"><?= htmlspecialchars($e['title']) ?></a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="corp-hne-item">
          <div class="date">April 10, 2026</div>
          <a href="/events/">East Africa Transport, Logistics &amp; Road Safety Awards</a>
        </div>
        <div class="corp-hne-item">
          <div class="date">May 3, 2026</div>
          <a href="/events/">Road Safety Club Annual General Meeting</a>
        </div>
        <div class="corp-hne-item">
          <div class="date">June 14, 2026</div>
          <a href="/events/">Smart Drivers Club Graduation Ceremony</a>
        </div>
      <?php endif; ?>
      <a href="/events/" class="corp-hne-more">View All Events →</a>
    </div>
  </div>
</section>

<!-- ════════════════════════════════════════
     SERVICES SLIDESHOW
════════════════════════════════════════ -->
<section class="corp-slideshow">
  <div class="corp-slideshow-inner">
    <div class="corp-ss-header">
      <div>
        <div class="eyebrow">Our Work in Action</div>
        <h2 class="corp-ss-header">See what we actually do.</h2>
      </div>
      <p class="corp-ss-sub">Each service area changes real lives. Here's a closer look at what we deliver across Kenya.</p>
    </div>

    <div class="corp-ss-wrap" id="corpWrap">
      <div class="corp-ss-track">

        <!-- Slide 1 -->
        <div class="corp-ss-slide">
          <div class="corp-ss-img" style="background-image:url('/assets/images/road-safety.jpg');">
            <div class="corp-ss-img-inner-label"><span class="corp-ss-badge">Road Safety</span></div>
          </div>
          <div class="corp-ss-content">
            <div class="corp-ss-content-num">01 / 04</div>
            <h3>Road Safety Education</h3>
            <p>With over 500 Road Safety Clubs established across Kenya and East Africa, we embed a culture of safety from the ground up — in schools, workplaces, and communities.</p>
            <a href="https://www.mfanoboraafrica.com/road_safety_club/" class="corp-ss-cta-link">Learn More →</a>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="corp-ss-slide">
          <div class="corp-ss-img" style="background-image:url('/assets/images/transport-awards.jpg');">
            <div class="corp-ss-img-inner-label"><span class="corp-ss-badge">EA Awards</span></div>
          </div>
          <div class="corp-ss-content">
            <div class="corp-ss-content-num">02 / 04</div>
            <h3>East Africa Transport, Logistics &amp; Road Safety Awards</h3>
            <p>For 24 years, we have hosted East Africa's premier awards ceremony recognising excellence and innovation in the logistics and transport industry.</p>
            <a href="https://www.mfanoboraafrica.com/transport_awards/" class="corp-ss-cta-link">Learn More →</a>
          </div>
        </div>

        <!-- Slide 3 -->
        <div class="corp-ss-slide">
          <div class="corp-ss-img" style="background-image:url('/assets/images/attachment.jpg');">
            <div class="corp-ss-img-inner-label"><span class="corp-ss-badge">Attachments</span></div>
          </div>
          <div class="corp-ss-content">
            <div class="corp-ss-content-num">03 / 04</div>
            <h3>Industrial Attachment Programmes</h3>
            <p>We offer structured industrial attachment opportunities in ICT, logistics, administration, and more — equipping the next generation of East African professionals.</p>
            <a href="https://www.mfanoboraafrica.com/attachment/" class="corp-ss-cta-link">Learn More →</a>
          </div>
        </div>

        <!-- Slide 4 -->
        <div class="corp-ss-slide">
          <div class="corp-ss-img" style="background-image:url('/assets/images/smart-drivers.jpg');">
            <div class="corp-ss-img-inner-label"><span class="corp-ss-badge">Smart Drivers Club</span></div>
          </div>
          <div class="corp-ss-content">
            <div class="corp-ss-content-num">04 / 04</div>
            <h3>Smart Drivers Club</h3>
            <p>Empowering drivers with essential skills, safety knowledge, and responsible road behaviour. We train participants to become confident and responsible road users for safer communities.</p>
            <a href="https://www.mfanoboraafrica.com/smart_drivers_club/" class="corp-ss-cta-link">Learn More →</a>
          </div>
        </div>

      </div><!-- end .corp-ss-track -->
    </div><!-- end #corpWrap -->

    <div class="corp-ss-controls">
      <button class="corp-ss-arr" onclick="corpSsPrev()">&#8592;</button>
      <div class="corp-ss-dots" id="corpDots">
        <button class="corp-ss-dot active" onclick="corpSsGo(0)"></button>
        <button class="corp-ss-dot" onclick="corpSsGo(1)"></button>
        <button class="corp-ss-dot" onclick="corpSsGo(2)"></button>
        <button class="corp-ss-dot" onclick="corpSsGo(3)"></button>
      </div>
      <button class="corp-ss-arr" onclick="corpSsNext()">&#8594;</button>
    </div>
  </div>
</section>

<!-- ════════════════════════════════════════
     ABOUT
════════════════════════════════════════ -->
<section class="corp-about">
  <div class="corp-about-eyebrow">About Us</div>
  <h2>24 years of raising<br><em>Kenya's standard.</em></h2>
  <div class="corp-about-grid">
    <div class="corp-about-img">
      <img src="/assets/images/our-history.png" alt="Our History — Mfano Bora Africa">
    </div>
    <div class="corp-about-text">
      <p>Mfano Bora Africa Limited is the leading consulting firm in Logistics in Kenya. We provide integrated supply chain management consulting services that optimise operations across planning, sourcing, distribution, and customer service.</p>
      <p>We are also the proud home of the <strong>East Africa Transport, Logistics &amp; Road Safety Awards</strong> — an institution that has, for the past 24 years, recognised excellence and innovation in the logistics and supply chain industry across the region.</p>
      <div class="corp-about-read-more-content" id="corpAboutMore">
        <p style="margin-top:1.25rem;">Through our Road Safety Education programmes, we currently have more than 500 Road Safety Clubs across the region — each one a beacon of community-driven change. Our Smart Drivers Club continues to grow, equipping drivers with the knowledge and skills to make Kenya's roads safer for everyone.</p>
        <p>Whether you are a student seeking attachment, a business looking for logistics expertise, or a community member wanting to make a difference — Mfano Bora Africa has a programme for you.</p>
      </div>
      <a href="#" class="corp-about-link" id="corpReadMore">Read More →</a>
      <br><br>
      <a href="https://www.mfanoboraafrica.com/contact-us/" class="corp-about-link">Get in Touch →</a>
    </div>
  </div>
</section>

<!-- ════════════════════════════════════════
     MISSION & VALUES
════════════════════════════════════════ -->
<section class="corp-mv">
  <div class="corp-mv-header">
    <div class="eyebrow">Our Foundation</div>
    <h2>Mission, Vision &amp; Values</h2>
  </div>
  <div class="corp-mv-grid">
    <div class="corp-mv-card">
      <h3>Our Mission</h3>
      <p>To relentlessly focus on helping our partners succeed by serving their logistics needs through unparalleled expertise, technological agility, and continuous innovation.</p>
    </div>
    <div class="corp-mv-card">
      <h3>Our Vision</h3>
      <p>To be the leading logistics consultant in Africa, recognised for excellence, innovation, and commitment to safety and sustainability.</p>
    </div>
  </div>
  <h3 class="corp-values-title">Our Core Values</h3>
  <div class="corp-values-grid">
    <div class="corp-val">
      <h4>Preservation of Human Life</h4>
      <p>Protecting and saving lives is our highest priority. Every action we take is guided by the principle that human life is priceless.</p>
    </div>
    <div class="corp-val">
      <h4>Whole Community Participation</h4>
      <p>We encourage the active involvement of individuals, families, organisations, and authorities to create safer communities together.</p>
    </div>
    <div class="corp-val">
      <h4>Partnership</h4>
      <p>We build strong, mutually beneficial relationships with stakeholders to share resources, expertise, and achieve greater impact.</p>
    </div>
    <div class="corp-val">
      <h4>Capacity Development</h4>
      <p>We equip people and communities with the skills, knowledge, and tools they need to prevent accidents and respond effectively to emergencies.</p>
    </div>
    <div class="corp-val">
      <h4>Sustainability &amp; Socio-Economic Development</h4>
      <p>We aim for long-term solutions that improve safety while also enhancing the social and economic well-being of communities.</p>
    </div>
    <div class="corp-val">
      <h4>Road Accidents Are Avoidable</h4>
      <p>With proper education, enforcement, and infrastructure, road accidents can be significantly reduced and, in many cases, prevented entirely.</p>
    </div>
  </div>
</section>

<!-- ════════════════════════════════════════
     CTA
════════════════════════════════════════ -->
<section class="corp-cta">
  <div class="eyebrow">Take the Next Step</div>
  <h2>Ready to connect with us?</h2>
  <p>Whether you're looking for training, partnership, or a chance to make a difference — we'd love to hear from you.</p>
  <div class="corp-cta-buttons">
    <a href="https://www.mfanoboraafrica.com/contact-us/" class="corp-cta-btn-primary">Get in Touch</a>
    <a href="#" class="corp-cta-btn-outline">Download Our Profile</a>
  </div>
</section>

<!-- ════════════════════════════════════════
     FOOTER
════════════════════════════════════════ -->
<footer class="mb-footer">
  <div class="mb-footer-top">

    <!-- Brand -->
    <div class="mb-footer-brand">
      <img src="/assets/images/logo.png" alt="Mfano Bora Africa">
      <p>Mfano Bora Africa – Setting the standard in transportation and logistics across Africa.</p>
      <div class="mb-social">
        <a href="https://www.facebook.com/share/g/1DDgDpbHVA/" title="Facebook" target="_blank">
          <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/facebook.svg" alt="Facebook">
        </a>
        <a href="https://www.tiktok.com/@mfanobo" title="TikTok" target="_blank">
          <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/tiktok.svg" alt="TikTok">
        </a>
        <a href="https://www.instagram.com/mfano_bora_africa" title="Instagram" target="_blank">
          <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/instagram.svg" alt="Instagram">
        </a>
        <a href="https://www.linkedin.com/company/107007801/" title="LinkedIn" target="_blank">
          <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/linkedin.svg" alt="LinkedIn">
        </a>
        <a href="https://x.com/LtdMfano" title="Twitter / X" target="_blank">
          <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/twitter.svg" alt="Twitter">
        </a>
      </div>
    </div>

    <!-- Newsletter -->
    <div class="mb-footer-col">
      <h4>Newsletter</h4>
      <p style="font-size:0.82rem;color:rgba(255,255,255,0.5);margin-bottom:0.5rem;">Stay updated on our latest news, offers, and events.</p>
      <div class="mb-newsletter-form">
        <input type="email" placeholder="Your email address">
        <button type="button">Subscribe</button>
      </div>
    </div>

    <!-- Operating Hours -->
    <div class="mb-footer-col">
      <h4>Operating Hours</h4>
      <ul class="mb-hours">
        <li>Mon – Fri: 7:00 AM – 5:00 PM</li>
        <li>Saturday: 8:00 AM – 1:00 PM</li>
        <li>Sunday: Closed</li>
      </ul>
    </div>

    <!-- Quick Links -->
    <div class="mb-footer-col">
      <h4>Quick Links</h4>
      <ul>
        <li><a href="https://www.mfanoboraafrica.com/">› Home</a></li>
        <li><a href="https://www.mfanoboraafrica.com/transport_awards/">› E.A Regional Awards</a></li>
        <li><a href="https://www.mfanoboraafrica.com/gallery/">› Gallery</a></li>
        <li><a href="https://www.mfanoboraafrica.com/attachment/">› Attachment</a></li>
        <li><a href="https://www.mfanoboraafrica.com/computer_packages/">› Computer Packages</a></li>
        <li><a href="https://www.mfanoboraafrica.com/employment/">› Employment</a></li>
        <li><a href="https://www.mfanoboraafrica.com/internship/">› Internship</a></li>
        <li><a href="https://www.mfanoboraafrica.com/mentorship/">› Mentorship</a></li>
        <li><a href="https://www.mfanoboraafrica.com/contact-us/">› Contact Us</a></li>
      </ul>
    </div>

    <!-- Contact Info -->
    <div class="mb-footer-col">
      <h4>Contact Info</h4>
      <div class="mb-footer-contact">
        <div class="mb-footer-contact-item">
          <span class="icon">📍</span>
          <span>Mfano House, Ole Sein Rd, Nairobi, Kenya</span>
        </div>
        <div class="mb-footer-contact-item">
          <span class="icon">✉️</span>
          <a href="mailto:info@mfanoboraafrica.com" style="color:rgba(255,255,255,0.6);text-decoration:none;">info@mfanoboraafrica.com</a>
        </div>
        <div class="mb-footer-contact-item">
          <span class="icon">🕐</span>
          <span>Mon–Fri: 8:00 AM – 5:00 PM</span>
        </div>
      </div>

      <!-- Redesign Credit -->
      <div class="mb-acknowledgement" style="margin-top:1.5rem;">
        <div class="mb-credit-label">Redesign by</div>
        <div class="mb-credit-name">Gilbert Williams Nyange</div>
        <div class="mb-credit-links">
          <a href="mailto:gilbertwilliamsnyange@gmail.com"><span>✉</span> gilbertwilliamsnyange@gmail.com</a>
          <a href="tel:+254719737274"><span>📞</span> +254 719 737 274</a>
          <a href="https://www.linkedin.com/in/gilbertwilliamsnyange" target="_blank"><span>🔗</span> LinkedIn</a>
          <a href="https://github.com/Gilb3rtWilliams" target="_blank"><span>🐙</span> Gilb3rtWilliams</a>
        </div>
      </div>
    </div>

  </div>

  <div class="mb-footer-bottom">
    <span>© 2026 Mfano Bora Africa. All Rights Reserved.</span>
    <span>
      <a href="https://www.mfanoboraafrica.com/privacy-policy/">Privacy Policy</a>
      &nbsp;|&nbsp;
      <a href="https://www.mfanoboraafrica.com/disclaimer/">Disclaimer</a>
    </span>
  </div>
</footer>

<!-- ════════════════════════════════════════
     COOKIE BANNER
════════════════════════════════════════ -->
<div class="mb-cookie-banner" id="mbCookieBanner">
  <p>Our website uses cookies to enhance your experience. By clicking "Accept All," you consent to our use of cookies. You can also decline if you wish.</p>
  <div class="mb-cookie-btns">
    <button class="mb-cookie-btn accept" onclick="document.getElementById('mbCookieBanner').style.display='none'">Accept All</button>
    <button class="mb-cookie-btn decline" onclick="document.getElementById('mbCookieBanner').style.display='none'">Decline</button>
  </div>
</div>

<!-- ════════════════════════════════════════
     EVENT POPUP
════════════════════════════════════════ -->
<?php if ($event): ?>
<div id="eventPopup">
  <span class="popup-close" onclick="closePopup()">&times;</span>
  <div class="popup-content">
    <?php if (!empty($event['banner_url'])): ?>
      <img src="<?= htmlspecialchars('/' . ltrim($event['banner_url'], '/')) ?>" alt="Event Banner">
    <?php endif; ?>
    <h3><?= htmlspecialchars($event['title']) ?></h3>
    <p><strong>Date:</strong> <?= date('F j, Y', strtotime($event['event_date'])) ?></p>
    <div class="popup-btn-row">
      <a href="/events/" class="popup-btn">View More</a>
      <button class="popup-btn popup-close-btn" onclick="closePopup()">Close</button>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- ════════════════════════════════════════
     ACKNOWLEDGEMENT BANNER
════════════════════════════════════════ -->
<div class="gw-ack" id="gwAck">
  <div class="gw-ack-inner">
    <div class="gw-ack-left">
      <div class="gw-ack-avatar">GW</div>
      <div>
        <div class="gw-ack-name">
          <span id="gwTyping"></span><span class="gw-cursor">|</span>
        </div>
        <div class="gw-ack-role">Attachment Student &middot; Mfano Bora Africa Ltd &middot; Homepage Redesign Proposal — Corporate Direction</div>
      </div>
    </div>
    <div class="gw-ack-links">
      <a href="mailto:gilbertwilliamsnyange@gmail.com" class="gw-ack-link" title="Email">
        <span class="gw-ack-icon">✉</span>
        <span>gilbertwilliamsnyange@gmail.com</span>
      </a>
      <a href="tel:+254719737274" class="gw-ack-link" title="Phone">
        <span class="gw-ack-icon">📞</span>
        <span>+254 719 737 274</span>
      </a>
      <a href="https://www.linkedin.com/in/gilbertwilliamsnyange" target="_blank" class="gw-ack-link" title="LinkedIn">
        <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/linkedin.svg" class="gw-si" alt="LinkedIn">
        <span>LinkedIn</span>
      </a>
      <a href="https://github.com/Gilb3rtWilliams" target="_blank" class="gw-ack-link" title="GitHub">
        <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/github.svg" class="gw-si" alt="GitHub">
        <span>Gilb3rtWilliams</span>
      </a>
    </div>
    <button class="gw-ack-close" onclick="document.getElementById('gwAck').style.display='none'" title="Dismiss">✕</button>
  </div>
</div>

<!-- ════════════════════════════════════════
     JAVASCRIPT
════════════════════════════════════════ -->
<script>
/* ── Services Slideshow ── */
var corpSsCur = 0;
var corpSsTotal = 4;
var corpSsTimer;

function corpSsRender() {
  var w = document.getElementById('corpWrap');
  if (w) w.scrollLeft = corpSsCur * w.offsetWidth;
  document.querySelectorAll('#corpDots .corp-ss-dot').forEach(function(d, i) {
    d.classList.toggle('active', i === corpSsCur);
  });
}
function corpSsGo(n) {
  corpSsCur = (n + corpSsTotal) % corpSsTotal;
  corpSsRender();
  clearInterval(corpSsTimer);
  corpSsTimer = setInterval(corpSsNext, 5500);
}
function corpSsNext() { corpSsGo(corpSsCur + 1); }
function corpSsPrev() { corpSsGo(corpSsCur - 1); }

window.addEventListener('load', function() {
  corpSsTimer = setInterval(corpSsNext, 5500);
});

/* ── Read More / Less ── */
document.getElementById('corpReadMore').addEventListener('click', function(e) {
  e.preventDefault();
  var m = document.getElementById('corpAboutMore');
  var open = m.classList.contains('open');
  m.classList.toggle('open', !open);
  this.textContent = open ? 'Read More →' : 'Read Less ↑';
});

/* ── Mobile Hamburger ── */
document.getElementById('mbHamburger').addEventListener('click', function() {
  document.getElementById('mbNavLinks').classList.toggle('open');
});

/* ── Event Popup ── */
window.closePopup = function() {
  var p = document.getElementById('eventPopup');
  if (p) p.style.display = 'none';
};
(function() {
  var popup = document.getElementById('eventPopup');
  if (popup) {
    popup.classList.add('show');
    setInterval(function() {
      popup.classList.add('bounce');
      popup.addEventListener('animationend', function h() {
        popup.classList.remove('bounce');
        popup.removeEventListener('animationend', h);
      });
    }, 20000);
  }
})();

/* ── Acknowledgement Typing Animation ── */
(function() {
  var text = "Work done by Gilbert Williams Nyange";
  var el = document.getElementById('gwTyping');
  if (!el) return;
  var i = 0;
  function type() {
    if (i <= text.length) {
      el.textContent = text.slice(0, i);
      i++;
      setTimeout(type, i === 1 ? 600 : 55);
    }
  }
  setTimeout(type, 1500);
})();
</script>

</body>
</html>
