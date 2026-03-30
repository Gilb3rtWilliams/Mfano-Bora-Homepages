<?php
// ── STANDALONE PREVIEW MODE (no database required) ──
$page_title = "Home - Mfano Bora Africa Ltd";
$slides = [];
$events = [];
$news_items = [];
$priority_items = [];
$event = null;

function slugify($text)
{
  $text = strtolower(trim($text));
  $text = preg_replace('/[^a-z0-9]+/', '-', $text);
  return trim($text, '-');
}
function formatNoticeContent($text)
{
  return nl2br(htmlspecialchars($text));
}
function newsUrl($id, $title)
{
  $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
  return "/notices/{$id}-{$slug}";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description"
    content="Mfano Bora Africa — Road safety, driver training, logistics consulting and skills development across Kenya and East Africa.">
  <title>Home - Mfano Bora Africa Ltd</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Source+Sans+3:wght@300;400;500;600&display=swap"
    rel="stylesheet">
  <style>
    /* ════════════════════════════════════════
   OFFICIAL MFANO BORA HEADER
   ════════════════════════════════════════ */
    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    /* Top bar */
    .mb-topbar {
      background: #1a1a2e;
      padding: 0.4rem 2.5rem;
      display: flex;
      justify-content: flex-end;
      align-items: center;
      gap: 1.5rem;
      font-size: 0.78rem;
      color: rgba(255, 255, 255, 0.6);
    }

    .mb-topbar a {
      color: rgba(255, 255, 255, 0.6);
      text-decoration: none;
      transition: color 0.2s;
    }

    .mb-topbar a:hover {
      color: #E8A020;
    }

    .mb-topbar span {
      color: rgba(255, 255, 255, 0.3);
    }

    /* Main nav */
    .mb-nav {
      position: sticky;
      top: 0;
      z-index: 1000;
      background: #fff;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
      padding: 0 2.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 70px;
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

    .mb-nav-brand-text {
      display: flex;
      flex-direction: column;
    }

    .mb-nav-brand-text .name {
      font-weight: 700;
      font-size: 0.95rem;
      color: #1a1a2e;
      line-height: 1.2;
      letter-spacing: -0.01em;
    }

    .mb-nav-brand-text .tagline {
      font-size: 0.68rem;
      color: #888;
      letter-spacing: 0.02em;
    }

    /* Nav links */
    .mb-nav-links {
      display: flex;
      align-items: center;
      list-style: none;
      gap: 0;
      height: 70px;
    }

    .mb-nav-links>li {
      position: relative;
      height: 100%;
      display: flex;
      align-items: center;
    }

    .mb-nav-links>li>a,
    .mb-nav-links>li>span {
      display: flex;
      align-items: center;
      gap: 0.3rem;
      padding: 0 1rem;
      height: 100%;
      color: #333;
      text-decoration: none;
      font-size: 0.875rem;
      font-weight: 500;
      cursor: pointer;
      border-bottom: 3px solid transparent;
      transition: color 0.2s, border-color 0.2s;
      white-space: nowrap;
    }

    .mb-nav-links>li>a:hover,
    .mb-nav-links>li>span:hover,
    .mb-nav-links>li>a.active {
      color: #E8A020;
      border-bottom-color: #E8A020;
    }

    .mb-nav-links>li>a .arrow,
    .mb-nav-links>li>span .arrow {
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
      background: #fff;
      min-width: 200px;
      border-top: 3px solid #E8A020;
      border-radius: 0 0 8px 8px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
      list-style: none;
      z-index: 100;
    }

    .mb-nav-links>li:hover .mb-dropdown {
      display: block;
    }

    .mb-dropdown li a {
      display: block;
      padding: 0.75rem 1.25rem;
      color: #444;
      text-decoration: none;
      font-size: 0.85rem;
      border-bottom: 1px solid #f5f5f5;
      transition: background 0.2s, color 0.2s;
    }

    .mb-dropdown li:last-child a {
      border-bottom: none;
    }

    .mb-dropdown li a:hover {
      background: #fff8ee;
      color: #E8A020;
    }

    /* Search */
    .mb-nav-search {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0 0.75rem;
      height: 100%;
      color: #333;
      cursor: pointer;
      font-size: 1rem;
      border-left: 1px solid #eee;
      transition: color 0.2s;
    }

    .mb-nav-search:hover {
      color: #E8A020;
    }

    /* Mobile hamburger (hidden on desktop) */
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
      .mb-nav-links {
        display: none;
      }

      .mb-hamburger {
        display: flex;
      }

      .mb-nav-links.open {
        display: flex;
        flex-direction: column;
        height: auto;
        position: absolute;
        top: 70px;
        left: 0;
        right: 0;
        background: #fff;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        padding: 1rem 0;
        gap: 0;
      }

      .mb-nav-links.open>li {
        height: auto;
      }

      .mb-nav-links.open>li>a,
      .mb-nav-links.open>li>span {
        padding: 0.75rem 2rem;
        border-bottom: 1px solid #f0f0f0;
        height: auto;
        width: 100%;
      }

      .mb-dropdown {
        position: static;
        box-shadow: none;
        border-top: none;
        border-radius: 0;
        display: none !important;
      }
    }

    /* ════════════════════════════════════════
   OFFICIAL MFANO BORA FOOTER
   ════════════════════════════════════════ */
    .mb-footer {
      background: #111827;
      color: rgba(255, 255, 255, 0.7);
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

    .mb-footer-brand img {
      height: 52px;
      margin-bottom: 1rem;
    }

    .mb-footer-brand p {
      font-size: 0.85rem;
      color: rgba(255, 255, 255, 0.5);
      line-height: 1.7;
      max-width: 260px;
    }

    .mb-footer-col h4 {
      font-size: 0.8rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: #E8A020;
      margin-bottom: 1.25rem;
    }

    .mb-footer-col ul {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .mb-footer-col ul li a {
      color: rgba(255, 255, 255, 0.6);
      text-decoration: none;
      font-size: 0.85rem;
      transition: color 0.2s;
    }

    .mb-footer-col ul li a:hover {
      color: #E8A020;
    }

    /* Newsletter */
    .mb-newsletter-form {
      display: flex;
      gap: 0.5rem;
      margin-top: 0.75rem;
    }

    .mb-newsletter-form input {
      flex: 1;
      padding: 0.6rem 1rem;
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.15);
      border-radius: 6px;
      color: #fff;
      font-size: 0.85rem;
      outline: none;
      transition: border-color 0.2s;
    }

    .mb-newsletter-form input::placeholder {
      color: rgba(255, 255, 255, 0.35);
    }

    .mb-newsletter-form input:focus {
      border-color: #E8A020;
    }

    .mb-newsletter-form button {
      padding: 0.6rem 1.25rem;
      background: #E8A020;
      color: #111827;
      border: none;
      border-radius: 6px;
      font-weight: 700;
      font-size: 0.82rem;
      cursor: pointer;
      transition: background 0.2s;
      white-space: nowrap;
    }

    .mb-newsletter-form button:hover {
      background: #d4911a;
    }

    /* Hours */
    .mb-hours {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 0.4rem;
      margin-top: 0.25rem;
    }

    .mb-hours li {
      font-size: 0.83rem;
      color: rgba(255, 255, 255, 0.55);
    }

    /* Contact */
    .mb-footer-contact {
      display: flex;
      flex-direction: column;
      gap: 0.6rem;
    }

    .mb-footer-contact-item {
      display: flex;
      align-items: flex-start;
      gap: 0.6rem;
      font-size: 0.83rem;
      color: rgba(255, 255, 255, 0.6);
    }

    .mb-footer-contact-item .icon {
      font-size: 0.9rem;
      margin-top: 0.1rem;
      flex-shrink: 0;
      color: #E8A020;
    }

    /* Social icons */
    .mb-social {
      display: flex;
      gap: 0.75rem;
      margin-top: 1rem;
      flex-wrap: wrap;
    }

    .mb-social a {
      width: 34px;
      height: 34px;
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.2s, border-color 0.2s;
    }

    .mb-social a:hover {
      background: #E8A020;
      border-color: #E8A020;
    }

    .mb-social a img {
      width: 15px;
      height: 15px;
      filter: invert(1);
    }

    /* Footer bottom bar */
    .mb-footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      padding: 1.25rem 2.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 0.5rem;
      max-width: 1300px;
      margin: 0 auto;
      font-size: 0.8rem;
      color: rgba(255, 255, 255, 0.35);
    }

    .mb-footer-bottom a {
      color: rgba(255, 255, 255, 0.45);
      text-decoration: none;
      transition: color 0.2s;
    }

    .mb-footer-bottom a:hover {
      color: #E8A020;
    }

    /* Cookie banner */
    .mb-cookie-banner {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      z-index: 9999;
      background: #1f2937;
      border-top: 3px solid #E8A020;
      padding: 1.25rem 2.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 2rem;
      flex-wrap: wrap;
      box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.3);
    }

    .mb-cookie-banner p {
      font-size: 0.875rem;
      color: rgba(255, 255, 255, 0.75);
      max-width: 600px;
      line-height: 1.6;
    }

    .mb-cookie-btns {
      display: flex;
      gap: 0.75rem;
      flex-wrap: wrap;
    }

    .mb-cookie-btn {
      padding: 0.55rem 1.25rem;
      border-radius: 6px;
      font-size: 0.82rem;
      font-weight: 700;
      cursor: pointer;
      border: none;
      transition: background 0.2s;
    }

    .mb-cookie-btn.accept {
      background: #E8A020;
      color: #111827;
    }

    .mb-cookie-btn.accept:hover {
      background: #d4911a;
    }

    .mb-cookie-btn.decline {
      background: rgba(255, 255, 255, 0.1);
      color: rgba(255, 255, 255, 0.75);
    }

    .mb-cookie-btn.decline:hover {
      background: rgba(255, 255, 255, 0.18);
    }

    @media (max-width: 1024px) {
      .mb-footer-top {
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        padding: 2.5rem 1.5rem;
      }
    }

    @media (max-width: 600px) {
      .mb-footer-top {
        grid-template-columns: 1fr;
      }

      .mb-footer-bottom {
        flex-direction: column;
        text-align: center;
      }

      .mb-cookie-banner {
        padding: 1rem 1.25rem;
      }
    }


    /* ══ PLAYFUL DESIGN ══ */
    :root {
      --gold: #E8A020;
      --navy: #1A2C5B;
      --lime: #C8E63C;
      --cream: #FDF8EF;
      --dark: #0F1A2E;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--cream);
      color: var(--dark);
      overflow-x: hidden;
    }

    /* HERO */
    .pb-hero {
      background: var(--dark);
      min-height: 90vh;
      display: grid;
      grid-template-columns: 1fr 1fr;
      align-items: center;
      padding: 5rem 3rem 4rem;
      position: relative;
      overflow: hidden;
      gap: 4rem;
    }

    .pb-hero::before {
      content: '';
      position: absolute;
      inset: 0;
      pointer-events: none;
      background: radial-gradient(circle at 20% 50%, rgba(232, 160, 32, 0.08) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(200, 230, 60, 0.05) 0%, transparent 40%);
    }

    .pb-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 0.6rem;
      background: rgba(232, 160, 32, 0.12);
      border: 1.5px solid rgba(232, 160, 32, 0.3);
      padding: 0.4rem 1rem;
      border-radius: 100px;
      font-size: 0.75rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 1.75rem;
    }

    .pb-hero-title {
      font-family: 'Syne', sans-serif;
      font-size: clamp(2.6rem, 4.5vw, 4rem);
      font-weight: 800;
      line-height: 1.05;
      color: #fff;
      margin-bottom: 1.5rem;
    }

    .pb-hero-title .gold {
      color: var(--gold);
    }

    .pb-hero-title .lime {
      color: var(--lime);
    }

    .pb-hero-sub {
      font-size: 1rem;
      line-height: 1.75;
      color: rgba(255, 255, 255, 0.6);
      max-width: 480px;
      margin-bottom: 2.5rem;
    }

    .pb-hero-btns {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .pb-btn-primary {
      background: var(--gold);
      color: var(--dark);
      padding: 0.85rem 2rem;
      border-radius: 100px;
      font-weight: 700;
      font-size: 0.95rem;
      text-decoration: none;
      border: 2px solid var(--gold);
      transition: background 0.2s, transform 0.2s;
    }

    .pb-btn-primary:hover {
      background: #d4911a;
      transform: translateY(-2px);
    }

    .pb-btn-ghost {
      background: transparent;
      color: #fff;
      padding: 0.85rem 2rem;
      border-radius: 100px;
      border: 2px solid rgba(255, 255, 255, 0.25);
      font-weight: 500;
      font-size: 0.95rem;
      text-decoration: none;
      transition: border-color 0.2s;
    }

    .pb-btn-ghost:hover {
      border-color: rgba(255, 255, 255, 0.6);
    }

    /* Hero right panel */
    .pb-hero-panel {
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      overflow: hidden;
    }

    .pb-panel-header {
      padding: 1.1rem 1.5rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .pb-panel-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: var(--gold);
    }

    .pb-panel-header span {
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: rgba(255, 255, 255, 0.5);
    }

    .pb-panel-items {
      padding: 0.75rem;
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .pb-panel-item {
      padding: 0.85rem 1rem;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.07);
      display: flex;
      align-items: center;
      gap: 0.85rem;
      text-decoration: none;
      transition: background 0.2s, border-color 0.2s, transform 0.2s;
    }

    .pb-panel-item:hover {
      background: rgba(232, 160, 32, 0.1);
      border-color: rgba(232, 160, 32, 0.3);
      transform: translateX(4px);
    }

    .pb-panel-icon {
      width: 36px;
      height: 36px;
      flex-shrink: 0;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      background: rgba(232, 160, 32, 0.15);
    }

    .pb-panel-text h4 {
      font-size: 0.85rem;
      font-weight: 600;
      color: #fff;
      margin-bottom: 0.15rem;
    }

    .pb-panel-text p {
      font-size: 0.75rem;
      color: rgba(255, 255, 255, 0.5);
    }

    .pb-panel-arrow {
      margin-left: auto;
      color: rgba(255, 255, 255, 0.2);
      transition: color 0.2s;
    }

    .pb-panel-item:hover .pb-panel-arrow {
      color: var(--gold);
    }

    .pb-panel-footer {
      padding: 1rem 1.5rem;
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      font-size: 0.75rem;
      color: rgba(255, 255, 255, 0.4);
      text-align: center;
    }

    /* AUDIENCE */
    .pb-audience {
      background: var(--cream);
      padding: 4rem 3rem;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
      max-width: 1300px;
      margin: 0 auto;
    }

    .pb-audience-card {
      background: #fff;
      border: 2px solid var(--dark);
      border-radius: 16px;
      padding: 2rem;
      transition: transform 0.25s, box-shadow 0.25s;
    }

    .pb-audience-card:hover {
      transform: translateY(-6px);
      box-shadow: 6px 6px 0 var(--dark);
    }

    .pb-audience-icon {
      font-size: 2.2rem;
      margin-bottom: 1rem;
    }

    .pb-audience-card h3 {
      font-family: 'Syne', sans-serif;
      font-size: 1rem;
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 0.6rem;
    }

    .pb-audience-card p {
      font-size: 0.875rem;
      color: #555;
      line-height: 1.65;
      margin-bottom: 1.25rem;
    }

    .pb-audience-link {
      font-size: 0.85rem;
      font-weight: 700;
      color: var(--gold);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.3rem;
    }

    /* SERVICES SLIDESHOW */
    .pb-services {
      background: var(--dark);
      padding: 5rem 3rem 4rem;
    }

    .pb-services-inner {
      max-width: 1300px;
      margin: 0 auto;
    }

    .pb-section-label {
      font-size: 0.75rem;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 0.5rem;
    }

    .pb-section-title {
      font-family: 'Syne', sans-serif;
      font-size: clamp(1.8rem, 3vw, 2.5rem);
      font-weight: 800;
      color: #fff;
      margin-bottom: 0.5rem;
    }

    .pb-section-title .lime {
      color: var(--lime);
    }

    .pb-services-wrap {
      margin-top: 2.5rem;
      overflow-x: hidden;
      border-radius: 20px;
      border: 2px solid rgba(255, 255, 255, 0.1);
    }

    .pb-services-track {
      display: flex;
    }

    .pb-service-slide {
      flex: 0 0 100%;
      min-width: 0;
      display: flex;
      flex-direction: row;
      min-height: 420px;
    }

    .pb-service-img {
      flex: 1;
      position: relative;
      min-height: 420px;
      background-size: cover;
      background-position: center;
    }

    .pb-service-img-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to right, rgba(15, 26, 46, 0.3), transparent);
    }

    .pb-service-tag-wrap {
      position: absolute;
      bottom: 1.25rem;
      left: 1.25rem;
    }

    .pb-service-tag {
      background: var(--gold);
      color: var(--dark);
      padding: 0.35rem 1rem;
      border-radius: 100px;
      font-weight: 700;
      font-size: 0.78rem;
      border: 2px solid var(--dark);
      font-family: 'Syne', sans-serif;
    }

    .pb-service-body {
      flex: 1;
      background: rgba(255, 255, 255, 0.04);
      padding: 3rem 2.5rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      border-left: 1px solid rgba(255, 255, 255, 0.08);
    }

    .pb-service-num {
      font-family: 'Syne', sans-serif;
      font-size: 3.5rem;
      font-weight: 800;
      color: rgba(255, 255, 255, 0.06);
      line-height: 1;
      margin-bottom: 0.75rem;
    }

    .pb-service-body h3 {
      font-family: 'Syne', sans-serif;
      font-size: 1.4rem;
      font-weight: 700;
      color: #fff;
      margin-bottom: 1rem;
      line-height: 1.2;
    }

    .pb-service-body p {
      font-size: 0.93rem;
      color: rgba(255, 255, 255, 0.6);
      line-height: 1.75;
      margin-bottom: 1.5rem;
    }

    .pb-service-link {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      color: var(--lime);
      text-decoration: none;
      font-weight: 600;
      font-size: 0.9rem;
      width: fit-content;
      transition: gap 0.2s;
    }

    .pb-service-link:hover {
      gap: 0.75rem;
    }

    .pb-ss-controls {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 1.5rem;
      margin-top: 1.25rem;
    }

    .pb-ss-btn {
      background: rgba(255, 255, 255, 0.08);
      border: 2px solid rgba(255, 255, 255, 0.15);
      color: #fff;
      width: 44px;
      height: 44px;
      border-radius: 50%;
      cursor: pointer;
      font-size: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.2s, border-color 0.2s;
    }

    .pb-ss-btn:hover {
      background: var(--gold);
      border-color: var(--gold);
      color: var(--dark);
    }

    .pb-ss-dots {
      display: flex;
      gap: 0.5rem;
      align-items: center;
    }

    .pb-ss-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      border: none;
      cursor: pointer;
      transition: background 0.2s, transform 0.2s;
      padding: 0;
    }

    .pb-ss-dot.active {
      background: var(--gold);
      transform: scale(1.4);
    }

    /* ABOUT */
    .pb-about {
      background: var(--cream);
      padding: 5rem 3rem;
    }

    .pb-about-inner {
      max-width: 1100px;
      margin: 2rem auto 0;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 3rem;
      align-items: center;
    }

    .pb-about-img img {
      width: 100%;
      border-radius: 20px;
      border: 3px solid var(--dark);
      box-shadow: 8px 8px 0 var(--gold);
    }

    .pb-about-text p {
      font-size: 1rem;
      line-height: 1.8;
      color: #444;
      margin-bottom: 1.25rem;
    }

    .pb-about-more {
      display: none;
    }

    .pb-read-more-btn {
      background: var(--dark);
      color: #fff;
      padding: 0.75rem 2rem;
      border-radius: 100px;
      border: none;
      cursor: pointer;
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 0.9rem;
      margin-top: 0.5rem;
      transition: background 0.2s;
    }

    .pb-read-more-btn:hover {
      background: var(--navy);
    }

    /* NEWS & EVENTS */
    .pb-hne-outer {
      background: #fff;
      padding: 5rem 3rem;
    }

    .pb-hne {
      max-width: 1100px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 3rem;
    }

    .pb-hne-col h2 {
      font-family: 'Syne', sans-serif;
      font-size: 1.5rem;
      font-weight: 800;
      color: var(--dark);
      margin-bottom: 1.5rem;
      padding-bottom: 0.75rem;
      border-bottom: 3px solid var(--gold);
      display: inline-block;
    }

    .pb-hne-item {
      padding: 1rem 0;
      border-bottom: 1px solid #eee;
    }

    .pb-hne-date {
      font-size: 0.75rem;
      color: var(--gold);
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      margin-bottom: 0.3rem;
    }

    .pb-hne-link {
      font-size: 0.9rem;
      font-weight: 500;
      color: var(--dark);
      text-decoration: none;
      line-height: 1.5;
      transition: color 0.2s;
    }

    .pb-hne-link:hover {
      color: var(--gold);
    }

    .pb-hne-more {
      display: inline-block;
      margin-top: 1.25rem;
      font-size: 0.85rem;
      font-weight: 700;
      color: var(--gold);
      text-decoration: none;
    }

    /* MISSION/VISION */
    .pb-mv {
      background: var(--dark);
      padding: 5rem 3rem;
      text-align: center;
    }

    .pb-mv h2 {
      font-family: 'Syne', sans-serif;
      font-size: 2rem;
      font-weight: 800;
      color: #fff;
      margin-bottom: 2.5rem;
    }

    .pb-mv-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
      max-width: 900px;
      margin: 0 auto;
    }

    .pb-mv-box {
      background: rgba(255, 255, 255, 0.05);
      border: 2px solid rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      padding: 2.5rem;
      text-align: left;
    }

    .pb-mv-box h3 {
      font-family: 'Syne', sans-serif;
      font-size: 0.95rem;
      font-weight: 700;
      color: var(--gold);
      margin-bottom: 1rem;
      text-transform: uppercase;
      letter-spacing: 0.08em;
    }

    .pb-mv-box p {
      font-size: 0.9rem;
      color: rgba(255, 255, 255, 0.65);
      line-height: 1.75;
    }

    /* VALUES */
    .pb-values {
      background: var(--cream);
      padding: 5rem 3rem;
    }

    .pb-values-inner {
      max-width: 1100px;
      margin: 0 auto;
    }

    .pb-values h2 {
      font-family: 'Syne', sans-serif;
      font-size: 2rem;
      font-weight: 800;
      color: var(--dark);
      text-align: center;
      margin-bottom: 0.5rem;
    }

    .pb-values-sub {
      text-align: center;
      color: #666;
      margin-bottom: 2.5rem;
    }

    .pb-values-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
    }

    .pb-value-card {
      background: #fff;
      border: 2px solid var(--dark);
      border-radius: 16px;
      padding: 2rem;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .pb-value-card:hover {
      transform: translateY(-4px);
      box-shadow: 4px 4px 0 var(--gold);
    }

    .pb-value-card h4 {
      font-family: 'Syne', sans-serif;
      font-size: 0.95rem;
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 0.75rem;
    }

    .pb-value-card p {
      font-size: 0.875rem;
      color: #555;
      line-height: 1.65;
    }

    /* CTA */
    .pb-cta {
      background: var(--gold);
      padding: 4rem 3rem;
      text-align: center;
    }

    .pb-cta h2 {
      font-family: 'Syne', sans-serif;
      font-size: 2.2rem;
      font-weight: 800;
      color: var(--dark);
      margin-bottom: 0.75rem;
    }

    .pb-cta p {
      font-size: 1rem;
      color: rgba(15, 26, 46, 0.7);
      margin-bottom: 2rem;
    }

    .pb-cta a {
      background: var(--dark);
      color: #fff;
      padding: 0.9rem 2.5rem;
      border-radius: 100px;
      font-weight: 700;
      text-decoration: none;
      font-family: 'Syne', sans-serif;
      transition: background 0.2s;
    }

    .pb-cta a:hover {
      background: var(--navy);
    }

    /* Event popup */
    #eventPopup {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: rgba(255, 255, 255, 0.95);
      border: 1px solid #ccc;
      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.25);
      z-index: 9999;
      width: 200px;
      border-radius: 8px;
      font-family: 'DM Sans', sans-serif;
      padding: 12px;
      text-align: center;
    }

    #eventPopup h3 {
      margin: 6px 0;
      color: #333;
      font-size: 1em;
      font-weight: bold;
      line-height: 1.2;
    }

    #eventPopup p {
      font-size: 0.85em;
      color: #555;
      line-height: 1.3;
      margin: 4px 0;
    }

    .popup-btn-row {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 12px;
    }

    .popup-btn {
      padding: 8px 14px;
      background: #007BFF;
      color: #fff;
      text-decoration: none;
      border: none;
      border-radius: 5px;
      font-size: 13px;
      cursor: pointer;
    }

    .popup-close {
      position: absolute;
      top: 4px;
      right: 6px;
      cursor: pointer;
      font-size: 16px;
      color: #666;
    }

    .popup-close-btn {
      background: #6c757d;
    }

    @keyframes bounceFromBottom {
      0% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-100px);
      }

      100% {
        transform: translateY(0);
      }
    }

    .bounce {
      animation: bounceFromBottom 3s ease-in-out;
    }

    @media (max-width:900px) {
      .pb-hero {
        grid-template-columns: 1fr;
        padding: 4rem 1.5rem 3rem;
        gap: 2rem;
      }

      .pb-audience {
        grid-template-columns: 1fr;
        padding: 2.5rem 1.5rem;
      }

      .pb-about-inner {
        grid-template-columns: 1fr;
      }

      .pb-hne {
        grid-template-columns: 1fr;
      }

      .pb-mv-grid {
        grid-template-columns: 1fr;
      }

      .pb-values-grid {
        grid-template-columns: 1fr 1fr;
      }

      .pb-services,
      .pb-about,
      .pb-mv,
      .pb-values,
      .pb-cta {
        padding: 3rem 1.5rem;
      }
    }

    @media (max-width:600px) {
      .pb-values-grid {
        grid-template-columns: 1fr;
      }
    }

    /* ════ GILBERT ACKNOWLEDGEMENT BANNER ════ */
    .gw-ack {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      z-index: 8000;
      background: linear-gradient(135deg, #0f1a2e 0%, #1a2c5b 50%, #0f1a2e 100%);
      border-top: 3px solid #E8A020;
      padding: 1rem 2rem;
      box-shadow: 0 -4px 30px rgba(232, 160, 32, 0.2);
      animation: gwSlideUp 0.7s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    @keyframes gwSlideUp {
      from {
        transform: translateY(100%);
        opacity: 0;
      }

      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .gw-ack-inner {
      max-width: 1300px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 2rem;
      flex-wrap: wrap;
    }

    .gw-ack-left {
      display: flex;
      align-items: center;
      gap: 1rem;
      flex-shrink: 0;
    }

    .gw-ack-avatar {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: linear-gradient(135deg, #E8A020, #d4911a);
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 800;
      font-size: 0.85rem;
      color: #0f1a2e;
      flex-shrink: 0;
      box-shadow: 0 0 0 3px rgba(232, 160, 32, 0.3);
      animation: gwPulse 3s ease-in-out infinite;
    }

    @keyframes gwPulse {

      0%,
      100% {
        box-shadow: 0 0 0 3px rgba(232, 160, 32, 0.3);
      }

      50% {
        box-shadow: 0 0 0 6px rgba(232, 160, 32, 0.1);
      }
    }

    .gw-ack-name {
      font-size: 1rem;
      font-weight: 700;
      color: #fff;
      letter-spacing: 0.02em;
      display: flex;
      align-items: center;
      gap: 2px;
      min-width: 280px;
    }

    .gw-typing {
      color: #E8A020;
    }

    .gw-cursor {
      color: #E8A020;
      font-weight: 300;
      animation: gwBlink 0.8s step-end infinite;
    }

    @keyframes gwBlink {

      0%,
      100% {
        opacity: 1;
      }

      50% {
        opacity: 0;
      }
    }

    .gw-ack-role {
      font-size: 0.72rem;
      color: rgba(255, 255, 255, 0.45);
      margin-top: 0.2rem;
      letter-spacing: 0.03em;
    }

    .gw-ack-links {
      display: flex;
      align-items: center;
      gap: 1.25rem;
      flex-wrap: wrap;
    }

    .gw-ack-link {
      display: flex;
      align-items: center;
      gap: 0.4rem;
      color: rgba(255, 255, 255, 0.7);
      text-decoration: none;
      font-size: 0.8rem;
      font-weight: 500;
      padding: 0.4rem 0.85rem;
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 100px;
      transition: background 0.2s, border-color 0.2s, color 0.2s, transform 0.2s;
      white-space: nowrap;
    }

    .gw-ack-link:hover {
      background: rgba(232, 160, 32, 0.15);
      border-color: rgba(232, 160, 32, 0.5);
      color: #E8A020;
      transform: translateY(-2px);
    }

    .gw-ack-icon {
      font-size: 0.85rem;
    }

    .gw-si {
      width: 14px;
      height: 14px;
      filter: invert(1) opacity(0.7);
      transition: opacity 0.2s;
    }

    .gw-ack-link:hover .gw-si {
      filter: invert(1) sepia(1) saturate(3) hue-rotate(0deg) opacity(1);
    }

    .gw-ack-close {
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid rgba(255, 255, 255, 0.12);
      color: rgba(255, 255, 255, 0.4);
      width: 32px;
      height: 32px;
      border-radius: 50%;
      cursor: pointer;
      font-size: 0.8rem;
      flex-shrink: 0;
      transition: background 0.2s, color 0.2s;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .gw-ack-close:hover {
      background: rgba(255, 255, 255, 0.15);
      color: #fff;
    }

    @media (max-width: 900px) {
      .gw-ack {
        padding: 1rem 1.25rem;
      }

      .gw-ack-links {
        gap: 0.75rem;
      }

      .gw-ack-link span:not(.gw-ack-icon) {
        display: none;
      }

      .gw-ack-link {
        padding: 0.4rem 0.6rem;
      }
    }

    /* ════ END ACKNOWLEDGEMENT CSS ════ */

    /* ══ CORPORATE DESIGN ══ */
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

    body {
      font-family: 'Space Grotesk', sans-serif;
      background: var(--white);
      color: var(--text);
      overflow-x: hidden;
    }

    /* TOPBAR override for corporate */
    .mb-topbar {
      background: var(--navy);
    }

    /* HERO */
    .cp-hero {
      background: var(--navy);
      min-height: 88vh;
      display: grid;
      grid-template-columns: 55% 45%;
      position: relative;
      overflow: hidden;
    }

    .cp-hero::after {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      width: 48%;
      height: 100%;
      background: var(--gold-pale);
      clip-path: polygon(12% 0%, 100% 0%, 100% 100%, 0% 100%);
      z-index: 0;
    }

    .cp-hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image: radial-gradient(circle, rgba(200, 145, 10, 0.08) 1px, transparent 1px);
      background-size: 32px 32px;
      z-index: 0;
    }

    .cp-hero-left {
      position: relative;
      z-index: 1;
      padding: 6rem 3rem 5rem 3.5rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .cp-hero-eyebrow {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 2rem;
    }

    .cp-hero-eyebrow-line {
      width: 40px;
      height: 2px;
      background: var(--gold);
    }

    .cp-hero-eyebrow span {
      font-size: 0.78rem;
      font-weight: 600;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--gold-light);
    }

    .cp-hero-headline {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2.6rem, 4vw, 3.8rem);
      font-weight: 700;
      color: var(--white);
      line-height: 1.15;
      margin-bottom: 1.75rem;
    }

    .cp-hero-headline em {
      font-style: italic;
      color: var(--gold-light);
    }

    .cp-hero-sub {
      font-size: 1.05rem;
      color: rgba(255, 255, 255, 0.65);
      line-height: 1.75;
      max-width: 460px;
      margin-bottom: 2.5rem;
      font-weight: 300;
    }

    .cp-hero-actions {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
      margin-bottom: 3.5rem;
    }

    .cp-btn-primary {
      background: var(--gold);
      color: var(--white);
      padding: 0.85rem 2.2rem;
      border-radius: 4px;
      text-decoration: none;
      font-weight: 600;
      font-size: 0.95rem;
      transition: background 0.2s, transform 0.2s;
    }

    .cp-btn-primary:hover {
      background: #A87508;
      transform: translateY(-1px);
    }

    .cp-btn-ghost {
      background: transparent;
      color: var(--white);
      padding: 0.85rem 2.2rem;
      border-radius: 4px;
      border: 1.5px solid rgba(255, 255, 255, 0.3);
      text-decoration: none;
      font-weight: 500;
      font-size: 0.95rem;
      transition: border-color 0.2s, background 0.2s;
    }

    .cp-btn-ghost:hover {
      border-color: rgba(255, 255, 255, 0.7);
      background: rgba(255, 255, 255, 0.07);
    }

    .cp-hero-stats {
      display: flex;
      gap: 2.5rem;
      padding-top: 2.5rem;
      border-top: 1px solid rgba(255, 255, 255, 0.12);
    }

    .cp-hero-stat .num {
      font-family: 'Playfair Display', serif;
      font-size: 2.2rem;
      font-weight: 700;
      color: var(--gold-light);
      line-height: 1;
    }

    .cp-hero-stat .label {
      font-size: 0.8rem;
      color: rgba(255, 255, 255, 0.5);
      margin-top: 0.3rem;
    }

    /* Hero right — service cards */
    .cp-hero-right {
      position: relative;
      z-index: 1;
      padding: 5rem 3rem 5rem 5rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .cp-services-list {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .cp-service-row {
      background: var(--white);
      border-radius: 8px;
      padding: 1.25rem 1.5rem;
      display: flex;
      align-items: center;
      gap: 1.25rem;
      box-shadow: 0 2px 16px rgba(13, 30, 61, 0.08);
      transition: transform 0.2s, box-shadow 0.2s;
      text-decoration: none;
    }

    .cp-service-row:hover {
      transform: translateX(4px);
      box-shadow: 0 4px 24px rgba(13, 30, 61, 0.14);
    }

    .cp-service-icon {
      width: 44px;
      height: 44px;
      flex-shrink: 0;
      background: var(--navy-light);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.3rem;
    }

    .cp-service-row h4 {
      font-weight: 600;
      font-size: 0.95rem;
      color: var(--navy);
      margin-bottom: 0.2rem;
    }

    .cp-service-row p {
      font-size: 0.8rem;
      color: var(--text-light);
    }

    .cp-service-arrow {
      margin-left: auto;
      color: var(--gold);
      font-size: 1.1rem;
    }

    /* INTRO BAND */
    .cp-intro-band {
      background: var(--off-white);
      border-top: 1px solid var(--rule);
      border-bottom: 1px solid var(--rule);
      padding: 3.5rem 3rem;
      text-align: center;
    }

    .cp-intro-band p {
      font-family: 'Playfair Display', serif;
      font-size: 1.4rem;
      font-weight: 600;
      color: var(--navy-mid);
      max-width: 720px;
      margin: 0 auto;
      line-height: 1.6;
    }

    .cp-intro-band p em {
      color: var(--gold);
      font-style: italic;
    }

    /* AUDIENCE */
    .cp-audience {
      padding: 6rem 3rem;
      background: var(--white);
    }

    .cp-audience-inner {
      max-width: 1200px;
      margin: 0 auto;
    }

    .cp-section-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-bottom: 3rem;
      padding-bottom: 1.5rem;
      border-bottom: 1px solid var(--rule);
    }

    .cp-section-header-left .eyebrow {
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 0.5rem;
    }

    .cp-section-header-left h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.2rem;
      font-weight: 700;
      color: var(--navy);
      line-height: 1.2;
    }

    .cp-section-header>p {
      font-size: 0.9rem;
      color: var(--text-light);
      max-width: 280px;
      line-height: 1.65;
      text-align: right;
    }

    .cp-audience-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 2rem;
    }

    .cp-acard {
      border: 1px solid var(--rule);
      border-radius: 8px;
      overflow: hidden;
      transition: box-shadow 0.3s;
    }

    .cp-acard:hover {
      box-shadow: 0 8px 40px rgba(13, 30, 61, 0.1);
    }

    .cp-acard-header {
      padding: 2rem;
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
    }

    .cp-acard:nth-child(1) .cp-acard-header {
      background: var(--navy);
    }

    .cp-acard:nth-child(2) .cp-acard-header {
      background: var(--gold);
    }

    .cp-acard:nth-child(3) .cp-acard-header {
      background: var(--off-white);
    }

    .cp-acard-icon {
      font-size: 2.2rem;
    }

    .cp-acard-tag {
      font-size: 0.7rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      padding: 0.3rem 0.7rem;
      border-radius: 3px;
    }

    .cp-acard:nth-child(1) .cp-acard-tag {
      background: rgba(255, 255, 255, 0.15);
      color: rgba(255, 255, 255, 0.8);
    }

    .cp-acard:nth-child(2) .cp-acard-tag {
      background: rgba(255, 255, 255, 0.3);
      color: var(--navy);
    }

    .cp-acard:nth-child(3) .cp-acard-tag {
      background: var(--navy-light);
      color: var(--navy);
    }

    .cp-acard-body {
      padding: 1.75rem 2rem;
      background: var(--white);
    }

    .cp-acard-body h3 {
      font-family: 'Playfair Display', serif;
      font-size: 1.15rem;
      font-weight: 700;
      color: var(--navy);
      margin-bottom: 0.75rem;
    }

    .cp-acard-body p {
      font-size: 0.875rem;
      color: var(--text-mid);
      line-height: 1.7;
      margin-bottom: 1.25rem;
    }

    .cp-acard-link {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      font-size: 0.875rem;
      font-weight: 600;
      color: var(--gold);
      text-decoration: none;
      border-bottom: 1px solid transparent;
      transition: border-color 0.2s, gap 0.2s;
    }

    .cp-acard-link:hover {
      border-bottom-color: var(--gold);
      gap: 0.65rem;
    }

    /* PILLARS */
    .cp-pillars {
      background: var(--navy);
      padding: 6rem 3rem;
    }

    .cp-pillars-inner {
      max-width: 1200px;
      margin: 0 auto;
    }

    .cp-pillars-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
    }

    .cp-pillars-header h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.2rem;
      font-weight: 700;
      color: #fff;
      line-height: 1.2;
    }

    .cp-pillars-header p {
      font-size: 0.9rem;
      color: rgba(255, 255, 255, 0.45);
      max-width: 300px;
      text-align: right;
      line-height: 1.65;
    }

    .cp-pillars-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 0;
      margin-top: 3rem;
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 8px;
      overflow: hidden;
    }

    .cp-pillar {
      padding: 2.5rem 2rem;
      border-right: 1px solid rgba(255, 255, 255, 0.1);
      transition: background 0.3s;
    }

    .cp-pillar:last-child {
      border-right: none;
    }

    .cp-pillar:hover {
      background: rgba(255, 255, 255, 0.04);
    }

    .cp-pillar-num {
      font-family: 'Playfair Display', serif;
      font-size: 3rem;
      color: rgba(200, 145, 10, 0.3);
      font-weight: 700;
      line-height: 1;
      margin-bottom: 1.25rem;
    }

    .cp-pillar h3 {
      font-weight: 600;
      font-size: 1rem;
      color: #fff;
      margin-bottom: 0.75rem;
      line-height: 1.3;
    }

    .cp-pillar p {
      font-size: 0.85rem;
      color: rgba(255, 255, 255, 0.5);
      line-height: 1.65;
    }

    .cp-pillar-link {
      display: block;
      margin-top: 1.25rem;
      font-size: 0.8rem;
      color: var(--gold-light);
      text-decoration: none;
      font-weight: 600;
    }

    .cp-pillar-link:hover {
      text-decoration: underline;
    }

    /* SERVICES SLIDESHOW */
    .cp-slideshow {
      background: var(--off-white);
      border-top: 1px solid var(--rule);
      border-bottom: 1px solid var(--rule);
      padding: 5rem 3rem;
    }

    .cp-slideshow-inner {
      max-width: 1100px;
      margin: 0 auto;
    }

    .cp-ss-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      gap: 3rem;
      margin-bottom: 2.5rem;
      padding-bottom: 1.5rem;
      border-bottom: 1px solid var(--rule);
    }

    .cp-eyebrow-tag {
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 0.5rem;
    }

    .cp-ss-title {
      font-family: 'Playfair Display', serif;
      font-size: 2rem;
      font-weight: 700;
      color: var(--navy);
      line-height: 1.2;
    }

    .cp-ss-sub {
      font-size: 0.9rem;
      color: var(--text-light);
      max-width: 320px;
      line-height: 1.7;
      text-align: right;
      align-self: flex-end;
    }

    .cp-ss-wrap {
      overflow-x: hidden;
      border-radius: 8px;
      border: 1px solid var(--rule);
      box-shadow: 0 4px 32px rgba(13, 30, 61, 0.07);
    }

    .cp-ss-track {
      display: flex;
    }

    .ss-slide {
      flex: 0 0 100%;
      min-width: 0;
      display: flex;
      flex-direction: row;
      min-height: 380px;
      background: var(--white);
    }

    .ss-img {
      flex: 1;
      position: relative;
      min-height: 380px;
      background-size: cover;
      background-position: center;
    }

    .ss-img-inner-label {
      position: absolute;
      bottom: 1rem;
      left: 1.25rem;
    }

    .ss-badge {
      background: var(--gold);
      color: var(--white);
      padding: 0.3rem 0.85rem;
      border-radius: 3px;
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: 0.06em;
      text-transform: uppercase;
    }

    .ss-content {
      flex: 1;
      padding: 3rem 2.5rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      border-left: 1px solid var(--rule);
    }

    .ss-content-num {
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.1em;
      color: var(--text-light);
      text-transform: uppercase;
      margin-bottom: 1rem;
    }

    .ss-content h3 {
      font-family: 'Playfair Display', serif;
      font-size: 1.45rem;
      font-weight: 700;
      color: var(--navy);
      margin-bottom: 1rem;
      line-height: 1.3;
    }

    .ss-content p {
      font-size: 0.9rem;
      color: var(--text-mid);
      line-height: 1.75;
      margin-bottom: 1.5rem;
    }

    .ss-cta-link {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      font-size: 0.875rem;
      font-weight: 600;
      color: var(--gold);
      text-decoration: none;
      transition: gap 0.2s;
      width: fit-content;
    }

    .ss-cta-link:hover {
      gap: 0.65rem;
    }

    .cp-ss-controls {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 1.25rem;
      margin-top: 1.25rem;
    }

    .cp-ss-arr {
      background: var(--white);
      border: 1px solid var(--rule);
      color: var(--navy);
      width: 40px;
      height: 40px;
      border-radius: 50%;
      cursor: pointer;
      font-size: 1rem;
      transition: background 0.2s, border-color 0.2s;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .cp-ss-arr:hover {
      background: var(--navy);
      color: #fff;
      border-color: var(--navy);
    }

    .cp-ss-dots {
      display: flex;
      gap: 0.4rem;
      align-items: center;
    }

    .ss-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: var(--rule);
      border: none;
      cursor: pointer;
      transition: background 0.2s, transform 0.2s;
      padding: 0;
    }

    .ss-dot.active {
      background: var(--gold);
      transform: scale(1.4);
    }

    /* ABOUT */
    .cp-about {
      background: var(--white);
      padding: 6rem 3rem;
    }

    .cp-about-inner {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 4rem;
      align-items: center;
    }

    .cp-about-img img {
      width: 100%;
      border-radius: 8px;
      box-shadow: 0 8px 32px rgba(13, 30, 61, 0.12);
    }

    .cp-about-eyebrow {
      font-size: 0.75rem;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 0.75rem;
    }

    .cp-about-text h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2rem;
      font-weight: 700;
      color: var(--navy);
      line-height: 1.2;
      margin-bottom: 1.5rem;
    }

    .cp-about-text p {
      font-size: 0.95rem;
      color: var(--text-mid);
      line-height: 1.8;
      margin-bottom: 1.25rem;
    }

    .cp-about-more {
      display: none;
    }

    .cp-read-more-btn {
      background: var(--navy);
      color: #fff;
      padding: 0.75rem 2rem;
      border-radius: 4px;
      border: none;
      cursor: pointer;
      font-family: 'Source Sans 3', sans-serif;
      font-weight: 600;
      font-size: 0.9rem;
      margin-top: 0.5rem;
      transition: background 0.2s;
    }

    .cp-read-more-btn:hover {
      background: #0A1830;
    }

    /* NEWS & EVENTS */
    .cp-hne {
      background: var(--off-white);
      border-top: 1px solid var(--rule);
      padding: 6rem 3rem;
    }

    .cp-hne-inner {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 3rem;
    }

    .cp-hne-col h2 {
      font-family: 'Playfair Display', serif;
      font-size: 1.6rem;
      font-weight: 700;
      color: var(--navy);
      margin-bottom: 1.5rem;
      padding-bottom: 0.75rem;
      border-bottom: 2px solid var(--gold);
      display: inline-block;
    }

    .cp-hne-item {
      padding: 1rem 0;
      border-bottom: 1px solid var(--rule);
    }

    .cp-hne-date {
      font-size: 0.75rem;
      color: var(--gold);
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      margin-bottom: 0.3rem;
    }

    .cp-hne-link {
      font-size: 0.9rem;
      font-weight: 500;
      color: var(--text);
      text-decoration: none;
      line-height: 1.5;
      transition: color 0.2s;
    }

    .cp-hne-link:hover {
      color: var(--gold);
    }

    .cp-hne-more {
      display: inline-block;
      margin-top: 1.25rem;
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--gold);
      text-decoration: none;
    }

    /* MISSION/VISION */
    .cp-mv {
      background: var(--gold-pale);
      border-top: 1px solid rgba(200, 145, 10, 0.2);
      padding: 6rem 3rem;
      text-align: center;
    }

    .cp-mv h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.4rem;
      font-weight: 700;
      color: var(--navy);
      margin-bottom: 3rem;
    }

    .cp-mv-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
      max-width: 900px;
      margin: 0 auto;
    }

    .cp-mv-box {
      background: var(--white);
      border-radius: 8px;
      padding: 2.5rem;
      text-align: left;
      box-shadow: 0 2px 20px rgba(13, 30, 61, 0.07);
    }

    .cp-mv-box h3 {
      font-family: 'Playfair Display', serif;
      font-size: 1rem;
      font-weight: 700;
      color: var(--gold);
      margin-bottom: 1rem;
      text-transform: uppercase;
      letter-spacing: 0.08em;
    }

    .cp-mv-box p {
      font-size: 0.9rem;
      color: var(--text-mid);
      line-height: 1.75;
    }

    /* VALUES */
    .cp-values {
      background: var(--white);
      padding: 6rem 3rem;
    }

    .cp-values-inner {
      max-width: 1200px;
      margin: 0 auto;
    }

    .cp-values h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2rem;
      font-weight: 700;
      color: var(--navy);
      text-align: center;
      margin-bottom: 0.5rem;
    }

    .cp-values-sub {
      text-align: center;
      color: var(--text-light);
      margin-bottom: 3rem;
    }

    .cp-values-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
    }

    .cp-value-card {
      padding: 2rem;
      border: 1px solid var(--rule);
      border-radius: 8px;
      transition: box-shadow 0.3s, border-color 0.3s;
    }

    .cp-value-card:hover {
      box-shadow: 0 8px 32px rgba(13, 30, 61, 0.1);
      border-color: var(--gold);
    }

    .cp-value-card h4 {
      font-family: 'Playfair Display', serif;
      font-size: 1rem;
      font-weight: 700;
      color: var(--navy);
      margin-bottom: 0.75rem;
    }

    .cp-value-card p {
      font-size: 0.875rem;
      color: var(--text-mid);
      line-height: 1.65;
    }

    /* CTA */
    .cp-cta {
      background: var(--navy);
      padding: 5rem 3rem;
      text-align: center;
    }

    .cp-cta .eyebrow {
      font-size: 0.78rem;
      font-weight: 600;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--gold-light);
      margin-bottom: 1rem;
    }

    .cp-cta h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.8rem;
      font-weight: 700;
      color: #fff;
      margin-bottom: 1rem;
      line-height: 1.2;
    }

    .cp-cta p {
      color: rgba(255, 255, 255, 0.6);
      max-width: 480px;
      margin: 0 auto 2.5rem;
      line-height: 1.7;
    }

    .cp-cta-buttons {
      display: flex;
      gap: 1rem;
      justify-content: center;
    }

    /* Credit snippet styles */
    .gw-credit {
      margin-top: 1.5rem;
      padding: 1rem 1.25rem;
      background: rgba(200, 145, 10, 0.08);
      border: 1px solid rgba(200, 145, 10, 0.25);
      border-radius: 10px;
    }

    .gw-credit-label {
      font-size: 0.65rem;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--gold-light);
      margin-bottom: 0.5rem;
    }

    .gw-credit-name {
      font-size: 0.88rem;
      font-weight: 600;
      color: #fff;
      margin-bottom: 0.75rem;
    }

    .gw-credit-links {
      display: flex;
      flex-direction: column;
      gap: 0.4rem;
    }

    .gw-credit-links a {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.78rem;
      color: rgba(255, 255, 255, 0.55);
      text-decoration: none;
      transition: color 0.2s;
    }

    .gw-credit-links a:hover {
      color: var(--gold-light);
    }

    .gw-credit-links a span {
      font-size: 0.8rem;
    }

    @media (max-width: 1024px) {
      .cp-hero {
        grid-template-columns: 1fr;
        min-height: auto;
      }

      .cp-hero::after {
        display: none;
      }

      .cp-hero-left {
        padding: 5rem 2rem 3rem;
      }

      .cp-hero-right {
        padding: 2rem;
      }

      .cp-audience-grid,
      .cp-pillars-grid {
        grid-template-columns: 1fr 1fr;
      }

      .cp-about-inner,
      .cp-hne-inner,
      .cp-mv-grid {
        grid-template-columns: 1fr;
      }

      .cp-values-grid {
        grid-template-columns: 1fr 1fr;
      }

      .cp-audience,
      .cp-pillars,
      .cp-slideshow,
      .cp-about,
      .cp-hne,
      .cp-mv,
      .cp-values,
      .cp-cta {
        padding: 4rem 1.5rem;
      }

      .cp-section-header {
        flex-direction: column;
        align-items: flex-start;
      }

      .cp-section-header>p {
        text-align: left;
        max-width: 100%;
      }

      .cp-pillars-header {
        flex-direction: column;
        gap: 1rem;
      }

      .cp-pillars-header p {
        text-align: left;
      }
    }

    @media (max-width: 600px) {

      .cp-audience-grid,
      .cp-values-grid {
        grid-template-columns: 1fr;
      }

      .cp-pillar {
        border-right: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      }
    }

    /* ════ REDESIGN CREDIT CSS ════ */
    .mb-credit {
      margin-top: 1.5rem;
      padding: 1rem 1.25rem;
      background: rgba(232, 160, 32, 0.08);
      border: 1px solid rgba(232, 160, 32, 0.25);
      border-radius: 10px;
    }

    .mb-credit-label {
      font-size: 0.8rem;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: #E8A020;
      margin-bottom: 0.5rem;
    }

    .mb-credit-name {
      font-size: 0.88rem;
      font-weight: 600;
      color: #fff;
      margin-bottom: 0.75rem;
    }

    .mb-credit-links {
      display: flex;
      flex-direction: column;
      gap: 0.4rem;
    }

    .mb-credit-links a {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.78rem;
      color: rgba(255, 255, 255, 0.55);
      text-decoration: none;
      transition: color 0.2s;
    }

    .mb-credit-links a:hover {
      color: #E8A020;
    }

    .mb-credit-links a span {
      font-size: 0.8rem;
    }

    /* END OF REDESIGN CREDIT CSS */
  </style>
