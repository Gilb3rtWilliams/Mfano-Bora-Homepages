  <?php
// Page title
$page_title = "Home - Mfano Bora Africa Ltd";

// Include database configuration
require_once __DIR__ . '/../configs/database.php';

try {
    // ----------------------------
    // Fetch all events (past + upcoming), newest first
    // ----------------------------
    $event_stmt = $pdo->prepare("
        SELECT id, title, description, banner_url, event_date 
        FROM events 
        ORDER BY event_date DESC
    ");
    $event_stmt->execute();
    $events = $event_stmt->fetchAll(PDO::FETCH_ASSOC);

    // ----------------------------
    // Fetch all news, newest first
    // ----------------------------
    $news_stmt = $pdo->prepare("
        SELECT id, title, content, thumbnail, created_at 
        FROM news 
        ORDER BY created_at DESC
    ");
    $news_stmt->execute();
    $news_items = $news_stmt->fetchAll(PDO::FETCH_ASSOC);

    $priority_stmt = $pdo->prepare("
    -- Priority 1 items
    SELECT 
        id, 
        title, 
        content AS description,
        NULL AS subtitle, 
        custom_url, 
        CONCAT('/news_and_events/?id=', id) AS url, 
        created_at
    FROM news 
    WHERE priority = 1

    UNION ALL

    SELECT 
        id, 
        title, 
        description,
        NULL AS subtitle, 
        custom_url, 
        CONCAT('/events/?id=', id) AS url, 
        event_date AS created_at
    FROM events 
    WHERE priority = 1

    ORDER BY created_at DESC
    LIMIT 3
");
$priority_stmt->execute();
$priority_items = $priority_stmt->fetchAll(PDO::FETCH_ASSOC);

try {
    $stmt = $pdo->prepare("
        SELECT *
        FROM home_slides
        WHERE status = 1
        ORDER BY display_order ASC
    ");
    $stmt->execute();
    $slides = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $slides = [];
}


// ----------------------------
// Fetch items with priority ≥ 2 and priority > 0
// ----------------------------
$other_priority_stmt = $pdo->prepare("
    SELECT 
        id, 
        title, 
        content AS description,
        NULL AS subtitle, 
        custom_url, 
        CONCAT('/news_and_events/?id=', id) AS url, 
        created_at
    FROM news 
    WHERE priority > 1

    UNION ALL

    SELECT 
        id, 
        title, 
        description,
        NULL AS subtitle, 
        custom_url, 
        CONCAT('/events/?id=', id) AS url, 
        event_date AS created_at
    FROM events 
    WHERE priority > 1

    ORDER BY created_at DESC
");
$other_priority_stmt->execute();
$other_priority_items = $other_priority_stmt->fetchAll(PDO::FETCH_ASSOC);

// Merge priority 1 with priority ≥ 2 items
$priority_items = array_merge($priority_items, $other_priority_items);

    // ----------------------------
    // Fetch next upcoming event
    // ----------------------------
    $upcoming_stmt = $pdo->prepare("
        SELECT * 
        FROM events
        WHERE event_date >= CURDATE()
        ORDER BY event_date ASC
        LIMIT 1
    ");
    $upcoming_stmt->execute();
    $event = $upcoming_stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Log database errors
    error_log("Database error: " . $e->getMessage());

    // Set variables to null in case of failure
    $events = [];
    $news_items = [];
    $priority_items = [];
    $event = null;
}
function slugify($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}
function formatNoticeContent($text) {
    $lines = explode("\n", $text);
    $formattedLines = [];
    $inUl = false;
    $inOl = false;

    foreach ($lines as $line) {
        $trimmed = trim($line);

        if ($trimmed === '') {
            if ($inUl) { $formattedLines[] = '</ul>'; $inUl=false; }
            if ($inOl) { $formattedLines[] = '</ol>'; $inOl=false; }
            $formattedLines[] = '';
            continue;
        }

        // Natural heading detection: all caps, short <=25 chars
        if (strlen($trimmed) <= 25 && strtoupper($trimmed) === $trimmed && preg_match('/[A-Z]/', $trimmed)) {
            if ($inUl) { $formattedLines[] = '</ul>'; $inUl=false; }
            if ($inOl) { $formattedLines[] = '</ol>'; $inOl=false; }
            $formattedLines[] = '<b style="font-size:1.1em; display:block; margin-top:20px; margin-bottom:10px;">' . htmlspecialchars($trimmed) . '</b>';
            continue;
        }

        // Bullet list
        if (preg_match('/^- /', $trimmed)) {
            if (!$inUl) { $formattedLines[] = '<ul>'; $inUl=true; }
            $formattedLines[] = '<li>' . htmlspecialchars(substr($trimmed,2)) . '</li>';
            continue;
        }

        // Numbered list
        if (preg_match('/^\d+\.\s+/', $trimmed)) {
            if (!$inOl) { $formattedLines[] = '<ol>'; $inOl=true; }
            $formattedLines[] = '<li>' . htmlspecialchars(preg_replace('/^\d+\.\s+/', '', $trimmed)) . '</li>';
            continue;
        }

        // Default paragraph
        if ($inUl) { $formattedLines[] = '</ul>'; $inUl=false; }
        if ($inOl) { $formattedLines[] = '</ol>'; $inOl=false; }
        $formattedLines[] = '<p>' . htmlspecialchars($trimmed) . '</p>';
    }

    // Close any open lists
    if ($inUl) $formattedLines[] = '</ul>';
    if ($inOl) $formattedLines[] = '</ol>';

    return implode("\n", $formattedLines);
}

?>

<head>
    <meta charset="UTF-8" name="description" content="Learn more about our services, values, and over 20 years of service at Mfano Bora Africa. Discover who we are and what drives our impact.">
<style>
/* Main Section */
.main-section {
  display: flex;
  gap: 10px;
  margin: 100px 20px 0;
  flex-wrap: nowrap;
}

.slideshow-wrapper {
  flex: 0 0 65%;
  max-width: 65%;
}

/* Flex container: reduce gap */
.event-banner-wrapper {
  flex: 0 0 35%;
  max-width: 35%;
  display: flex;
  flex-direction: column;
  gap: 8px; /* reduced from 15px */
  min-height: 400px;
  height: auto;
  overflow-y: visible;
  box-sizing: border-box;
  justify-content: flex-start;
  background-color: #353232ff;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  padding: 15px;
}

/* Title spacing */
.event-banner-wrapper h2 {
  font-size: 1.4em;
  margin-top: 0;       /* remove extra top margin */
  margin-bottom: 4px;  /* smaller gap to description */
  color: #4dabf7 !important;
}

/* Description spacing + 3-line clamp */
.event-banner-wrapper p {
  font-size: 1em;
  margin: 0 0 6px 0;   /* smaller bottom gap to button */
  color: #fff;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Button spacing */
.event-banner-wrapper .cta-btn {
  display: inline-block;
  margin-top: 0;       /* remove extra top margin */
  padding: 8px 16px;
  background: #ff9900;
  color: #fff;
  text-decoration: none;
  border-radius: 5px;
  font-weight: bold;
  transition: 0.3s;
}

.event-banner-wrapper .cta-btn:hover {
  opacity: 0.85;
}

/* Slideshow */
.slider-container {
  position: relative;
  overflow: hidden;
}

.slides {
  display: none;
  position: relative;
}

.slides img {
  width: 100%;
  height: 400px;
  object-fit: cover;
  border-radius: 10px;
}

.slide-text {
  position: absolute;
  bottom: 20px;
  left: 20px;
  background: rgba(0, 0, 0, 0.5);
  padding: 15px;
  border-radius: 10px;
  color: #fff;
  max-width: 350px;
}

.slide-text h2 {
  color: #4dabf7 !important; /* Slideshow heading color */
}

.slide-text .cta-btn {
  display: inline-block;
  margin-top: 8px;
  padding: 8px 16px;
  background: #ff9900; /* Orange button */
  color: #fff;
  text-decoration: none;
  border-radius: 5px;
  font-weight: bold;
  transition: 0.3s;
}

.slide-text .cta-btn:hover {
  opacity: 0.85;
}

.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  padding: 14px;
  color: #fff;
  font-size: 28px;
  border-radius: 50%;
  background: rgba(0, 0, 0, 0.4);
  user-select: none;
}

.prev { left: 10px; }
.next { right: 10px; }

/* Responsive adjustments */
@media (max-width: 900px) {
  .main-section {
    flex-direction: column;
  }

  .slideshow-wrapper,
  .event-banner-wrapper {
    flex: 1 1 100%;
    max-width: 100%;
    height: auto;
  }

  .slides img { height: 300px; }

  .stats-section {
    flex-direction: row;
    gap: 8px;
  }

  .stats-section .stat {
    flex: 1 1 30%;
    padding: 6px 4px;
  }

  .slide-text {
    max-width: 90%;
    bottom: 15px;
    left: 15px;
    padding: 12px;
  }

  .slide-text .cta-btn {
    padding: 6px 12px;
    font-size: 0.9em;
  }
}
  #eventPopup {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid #ccc;
    box-shadow: 0 8px 18px rgba(0,0,0,0.25);
    z-index: 9999;
    width: 180px;            /* slightly larger for better content fit */
    border-radius: 8px;
    font-family: Arial, sans-serif;
    padding: 12px;
    text-align: center;
}

#eventPopup img {
    max-width: 100%;
    max-height: 80px;        /* smaller image to fit rectangle */
    margin-bottom: 8px;
}

#eventPopup .popup-content {
    padding: 0;              /* padding handled in main container */
}

#eventPopup h3 {
    margin: 6px 0;
    color: #333;
    font-size: 1em;          /* readable but small */
    font-weight: bold;       /* bold heading */
    line-height: 1.2;
}

#eventPopup p {
    font-size: 0.85em;       /* smaller paragraph */
    color: #555;
    line-height: 1.3;
    margin: 4px 0;
}

#eventPopup .popup-btn {
    display: inline-block;
    margin-top: 8px;
    padding: 6px 10px;       /* smaller button */
    background: #007BFF;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-size: 0.8em;
    cursor: pointer;
}

