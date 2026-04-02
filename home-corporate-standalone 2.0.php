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
    content="Mfano Bora Africa Ltd — East Africa's leading authority in road safety education, logistics consulting, transport awards, and professional skills development. Based in Nairobi, Kenya.">
  <title>Home - Mfano Bora Africa Ltd</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&family=Source+Sans+3:wght@300;400;500;600;700&display=swap"
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
      --gold-hover: #A87508;
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
      font-family: 'Source Sans 3', sans-serif;
      background: var(--white);
      color: var(--text);
      overflow-x: hidden;
    }

    /* HERO */
    .cp-hero {
      background: var(--navy);
      min-height: 90vh;
      display: grid;
      grid-template-columns: 55% 45%;
      position: relative;
      overflow: hidden;
      align-items: center;
    }

    .cp-hero::after {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      width: 47%;
      height: 100%;
      background: var(--gold-pale);
      clip-path: polygon(14% 0%, 100% 0%, 100% 100%, 0% 100%);
      z-index: 0;
    }

    .cp-hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image: radial-gradient(circle, rgba(200, 145, 10, 0.07) 1px, transparent 1px);
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

    .cp-kicker {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 1.75rem;
    }

    .cp-kicker-line {
      width: 40px;
      height: 2px;
      background: var(--gold);
      flex-shrink: 0;
    }

    .cp-kicker span {
      font-size: 0.75rem;
      font-weight: 700;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: var(--gold-light);
    }

    .cp-headline {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2.4rem, 3.5vw, 3.6rem);
      font-weight: 700;
      color: var(--white);
      line-height: 1.15;
      margin-bottom: 1.5rem;
    }

    .cp-headline em {
      font-style: italic;
      color: var(--gold-light);
    }

    .cp-sub {
      font-size: 1rem;
      color: rgba(255, 255, 255, 0.62);
      line-height: 1.8;
      max-width: 460px;
      margin-bottom: 2.5rem;
      font-weight: 300;
    }

    .cp-actions {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
      margin-bottom: 3rem;
    }

    .cp-btn {
      background: var(--gold);
      color: var(--white);
      padding: 0.85rem 2.2rem;
      border-radius: 4px;
      text-decoration: none;
      font-weight: 600;
      font-size: 0.92rem;
      transition: background 0.2s, transform 0.2s;
    }

    .cp-btn:hover {
      background: var(--gold-hover);
      transform: translateY(-1px);
    }

    .cp-btn-out {
      background: transparent;
      color: var(--white);
      padding: 0.85rem 2.2rem;
      border-radius: 4px;
      border: 1.5px solid rgba(255, 255, 255, 0.3);
      text-decoration: none;
      font-weight: 500;
      font-size: 0.92rem;
      transition: border-color 0.2s, background 0.2s;
    }

    .cp-btn-out:hover {
      border-color: rgba(255, 255, 255, 0.7);
      background: rgba(255, 255, 255, 0.07);
    }

    .cp-stats {
      display: flex;
      gap: 2.5rem;
      padding-top: 2.5rem;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .cp-stat .num {
      font-family: 'Playfair Display', serif;
      font-size: 2.2rem;
      font-weight: 700;
      color: var(--gold-light);
      line-height: 1;
    }

    .cp-stat .lbl {
      font-size: 0.78rem;
      color: rgba(255, 255, 255, 0.45);
      margin-top: 0.3rem;
      line-height: 1.4;
    }

    .cp-hero-right {
      position: relative;
      z-index: 1;
      padding: 5rem 3rem 5rem 5rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .cp-hero-right-lbl {
      font-size: 0.7rem;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 1.25rem;
    }

    .cp-svc-cards {
      display: flex;
      flex-direction: column;
      gap: 0.85rem;
    }

    .cp-svc-card {
      background: var(--white);
      border-radius: 8px;
      padding: 1.1rem 1.4rem;
      display: flex;
      align-items: center;
      gap: 1rem;
      box-shadow: 0 2px 16px rgba(13, 30, 61, 0.09);
      text-decoration: none;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .cp-svc-card:hover {
      transform: translateX(6px);
      box-shadow: 0 6px 28px rgba(13, 30, 61, 0.16);
    }

    .cp-svc-card-ico {
      width: 42px;
      height: 42px;
      flex-shrink: 0;
      background: var(--navy-light);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
    }

    .cp-svc-card-txt h4 {
      font-weight: 600;
      font-size: 0.9rem;
      color: var(--navy);
      margin-bottom: 0.15rem;
    }

    .cp-svc-card-txt p {
      font-size: 0.77rem;
      color: var(--text-light);
    }

    .cp-svc-card-arrow {
      margin-left: auto;
      color: var(--gold);
      font-size: 1rem;
      transition: transform 0.2s;
    }

    .cp-svc-card:hover .cp-svc-card-arrow {
      transform: translateX(3px);
    }

    /* MARQUEE */
    .cp-marquee {
      background: var(--gold);
      padding: 0.85rem 0;
      overflow: hidden;
      display: flex;
    }

    .cp-marquee-inner {
      display: flex;
      white-space: nowrap;
      animation: cpMarquee 30s linear infinite;
    }

    .cp-marquee-item {
      display: inline-flex;
      align-items: center;
      gap: 1rem;
      padding: 0 2rem;
      font-family: 'Playfair Display', serif;
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--navy);
      letter-spacing: 0.04em;
    }

    .cp-marquee-sep {
      opacity: 0.35;
    }

    @keyframes cpMarquee {
      from {
        transform: translateX(0);
      }

      to {
        transform: translateX(-50%);
      }
    }

    /* IDENTITY BAND */
    .cp-identity {
      background: var(--off-white);
      border-top: 1px solid var(--rule);
      border-bottom: 1px solid var(--rule);
      padding: 4rem 3rem;
    }

    .cp-identity-inner {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr 2px 1fr 2px 1fr;
      gap: 0;
      align-items: start;
    }

    .cp-identity-divider {
      background: var(--rule);
      align-self: stretch;
    }

    .cp-identity-col {
      padding: 0 3rem;
    }

    .cp-identity-col:first-child {
      padding-left: 0;
    }

    .cp-identity-col:last-child {
      padding-right: 0;
    }

    .cp-identity-num {
      font-family: 'Playfair Display', serif;
      font-size: 3rem;
      font-weight: 700;
      color: var(--gold);
      line-height: 1;
      margin-bottom: 0.4rem;
    }

    .cp-identity-col h3 {
      font-family: 'Playfair Display', serif;
      font-size: 1.05rem;
      font-weight: 700;
      color: var(--navy);
      margin-bottom: 0.75rem;
    }

    .cp-identity-col p {
      font-size: 0.875rem;
      color: var(--text-mid);
      line-height: 1.75;
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

    .cp-sec-head {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-bottom: 3rem;
      padding-bottom: 1.5rem;
      border-bottom: 1px solid var(--rule);
    }

    .cp-eyebrow {
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 0.5rem;
    }

    .cp-sec-head h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2rem;
      font-weight: 700;
      color: var(--navy);
      line-height: 1.2;
    }

    .cp-sec-head>p {
      font-size: 0.875rem;
      color: var(--text-light);
      max-width: 280px;
      line-height: 1.7;
      text-align: right;
    }

    .cp-aud-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 2rem;
    }

    .cp-acard {
      border: 1px solid var(--rule);
      border-radius: 8px;
      overflow: hidden;
      transition: box-shadow 0.3s, transform 0.3s;
    }

    .cp-acard:hover {
      box-shadow: 0 12px 40px rgba(13, 30, 61, 0.1);
      transform: translateY(-4px);
    }

    .cp-acard-top {
      padding: 2rem;
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
    }

    .cp-acard:nth-child(1) .cp-acard-top {
      background: var(--navy);
    }

    .cp-acard:nth-child(2) .cp-acard-top {
      background: var(--gold);
    }

    .cp-acard:nth-child(3) .cp-acard-top {
      background: var(--off-white);
    }

    .cp-acard-ico {
      font-size: 2.4rem;
    }

    .cp-acard-tag {
      font-size: 0.68rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      padding: 0.3rem 0.7rem;
      border-radius: 3px;
    }

    .cp-acard:nth-child(1) .cp-acard-tag {
      background: rgba(255, 255, 255, 0.14);
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
      font-size: 1.1rem;
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
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--gold);
      text-decoration: none;
      transition: gap 0.2s;
    }

    .cp-acard-link:hover {
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

    .cp-pillars-hdr {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-bottom: 3rem;
    }

    .cp-pillars-hdr h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.2rem;
      font-weight: 700;
      color: #fff;
      line-height: 1.2;
    }

    .cp-pillars-eyebrow {
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--gold-light);
      margin-bottom: 0.5rem;
    }

    .cp-pillars-hdr>p {
      font-size: 0.9rem;
      color: rgba(255, 255, 255, 0.45);
      max-width: 280px;
      text-align: right;
      line-height: 1.65;
    }

    .cp-pillars-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 8px;
      overflow: hidden;
    }

    .cp-pillar {
      padding: 2.5rem 2rem;
      border-right: 1px solid rgba(255, 255, 255, 0.1);
      transition: background 0.3s;
      position: relative;
      overflow: hidden;
    }

    .cp-pillar:last-child {
      border-right: none;
    }

    .cp-pillar:hover {
      background: rgba(255, 255, 255, 0.04);
    }

    .cp-pillar-bg {
      position: absolute;
      bottom: -0.5rem;
      right: 1rem;
      font-family: 'Playfair Display', serif;
      font-size: 6rem;
      font-weight: 700;
      color: rgba(255, 255, 255, 0.03);
      line-height: 1;
      pointer-events: none;
    }

    .cp-pillar-ico {
      font-size: 1.75rem;
      margin-bottom: 1rem;
      display: block;
    }

    .cp-pillar h3 {
      font-family: 'Playfair Display', serif;
      font-weight: 700;
      font-size: 1rem;
      color: #fff;
      margin-bottom: 0.75rem;
      line-height: 1.3;
    }

    .cp-pillar p {
      font-size: 0.83rem;
      color: rgba(255, 255, 255, 0.5);
      line-height: 1.7;
      margin-bottom: 1.25rem;
    }

    .cp-pillar-lnk {
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      font-size: 0.8rem;
      color: var(--gold-light);
      text-decoration: none;
      font-weight: 600;
      transition: gap 0.2s;
    }

    .cp-pillar-lnk:hover {
      gap: 0.6rem;
    }

    /* SLIDESHOW */
    .cp-ss {
      background: var(--off-white);
      border-top: 1px solid var(--rule);
      border-bottom: 1px solid var(--rule);
      padding: 5rem 3rem;
    }

    .cp-ss-inner {
      max-width: 1100px;
      margin: 0 auto;
    }

    .cp-ss-hdr {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      gap: 3rem;
      margin-bottom: 2.5rem;
      padding-bottom: 1.5rem;
      border-bottom: 1px solid var(--rule);
    }

    .cp-ss-title {
      font-family: 'Playfair Display', serif;
      font-size: 2rem;
      font-weight: 700;
      color: var(--navy);
      line-height: 1.2;
    }

    .cp-ss-sub {
      font-size: 0.875rem;
      color: var(--text-light);
      max-width: 300px;
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

    .cp-ss-slide {
      flex: 0 0 100%;
      min-width: 0;
      display: flex;
      flex-direction: row;
      min-height: 380px;
      background: var(--white);
    }

    .cp-ss-img {
      flex: 1;
      position: relative;
      min-height: 380px;
      background-size: cover;
      background-position: center;
    }

    .cp-ss-img-lbl {
      position: absolute;
      bottom: 1rem;
      left: 1.25rem;
    }

    .cp-ss-badge {
      background: var(--gold);
      color: var(--white);
      padding: 0.3rem 0.85rem;
      border-radius: 3px;
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: 0.06em;
      text-transform: uppercase;
    }

    .cp-ss-body {
      flex: 1;
      padding: 2.75rem 2.5rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      border-left: 1px solid var(--rule);
    }

    .cp-ss-body-num {
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.1em;
      color: var(--text-light);
      text-transform: uppercase;
      margin-bottom: 1rem;
    }

    .cp-ss-body h3 {
      font-family: 'Playfair Display', serif;
      font-size: 1.4rem;
      font-weight: 700;
      color: var(--navy);
      margin-bottom: 0.85rem;
      line-height: 1.3;
    }

    .cp-ss-body p {
      font-size: 0.875rem;
      color: var(--text-mid);
      line-height: 1.8;
      margin-bottom: 1.5rem;
    }

    .cp-ss-lnk {
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

    .cp-ss-lnk:hover {
      gap: 0.65rem;
    }

    .cp-ss-ctrl {
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

    .cp-ss-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: var(--rule);
      border: none;
      cursor: pointer;
      transition: background 0.2s, transform 0.2s;
      padding: 0;
    }

    .cp-ss-dot.active {
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
      gap: 5rem;
      align-items: start;
    }

    .cp-about-img {
      position: relative;
    }

    .cp-about-img img {
      width: 100%;
      border-radius: 8px;
      box-shadow: 0 12px 40px rgba(13, 30, 61, 0.14);
    }

    .cp-about-stat {
      position: absolute;
      bottom: -1.5rem;
      right: -1.5rem;
      background: var(--gold);
      color: var(--navy);
      padding: 1.25rem 1.5rem;
      border-radius: 8px;
      text-align: center;
      box-shadow: 0 8px 24px rgba(200, 145, 10, 0.35);
    }

    .cp-about-stat .big {
      font-family: 'Playfair Display', serif;
      font-size: 2.2rem;
      font-weight: 700;
      line-height: 1;
    }

    .cp-about-stat .small {
      font-size: 0.75rem;
      font-weight: 600;
      margin-top: 0.2rem;
      opacity: 0.85;
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
      line-height: 1.85;
      margin-bottom: 1.25rem;
    }

    .cp-about-text strong {
      color: var(--navy);
      font-weight: 600;
    }

    .cp-about-more {
      display: none;
    }

    .cp-rm-btn {
      background: var(--navy);
      color: #fff;
      padding: 0.75rem 2rem;
      border-radius: 4px;
      border: none;
      cursor: pointer;
      font-family: 'Source Sans 3', sans-serif;
      font-weight: 600;
      font-size: 0.9rem;
      margin-top: 0.75rem;
      transition: background 0.2s;
    }

    .cp-rm-btn:hover {
      background: #0A1830;
    }

    /* IMPACT */
    .cp-impact {
      background: var(--navy);
      padding: 5rem 3rem;
    }

    .cp-impact-inner {
      max-width: 1200px;
      margin: 0 auto;
    }

    .cp-impact-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 8px;
      overflow: hidden;
      margin-top: 3rem;
    }

    .cp-impact-item {
      padding: 2.5rem 2rem;
      border-right: 1px solid rgba(255, 255, 255, 0.1);
      text-align: center;
      transition: background 0.3s;
    }

    .cp-impact-item:last-child {
      border-right: none;
    }

    .cp-impact-item:hover {
      background: rgba(255, 255, 255, 0.04);
    }

    .cp-impact-num {
      font-family: 'Playfair Display', serif;
      font-size: 3rem;
      font-weight: 700;
      color: var(--gold-light);
      line-height: 1;
      margin-bottom: 0.5rem;
    }

    .cp-impact-lbl {
      font-size: 0.85rem;
      color: rgba(255, 255, 255, 0.55);
      line-height: 1.5;
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
      gap: 4rem;
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
      font-size: 0.72rem;
      color: var(--gold);
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      margin-bottom: 0.3rem;
    }

    .cp-hne-lnk {
      font-size: 0.9rem;
      font-weight: 500;
      color: var(--text);
      text-decoration: none;
      line-height: 1.5;
      transition: color 0.2s;
      display: block;
    }

    .cp-hne-lnk:hover {
      color: var(--gold);
    }

    .cp-hne-more {
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      margin-top: 1.25rem;
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--gold);
      text-decoration: none;
      transition: gap 0.2s;
    }

    .cp-hne-more:hover {
      gap: 0.6rem;
    }

    /* MISSION/VISION */
    .cp-mv {
      background: var(--gold-pale);
      border-top: 1px solid rgba(200, 145, 10, 0.15);
      padding: 6rem 3rem;
    }

    .cp-mv-inner {
      max-width: 1100px;
      margin: 0 auto;
    }

    .cp-mv h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.4rem;
      font-weight: 700;
      color: var(--navy);
      text-align: center;
      margin-bottom: 0.75rem;
    }

    .cp-mv-sub {
      text-align: center;
      color: var(--text-mid);
      max-width: 520px;
      margin: 0 auto 3rem;
      font-size: 0.95rem;
      line-height: 1.7;
    }

    .cp-mv-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
    }

    .cp-mv-box {
      background: var(--white);
      border-radius: 8px;
      padding: 2.75rem;
      box-shadow: 0 2px 20px rgba(13, 30, 61, 0.07);
      border-top: 4px solid var(--gold);
    }

    .cp-mv-ico {
      font-size: 2rem;
      margin-bottom: 1rem;
      display: block;
    }

    .cp-mv-box h3 {
      font-family: 'Playfair Display', serif;
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--gold);
      margin-bottom: 1rem;
      text-transform: uppercase;
      letter-spacing: 0.06em;
    }

    .cp-mv-box p {
      font-size: 0.9rem;
      color: var(--text-mid);
      line-height: 1.8;
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
      font-size: 0.95rem;
    }

    .cp-values-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
    }

    .cp-vcard {
      padding: 2rem;
      border: 1px solid var(--rule);
      border-radius: 8px;
      position: relative;
      overflow: hidden;
      transition: box-shadow 0.3s, border-color 0.3s, transform 0.3s;
    }

    .cp-vcard:hover {
      box-shadow: 0 8px 32px rgba(13, 30, 61, 0.1);
      border-color: var(--gold);
      transform: translateY(-3px);
    }

    .cp-vcard-num {
      position: absolute;
      top: 1rem;
      right: 1.25rem;
      font-family: 'Playfair Display', serif;
      font-size: 2.5rem;
      font-weight: 700;
      color: rgba(13, 30, 61, 0.05);
      line-height: 1;
    }

    .cp-vcard h4 {
      font-family: 'Playfair Display', serif;
      font-size: 1rem;
      font-weight: 700;
      color: var(--navy);
      margin-bottom: 0.75rem;
    }

    .cp-vcard p {
      font-size: 0.875rem;
      color: var(--text-mid);
      line-height: 1.7;
    }

    /* CTA */
    .cp-cta {
      background: var(--navy);
      padding: 5rem 3rem;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .cp-cta::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse 70% 70% at 50% 110%, rgba(200, 145, 10, 0.12) 0%, transparent 70%);
      pointer-events: none;
    }

    .cp-cta-eyebrow {
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: var(--gold-light);
      margin-bottom: 1rem;
      position: relative;
      z-index: 1;
    }

    .cp-cta h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.8rem;
      font-weight: 700;
      color: #fff;
      margin-bottom: 1rem;
      line-height: 1.2;
      position: relative;
      z-index: 1;
    }

    .cp-cta p {
      color: rgba(255, 255, 255, 0.58);
      max-width: 500px;
      margin: 0 auto 2.5rem;
      line-height: 1.75;
      position: relative;
      z-index: 1;
      font-size: 0.975rem;
    }

    .cp-cta-btns {
      display: flex;
      gap: 1rem;
      justify-content: center;
      position: relative;
      z-index: 1;
    }

    /* Credit */
    .gw-credit {
      margin-top: 1.5rem;
      padding: 1rem 1.25rem;
      background: rgba(200, 145, 10, 0.08);
      border: 1px solid rgba(200, 145, 10, 0.25);
      border-radius: 10px;
    }

    .gw-credit-label {
      font-size: 0.8rem;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: #E8A020;
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
      color: #E8A020;
    }

    /* Responsive */
    @media (max-width:1024px) {
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

      .cp-identity-inner {
        grid-template-columns: 1fr;
      }

      .cp-identity-divider {
        display: none;
      }

      .cp-identity-col {
        padding: 1.5rem 0;
        border-bottom: 1px solid var(--rule);
      }

      .cp-identity-col:last-child {
        border-bottom: none;
      }

      .cp-aud-grid {
        grid-template-columns: 1fr 1fr;
      }

      .cp-pillars-grid {
        grid-template-columns: 1fr 1fr;
      }

      .cp-pillar {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      }

      .cp-about-inner {
        grid-template-columns: 1fr;
        gap: 3rem;
      }

      .cp-about-stat {
        position: static;
        display: inline-block;
        margin-top: 1rem;
      }

      .cp-impact-grid {
        grid-template-columns: 1fr 1fr;
      }

      .cp-impact-item {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      }

      .cp-hne-inner {
        grid-template-columns: 1fr;
        gap: 3rem;
      }

      .cp-mv-grid {
        grid-template-columns: 1fr;
      }

      .cp-values-grid {
        grid-template-columns: 1fr 1fr;
      }

      .cp-sec-head {
        flex-direction: column;
        align-items: flex-start;
      }

      .cp-sec-head>p {
        text-align: left;
        max-width: 100%;
      }

      .cp-pillars-hdr {
        flex-direction: column;
        gap: 1rem;
      }

      .cp-pillars-hdr>p {
        text-align: left;
      }
    }

    @media (max-width:640px) {

      .cp-aud-grid,
      .cp-values-grid {
        grid-template-columns: 1fr;
      }

      .cp-stats {
        flex-wrap: wrap;
        gap: 1.5rem;
      }

      .cp-audience,
      .cp-pillars,
      .cp-ss,
      .cp-about,
      .cp-hne,
      .cp-mv,
      .cp-values,
      .cp-cta {
        padding: 3.5rem 1.5rem;
      }
    }
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
    <div class="mb-hamburger" id="mbHamburger"><span></span><span></span><span></span></div>
  </nav>
  <!-- ════ END HEADER ════ -->

  <!-- HERO -->
  <section class="cp-hero">
    <div class="cp-hero-left">
      <div class="cp-kicker">
        <div class="cp-kicker-line"></div>
        <span>East Africa's Road Safety &amp; Logistics Authority</span>
      </div>
      <h1 class="cp-headline">
        Safer roads.<br>Smarter logistics.<br><em>Stronger communities.</em>
      </h1>
      <p class="cp-sub">
        For over two decades, Mfano Bora Africa Limited has led the charge on road safety education,
        professional driver training, logistics consulting, and youth skills development —
        building a Kenya where every road user is informed, every driver is skilled,
        and every organisation operates safely.
      </p>
      <div class="cp-actions">
        <a href="https://www.mfanoboraafrica.com/transport_awards/" class="cp-btn">Explore Our Work</a>
        <a href="https://www.mfanoboraafrica.com/contact-us/" class="cp-btn-out">Get in Touch</a>
      </div>
      <div class="cp-stats">
        <div class="cp-stat">
          <div class="num">24+</div>
          <div class="lbl">Years driving<br>change in East Africa</div>
        </div>
        <div class="cp-stat">
          <div class="num">500+</div>
          <div class="lbl">Road Safety Clubs<br>across Kenya</div>
        </div>
        <div class="cp-stat">
          <div class="num">75%</div>
          <div class="lbl">Attachment graduates<br>placed in employment</div>
        </div>
      </div>
    </div>
    <div class="cp-hero-right">
      <div class="cp-hero-right-lbl">Our Core Services</div>
      <div class="cp-svc-cards">
        <a href="https://www.mfanoboraafrica.com/transport_awards/" class="cp-svc-card">
          <div class="cp-svc-card-ico">🏆</div>
          <div class="cp-svc-card-txt">
            <h4>EA Transport &amp; Logistics Awards</h4>
            <p>24 years recognising East Africa's finest in transport</p>
          </div>
          <span class="cp-svc-card-arrow">→</span>
        </a>
        <a href="https://www.mfanoboraafrica.com/attachment/" class="cp-svc-card">
          <div class="cp-svc-card-ico">🎓</div>
          <div class="cp-svc-card-txt">
            <h4>Industrial Attachment Programmes</h4>
            <p>ICT, logistics, finance, journalism &amp; more — apply online</p>
          </div>
          <span class="cp-svc-card-arrow">→</span>
        </a>
        <a href="https://www.mfanoboraafrica.com/road-safety-club/" class="cp-svc-card">
          <div class="cp-svc-card-ico">🛡️</div>
          <div class="cp-svc-card-txt">
            <h4>Road Safety Club Kenya</h4>
            <p>500+ clubs — nationwide school &amp; community campaigns</p>
          </div>
          <span class="cp-svc-card-arrow">→</span>
        </a>
        <a href="https://www.mfanoboraafrica.com/smart-driver-club/" class="cp-svc-card">
          <div class="cp-svc-card-ico">🚗</div>
          <div class="cp-svc-card-txt">
            <h4>Smart Drivers Club</h4>
            <p>Skills, PA cover awareness &amp; responsible road behaviour</p>
          </div>
          <span class="cp-svc-card-arrow">→</span>
        </a>
      </div>
    </div>
  </section>

  <!-- MARQUEE -->
  <div class="cp-marquee">
    <div class="cp-marquee-inner">
      <span class="cp-marquee-item">EA Transport Awards <span class="cp-marquee-sep">✦</span></span>
      <span class="cp-marquee-item">500+ Road Safety Clubs in Kenya <span class="cp-marquee-sep">✦</span></span>
      <span class="cp-marquee-item">Industrial Attachment — Apply Now <span class="cp-marquee-sep">✦</span></span>
      <span class="cp-marquee-item">Smart Drivers Club <span class="cp-marquee-sep">✦</span></span>
      <span class="cp-marquee-item">75% Attachment Employment Rate <span class="cp-marquee-sep">✦</span></span>
      <span class="cp-marquee-item">24 Years of Excellence <span class="cp-marquee-sep">✦</span></span>
      <span class="cp-marquee-item">EA Transport Awards <span class="cp-marquee-sep">✦</span></span>
      <span class="cp-marquee-item">500+ Road Safety Clubs in Kenya <span class="cp-marquee-sep">✦</span></span>
      <span class="cp-marquee-item">Industrial Attachment — Apply Now <span class="cp-marquee-sep">✦</span></span>
      <span class="cp-marquee-item">Smart Drivers Club <span class="cp-marquee-sep">✦</span></span>
      <span class="cp-marquee-item">75% Attachment Employment Rate <span class="cp-marquee-sep">✦</span></span>
      <span class="cp-marquee-item">24 Years of Excellence <span class="cp-marquee-sep">✦</span></span>
    </div>
  </div>

  <!-- IDENTITY BAND -->
  <div class="cp-identity">
    <div class="cp-identity-inner">
      <div class="cp-identity-col">
        <div class="cp-identity-num">24</div>
        <h3>Years of Consistent Impact</h3>
        <p>Since its founding, Mfano Bora Africa has grown from a logistics consultancy into East Africa's most
          recognisable name in transport safety, skills development, and industry recognition — without ever losing
          sight of its founding mission.</p>
      </div>
      <div class="cp-identity-divider"></div>
      <div class="cp-identity-col">
        <div class="cp-identity-num">4</div>
        <h3>Integrated Service Pillars</h3>
        <p>Our work is deliberately interconnected. Safer drivers need better training. Better training needs industry
          standards. Standards need recognition. Recognition inspires the next generation — and we provide all four,
          under one roof, in one organisation.</p>
      </div>
      <div class="cp-identity-divider"></div>
      <div class="cp-identity-col">
        <div class="cp-identity-num">1</div>
        <h3>Unwavering Core Belief</h3>
        <p>Every programme Mfano Bora Africa runs — from the EA Awards gala to a school road safety campaign in Kisumu —
          traces back to a single conviction: that human life is priceless, and that <em>road accidents are entirely
            preventable</em>.</p>
      </div>
    </div>
  </div>

  <!-- AUDIENCE -->
  <section class="cp-audience">
    <div class="cp-audience-inner">
      <div class="cp-sec-head">
        <div>
          <div class="cp-eyebrow">Find Your Path</div>
          <h2>How can Mfano Bora help you?</h2>
        </div>
        <p>Whether you're building a career, scaling a business, or strengthening your community — we have a programme
          designed for you.</p>
      </div>
      <div class="cp-aud-grid">
        <div class="cp-acard">
          <div class="cp-acard-top"><span class="cp-acard-ico">🎓</span><span class="cp-acard-tag">Students &amp;
              Graduates</span></div>
          <div class="cp-acard-body">
            <h3>Students &amp; Attachment Seekers</h3>
            <p>Gain structured, 1–3 month industrial attachment experience across 10+ departments designed to prepare
              you for the professional world.Remote options also available for students outside Nairobi.</p>
            <a href="https://www.mfanoboraafrica.com/attachment/" class="cp-acard-link">View programmes &amp; apply
              →</a>
          </div>
        </div>
        <div class="cp-acard">
          <div class="cp-acard-top"><span class="cp-acard-ico">🏢</span><span class="cp-acard-tag">Corporate &amp;
              Business</span></div>
          <div class="cp-acard-body">
            <h3>Corporate &amp; Business Partners</h3>
            <p>From fleet safety audits and logistics consulting to nominating your organisation for the EA Transport
              Awards — we work with companies across East Africa to raise standards, reduce risk, and recognise
              excellence in transport and supply chain operations.</p>
            <a href="https://www.mfanoboraafrica.com/contact-us/" class="cp-acard-link">Partner with us →</a>
          </div>
        </div>
        <div class="cp-acard">
          <div class="cp-acard-top"><span class="cp-acard-ico">🌍</span><span class="cp-acard-tag">Community &amp;
              Drivers</span></div>
          <div class="cp-acard-body">
            <h3>Community Members &amp; Drivers</h3>
            <p>Join the Smart Driver Club, participate in road safety awareness campaigns, and become part of a growing
              movement making Kenya's roads safer.</p>
            <a href="https://www.mfanoboraafrica.com/road-safety-club/" class="cp-acard-link">Join the movement →</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- PILLARS -->
  <section class="cp-pillars">
    <div class="cp-pillars-inner">
      <div class="cp-pillars-hdr">
        <div>
          <div class="cp-pillars-eyebrow">What We Do</div>
          <h2>Four disciplines.<br>One commitment.</h2>
        </div>
        <p>Every programme is designed to raise the standard of transport safety, professional capability, and economic
          opportunity in Kenya and across East Africa.</p>
      </div>
      <div class="cp-pillars-grid">
        <div class="cp-pillar">
          <span class="cp-pillar-ico">🏆</span>
          <h3>EA Transport, Logistics &amp; Road Safety Awards</h3>
          <p>For 24 years we have convened East Africa's transport sector to celebrate excellence, foster innovation,
            and inspire best practice. The Awards Gala draws nominees from across the region — private fleets, PSV
            operators, logistics firms, government agencies and road safety advocates — all judged on merit alone.</p>
          <a href="https://www.mfanoboraafrica.com/transport_awards/" class="cp-pillar-lnk">Learn more →</a>
          <div class="cp-pillar-bg">01</div>
        </div>
        <div class="cp-pillar">
          <span class="cp-pillar-ico">🎓</span>
          <h3>Industrial Attachment &amp; Skills Development</h3>
          <p>Structured 1–3 month programmes open to students in ICT, logistics, finance, journalism, actuarial science,
            project management, and 6+ other disciplines. Soft skills training is embedded in every placement — from
            communication and leadership to office ethics and interview preparation — ensuring every attachee leaves
            work-ready.</p>
          <a href="https://www.mfanoboraafrica.com/attachment/" class="cp-pillar-lnk">Apply now →</a>
          <div class="cp-pillar-bg">02</div>
        </div>
        <div class="cp-pillar">
          <span class="cp-pillar-ico">🛡️</span>
          <h3>Road Safety Club Network</h3>
          <p>With over 500 active Road Safety Clubs across Kenya, we reach students, community members, and drivers
            through school campaigns, public awareness drives, and hands-on road safety training. Our traffic marshals
            programme extends this reach to highways and congested town routes, reducing accidents where they happen
            most.</p>
          <a href="https://www.mfanoboraafrica.com/road-safety-club/" class="cp-pillar-lnk">Join a club →</a>
          <div class="cp-pillar-bg">03</div>
        </div>
        <div class="cp-pillar">
          <span class="cp-pillar-ico">🚗</span>
          <h3>Smart Drivers Club</h3>
          <p>The Smart Drivers Club addresses a critical knowledge gap in Kenya — most drivers are unaware that standard
            motor insurance does not cover their own injuries or death. We train drivers in essential road skills,
            responsible behaviour, and personal accident cover awareness, empowering them to protect themselves and
            their families.</p>
          <a href="https://www.mfanoboraafrica.com/smart-driver-club/" class="cp-pillar-lnk">Join the club →</a>
          <div class="cp-pillar-bg">04</div>
        </div>
      </div>
    </div>
  </section>

  <!-- SERVICES SLIDESHOW -->
  <section class="cp-ss">
    <div class="cp-ss-inner">
      <div class="cp-ss-hdr">
        <div>
          <div class="cp-eyebrow">Our Work in Action</div>
          <h2 class="cp-ss-title">Programmes that make<br>a real difference.</h2>
        </div>
        <p class="cp-ss-sub">Real initiatives, real people, real impact — across Kenya and East Africa.</p>
      </div>
      <div class="cp-ss-wrap" id="cpSvcWrap">
        <div class="cp-ss-track">
          <div class="cp-ss-slide">
            <div class="cp-ss-img"
              style="background-image:url('awards.jpg');background-size:cover;background-position:center;">
              <div class="cp-ss-img-lbl"><span class="cp-ss-badge">EA Transport Awards</span></div>
            </div>
            <div class="cp-ss-body">
              <div class="cp-ss-body-num">01 / 04</div>
              <h3>EA Transport, Logistics &amp; Road Safety Awards</h3>
              <p>Now in its 4th edition, the EA Transport Awards Gala is East Africa's premier recognition event for
                transport, logistics, and road safety excellence. Nominees span private fleets, PSV operators, logistics
                firms, and road safety advocates from across the region — all judged on merit, regardless of company
                size. Coming April 2026 in Nairobi.</p>
              <a href="https://www.mfanoboraafrica.com/transport_awards/" class="cp-ss-lnk">View the Awards →</a>
            </div>
          </div>
          <div class="cp-ss-slide">
            <div class="cp-ss-img"
              style="background-image:url('attachment.jpeg');background-size:cover;background-position:center;">
              <div class="cp-ss-img-lbl"><span class="cp-ss-badge">Industrial Attachment</span></div>
            </div>
            <div class="cp-ss-body">
              <div class="cp-ss-body-num">02 / 04</div>
              <h3>Industrial Attachments Kenya</h3>
              <p>Our attachment programmes go beyond task completion. Every student receives structured mentorship,
                embedded soft skills training across 19 competencies, and a recognised certificate. With a 75%
                employment rate post-attachment, our programme is one of Kenya's most impactful bridges between
                education and the workplace — with remote options for students outside Nairobi.</p>
              <a href="https://www.mfanoboraafrica.com/apply-now/" class="cp-ss-lnk">Apply Online →</a>
            </div>
          </div>
          <div class="cp-ss-slide">
            <div class="cp-ss-img"
              style="background-image:url('road_safety.png');background-size:cover;background-position:center;">
              <div class="cp-ss-img-lbl"><span class="cp-ss-badge">Road Safety Club</span></div>
            </div>
            <div class="cp-ss-body">
              <div class="cp-ss-body-num">03 / 04</div>
              <h3>Road Safety Club in Kenya</h3>
              <p>With over 500 Road Safety Clubs operating in schools, churches, companies, and community groups across
                Kenya, Mfano Bora's network is one of the largest grassroots road safety movements in the region. Clubs
                receive training materials, community campaign support, and access to our traffic marshals programme —
                putting life-saving knowledge in local hands.</p>
              <a href="https://www.mfanoboraafrica.com/road-safety-club/" class="cp-ss-lnk">Join a Club →</a>
            </div>
          </div>
          <div class="cp-ss-slide">
            <div class="cp-ss-img"
              style="background-image:url('smart_driver.png');background-size:cover;background-position:center;">
              <div class="cp-ss-img-lbl"><span class="cp-ss-badge">Smart Drivers Club</span></div>
            </div>
            <div class="cp-ss-body">
              <div class="cp-ss-body-num">04 / 04</div>
              <h3>Smart Drivers Club</h3>
              <p>Kenya's roads remain among the most dangerous in the world, yet most drivers are unaware that their
                motor insurance doesn't cover their own death or injury. The Smart Drivers Club changes that — equipping
                PSV drivers, private motorists, and fleet operators with essential driving skills, personal accident
                cover awareness, and the confidence to advocate for safer roads.</p>
              <a href="https://www.mfanoboraafrica.com/smart-driver-club/" class="cp-ss-lnk">Learn More →</a>
            </div>
          </div>
        </div>
      </div>
      <div class="cp-ss-ctrl">
        <button class="cp-ss-arr" onclick="cpSvcPrev()">&#8592;</button>
        <div class="cp-ss-dots" id="cpSvcDots">
          <button class="cp-ss-dot active" onclick="cpSvcGo(0)"></button>
          <button class="cp-ss-dot" onclick="cpSvcGo(1)"></button>
          <button class="cp-ss-dot" onclick="cpSvcGo(2)"></button>
          <button class="cp-ss-dot" onclick="cpSvcGo(3)"></button>
        </div>
        <button class="cp-ss-arr" onclick="cpSvcNext()">&#8594;</button>
      </div>
    </div>
  </section>

  <!-- ABOUT -->
  <section class="cp-about">
    <div class="cp-about-inner">
      <div class="cp-about-img">
        <img src="https://www.mfanoboraafrica.com/assets/images/our-history.png" alt="Mfano Bora Africa — Our History">
        <div class="cp-about-stat">
          <div class="big">24+</div>
          <div class="small">Years of<br>Impact</div>
        </div>
      </div>
      <div class="cp-about-text">
        <div class="cp-eyebrow">Who We Are</div>
        <h2>Built on 24 years of trust, expertise and purpose.</h2>
        <p>Mfano Bora Africa Limited is East Africa's leading logistics consulting firm and the home of the <strong>East
            Africa Transport, Logistics &amp; Road Safety Awards</strong> — a prestigious annual platform celebrating
          excellence in the transport sector for over two decades. We provide integrated supply chain management
          consulting that optimises operations by analysing, streamlining, and integrating all aspects of a supply
          chain, from planning and sourcing to distribution and customer service.</p>
        <p>But our work extends well beyond the boardroom. Through our <strong>Road Safety Education</strong> division,
          we have established more than 500 Road Safety Clubs across Kenya — in schools, colleges, churches,
          corporations and community organisations — reaching thousands of road users every year with life-saving
          information and practical training.</p>
        <div class="cp-about-more" id="cpAboutMore">
          <p>Our <strong>Industrial Attachment Programme</strong> has become one of Kenya's most respected pathways
            between academic training and professional employment. Students across 10+ disciplines — from ICT and
            logistics to journalism and actuarial science — gain not only practical experience but comprehensive soft
            skills training covering communication, leadership, time management, office ethics, and career development.
            <strong>75% of our graduates secure employment</strong> after completing their placement.
          </p>
          <p>Through the <strong>Smart Drivers Club</strong>, we address a widespread but often overlooked challenge:
            most Kenyan drivers don't realise that standard comprehensive or third-party motor insurance does not cover
            the driver's own injuries or death. We train drivers to be safer, smarter, and better protected — covering
            everything from defensive driving techniques to personal accident cover and their legal rights on the road.
          </p>
          <p>At Mfano Bora Africa, we believe that <strong>road accidents are not inevitable</strong> — they are
            preventable with the right education, the right standards, and the right people. That belief drives
            everything we do, every single day.</p>
        </div>
        <button class="cp-rm-btn" id="cpReadMore">Read More</button>
      </div>
    </div>
  </section>

  <!-- IMPACT NUMBERS -->
  <section class="cp-impact">
    <div class="cp-impact-inner">
      <div class="cp-eyebrow" style="color:var(--gold-light);margin-bottom:0.5rem;">Our Impact in Numbers</div>
      <h2 style="font-family:'Playfair Display',serif;font-size:2rem;font-weight:700;color:#fff;line-height:1.2;">A
        track record that speaks<br>for itself.</h2>
      <div class="cp-impact-grid">
        <div class="cp-impact-item">
          <div class="cp-impact-num">24+</div>
          <div class="cp-impact-lbl">Years as East Africa's Transport &amp; Logistics Awards host</div>
        </div>
        <div class="cp-impact-item">
          <div class="cp-impact-num">500+</div>
          <div class="cp-impact-lbl">Active Road Safety Clubs across Kenya</div>
        </div>
        <div class="cp-impact-item">
          <div class="cp-impact-num">75%</div>
          <div class="cp-impact-lbl">Attachment graduates who secured employment after programme</div>
        </div>
        <div class="cp-impact-item">
          <div class="cp-impact-num">10+</div>
          <div class="cp-impact-lbl">Attachment disciplines — from ICT to actuarial science</div>
        </div>
      </div>
    </div>
  </section>

  <!-- NEWS & EVENTS -->
  <section class="cp-hne">
    <div class="cp-hne-inner">
      <div class="cp-hne-col">
        <h2>Latest Notices</h2>
        <div class="cp-hne-item"><a
            href="https://www.mfanoboraafrica.com/notices/68-industrial-attachment-opportunities-may-intake-2026-"
            class="cp-hne-lnk">INDUSTRIAL ATTACHMENT OPPORTUNITIES — MAY INTAKE 2026</a></div>
        <div class="cp-hne-item"><a
            href="https://www.mfanoboraafrica.com/notices/44-industrial-attachment-opportunities-2026-intake-"
            class="cp-hne-lnk">INDUSTRIAL ATTACHMENT OPPORTUNITIES (2026 INTAKE)</a></div>
        <a href="https://www.mfanoboraafrica.com/notices/" class="cp-hne-more">More Notices →</a>
      </div>
      <div class="cp-hne-col">
        <h2>Upcoming Events</h2>
        <div class="cp-hne-item">
          <div class="cp-hne-date">April 24, 2026</div>
          <a href="https://www.mfanoboraafrica.com/events/3-4th-east-africa-transport-logistics-road-safety-awards-gala"
            class="cp-hne-lnk">4TH EAST AFRICA TRANSPORT, LOGISTICS &amp; ROAD SAFETY AWARDS GALA — Nairobi, Kenya</a>
        </div>
        <div class="cp-hne-item">
          <div class="cp-hne-date">April 30, 2026</div>
          <a href="https://www.mfanoboraafrica.com/events/2-personal-accident-cover-networking-breakfast"
            class="cp-hne-lnk">PERSONAL ACCIDENT COVER NETWORKING BREAKFAST</a>
        </div>
        <a href="https://www.mfanoboraafrica.com/events/" class="cp-hne-more">View All Events →</a>
      </div>
    </div>
  </section>

  <!-- MISSION & VISION -->
  <section class="cp-mv">
    <div class="cp-mv-inner">
      <h2>Our Mission &amp; Vision</h2>
      <p class="cp-mv-sub">Two declarations that guide every programme, partnership and decision Mfano Bora Africa makes
        — from an awards gala to a school road safety campaign.</p>
      <div class="cp-mv-grid">
        <div class="cp-mv-box">
          <span class="cp-mv-ico">🎯</span>
          <h3>Our Mission</h3>
          <p>To relentlessly focus on helping our partners succeed by serving their logistics needs through unparalleled
            expertise, technological agility, and continuous innovation — while simultaneously building a culture of
            road safety awareness that saves lives across East Africa.</p>
        </div>
        <div class="cp-mv-box">
          <span class="cp-mv-ico">🌍</span>
          <h3>Our Vision</h3>
          <p>To be the leading logistics consultant in Africa — recognised for excellence, innovation, and commitment to
            safety and sustainability — while working to meet and exceed customer expectations through reliable,
            accurate consultancy services that build lasting trust across the continent.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- VALUES -->
  <section class="cp-values">
    <div class="cp-values-inner">
      <h2>Our Core Values</h2>
      <p class="cp-values-sub">Six principles that are not aspirational statements — they are operational commitments
        that shape every action we take at Mfano Bora Africa.</p>
      <div class="cp-values-grid">
        <div class="cp-vcard">
          <div class="cp-vcard-num">01</div>
          <h4>Preservation of Human Life</h4>
          <p>Human life is our highest priority. Every road safety club established, every driver trained, every award
            presented is ultimately in service of this single principle: no life should be lost on a road unnecessarily.
          </p>
        </div>
        <div class="cp-vcard">
          <div class="cp-vcard-num">02</div>
          <h4>Whole Community Participation</h4>
          <p>Road safety and skills development are community challenges requiring community solutions. We actively
            involve individuals, families, schools, organisations, and authorities — because lasting change is never
            top-down alone.</p>
        </div>
        <div class="cp-vcard">
          <div class="cp-vcard-num">03</div>
          <h4>Partnership</h4>
          <p>We build mutually beneficial relationships with government, the private sector, and civil society — sharing
            resources, expertise, and accountability to achieve outcomes none of us could reach alone.</p>
        </div>
        <div class="cp-vcard">
          <div class="cp-vcard-num">04</div>
          <h4>Capacity Development</h4>
          <p>From attachment students learning office ethics to PSV drivers understanding personal accident cover — we
            are in the business of equipping people with knowledge and skills that make them safer, more productive, and
            more resilient.</p>
        </div>
        <div class="cp-vcard">
          <div class="cp-vcard-num">05</div>
          <h4>Sustainability &amp; Socio-Economic Development</h4>
          <p>Our programmes are designed for long-term impact. Better-trained professionals drive better business
            outcomes. Safer roads reduce economic losses from accidents. Every programme contributes to a stronger, more
            sustainable Kenya.</p>
        </div>
        <div class="cp-vcard">
          <div class="cp-vcard-num">06</div>
          <h4>Road Accidents Are Avoidable</h4>
          <p>This is the founding conviction of Mfano Bora Africa. With proper education, consistent enforcement, and
            infrastructure investment, every road accident can be prevented. We exist to make that belief a reality.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cp-cta">
    <div class="cp-cta-eyebrow">Take the Next Step</div>
    <h2>Ready to work with us?</h2>
    <p>Whether you're a student seeking your first professional opportunity, a business looking to improve fleet safety,
      or a community leader ready to start a Road Safety Club — Mfano Bora Africa is ready to partner with you.</p>
    <div class="cp-cta-btns">
      <a href="https://www.mfanoboraafrica.com/contact-us/" class="cp-btn">Get in Touch</a>
      <a href="https://www.mfanoboraafrica.com/apply-now/" class="cp-btn-out">Apply for Attachment</a>
    </div>
  </section>

  <!-- ════ MFANO BORA OFFICIAL FOOTER ════ -->
  <footer class="mb-footer">
    <div class="mb-footer-top">
      <div class="mb-footer-brand">
        <img src="logo.png" alt="Mfano Bora Africa">
        <p>Mfano Bora Africa – Setting the standard in transportation and logistics across Africa.</p>
        <div class="mb-social">
          <a href="https://www.facebook.com/share/g/1DDgDpbHVA/" title="Facebook" target="_blank"><img
              src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/facebook.svg" alt="Facebook"></a>
          <a href="https://www.tiktok.com/@mfanobo" title="TikTok" target="_blank"><img
              src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/tiktok.svg" alt="TikTok"></a>
          <a href="https://www.instagram.com/mfano_bora_africa" title="Instagram" target="_blank"><img
              src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/instagram.svg" alt="Instagram"></a>
          <a href="https://www.linkedin.com/company/107007801/" title="LinkedIn" target="_blank"><img
              src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/linkedin.svg" alt="LinkedIn"></a>
          <a href="https://x.com/LtdMfano" title="Twitter/X" target="_blank"><img
              src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/twitter.svg" alt="Twitter"></a>
        </div>
      </div>
      <div class="mb-footer-col">
        <h4>Newsletter</h4>
        <p style="font-size:0.82rem;color:rgba(255,255,255,0.5);margin-bottom:0.5rem;">Stay updated on our latest news,
          offers, and events.</p>
        <div class="mb-newsletter-form"><input type="email" placeholder="Your email address"><button
            type="button">Subscribe</button></div>
      </div>
      <div class="mb-footer-col">
        <h4>Operating Hours</h4>
        <ul class="mb-hours">
          <li>Mon – Fri: 7:00 AM – 5:00 PM</li>
          <li>Saturday: 8:00 AM – 1:00 PM</li>
          <li>Sunday: Closed</li>
        </ul>
        <div class="gw-credit">
          <div class="gw-credit-label">Redesign by</div>
          <div class="gw-credit-name">Gilbert Williams Nyange</div>
          <div class="gw-credit-links">
            <a href="mailto:gilbertwilliamsnyange@gmail.com"><span>✉</span> gilbertwilliamsnyange@gmail.com</a>
            <a href="tel:+254719737274"><span>📞</span> +254 719 737 274/+254 714 591 285 </a></a>
            <a href="https://www.linkedin.com/in/gilbertwilliamsnyange" target="_blank"><span>🔗</span> Gilbert's
              LinkedIn</a>
            <a href="https://github.com/Gilb3rtWilliams" target="_blank"><span>🐙</span> Gilb3rtWilliams</a>
          </div>
        </div>
      </div>
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
      <div class="mb-footer-col">
        <h4>Contact Info</h4>
        <div class="mb-footer-contact">
          <div class="mb-footer-contact-item"><span class="icon">📍</span><span>Mfano House, Ole Sein Rd, Nairobi,
              Kenya</span></div>
          <div class="mb-footer-contact-item"><span class="icon">✉️</span><a href="mailto:info@mfanoboraafrica.com"
              style="color:rgba(255,255,255,0.6);text-decoration:none;">info@mfanoboraafrica.com</a></div>
          <div class="mb-footer-contact-item"><span class="icon">🕐</span><span>Mon–Fri: 8:00 AM – 5:00 PM</span></div>
        </div>
      </div>
    </div>
    <div class="mb-footer-bottom">
      <span>© 2026 Mfano Bora Africa. All Rights Reserved.</span>
      <span><a href="https://www.mfanoboraafrica.com/privacy-policy/">Privacy Policy</a> &nbsp;|&nbsp; <a
          href="https://www.mfanoboraafrica.com/disclaimer/">Disclaimer</a></span>
    </div>
  </footer>
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
          <div class="gw-ack-role">Attachment Student · Mfano Bora Africa Ltd · Homepage Redesign Proposal</div>
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
    var cpSvcCur = 0, cpSvcTotal = 4, cpSvcTimer;
    function cpSvcRender() {
      var w = document.getElementById('cpSvcWrap');
      w.scrollLeft = cpSvcCur * w.offsetWidth;
      document.querySelectorAll('#cpSvcDots .cp-ss-dot').forEach(function (d, i) { d.classList.toggle('active', i === cpSvcCur); });
    }
    function cpSvcGo(n) { cpSvcCur = (n + cpSvcTotal) % cpSvcTotal; cpSvcRender(); clearInterval(cpSvcTimer); cpSvcTimer = setInterval(cpSvcNext, 5500); }
    function cpSvcNext() { cpSvcGo(cpSvcCur + 1); }
    function cpSvcPrev() { cpSvcGo(cpSvcCur - 1); }
    cpSvcTimer = setInterval(cpSvcNext, 5500);

    document.getElementById('cpReadMore').addEventListener('click', function () {
      var m = document.getElementById('cpAboutMore');
      var open = m.style.display === 'block';
      m.style.display = open ? 'none' : 'block';
      this.textContent = open ? 'Read More' : 'Read Less';
    });
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