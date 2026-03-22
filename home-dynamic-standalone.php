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
    href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Bebas+Neue&display=swap"
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


    /* ══ DYNAMIC DESIGN ══ */
    :root {
      --amber: #E8A020;
      --amber-bright: #FFB733;
      --navy: #060D1F;
      --navy-2: #0D1A35;
      --navy-3: #122040;
      --white: #FFFFFF;
      --muted: rgba(255, 255, 255, 0.5);
    }

    body {
      font-family: 'Space Grotesk', sans-serif;
      background: var(--navy);
      color: #fff;
      overflow-x: hidden;
    }

    /* HERO */
    .dn-hero {
      min-height: 90vh;
      position: relative;
      display: flex;
      align-items: center;
      padding: 6rem 3rem 4rem;
      overflow: hidden;
      background: var(--navy);
    }

    .dn-hero-grid {
      position: absolute;
      inset: 0;
      background-image: linear-gradient(rgba(232, 160, 32, 0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(232, 160, 32, 0.04) 1px, transparent 1px);
      background-size: 60px 60px;
      mask-image: radial-gradient(ellipse 80% 60% at 50% 50%, black 40%, transparent 100%);
      animation: dnGridPulse 6s ease-in-out infinite;
    }

    @keyframes dnGridPulse {

      0%,
      100% {
        opacity: .6;
      }

      50% {
        opacity: 1;
      }
    }

    .dn-hero-glow {
      position: absolute;
      top: 10%;
      left: 50%;
      transform: translateX(-50%);
      width: 800px;
      height: 500px;
      background: radial-gradient(ellipse, rgba(232, 160, 32, 0.12) 0%, transparent 70%);
      pointer-events: none;
    }

    .dn-hero-inner {
      position: relative;
      z-index: 1;
      max-width: 1300px;
      margin: 0 auto;
      width: 100%;
      display: grid;
      grid-template-columns: 1fr 420px;
      gap: 4rem;
      align-items: center;
    }

    .dn-pretitle {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1.75rem;
    }

    .dn-pretitle-dot {
      width: 8px;
      height: 8px;
      background: var(--amber);
      border-radius: 50%;
      animation: dnBlink 2s ease-in-out infinite;
    }

    @keyframes dnBlink {

      0%,
      100% {
        opacity: 1;
      }

      50% {
        opacity: .3;
      }
    }

    .dn-pretitle-text {
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.16em;
      text-transform: uppercase;
      color: var(--amber);
    }

    .dn-hero-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: clamp(3.5rem, 7vw, 6rem);
      line-height: 0.95;
      letter-spacing: 0.02em;
      margin-bottom: 1.75rem;
      color: #fff;
    }

    .dn-hero-title .t-muted {
      color: rgba(255, 255, 255, 0.2);
    }

    .dn-hero-title .t-amber {
      color: var(--amber);
    }

    .dn-hero-desc {
      font-size: 1rem;
      line-height: 1.75;
      color: rgba(255, 255, 255, 0.6);
      max-width: 520px;
      margin-bottom: 2.5rem;
      font-weight: 300;
    }

    .dn-hero-desc strong {
      color: #fff;
      font-weight: 500;
    }

    .dn-hero-btns {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .dn-btn-amber {
      display: inline-flex;
      align-items: center;
      gap: .6rem;
      background: var(--amber);
      color: var(--navy);
      padding: .9rem 2rem;
      border-radius: 6px;
      font-weight: 700;
      font-size: .9rem;
      text-decoration: none;
      transition: background .2s, transform .2s;
    }

    .dn-btn-amber:hover {
      background: var(--amber-bright);
      transform: translateY(-2px);
    }

    .dn-btn-ghost {
      display: inline-flex;
      align-items: center;
      gap: .6rem;
      background: transparent;
      color: #fff;
      padding: .9rem 2rem;
      border-radius: 6px;
      border: 1px solid rgba(255, 255, 255, .2);
      font-weight: 500;
      font-size: .9rem;
      text-decoration: none;
      transition: border-color .2s, background .2s;
    }

    .dn-btn-ghost:hover {
      border-color: rgba(255, 255, 255, .5);
      background: rgba(255, 255, 255, .05);
    }

    .dn-hero-panel {
      background: rgba(255, 255, 255, .04);
      border: 1px solid rgba(255, 255, 255, .1);
      border-radius: 16px;
      overflow: hidden;
    }

    .dn-panel-header {
      padding: 1.1rem 1.5rem;
      border-bottom: 1px solid rgba(255, 255, 255, .08);
      display: flex;
      align-items: center;
      gap: .75rem;
    }

    .dn-panel-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: var(--amber);
    }

    .dn-panel-header span {
      font-size: .75rem;
      font-weight: 600;
      letter-spacing: .08em;
      text-transform: uppercase;
      color: var(--muted);
    }

    .dn-panel-items {
      padding: .75rem;
      display: flex;
      flex-direction: column;
      gap: .5rem;
    }

    .dn-panel-item {
      padding: .85rem 1rem;
      border-radius: 10px;
      background: rgba(255, 255, 255, .04);
      border: 1px solid rgba(255, 255, 255, .07);
      display: flex;
      align-items: center;
      gap: .85rem;
      text-decoration: none;
      transition: background .2s, border-color .2s, transform .2s;
    }

    .dn-panel-item:hover {
      background: rgba(232, 160, 32, .1);
      border-color: rgba(232, 160, 32, .3);
      transform: translateX(4px);
    }

    .dn-panel-icon {
      width: 36px;
      height: 36px;
      flex-shrink: 0;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
    }

    .dn-panel-item:nth-child(1) .dn-panel-icon {
      background: rgba(232, 160, 32, .15);
    }

    .dn-panel-item:nth-child(2) .dn-panel-icon {
      background: rgba(100, 160, 255, .15);
    }

    .dn-panel-item:nth-child(3) .dn-panel-icon {
      background: rgba(100, 220, 120, .15);
    }

    .dn-panel-item:nth-child(4) .dn-panel-icon {
      background: rgba(220, 100, 200, .15);
    }

    .dn-panel-text h4 {
      font-size: .85rem;
      font-weight: 600;
      color: #fff;
      margin-bottom: .15rem;
    }

    .dn-panel-text p {
      font-size: .75rem;
      color: var(--muted);
    }

    .dn-panel-arrow {
      margin-left: auto;
      color: rgba(255, 255, 255, .2);
      transition: color .2s;
    }

    .dn-panel-item:hover .dn-panel-arrow {
      color: var(--amber);
    }

    .dn-panel-footer {
      padding: 1rem 1.5rem;
      border-top: 1px solid rgba(255, 255, 255, .08);
      font-size: .75rem;
      color: var(--muted);
      text-align: center;
    }

    /* TICKER */
    .dn-ticker {
      background: var(--amber);
      color: var(--navy);
      padding: .75rem 0;
      overflow: hidden;
      display: flex;
    }

    .dn-ticker-inner {
      display: flex;
      white-space: nowrap;
      animation: dnTicker 25s linear infinite;
    }

    .dn-ticker-item {
      display: inline-flex;
      align-items: center;
      gap: 1rem;
      padding: 0 2rem;
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1rem;
      letter-spacing: .08em;
    }

    .dn-ticker-sep {
      opacity: .4;
    }

    @keyframes dnTicker {
      from {
        transform: translateX(0);
      }

      to {
        transform: translateX(-50%);
      }
    }

    /* AUDIENCE */
    .dn-audience {
      background: var(--navy);
      padding: 7rem 3rem;
    }

    .dn-audience-inner {
      max-width: 1300px;
      margin: 0 auto;
    }

    .dn-eyebrow {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1rem;
    }

    .dn-eyebrow-line {
      width: 32px;
      height: 2px;
      background: var(--amber);
    }

    .dn-eyebrow-text {
      font-size: .72rem;
      font-weight: 600;
      letter-spacing: .16em;
      text-transform: uppercase;
      color: var(--amber);
    }

    .dn-section-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: clamp(2.5rem, 5vw, 4rem);
      line-height: 1;
      letter-spacing: .03em;
      color: #fff;
      margin-bottom: .75rem;
    }

    .dn-section-sub {
      font-size: 1rem;
      color: var(--muted);
      line-height: 1.7;
      max-width: 480px;
      margin-bottom: 3.5rem;
      font-weight: 300;
    }

    .dn-acards {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
    }

    .dn-acard {
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, .08);
      transition: transform .3s;
    }

    .dn-acard:hover {
      transform: translateY(-8px);
    }

    .dn-acard-top {
      height: 140px;
      position: relative;
      display: flex;
      align-items: flex-end;
      padding: 1.25rem;
    }

    .dn-acard:nth-child(1) .dn-acard-top {
      background: linear-gradient(135deg, #1A2C5B, #0D1A35);
    }

    .dn-acard:nth-child(2) .dn-acard-top {
      background: linear-gradient(135deg, #3A1A05, #6B3210);
    }

    .dn-acard:nth-child(3) .dn-acard-top {
      background: linear-gradient(135deg, #0A2A1A, #0F3D25);
    }

    .dn-acard-icon {
      font-size: 3rem;
      opacity: .5;
      position: absolute;
      top: 1rem;
      right: 1.25rem;
    }

    .dn-acard-tag {
      font-size: .7rem;
      font-weight: 700;
      letter-spacing: .1em;
      text-transform: uppercase;
      padding: .3rem .75rem;
      border-radius: 4px;
      background: rgba(255, 255, 255, .15);
      color: rgba(255, 255, 255, .8);
    }

    .dn-acard-body {
      background: rgba(255, 255, 255, .04);
      padding: 1.5rem;
      border-top: 1px solid rgba(255, 255, 255, .06);
    }

    .dn-acard-body h3 {
      font-weight: 600;
      font-size: 1rem;
      color: #fff;
      margin-bottom: .75rem;
    }

    .dn-acard-body p {
      font-size: .875rem;
      color: var(--muted);
      line-height: 1.7;
      margin-bottom: 1.25rem;
    }

    .dn-acard-link {
      display: inline-flex;
      align-items: center;
      gap: .4rem;
      font-size: .8rem;
      font-weight: 600;
      color: var(--amber);
      text-decoration: none;
      transition: gap .2s;
    }

    .dn-acard-link:hover {
      gap: .7rem;
    }

    /* SERVICES SLIDESHOW */
    .dn-services {
      padding: 7rem 3rem;
      background: var(--navy-3);
      border-top: 1px solid rgba(255, 255, 255, .05);
    }

    .dn-services-inner {
      max-width: 1300px;
      margin: 0 auto;
    }

    .dn-svc-wrap {
      overflow-x: hidden;
      border-radius: 16px;
      border: 1px solid rgba(255, 255, 255, .08);
      margin-top: 2.5rem;
    }

    .dn-svc-track {
      display: flex;
    }

    .dn-svc-slide {
      flex: 0 0 100%;
      min-width: 0;
      display: flex;
      flex-direction: row;
      min-height: 440px;
    }

    .dn-svc-img {
      flex: 3;
      position: relative;
      min-height: 440px;
      background-size: cover;
      background-position: center;
    }

    .dn-svc-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to right, rgba(6, 13, 31, .1), rgba(6, 13, 31, .55));
    }

    .dn-svc-img-content {
      position: absolute;
      bottom: 2rem;
      left: 2rem;
    }

    .dn-svc-badge {
      display: inline-block;
      background: var(--amber);
      color: var(--navy);
      padding: .3rem .85rem;
      border-radius: 4px;
      font-size: .72rem;
      font-weight: 700;
      letter-spacing: .08em;
      text-transform: uppercase;
      margin-bottom: .75rem;
    }

    .dn-svc-img-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 2.4rem;
      line-height: 1;
      letter-spacing: .03em;
      color: #fff;
      text-shadow: 0 2px 12px rgba(0, 0, 0, .5);
    }

    .dn-svc-body {
      flex: 2;
      background: rgba(255, 255, 255, .04);
      border-left: 1px solid rgba(255, 255, 255, .08);
      padding: 3rem 2.5rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      gap: 1rem;
    }

    .dn-svc-counter {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 2.5rem;
      color: var(--amber);
      line-height: 1;
    }

    .dn-svc-counter span {
      color: rgba(255, 255, 255, .2);
      font-size: 1.5rem;
    }

    .dn-svc-text {
      font-size: .9rem;
      color: rgba(255, 255, 255, .6);
      line-height: 1.8;
      font-weight: 300;
    }

    .dn-svc-link {
      display: inline-flex;
      align-items: center;
      gap: .4rem;
      font-size: .85rem;
      font-weight: 600;
      color: var(--amber);
      text-decoration: none;
      transition: gap .2s;
      width: fit-content;
      margin-top: .5rem;
    }

    .dn-svc-link:hover {
      gap: .7rem;
    }

    .dn-svc-progress {
      height: 2px;
      background: rgba(255, 255, 255, .08);
      margin-top: 1.25rem;
      border-radius: 2px;
      overflow: hidden;
    }

    .dn-svc-progress-bar {
      height: 100%;
      background: var(--amber);
      width: 25%;
      border-radius: 2px;
      transition: width .4s ease;
    }

    .dn-svc-controls {
      display: flex;
      align-items: center;
      justify-content: flex-end;
      gap: 1rem;
      margin-top: 1rem;
    }

    .dn-svc-arr {
      background: rgba(255, 255, 255, .06);
      border: 1px solid rgba(255, 255, 255, .12);
      color: #fff;
      width: 42px;
      height: 42px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 1rem;
      transition: background .2s;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .dn-svc-arr:hover {
      background: var(--amber);
      border-color: var(--amber);
      color: var(--navy);
    }

    .dn-svc-dots {
      display: flex;
      gap: .4rem;
      align-items: center;
    }

    .dn-svc-dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .2);
      border: none;
      cursor: pointer;
      transition: background .2s, transform .2s;
      padding: 0;
    }

    .dn-svc-dot.active {
      background: var(--amber);
      transform: scale(1.4);
    }

    /* ABOUT */
    .dn-about {
      background: var(--navy-2);
      padding: 7rem 3rem;
      border-top: 1px solid rgba(255, 255, 255, .05);
    }

    .dn-about-inner {
      max-width: 1300px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 4rem;
      align-items: center;
    }

    .dn-about-img img {
      width: 100%;
      border-radius: 16px;
      border: 1px solid rgba(255, 255, 255, .1);
    }

    .dn-about-text p {
      font-size: .95rem;
      color: rgba(255, 255, 255, .65);
      line-height: 1.8;
      margin-bottom: 1.25rem;
      font-weight: 300;
    }

    .dn-about-text strong {
      color: #fff;
      font-weight: 600;
    }

    .dn-about-more {
      display: none;
    }

    .dn-read-more-btn {
      background: var(--amber);
      color: var(--navy);
      padding: .75rem 2rem;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      font-family: 'Space Grotesk', sans-serif;
      font-weight: 700;
      font-size: .9rem;
      margin-top: .5rem;
      transition: background .2s;
    }

    .dn-read-more-btn:hover {
      background: var(--amber-bright);
    }

    /* NEWS & EVENTS */
    .dn-hne-outer {
      background: var(--navy);
      padding: 7rem 3rem;
      border-top: 1px solid rgba(255, 255, 255, .05);
    }

    .dn-hne {
      max-width: 1300px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 3rem;
    }

    .dn-hne-col h2 {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.8rem;
      letter-spacing: .04em;
      color: #fff;
      margin-bottom: 1.5rem;
      padding-bottom: .75rem;
      border-bottom: 2px solid var(--amber);
      display: inline-block;
    }

    .dn-hne-item {
      padding: 1rem 0;
      border-bottom: 1px solid rgba(255, 255, 255, .07);
    }

    .dn-hne-date {
      font-size: .72rem;
      color: var(--amber);
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .08em;
      margin-bottom: .3rem;
    }

    .dn-hne-link {
      font-size: .9rem;
      font-weight: 500;
      color: rgba(255, 255, 255, .75);
      text-decoration: none;
      line-height: 1.5;
      transition: color .2s;
    }

    .dn-hne-link:hover {
      color: var(--amber);
    }

    .dn-hne-more {
      display: inline-block;
      margin-top: 1.25rem;
      font-size: .85rem;
      font-weight: 700;
      color: var(--amber);
      text-decoration: none;
    }

    /* MISSION/VISION */
    .dn-mv {
      background: var(--navy-3);
      padding: 7rem 3rem;
      text-align: center;
      border-top: 1px solid rgba(255, 255, 255, .05);
    }

    .dn-mv-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: clamp(2.5rem, 5vw, 4rem);
      color: #fff;
      margin-bottom: 3rem;
      letter-spacing: .03em;
    }

    .dn-mv-title span {
      color: var(--amber);
    }

    .dn-mv-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
      max-width: 900px;
      margin: 0 auto;
    }

    .dn-mv-box {
      background: rgba(255, 255, 255, .04);
      border: 1px solid rgba(255, 255, 255, .08);
      border-radius: 16px;
      padding: 2.5rem;
      text-align: left;
    }

    .dn-mv-box h3 {
      font-size: 1rem;
      font-weight: 700;
      color: var(--amber);
      margin-bottom: 1rem;
      text-transform: uppercase;
      letter-spacing: .08em;
    }

    .dn-mv-box p {
      font-size: .9rem;
      color: rgba(255, 255, 255, .6);
      line-height: 1.75;
    }

    /* VALUES */
    .dn-values {
      background: var(--navy-2);
      padding: 7rem 3rem;
      border-top: 1px solid rgba(255, 255, 255, .05);
    }

    .dn-values-inner {
      max-width: 1300px;
      margin: 0 auto;
    }

    .dn-values-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
      margin-top: 3.5rem;
    }

    .dn-value-item {
      padding: 2.5rem;
      border-radius: 16px;
      background: rgba(255, 255, 255, .03);
      border: 1px solid rgba(255, 255, 255, .07);
      position: relative;
      overflow: hidden;
      transition: border-color .3s, background .3s;
    }

    .dn-value-item:hover {
      border-color: rgba(232, 160, 32, .25);
      background: rgba(232, 160, 32, .04);
    }

    .dn-value-num {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 5rem;
      color: rgba(255, 255, 255, .04);
      position: absolute;
      top: 1rem;
      right: 1.5rem;
      line-height: 1;
    }

    .dn-value-item h4 {
      font-weight: 600;
      font-size: 1rem;
      color: #fff;
      margin-bottom: .75rem;
    }

    .dn-value-item p {
      font-size: .875rem;
      color: rgba(255, 255, 255, .55);
      line-height: 1.7;
    }

    /* CTA */
    .dn-cta {
      padding: 7rem 3rem;
      text-align: center;
      background: var(--navy);
      position: relative;
      overflow: hidden;
    }

    .dn-cta::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse 70% 70% at 50% 100%, rgba(232, 160, 32, .1) 0%, transparent 70%);
      pointer-events: none;
    }

    .dn-cta-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: clamp(3rem, 6vw, 5.5rem);
      color: #fff;
      margin-bottom: 1.5rem;
      line-height: 1;
      position: relative;
      z-index: 1;
    }

    .dn-cta-title .amber {
      color: var(--amber);
    }

    .dn-cta-title .muted {
      color: rgba(255, 255, 255, .2);
    }

    .dn-cta-sub {
      font-size: 1rem;
      color: var(--muted);
      max-width: 480px;
      margin: 0 auto 2.5rem;
      line-height: 1.7;
      font-weight: 300;
      position: relative;
      z-index: 1;
    }

    .dn-cta-btns {
      display: flex;
      gap: 1rem;
      justify-content: center;
      position: relative;
      z-index: 1;
    }

    @media (max-width:1024px) {
      .dn-hero-inner {
        grid-template-columns: 1fr;
      }

      .dn-hero-panel {
        margin-top: 2rem;
      }

      .dn-acards {
        grid-template-columns: 1fr;
      }

      .dn-about-inner {
        grid-template-columns: 1fr;
      }

      .dn-hne {
        grid-template-columns: 1fr;
      }

      .dn-mv-grid {
        grid-template-columns: 1fr;
      }

      .dn-values-grid {
        grid-template-columns: 1fr 1fr;
      }
    }

    @media (max-width:600px) {
      .dn-values-grid {
        grid-template-columns: 1fr;
      }

      .dn-hero,
      .dn-audience,
      .dn-services,
      .dn-about,
      .dn-hne-outer,
      .dn-mv,
      .dn-values,
      .dn-cta {
        padding: 4rem 1.5rem;
      }
    }

    /* ════ GILBERT ACKNOWLEDGEMENT ════ */
    .mb-credit {
  margin-top: 1.5rem;
  padding: 1rem 1.25rem;
  background: rgba(232,160,32,0.08);
  border: 1px solid rgba(232,160,32,0.25);
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
  color: rgba(255,255,255,0.55);
  text-decoration: none;
  transition: color 0.2s;
}
.mb-credit-links a:hover { color: #E8A020; }
.mb-credit-links a span { font-size: 0.8rem; }


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
  <section class="dn-hero">
    <div class="dn-hero-grid"></div>
    <div class="dn-hero-glow"></div>
    <div class="dn-hero-inner">
      <div>
        <div class="dn-pretitle">
          <div class="dn-pretitle-dot"></div><span class="dn-pretitle-text">Changing Kenya. One road at a time.</span>
        </div>
        <h1 class="dn-hero-title">
          <div>SAFER</div>
          <div class="t-muted">ROADS,</div>
          <div class="t-amber">STRONGER</div>
          <div>COMMUNITIES.</div>
        </h1>
        <p class="dn-hero-desc">Mfano Bora Africa brings together <strong>road safety education</strong>, professional
          driver training, logistics consulting, and skills development — united by one purpose: raising the standard of
          life in Kenya.</p>
        <div class="dn-hero-btns">
          <a href="https://www.mfanoboraafrica.com/about/" class="dn-btn-amber">Explore Our Work →</a>
          <a href="https://www.mfanoboraafrica.com/contact-us/" class="dn-btn-ghost">Get in Touch</a>
        </div>
      </div>
      <div>
        <div class="dn-hero-panel">
          <div class="dn-panel-header">
            <div class="dn-panel-dot"></div><span>Our Core Services</span>
          </div>
          <div class="dn-panel-items">
            <a href="https://www.mfanoboraafrica.com/transport_awards/" class="dn-panel-item">
              <div class="dn-panel-icon">🏆</div>
              <div class="dn-panel-text">
                <h4>EA Transport Awards</h4>
                <p>Excellence in East Africa transport</p>
              </div><span class="dn-panel-arrow">→</span>
            </a>
            <a href="https://www.mfanoboraafrica.com/attachment/" class="dn-panel-item">
              <div class="dn-panel-icon">🎓</div>
              <div class="dn-panel-text">
                <h4>Industrial Attachments</h4>
                <p>ICT, logistics &amp; admin programmes</p>
              </div><span class="dn-panel-arrow">→</span>
            </a>
            <a href="https://www.mfanoboraafrica.com/road-safety-club/" class="dn-panel-item">
              <div class="dn-panel-icon">🛡️</div>
              <div class="dn-panel-text">
                <h4>Road Safety Club</h4>
                <p>Nationwide awareness campaigns</p>
              </div><span class="dn-panel-arrow">→</span>
            </a>
            <a href="https://www.mfanoboraafrica.com/smart-driver-club/" class="dn-panel-item">
              <div class="dn-panel-icon">🚗</div>
              <div class="dn-panel-text">
                <h4>Smart Drivers Club</h4>
                <p>Skills, safety &amp; responsible driving</p>
              </div><span class="dn-panel-arrow">→</span>
            </a>
          </div>
          <div class="dn-panel-footer">Select a service to learn more</div>
        </div>
      </div>
    </div>
  </section>

  <!-- TICKER -->
  <div class="dn-ticker">
    <div class="dn-ticker-inner">
      <span class="dn-ticker-item">EA Transport Awards <span class="dn-ticker-sep">✦</span></span>
      <span class="dn-ticker-item">Industrial Attachments Kenya <span class="dn-ticker-sep">✦</span></span>
      <span class="dn-ticker-item">Road Safety Club <span class="dn-ticker-sep">✦</span></span>
      <span class="dn-ticker-item">Smart Drivers Club <span class="dn-ticker-sep">✦</span></span>
      <span class="dn-ticker-item">EA Transport Awards <span class="dn-ticker-sep">✦</span></span>
      <span class="dn-ticker-item">Industrial Attachments Kenya <span class="dn-ticker-sep">✦</span></span>
      <span class="dn-ticker-item">Road Safety Club <span class="dn-ticker-sep">✦</span></span>
      <span class="dn-ticker-item">Smart Drivers Club <span class="dn-ticker-sep">✦</span></span>
    </div>
  </div>

  <!-- AUDIENCE -->
  <section class="dn-audience">
    <div class="dn-audience-inner">
      <div class="dn-eyebrow">
        <div class="dn-eyebrow-line"></div><span class="dn-eyebrow-text">Find Your Path</span>
      </div>
      <h2 class="dn-section-title">WHO ARE YOU <span style="color:rgba(255,255,255,.2)">HERE FOR?</span></h2>
      <p class="dn-section-sub">We serve people with very different goals. Pick your path and we'll take you straight to
        what matters.</p>
      <div class="dn-acards">
        <div class="dn-acard">
          <div class="dn-acard-top"><span class="dn-acard-icon">🎓</span><span class="dn-acard-tag">Students &amp;
              Interns</span></div>
          <div class="dn-acard-body">
            <h3>Students &amp; Attachment Seekers</h3>
            <p>Structured industrial attachment programmes in ICT, logistics and administration to launch your
              professional journey.</p><a href="https://www.mfanoboraafrica.com/attachment/" class="dn-acard-link">Find
              opportunities →</a>
          </div>
        </div>
        <div class="dn-acard">
          <div class="dn-acard-top"><span class="dn-acard-icon">🏢</span><span class="dn-acard-tag">Corporate</span>
          </div>
          <div class="dn-acard-body">
            <h3>Corporate &amp; Business Partners</h3>
            <p>Fleet safety audits, logistics consulting and employee road safety training that protects your people and
              your bottom line.</p><a href="https://www.mfanoboraafrica.com/contact-us/" class="dn-acard-link">Partner
              with us →</a>
          </div>
        </div>
        <div class="dn-acard">
          <div class="dn-acard-top"><span class="dn-acard-icon">🌍</span><span class="dn-acard-tag">Community</span>
          </div>
          <div class="dn-acard-body">
            <h3>Community Members</h3>
            <p>Join the Smart Driver Club, participate in campaigns, and help build a culture of safety on Kenya's
              roads.</p><a href="https://www.mfanoboraafrica.com/road-safety-club/" class="dn-acard-link">Join the
              movement →</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SERVICES SLIDESHOW -->
  <section class="dn-services">
    <div class="dn-services-inner">
      <div class="dn-eyebrow">
        <div class="dn-eyebrow-line"></div><span class="dn-eyebrow-text">Work in Action</span>
      </div>
      <h2 class="dn-section-title">REAL WORK. <span style="color:var(--amber)">REAL IMPACT.</span></h2>
      <p class="dn-section-sub" style="margin-bottom:0;">Each service is a direct response to a real need in Kenya.</p>
      <div class="dn-svc-wrap" id="dnSvcWrap">
        <div class="dn-svc-track">
          <div class="dn-svc-slide">
            <div class="dn-svc-img"
              style="background-image:url('awards.jpg');background-size:cover;background-position:center;">
              <div class="dn-svc-overlay"></div>
              <div class="dn-svc-img-content">
                <span class="dn-svc-badge">EA Transport Awards</span>
                <h3 class="dn-svc-img-title">EA Transport, Logistics &amp; Road Safety Awards</h3>
              </div>
            </div>
            <div class="dn-svc-body">
              <div class="dn-svc-counter">01 <span>/ 04</span></div>
              <p class="dn-svc-text">Mfano Bora Africa Ltd hosts the East Africa Transport, Logistics &amp; Road Safety
                Awards, recognising excellence and innovation in the transport sector across East Africa.</p>
              <a href="https://www.mfanoboraafrica.com/transport_awards/" class="dn-svc-link">More Info →</a>
            </div>
          </div>
          <div class="dn-svc-slide">
            <div class="dn-svc-img"
              style="background-image:url('attachment.jpeg');background-size:cover;background-position:center;">
              <div class="dn-svc-overlay"></div>
              <div class="dn-svc-img-content">
                <span class="dn-svc-badge">Industrial Attachment</span>
                <h3 class="dn-svc-img-title">Industrial Attachments Kenya</h3>
              </div>
            </div>
            <div class="dn-svc-body">
              <div class="dn-svc-counter">02 <span>/ 04</span></div>
              <p class="dn-svc-text">Mfano Bora Africa Ltd offers well-structured and high-quality industrial attachment
                programmes for students studying ICT, logistics, administration, and related fields.</p>
              <a href="https://www.mfanoboraafrica.com/apply-now/" class="dn-svc-link">Apply Now →</a>
            </div>
          </div>
          <div class="dn-svc-slide">
            <div class="dn-svc-img"
              style="background-image:url('road_safety.png');background-size:cover;background-position:center;">
              <div class="dn-svc-overlay"></div>
              <div class="dn-svc-img-content">
                <span class="dn-svc-badge">Road Safety Club</span>
                <h3 class="dn-svc-img-title">Road Safety Club in Kenya</h3>
              </div>
            </div>
            <div class="dn-svc-body">
              <div class="dn-svc-counter">03 <span>/ 04</span></div>
              <p class="dn-svc-text">Through our Road Safety Club, Mfano Bora Africa Ltd leads nationwide awareness
                programmes, school road safety campaigns, and community training initiatives across Kenya.</p>
              <a href="https://www.mfanoboraafrica.com/road-safety-club/" class="dn-svc-link">Join Now →</a>
            </div>
          </div>
          <div class="dn-svc-slide">
            <div class="dn-svc-img"
              style="background-image:url('smart_driver.png');background-size:cover;background-position:center;">
              <div class="dn-svc-overlay"></div>
              <div class="dn-svc-img-content">
                <span class="dn-svc-badge">Smart Drivers Club</span>
                <h3 class="dn-svc-img-title">Smart Drivers Club</h3>
              </div>
            </div>
            <div class="dn-svc-body">
              <div class="dn-svc-counter">04 <span>/ 04</span></div>
              <p class="dn-svc-text">Empowering drivers with essential skills, safety knowledge, and responsible road
                behaviour. We train participants to become confident and responsible road users.</p>
              <a href="https://www.mfanoboraafrica.com/smart-driver-club/" class="dn-svc-link">Learn More →</a>
            </div>
          </div>
        </div>
      </div>
      <div class="dn-svc-progress">
        <div class="dn-svc-progress-bar" id="dnSvcProgress"></div>
      </div>
      <div class="dn-svc-controls">
        <button class="dn-svc-arr" onclick="dnSvcPrev()">←</button>
        <div class="dn-svc-dots" id="dnSvcDots"><button class="dn-svc-dot active" onclick="dnSvcGo(0)"></button><button
            class="dn-svc-dot" onclick="dnSvcGo(1)"></button><button class="dn-svc-dot"
            onclick="dnSvcGo(2)"></button><button class="dn-svc-dot" onclick="dnSvcGo(3)"></button></div>
        <button class="dn-svc-arr" onclick="dnSvcNext()">→</button>
      </div>
    </div>
  </section>

  <!-- ABOUT -->
  <section class="dn-about">
    <div class="dn-about-inner">
      <div class="dn-about-img"><img src="https://www.mfanoboraafrica.com/assets/images/our-history.png"
          alt="Our History"></div>
      <div class="dn-about-text">
        <div class="dn-eyebrow" style="margin-bottom:1.25rem;">
          <div class="dn-eyebrow-line"></div><span class="dn-eyebrow-text">Who We Are</span>
        </div>
        <h2 class="dn-section-title" style="font-size:clamp(2rem,4vw,3rem);margin-bottom:1.5rem;">24 YEARS OF <span
            style="color:var(--amber)">IMPACT.</span></h2>
        <p>Mfano Bora Africa Limited is the leading consulting firm in Logistics, providing integrated supply chain
          management consulting services that optimise operations across East Africa.</p>
        <p>We are the home of the <strong>East Africa Transport, Logistics &amp; Road Safety Awards</strong> —
          celebrating excellence and innovation for the past 24 years.</p>
        <div class="dn-about-more" id="dnAboutMore">
          <p>We provide Road Safety Education focusing on training and support for road users, with more than 500 Road
            Safety Clubs in the region.</p>
          <p>We also offer social training and industrial attachment programmes where students gain practical skills and
            real-world work experience.</p>
        </div>
        <button class="dn-read-more-btn" id="dnReadMore">Read More</button>
      </div>
    </div>
  </section>

  <!-- NEWS & EVENTS -->
  <div class="dn-hne-outer">
    <div class="dn-hne">
      <div class="dn-hne-col">
        <h2>Latest Notices</h2>
        <div class="dn-hne-item"><a
            href="https://www.mfanoboraafrica.com/notices/44-industrial-attachment-opportunities-2026-intake-"
            class="dn-hne-link">INDUSTRIAL ATTACHMENT OPPORTUNITIES (2026 INTAKE)</a></div>
        <a href="https://www.mfanoboraafrica.com/notices/" class="dn-hne-more">More Notices →</a>
      </div>
      <div class="dn-hne-col">
        <h2>Upcoming Events</h2>
        <div class="dn-hne-item">
          <div class="dn-hne-date">April 30, 2026</div><a
            href="https://www.mfanoboraafrica.com/events/2-personal-accident-cover-networking-breakfast"
            class="dn-hne-link">PERSONAL ACCIDENT COVER NETWORKING BREAKFAST</a>
        </div>
        <div class="dn-hne-item">
          <div class="dn-hne-date">April 24, 2026</div><a
            href="https://www.mfanoboraafrica.com/events/3-4th-east-africa-transport-logistics-road-safety-awards-gala"
            class="dn-hne-link">4TH EAST AFRICA TRANSPORT, LOGISTICS &amp; ROAD SAFETY AWARDS GALA</a>
        </div>
        <a href="https://www.mfanoboraafrica.com/events/" class="dn-hne-more">View All →</a>
      </div>
    </div>
  </div>

  <!-- MISSION & VISION -->
  <section class="dn-mv">
    <h2 class="dn-mv-title">OUR MISSION &amp; <span>VISION.</span></h2>
    <div class="dn-mv-grid">
      <div class="dn-mv-box">
        <h3>Our Mission</h3>
        <p>To relentlessly focus on helping our partners succeed by serving their logistics needs through unparalleled
          expertise, technological agility, and continuous innovation.</p>
      </div>
      <div class="dn-mv-box">
        <h3>Our Vision</h3>
        <p>To be the leading Logistics consultant in Africa, recognised for excellence, innovation, and commitment to
          safety and sustainability while exceeding customer expectations.</p>
      </div>
    </div>
  </section>

  <!-- VALUES -->
  <section class="dn-values">
    <div class="dn-values-inner">
      <div class="dn-eyebrow">
        <div class="dn-eyebrow-line"></div><span class="dn-eyebrow-text">What Drives Us</span>
      </div>
      <h2 class="dn-section-title">OUR CORE <span style="color:var(--amber)">VALUES.</span></h2>
      <div class="dn-values-grid">
        <div class="dn-value-item">
          <div class="dn-value-num">01</div>
          <h4>Preservation of Human Life</h4>
          <p>Every action we take is guided by the principle that human life is priceless.</p>
        </div>
        <div class="dn-value-item">
          <div class="dn-value-num">02</div>
          <h4>Whole Participation of the Community</h4>
          <p>We encourage active involvement of individuals, families, organisations, and authorities.</p>
        </div>
        <div class="dn-value-item">
          <div class="dn-value-num">03</div>
          <h4>Partnership</h4>
          <p>We build strong, mutually beneficial relationships to share resources, expertise, and achieve greater
            impact.</p>
        </div>
        <div class="dn-value-item">
          <div class="dn-value-num">04</div>
          <h4>Capacity Development</h4>
          <p>We equip people and communities with the skills and tools they need to prevent accidents.</p>
        </div>
        <div class="dn-value-item">
          <div class="dn-value-num">05</div>
          <h4>Sustainability &amp; Socio-Economic Development</h4>
          <p>Long-term solutions that improve safety while enhancing social and economic well-being.</p>
        </div>
        <div class="dn-value-item">
          <div class="dn-value-num">06</div>
          <h4>Road Accidents Are Avoidable</h4>
          <p>With proper education, enforcement, and infrastructure, accidents can be significantly reduced.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="dn-cta">
    <h2 class="dn-cta-title">LET'S <span class="amber">BUILD</span><br><span class="muted">SOMETHING</span> TOGETHER.
    </h2>
    <p class="dn-cta-sub">Whether you're a student, a business, or a community advocate — there's a place for you at
      Mfano Bora Africa.</p>
    <div class="dn-cta-btns">
      <a href="https://www.mfanoboraafrica.com/contact-us/" class="dn-btn-amber">Get in Touch →</a>
      <a href="https://www.mfanoboraafrica.com/about/" class="dn-btn-ghost">Learn More</a>
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

  <script>
    // SERVICES SLIDESHOW
    var dnSvcCur = 0, dnSvcTotal = 4;
    function dnSvcRender() {
      var w = document.getElementById('dnSvcWrap');
      w.scrollLeft = dnSvcCur * w.offsetWidth;
      document.querySelectorAll('.dn-svc-dot').forEach(function (d, i) { d.classList.toggle('active', i === dnSvcCur); });
      var p = document.getElementById('dnSvcProgress');
      if (p) p.style.width = ((dnSvcCur + 1) / dnSvcTotal * 100) + '%';
    }
    function dnSvcGo(n) { dnSvcCur = (n + dnSvcTotal) % dnSvcTotal; dnSvcRender(); clearInterval(dnSvcTimer); dnSvcTimer = setInterval(dnSvcNext, 5000); }
    function dnSvcNext() { dnSvcGo(dnSvcCur + 1); }
    function dnSvcPrev() { dnSvcGo(dnSvcCur - 1); }
    var dnSvcTimer = setInterval(dnSvcNext, 5000);

    // READ MORE
    document.getElementById('dnReadMore').addEventListener('click', function () {
      var m = document.getElementById('dnAboutMore');
      var open = m.style.display === 'block';
      m.style.display = open ? 'none' : 'block';
      this.textContent = open ? 'Read More' : 'Read Less';
    });

    // HAMBURGER
    document.getElementById('mbHamburger').addEventListener('click', function () {
      document.getElementById('mbNavLinks').classList.toggle('open');
    });
  </script>

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