#eventPopup .popup-btn:hover {
    background: #0056b3;
}

#eventPopup .popup-close {
    position: absolute;
    top: 4px;
    right: 6px;
    cursor: pointer;
    font-size: 16px;
    color: #666;
}

/* Bounce animation */
@keyframes bounceFromBottom {
    0%   { transform: translateY(0); }
    50%  { transform: translateY(-100px); }
    100% { transform: translateY(0); }
}

.bounce {
    animation: bounceFromBottom 3s ease-in-out;
}

.popup-btn-row {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 12px;
}

.popup-btn {
    padding: 10px 18px;
    background: #007BFF;
    color: #fff;
    text-decoration: none;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
}

.popup-btn:hover {
    background: #0056b3;
}

.popup-close-btn {
    background: #6c757d;
}

.popup-close-btn:hover {
    background: #5a6268;
}

/* Modal background */
.pdf-modal {
    display: none;
    position: fixed;
    z-index: 2000;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.6);
    justify-content: center;
    align-items: center;
}

/* PDF content */
.pdf-content {
    background: white;
    padding: 15px;
    border-radius: 8px;
    width: 80%;
    max-width: 900px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    position: relative;
}

/* Close button */
.pdf-close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 26px;
    cursor: pointer;
}

/* Disable right click on iframe */
iframe {
    pointer-events: auto;
}