</head>

<body>

  <!-- ════ MFANO BORA OFFICIAL HEADER ════ -->
  <div class="mb-topbar">
    <span>Mon–Fri: 8:00 AM – 5:00 PM &nbsp;|&nbsp; Sat: 8:00 AM – 1:00 PM</span>
    <span style="color:rgba(255,255,255,0.2)">|</span>
    <a href="mailto:info@mfanoboraafrica.com">info@mfanoboraafrica.com</a>
  </div>

  <nav class="mb-nav">
    <a href="https://www.mfanoboraafrica.com/" class="mb-nav-brand">
      <img src="logo.png" alt="Mfano Bora Africa Logo">
      <div class="mb-nav-brand-text">
        <span class="name">Mfano Bora Africa Ltd</span>
        <span class="tagline">Setting the standard in transportation &amp; logistics</span>
      </div>
    </a>

    <ul class="mb-nav-links" id="mbNavLinks">
      <li><a href="https://www.mfanoboraafrica.com/" class="active">Home</a></li>
      <li>
        <span>Logistics Awards <span class="arrow">▾</span></span>
        <ul class="mb-dropdown">
          <li><a href="https://www.mfanoboraafrica.com/transport_awards/">E.A Regional Awards</a></li>
          <li><a href="https://www.mfanoboraafrica.com/gallery/">Gallery</a></li>
        </ul>
      </li>
      <li><a href="https://www.mfanoboraafrica.com/road-safety-club/">Road Safety Club</a></li>
      <li><a href="https://www.mfanoboraafrica.com/smart-driver-club/">Smart Driver Club</a></li>
      <li>
        <span>Career <span class="arrow">▾</span></span>
        <ul class="mb-dropdown">
          <li><a href="https://www.mfanoboraafrica.com/attachment/">Attachment</a></li>
          <li><a href="https://www.mfanoboraafrica.com/employment/">Employment</a></li>
          <li><a href="https://www.mfanoboraafrica.com/internship/">Internship</a></li>
          <li><a href="https://www.mfanoboraafrica.com/mentorship/">Mentorship</a></li>
          <li><a href="https://www.mfanoboraafrica.com/computer_packages/">Computer Packages</a></li>
        </ul>
      </li>
      <li><a href="https://www.mfanoboraafrica.com/contact-us/">Contact Us</a></li>
      <li>
        <div class="mb-nav-search" title="Search">🔍</div>
      </li>
    </ul>

    <div class="mb-hamburger" id="mbHamburger" onclick="document.getElementById('mbNavLinks').classList.toggle('open')">
      <span></span><span></span><span></span>
    </div>
  </nav>
  <!-- ════ END HEADER ════ -->

  <!-- HERO -->
  <section class="cp-hero">
    <div class="cp-hero-left">
      <div class="cp-hero-eyebrow">
        <div class="cp-hero-eyebrow-line"></div>
        <span>Road Safety · Skills · Community</span>
      </div>
      <h1 class="cp-hero-headline">
        Elevating standards<br>across Kenya's roads<br>and <em>communities.</em>
      </h1>
      <p class="cp-hero-sub">
        Mfano Bora Africa is a multi-discipline organisation dedicated to road safety education,
        professional driver training, logistics consulting, and skills development —
        shaping a safer, more capable Kenya.
      </p>
      <div class="cp-hero-actions">
        <a href="https://www.mfanoboraafrica.com/about/" class="cp-btn-primary">Discover Our Work</a>
        <a href="https://www.mfanoboraafrica.com/contact-us/" class="cp-btn-ghost">Download Profile</a>
      </div>
      <div class="cp-hero-stats">
        <div class="cp-hero-stat">
          <div class="num">24+</div>
          <div class="label">Years of Experience</div>
        </div>
        <div class="cp-hero-stat">
          <div class="num">500+</div>
          <div class="label">Road Safety Clubs</div>
        </div>
        <div class="cp-hero-stat">
          <div class="num">EA</div>
          <div class="label">Regional Awards Host</div>
        </div>
      </div>
    </div>

    <div class="cp-hero-right">
      <div class="cp-services-list">
        <a href="https://www.mfanoboraafrica.com/transport_awards/" class="cp-service-row">
          <div class="cp-service-icon">🏆</div>
          <div>
            <h4>EA Transport Awards</h4>
            <p>Recognising excellence across East Africa</p>
          </div>
          <span class="cp-service-arrow">→</span>
        </a>
        <a href="https://www.mfanoboraafrica.com/attachment/" class="cp-service-row">
          <div class="cp-service-icon">🎓</div>
          <div>
            <h4>Industrial Attachments</h4>
            <p>ICT, logistics &amp; administration programmes</p>
          </div>
          <span class="cp-service-arrow">→</span>
        </a>
        <a href="https://www.mfanoboraafrica.com/road-safety-club/" class="cp-service-row">
          <div class="cp-service-icon">🛡️</div>
          <div>
            <h4>Road Safety Club</h4>
            <p>Nationwide awareness &amp; school campaigns</p>
          </div>
          <span class="cp-service-arrow">→</span>
        </a>
        <a href="https://www.mfanoboraafrica.com/smart-driver-club/" class="cp-service-row">
          <div class="cp-service-icon">🚗</div>
          <div>
            <h4>Smart Drivers Club</h4>
            <p>Skills, safety knowledge &amp; responsible driving</p>
          </div>
          <span class="cp-service-arrow">→</span>
        </a>
      </div>
    </div>
  </section>

  <!-- INTRO BAND -->
  <div class="cp-intro-band">
    <p>"We believe that <em>better roads, better drivers, and better-equipped people</em> are the foundation of a
      stronger Kenya."</p>
  </div>

  <!-- AUDIENCE -->
  <section class="cp-audience">
    <div class="cp-audience-inner">
      <div class="cp-section-header">
        <div class="cp-section-header-left">
          <div class="eyebrow">Find Your Path</div>
          <h2>How can we help you?</h2>
        </div>
        <p>Whether you're a student, a business, or a community advocate — our work is built around you.</p>
      </div>
      <div class="cp-audience-grid">
        <div class="cp-acard">
          <div class="cp-acard-header"><span class="cp-acard-icon">🎓</span><span class="cp-acard-tag">Students &amp;
              Interns</span></div>
          <div class="cp-acard-body">
            <h3>Students &amp; Attachment Seekers</h3>
            <p>Access structured industrial attachment programmes and career development opportunities designed to
              prepare you for the professional world.</p><a href="https://www.mfanoboraafrica.com/attachment/"
              class="cp-acard-link">View programmes →</a>
          </div>
        </div>
        <div class="cp-acard">
          <div class="cp-acard-header"><span class="cp-acard-icon">🏢</span><span class="cp-acard-tag">Corporate</span>
          </div>
          <div class="cp-acard-body">
            <h3>Corporate &amp; Business Partners</h3>
            <p>From fleet safety audits to logistics consulting and employee road safety training — we help businesses
              reduce risk and improve performance.</p><a href="https://www.mfanoboraafrica.com/contact-us/"
              class="cp-acard-link">Explore partnerships →</a>
          </div>
        </div>
        <div class="cp-acard">
          <div class="cp-acard-header"><span class="cp-acard-icon">🌍</span><span class="cp-acard-tag">Community</span>
          </div>
          <div class="cp-acard-body">
            <h3>Community Members</h3>
            <p>Join the Smart Driver Club, participate in road safety awareness campaigns, and become part of a growing
              movement making Kenya's roads safer.</p><a href="https://www.mfanoboraafrica.com/road-safety-club/"
              class="cp-acard-link">Join the movement →</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- PILLARS -->
  <section class="cp-pillars">
    <div class="cp-pillars-inner">
      <div class="cp-pillars-header">
        <div>
          <div
            style="font-size:0.75rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--gold-light);margin-bottom:0.5rem;">
            Our Core Work</div>
          <h2>Four disciplines.<br>One commitment.</h2>
        </div>
        <p>Every programme we run connects back to raising the standard of life in Kenya.</p>
      </div>
      <div class="cp-pillars-grid">
        <div class="cp-pillar">
          <div class="cp-pillar-num">01</div>
          <h3>EA Transport Awards</h3>
          <p>Celebrating excellence and innovation in transport, logistics and road safety across East Africa.</p><a
            href="https://www.mfanoboraafrica.com/transport_awards/" class="cp-pillar-link">Learn more →</a>
        </div>
        <div class="cp-pillar">
          <div class="cp-pillar-num">02</div>
          <h3>Industrial Attachments</h3>
          <p>Structured attachment programmes for ICT, logistics, and administration students across Kenya.</p><a
            href="https://www.mfanoboraafrica.com/attachment/" class="cp-pillar-link">Learn more →</a>
        </div>
        <div class="cp-pillar">
          <div class="cp-pillar-num">03</div>
          <h3>Road Safety Club</h3>
          <p>Nationwide awareness campaigns, school outreach, and community training nurturing responsible road users.
          </p><a href="https://www.mfanoboraafrica.com/road-safety-club/" class="cp-pillar-link">Learn more →</a>
        </div>
        <div class="cp-pillar">
          <div class="cp-pillar-num">04</div>
          <h3>Smart Drivers Club</h3>
          <p>Empowering drivers with skills, safety knowledge, and responsible road behaviour for safer communities.</p>
          <a href="https://www.mfanoboraafrica.com/smart-driver-club/" class="cp-pillar-link">Learn more →</a>
        </div>
      </div>
    </div>
  </section>

  <!-- SERVICES SLIDESHOW -->
  <section class="cp-slideshow">
    <div class="cp-slideshow-inner">
      <div class="cp-ss-header">
        <div>
          <div class="cp-eyebrow-tag">Our Work in Action</div>
          <h2 class="cp-ss-title">Programmes that<br>make a difference.</h2>
        </div>
        <p class="cp-ss-sub">Each service represents a real commitment to improving lives across Kenya.</p>
      </div>
      <div class="cp-ss-wrap" id="corpSvcWrap">
        <div class="cp-ss-track">
          <div class="ss-slide">
            <div class="ss-img"
              style="background-image:url('awards.jpg');background-size:cover;background-position:center;">
              <div class="ss-img-inner-label"><span class="ss-badge">EA Transport Awards</span></div>
            </div>
            <div class="ss-content">
              <div class="ss-content-num">01 / 04</div>
              <h3>EA Transport, Logistics &amp; Road Safety Awards</h3>
              <p>Mfano Bora Africa Ltd hosts the East Africa Transport, Logistics &amp; Road Safety Awards, recognising
                excellence and innovation in the transport sector across East Africa.</p>
              <a href="https://www.mfanoboraafrica.com/transport_awards/" class="ss-cta-link">More Info →</a>
            </div>
          </div>
          <div class="ss-slide">
            <div class="ss-img"
              style="background-image:url('attachment.jpeg');background-size:cover;background-position:center;">
              <div class="ss-img-inner-label"><span class="ss-badge">Industrial Attachment</span></div>
            </div>
            <div class="ss-content">
              <div class="ss-content-num">02 / 04</div>
              <h3>Industrial Attachments Kenya</h3>
              <p>Mfano Bora Africa Ltd offers well-structured and high-quality industrial attachment programmes for
                students studying ICT, logistics, administration, and related fields.</p>
              <a href="https://www.mfanoboraafrica.com/apply-now/" class="ss-cta-link">Apply Now →</a>
            </div>
          </div>
          <div class="ss-slide">
            <div class="ss-img"
              style="background-image:url('road_safety.png');background-size:cover;background-position:center;">
              <div class="ss-img-inner-label"><span class="ss-badge">Road Safety Club</span></div>
            </div>
            <div class="ss-content">
              <div class="ss-content-num">03 / 04</div>
              <h3>Road Safety Club in Kenya</h3>
              <p>Through our Road Safety Club, Mfano Bora Africa Ltd leads nationwide awareness programmes, school road
                safety campaigns, and community training initiatives across Kenya.</p>
              <a href="https://www.mfanoboraafrica.com/road-safety-club/" class="ss-cta-link">Join Now →</a>
            </div>
          </div>
          <div class="ss-slide">
            <div class="ss-img"
              style="background-image:url('smart_driver.png');background-size:cover;background-position:center;">
              <div class="ss-img-inner-label"><span class="ss-badge">Smart Drivers Club</span></div>
            </div>
            <div class="ss-content">
              <div class="ss-content-num">04 / 04</div>
              <h3>Smart Drivers Club</h3>
              <p>Empowering drivers with essential skills, safety knowledge, and responsible road behaviour. We train
                participants to become confident and responsible road users.</p>
              <a href="https://www.mfanoboraafrica.com/smart-driver-club/" class="ss-cta-link">Learn More →</a>
            </div>
          </div>
        </div>
      </div>
      <div class="cp-ss-controls">
        <button class="cp-ss-arr" onclick="corpSvcPrev()">&#8592;</button>
        <div class="cp-ss-dots" id="corpSvcDots"><button class="ss-dot active" onclick="corpSvcGo(0)"></button><button
            class="ss-dot" onclick="corpSvcGo(1)"></button><button class="ss-dot"
            onclick="corpSvcGo(2)"></button><button class="ss-dot" onclick="corpSvcGo(3)"></button></div>
        <button class="cp-ss-arr" onclick="corpSvcNext()">&#8594;</button>
      </div>
    </div>
  </section>

  <!-- ABOUT -->
  <section class="cp-about">
    <div class="cp-about-inner">
      <div class="cp-about-img">
        <img src="https://www.mfanoboraafrica.com/assets/images/our-history.png" alt="Our History">
      </div>
      <div class="cp-about-text">
        <div class="cp-about-eyebrow">Who We Are</div>
        <h2>24 years of impact in East Africa.</h2>
        <p>Mfano Bora Africa Limited is the leading consulting firm in Logistics, providing integrated supply chain
          management consulting services that optimise operations by analysing, streamlining, and integrating all
          aspects of a supply chain.</p>
        <p>We are the home of the <strong>East Africa Transport, Logistics &amp; Road Safety Awards</strong> —
          celebrating excellence and innovation for the past 24 years.</p>
        <div class="cp-about-more" id="cpAboutMore">
          <p>We provide Road Safety Education that focuses on offering training and support to road users to improve
            safety on regional roads. We currently have more than 500 Road Safety Clubs in the region.</p>
          <p>Mfano Bora Africa offers social training aimed at improving performance and skills, fostering long-term
            career growth, and increasing engagement and retention for fresh graduates.</p>
        </div>
        <button class="cp-read-more-btn" id="cpReadMore">Read More</button>
      </div>
    </div>
  </section>

  <!-- NEWS & EVENTS -->
  <section class="cp-hne">
    <div class="cp-hne-inner">
      <div class="cp-hne-col">
        <h2>Latest Notices</h2>
        <div class="cp-hne-item"><a
            href="https://www.mfanoboraafrica.com/notices/44-industrial-attachment-opportunities-2026-intake-"
            class="cp-hne-link">INDUSTRIAL ATTACHMENT OPPORTUNITIES (2026 INTAKE)</a></div>
        <a href="https://www.mfanoboraafrica.com/notices/" class="cp-hne-more">More Notices →</a>
      </div>
      <div class="cp-hne-col">
        <h2>Upcoming Events</h2>
        <div class="cp-hne-item">
          <div class="cp-hne-date">April 30, 2026</div><a
            href="https://www.mfanoboraafrica.com/events/2-personal-accident-cover-networking-breakfast"
            class="cp-hne-link">PERSONAL ACCIDENT COVER NETWORKING BREAKFAST</a>
        </div>
        <div class="cp-hne-item">
          <div class="cp-hne-date">April 24, 2026</div><a
            href="https://www.mfanoboraafrica.com/events/3-4th-east-africa-transport-logistics-road-safety-awards-gala"
            class="cp-hne-link">4TH EAST AFRICA TRANSPORT, LOGISTICS &amp; ROAD SAFETY AWARDS GALA</a>
        </div>
        <a href="https://www.mfanoboraafrica.com/events/" class="cp-hne-more">View All →</a>
      </div>
    </div>
  </section>

  <!-- MISSION & VISION -->
  <section class="cp-mv">
    <h2>Our Mission &amp; Vision</h2>
    <div class="cp-mv-grid">
      <div class="cp-mv-box">
        <h3>Our Mission</h3>
        <p>To relentlessly focus on helping our partners succeed by serving their logistics needs through unparalleled
          expertise, technological agility, and continuous innovation.</p>
      </div>
      <div class="cp-mv-box">
        <h3>Our Vision</h3>
        <p>To be the leading Logistics consultant in Africa, recognised for excellence, innovation, and commitment to
          safety and sustainability while exceeding customer expectations.</p>
      </div>
    </div>
  </section>

  <!-- VALUES -->
  <section class="cp-values">
    <div class="cp-values-inner">
      <h2>Our Core Values</h2>
      <p class="cp-values-sub">These guiding principles shape every decision and action we take at Mfano Bora.</p>
      <div class="cp-values-grid">
        <div class="cp-value-card">
          <h4>Preservation of Human Life</h4>
          <p>We believe that protecting and saving lives is our highest priority. Every action we take is guided by the
            principle that human life is priceless.</p>
        </div>
        <div class="cp-value-card">
          <h4>Whole Participation of the Community</h4>
          <p>We encourage the active involvement of individuals, families, organisations, and authorities to work
            together in creating safer communities.</p>
        </div>
        <div class="cp-value-card">
          <h4>Partnership</h4>
          <p>We build strong, mutually beneficial relationships with stakeholders to share resources, expertise, and
            achieve greater impact.</p>
        </div>
        <div class="cp-value-card">
          <h4>Capacity Development</h4>
          <p>We equip people and communities with the skills, knowledge, and tools they need to prevent accidents and
            respond effectively to emergencies.</p>
        </div>
        <div class="cp-value-card">
          <h4>Sustainability &amp; Socio-Economic Development</h4>
          <p>We aim for long-term solutions that improve safety while also enhancing the social and economic well-being
            of communities.</p>
        </div>
        <div class="cp-value-card">
          <h4>Road Accidents Are Avoidable</h4>
          <p>With proper education, enforcement, and infrastructure, road accidents can be significantly reduced and, in
            many cases, prevented entirely.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cp-cta">
    <div class="eyebrow">Take the Next Step</div>
    <h2>Ready to connect with us?</h2>
    <p>Whether you're looking for training, partnership, or a chance to make a difference — we'd love to hear from you.
    </p>
    <div class="cp-cta-buttons">
      <a href="https://www.mfanoboraafrica.com/contact-us/" class="cp-btn-primary">Get in Touch</a>
      <a href="https://www.mfanoboraafrica.com/contact-us/" class="cp-btn-ghost">Download Our Profile</a>
    </div>
  </section>

  <!-- ════ MFANO BORA OFFICIAL FOOTER ════ -->
  <footer class="mb-footer">
    <div class="mb-footer-top">

      <!-- Brand -->
      <div class="mb-footer-brand">
        <img src="logo.png" alt="Mfano Bora Africa">
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
        <p style="font-size:0.82rem;color:rgba(255,255,255,0.5);margin-bottom:0.5rem;">Stay updated on our latest news,
          offers, and events.</p>
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
            <a href="mailto:info@mfanoboraafrica.com"
              style="color:rgba(255,255,255,0.6);text-decoration:none;">info@mfanoboraafrica.com</a>
          </div>
          <div class="mb-footer-contact-item">
            <span class="icon">🕐</span>
            <span>Mon–Fri: 8:00 AM – 5:00 PM</span>
          </div>
        </div>
      </div>

      <!-- REDESIGN CREDIT/ ACKNOWLEDGEMENT -->
      <div class="mb-acknowledgement">
        <div class="mb-credit-label">Redesign by</div>
        <div class="mb-credit-name">Gilbert Williams Nyange</div>
        <div class="mb-credit-links">
          <a href="mailto:gilbertwilliamsnyange@gmail.com">
            <span>✉</span> gilbertwilliamsnyange@gmail.com
          </a>
          <a href="tel:+254719737274">
            <span>📞</span> +254 719 737 274
          </a>
          <a href="https://www.linkedin.com/in/gilbertwilliamsnyange" target="_blank">
            <span>🔗</span> LinkedIn
          </a>
          <a href="https://github.com/Gilb3rtWilliams" target="_blank">
            <span>🐙</span> Gilb3rtWilliams
          </a>
        </div>
      </div>
      <!-- ── END REDESIGN CREDIT ── -->

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

  <!-- Cookie Banner -->
  <div class="mb-cookie-banner" id="mbCookieBanner">
    <p>Our website uses cookies to enhance your experience. By clicking "Accept" or "Accept All," you consent to our use
      of cookies. You can also decline if you wish.</p>
    <div class="mb-cookie-btns">
      <button class="mb-cookie-btn accept"
        onclick="document.getElementById('mbCookieBanner').style.display='none'">Accept All</button>
      <button class="mb-cookie-btn decline"
        onclick="document.getElementById('mbCookieBanner').style.display='none'">Decline</button>
    </div>
  </div>
  <!-- ════ END FOOTER ════ -->

  <!-- ════ GILBERT ACKNOWLEDGEMENT BANNER ════ -->
  <div class="gw-ack" id="gwAck">
    <div class="gw-ack-inner">

      <div class="gw-ack-left">
        <div class="gw-ack-avatar">GW</div>
        <div>
          <div class="gw-ack-name">
            <span class="gw-typing" id="gwTyping"></span><span class="gw-cursor">|</span>
          </div>
          <div class="gw-ack-role">Attachment Student · Mfano Bora Africa Ltd · Homepage Redesign Proposal Module 2
          </div>
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
        <a href="https://www.linkedin.com/in/gilbertwilliamsnyange" target="_blank" class="gw-ack-link"
          title="LinkedIn">
          <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/linkedin.svg" class="gw-si"
            alt="LinkedIn">
          <span>LinkedIn</span>
        </a>
        <a href="https://github.com/Gilb3rtWilliams" target="_blank" class="gw-ack-link" title="GitHub">
          <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/github.svg" class="gw-si" alt="GitHub">
          <span>Gilb3rtWilliams</span>
        </a>
      </div>

      <button class="gw-ack-close" onclick="document.getElementById('gwAck').style.display='none'"
        title="Dismiss">✕</button>
    </div>
  </div>
  <!-- ════ END ACKNOWLEDGEMENT ════ -->

  <script>
    // SERVICES SLIDESHOW
    var corpSvcCur = 0, corpSvcTotal = 4;
    function corpSvcRender() {
      var w = document.getElementById('corpSvcWrap');
      w.scrollLeft = corpSvcCur * w.offsetWidth;
      document.querySelectorAll('#corpSvcDots .ss-dot').forEach(function (d, i) {
        d.classList.toggle('active', i === corpSvcCur);
      });
    }
    function corpSvcGo(n) {
      corpSvcCur = (n + corpSvcTotal) % corpSvcTotal;
      corpSvcRender();
      clearInterval(corpSvcTimer);
      corpSvcTimer = setInterval(corpSvcNext, 5000);
    }
    function corpSvcNext() { corpSvcGo(corpSvcCur + 1); }
    function corpSvcPrev() { corpSvcGo(corpSvcCur - 1); }
    var corpSvcTimer = setInterval(corpSvcNext, 5000);

    // READ MORE
    document.getElementById('cpReadMore').addEventListener('click', function () {
      var m = document.getElementById('cpAboutMore');
      var open = m.style.display === 'block';
      m.style.display = open ? 'none' : 'block';
      this.textContent = open ? 'Read More' : 'Read Less';
    });

    // HAMBURGER
    document.getElementById('mbHamburger').addEventListener('click', function () {
      document.getElementById('mbNavLinks').classList.toggle('open');
    });
  </script>

  <script>
    // Typing animation for acknowledgement
    (function () {
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
      // Start after banner slides in
      setTimeout(type, 800);
    })();
  </script>
</body>

</html>