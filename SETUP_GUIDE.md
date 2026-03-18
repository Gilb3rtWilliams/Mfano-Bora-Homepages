# How to Run the Redesigned Homepage

## What you have
| File | Description |
|------|-------------|
| `home_playful.php` | Playful design (cream/gold/dark, Syne font) |
| `home_dynamic.php` | Dynamic design (dark/amber, Bebas Neue font) |

Both files are **drop-in replacements** for the existing `home.php`. They keep all the original PHP database logic intact — only the HTML/CSS output has changed.

---

## Step 1 — Move the service images

The service slideshow references these image paths. Copy your 4 service images into the site's assets folder:

```
/assets/images/awards.jpg        ← awards.jpg
/assets/images/attachment.jpeg   ← attachment.jpeg
/assets/images/road_safety.png   ← road_safety.png
/assets/images/smart_driver.png  ← smart_driver.png
```

If your assets folder has a different path, open the PHP file and update the `$service_slides` array near the top (around line 60):

```php
$service_slides = [
  ['tag'=>'EA Transport Awards', 'img'=>'/assets/images/awards.jpg', ...],
  ...
];
```

---

## Step 2 — Back up the original file

Before replacing anything:

```bash
cp home.php home_original_backup.php
```

---

## Step 3 — Swap in your chosen design

**To test the Playful design:**
```bash
cp home_playful.php home.php
```

**To test the Dynamic design:**
```bash
cp home_dynamic.php home.php
```

**To go back to the original:**
```bash
cp home_original_backup.php home.php
```

---

## Step 4 — Run the site locally (if you don't have a server running)

You need PHP and a database connection. The quickest options:

### Option A — XAMPP (Windows, easiest)
1. Download and install XAMPP from https://www.apachefriends.org
2. Copy the entire project folder into `C:\xampp\htdocs\`
3. Start Apache and MySQL from the XAMPP Control Panel
4. Open your browser and go to `http://localhost/your-project-folder/`

### Option B — WAMP (Windows alternative)
1. Download WampServer from https://www.wampserver.com
2. Same steps as XAMPP above

### Option C — Built-in PHP server (any OS, quick)
```bash
# Navigate to your project root (the folder that contains home.php)
cd /path/to/your/project

# Start PHP's built-in server
php -S localhost:8000

# Open your browser to:
# http://localhost:8000/
```
> Note: The built-in PHP server works for viewing pages but requires your `database.php` config to point to a running MySQL/MariaDB instance.

### Option D — The site is already on a live server
Just upload `home_playful.php` or `home_dynamic.php` via FTP/SFTP and rename it to `home.php` on the server. No extra setup needed.

---

## Step 5 — Verify it works

When you open the page you should see:
- ✅ The new hero section with navigation cards
- ✅ The "Find Your Path" audience section (Students / Corporate / Community)
- ✅ The services slideshow (4 slides with your real images)
- ✅ Latest Notices and Events pulled from the database
- ✅ About, Mission/Values, and CTA sections
- ✅ The event popup (if there's an upcoming event in the DB)

---

## Troubleshooting

| Problem | Fix |
|---------|-----|
| Blank page | Check PHP error log. Usually a missing `database.php` path or DB connection issue. |
| Slideshow images not showing | Confirm image files exist at `/assets/images/` and the filenames match exactly. |
| Fonts not loading | You need an internet connection — fonts are loaded from Google Fonts. |
| Styles look wrong | Make sure `/assets/style.css` still exists. The file references it for global styles. |
| Database error | The `require_once __DIR__ . '/../configs/database.php'` path assumes the file is one level inside the site root. Adjust the path if your folder structure differs. |

---

## Switching between designs quickly

You can keep both files on the server and switch between them at any time:

```bash
# Try playful
cp home_playful.php home.php

# Try dynamic  
cp home_dynamic.php home.php

# Restore original
cp home_original_backup.php home.php
```