</style>
    <title>Home - Mfano Bora Africa Ltd</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>

  

<section class="main-section">
  <!-- Slideshow Left -->
  <div class="slideshow-wrapper">
    <section class="slider-container">

      <?php if (!empty($slides)): ?>
        <?php foreach ($slides as $slide): ?>
          <div class="slides fade">
            <img
              src="<?= htmlspecialchars($slide['image_path']) ?>"
              alt="<?= htmlspecialchars($slide['image_alt'] ?? $slide['title']) ?>">

            <div class="slide-text">
              <h2><?= htmlspecialchars($slide['title']) ?></h2>

              <!-- description allows HTML (links, <br>, etc) -->
              <p><?= $slide['description'] ?></p>

              <?php if (!empty($slide['cta_text']) && !empty($slide['cta_link'])): ?>
                <a
                  href="<?= htmlspecialchars($slide['cta_link']) ?>"
                  class="cta-btn">
                  <?= htmlspecialchars($slide['cta_text']) ?>
                </a>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Optional fallback if no slides exist -->
        <div class="slides fade">
          <div class="slide-text">
            <h2>No slides available</h2>
          </div>
        </div>
      <?php endif; ?>

      <!-- Navigation -->
      <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
      <a class="next" onclick="plusSlides(1)">&#10095;</a>

    </section>
  </div>

<!-- Event Banner Right -->
<div class="event-banner-wrapper">
<?php if (!empty($priority_items)): 
        $item = $priority_items[0]; 
        $title = $item['title'];

        // Determine if it's an event
        $is_event = isset($item['url']) && str_starts_with($item['url'], '/events');

        $slug = slugify($title);

        if (!empty($item['custom_url'])) {
            $url = $item['custom_url'];
        } elseif (!empty($item['pdf_url'])) {
            $url = $item['pdf_url'];
        } else {
            $url = $is_event
                ? "/events/{$item['id']}-{$slug}"
                : "/notices/{$item['id']}-{$slug}";
        }

        // Description
        $description = isset($item['description']) && !empty($item['description']) 
                        ? $item['description'] 
                        : ($is_event ? "Join our next cohort and participate in this event." : "Read our latest news update.");

        // 🔥 Format then strip to plain preview
        $formatted_description = formatNoticeContent($description);
        $plain_description = trim(strip_tags($formatted_description));

        $short_description = mb_strlen($plain_description) > 150 
                             ? mb_substr($plain_description, 0, 150) . "..." 
                             : $plain_description;

        // Button text logic
        $title_lower = strtolower($title);
        if (strpos($title_lower, 'attachment') !== false) {
            $button_text = 'Click to Apply →';
        } elseif (strpos($title_lower, 'club') !== false || strpos($title_lower, 'event') !== false) {
            $button_text = 'Join →';
        } else {
            $button_text = 'Read More →';
        }
?>
    <h2><?= htmlspecialchars($title) ?></h2>

    <!-- SIMPLE PREVIEW (NO TOGGLE) -->
    <p class="three-line-text">
        <?= htmlspecialchars($short_description) ?>
    </p>

    <a href="<?= htmlspecialchars($url) ?>" class="cta-btn"><?= $button_text ?></a>

<?php if (count($priority_items) > 1): ?>
    <?php foreach ($priority_items as $index => $item): ?>
        <?php if ($index === 0) continue; ?>

        <?php
            $title = $item['title'];
            $slug = slugify($title);
            $is_event = isset($item['url']) && str_starts_with($item['url'], '/events');

            if (!empty($item['custom_url'])) {
                $url = $item['custom_url'];
            } elseif (!empty($item['pdf_url'])) {
                $url = $item['pdf_url'];
            } else {
                $url = $is_event
                    ? "/events/{$item['id']}-{$slug}"
                    : "/notices/{$item['id']}-{$slug}";
            }

            $description = !empty($item['description'])
                           ? $item['description']
                           : "Read more details.";

            $formatted_description = formatNoticeContent($description);
            $plain_description = trim(strip_tags($formatted_description));

            $short_description = mb_strlen($plain_description) > 150
                                 ? mb_substr($plain_description, 0, 150) . "..."
                                 : $plain_description;

            $title_lower = strtolower($title);
            if (strpos($title_lower, 'attachment') !== false) {
                $button_text = 'Click to Apply →';
            } elseif (strpos($title_lower, 'club') !== false || strpos($title_lower, 'event') !== false) {
                $button_text = 'Join →';
            } else {
                $button_text = 'Read More →';
            }
        ?>

        <h2><?= htmlspecialchars($title) ?></h2>

        <p class="three-line-text">
            <?= htmlspecialchars($short_description) ?>
        </p>

        <a href="<?= htmlspecialchars($url) ?>" class="cta-btn">
            <?= $button_text ?>
        </a>

    <?php endforeach; ?>
<?php endif; ?>

<?php else: ?>
    <h2>No priority events or news</h2>
    <p>Please check back later for updates.</p>
<?php endif; ?>
</div>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const desc = document.getElementById("desc");
    if (!desc) return;

    const fullText = desc.dataset.full;
    const shortText = desc.dataset.short;

    let expanded = false;

    desc.addEventListener("click", () => {
        if (!expanded) {
            desc.textContent = fullText;
            expanded = true;
        } else {
            desc.textContent = shortText;
            expanded = false;
        }
    });
});
</script>


<section class="our-story">

    <!-- ABOUT US header (full width) -->
    <div class="story-header">
        <h2>ABOUT US</h2>
    </div>

    <!-- First part (always visible) -->
    <div class="story-content">
        <div class="story-image">
            <img src="/../assets/images/our-history.png" alt="Our History">
        </div>

        <div class="story-text">
            <p>
                Mfano Bora Africa Limited is the leading consulting firm in Logistics. We provide Logistics and integrated supply chain management consulting services that optimize operations by analyzing, streamlining, and integrating all aspects of a supply chain, from planning and sourcing to distribution and customer service.
            </p>
            <br>
            <p>
                Mfano Bora Africa Limited is also the home of EAST AFRICA TRANSPORT, LOGISTICS & ROAD SAFETY AWARDS for the past 24 years. We recognize excellence and innovation in the logistics and supply chain industry.
            </p>
        </div>
    </div>

    <!-- Remaining parts (hidden initially) -->
    <div id="more-story" style="display: none;">

        <!-- Second part -->
        <div class="story-content reverse">
            <div class="story-image">
                <img src="/../assets/images/product.PNG" alt="Road Safety">
            </div>

            <div class="story-text">
                <p>
                    We provide ROAD SAFETY EDUCATION that focuses on offering training and support to road users to improve safety on regional roads. We currently have more than 500 Road Safety Clubs in the region.
                </p>
                <br>
                <p>
                    Mfano Bora Africa Limited offers social training aimed at improving performance and skills, fostering long-term career growth, and increasing engagement and retention for fresh graduates.
                </p>
                <br>
                <p>
                    We also provide attachments and internships where students gain practical skills and work experience.
                </p>
            </div>
        </div>

        <br><br>

        <!-- Third part -->
        <div class="story-content">
            <div class="story-image">
                <img src="/../assets/images/workforce.png" alt="Training & Development">
            </div>

            <div class="story-text">
                <p>
                    Our training programs empower individuals with essential life skills, professional development, and workforce readiness.
                </p>
                <br>
                <p>
                    Through mentorship, leadership training, and personalized coaching, we build a safer, more skilled workforce in the region.
                </p>
            </div>
        </div>

    </div>

    <!-- Read More button -->
<div style="text-align: center; margin-top: 20px;">
    <button id="readMoreBtn" style="
        padding: 12px 30px; 
        font-size: 18px; 
        background-color: #007BFF; 
        color: #fff; 
        border: none; 
        border-radius: 8px; 
        cursor: pointer;
        transition: background-color 0.3s;
    ">Read More</button>
</div>

<script>
    const btn = document.getElementById('readMoreBtn');
    const moreStory = document.getElementById('more-story');

    btn.addEventListener('click', () => {
        if (moreStory.style.display === 'none') {
            moreStory.style.display = 'block';
            btn.textContent = 'Read Less';
        } else {
            moreStory.style.display = 'none';
            btn.textContent = 'Read More';
        }
    });

    // Optional: hover effect
    btn.addEventListener('mouseover', () => {
        btn.style.backgroundColor = '#0056b3';
    });
    btn.addEventListener('mouseout', () => {
        btn.style.backgroundColor = '#007BFF';
    });
</script>
</section>
<section class="hne-wrapper">


    <div class="hne-content">

    <!-- ====================== NEWS SECTION ======================= -->
    <div class="hne-column">
        <h2 class="hne-title">Latest Notices</h2>

        <?php
        // Function to generate SEO-friendly URL
        function newsUrl($id, $title) {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
            return "/notices/{$id}-{$slug}";
        }
        ?>

        <?php foreach ($news_items as $n): ?>
            <div class="hne-item">
                <!-- Removed date -->

                <!-- Updated link only -->
                <a href="<?= newsUrl($n['id'], $n['title']) ?>" class="hne-link">
                    <?= htmlspecialchars($n['title']) ?>
                </a>
            </div>
        <?php endforeach; ?>

        <!-- Updated Read More link only -->
        <a href="/notices/" class="hne-more">More Notices →</a>
    </div>


       <!-- ====================== EVENTS SECTION ======================= -->
<div class="hne-column">
    <h2 class="hne-title">Upcoming Events</h2>

    <?php foreach ($events as $e): 
        // Generate SEO-friendly slug
        $slug = strtolower(trim($e['title']));
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');

        $eventUrl = "/events/" . $e['id'] . "-" . $slug;
    ?>
        <div class="hne-item">
            <p class="hne-date"><?= date("F j, Y", strtotime($e['event_date'])) ?></p>

            <!-- Updated SEO-friendly link -->
            <a href="<?= htmlspecialchars($eventUrl) ?>" class="hne-link">
                <?= htmlspecialchars($e['title']) ?>
            </a>
        </div>
    <?php endforeach; ?>

    <!-- Correct View All Link -->
    <a href="/events/" class="hne-more">View All →</a>
</div>

</section>

<?php if ($event): ?>
<div id="eventPopup" class="bounce">
    <span class="popup-close" onclick="closePopup()">&times;</span>
    <div class="popup-content">
        <?php if (!empty($event['banner_url'])): ?>
            <img 
                src="<?= htmlspecialchars('/' . ltrim($event['banner_url'], '/')) ?>" 
                alt="Event Banner" 
                style="width:100%; border-radius:8px; margin-bottom:10px;"
            >
        <?php endif; ?>
        
        <h3><?= htmlspecialchars($event['title']) ?></h3>
     
        <p style="font-size:13px; color:#777;">
            <strong>Date:</strong> <?= date('F j, Y', strtotime($event['event_date'])) ?>
        </p>

        <div class="popup-btn-row">
            <a href="/events/" class="popup-btn">View More</a>
            <button class="popup-btn popup-close-btn" onclick="closePopup()">Close</button>
        </div>
    </div>
</div>
<?php endif; ?>


    <section class="mission-vision-section">
    <h2>Our Mission & Vision</h2>
    <div class="mv-container">
        <div class="mv-box">
            <h3>Our Mission</h3>
            <p>
                To relentlessly focus on helping our partners succeed by serving their logistics needs through unparalleled expertise, technological agility, and continuous innovation.
            </p>
        </div>
        <div class="mv-box">
            <h3>Our Vision</h3>
            <p>
                To be the leading Logistics consultant in Africa, recognized for excellence, innovation, and commitment to safety and sustainability while working to meet and exceed customer expectations by providing reliable, rapid, and accurate consultancy services aimed at building trust and brand loyalty.
            </p>
        </div>
    </div>
</section>
<br>

<section class="values-section">
    <h2>Our Core Values</h2>
    <p class="values-subtitle">
        These guiding principles shape every decision and action we take at Mfano Bora.
    </p>
    <div class="values-container">
        <div class="value-box">
            <h4>Preservation of Human Life</h4>
            <p>We believe that protecting and saving lives is our highest priority. Every action we take is guided by the principle that human life is priceless.</p>
        </div>
        <div class="value-box">
            <h4>Whole Participation of the Community</h4>
            <p>We encourage the active involvement of individuals, families, organizations, and authorities to work together in creating safer communities.</p>
        </div>
        <div class="value-box">
            <h4>Partnership</h4>
            <p>We build strong, mutually beneficial relationships with stakeholders to share resources, expertise, and achieve greater impact.</p>
        </div>
        <div class="value-box">
            <h4>Capacity Development</h4>
            <p>We equip people and communities with the skills, knowledge, and tools they need to prevent accidents and respond effectively to emergencies.</p>
        </div>
        <div class="value-box">
            <h4>Sustainability & Socio-Economic Development</h4>
            <p>We aim for long-term solutions that improve safety while also enhancing the social and economic well-being of communities.</p>
        </div>
        <div class="value-box">
            <h4>Road Accidents Are Avoidable</h4>
            <p>With proper education, enforcement, and infrastructure, road accidents can be significantly reduced and, in many cases, prevented entirely.</p>
        </div>
    </div>
</section>


<section class="about-learn-more">
  <div class="about-learn-more-box">
    <h2>Learn More About Us</h2>
    <p>Setting the standard in transportation and logistics across Africa.</p>
    <a href="/contact-us/" class="btn-outline">Contact us</a>
  </div>
</section>



<script>
document.addEventListener("DOMContentLoaded", () => {
    // HNE Items animation on scroll
    const items = document.querySelectorAll('.hne-item');
    const observerItems = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = "1";
                entry.target.style.transform = "translateY(0)";
            } else {
                // Reset when scrolling up/out of view
                entry.target.style.opacity = "0";
                entry.target.style.transform = "translateY(20px)";
            }
        });
    }, { threshold: 0.2 });

    items.forEach(item => {
        // Initial state
        item.style.opacity = "0";
        item.style.transform = "translateY(20px)";
        item.style.transition = "all 0.6s ease";

        observerItems.observe(item);
    });

    // Stats counters animation
    const counters = document.querySelectorAll('.counter');

    function animateCounter(counter) {
        const target = +counter.getAttribute('data-target');
        const duration = 2000; // total duration in ms
        let start = 0;
        let startTime = null;

        function update(timestamp) {
            if (!startTime) startTime = timestamp;
            const progress = timestamp - startTime;
            const current = Math.min(Math.floor(progress / duration * target), target);
            counter.innerText = current;
            if (current < target) {
                requestAnimationFrame(update);
            }
        }
        requestAnimationFrame(update);
    }

    // Animate when counters are in view
    const observerCounters = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target); // animate only once
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(counter => {
        counter.innerText = '0';
        observerCounters.observe(counter);

        // Optional: animate on hover
        counter.addEventListener('mouseenter', () => {
            animateCounter(counter);
        });
    });
});

// Slideshow
let slideIndex = 0;
showSlides();

function showSlides() {
    let slides = document.getElementsByClassName("slides");
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}    
    slides[slideIndex-1].style.display = "block";  
    setTimeout(showSlides, 10000); // change slide every 10 seconds
}

function plusSlides(n) {
    slideIndex += n - 1;
    showSlides();
}

document.addEventListener("DOMContentLoaded", () => {
    const storyContents = document.querySelectorAll('.story-content');

    // Assign animation direction
    storyContents.forEach((content, index) => {
        if(index === 0) content.setAttribute('data-animate', 'left');
        else if(index === 1) content.setAttribute('data-animate', 'right');
        else if(index === 2) content.setAttribute('data-animate', 'bottom');
    });

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                entry.target.classList.add('animate');
            } else {
                // Reset animation when leaving viewport
                entry.target.classList.remove('animate');
            }
        });
    }, { threshold: 0.2 });

    storyContents.forEach(content => observer.observe(content));
});

// Popup handling
(function () {
    function onReady(fn) {
        if (document.readyState !== 'loading') fn();
        else document.addEventListener('DOMContentLoaded', fn);
    }

    onReady(function () {
        const popup = document.getElementById('eventPopup');

        // Make this callable from inline handlers too (e.g., the × span)
        window.closePopup = function () {
            if (popup) popup.style.display = 'none';
        };

        // Attach to the × icon, the Close button, and any future close buttons
        document.querySelectorAll('.popup-close, .popup-close-btn, .close-btn')
            .forEach(btn => btn.addEventListener('click', window.closePopup));

        // Bounce every 20s (optional)
        if (popup) {
            setInterval(() => {
                popup.classList.add('bounce');
                const handler = () => {
                    popup.classList.remove('bounce');
                    popup.removeEventListener('animationend', handler);
                };
                popup.addEventListener('animationend', handler);
            }, 20000);
        }
    });
})();
</script>



