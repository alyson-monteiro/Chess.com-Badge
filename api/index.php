<?php

declare(strict_types=1);

require_once __DIR__ . '/src/Validator.php';
require_once __DIR__ . '/src/Cache/FileCache.php';
require_once __DIR__ . '/src/RateLimiter.php';
require_once __DIR__ . '/src/ChessClient.php';
require_once __DIR__ . '/src/SvgRenderer.php';

$cacheDir = __DIR__ . '/storage/cache';
$rateLimitDir = __DIR__ . '/storage/ratelimit';
$cacheTtl = max(60, (int) ($_ENV['CACHE_TTL'] ?? getenv('CACHE_TTL') ?: 600));
$httpTimeout = max(2, (int) ($_ENV['CHESS_TIMEOUT'] ?? getenv('CHESS_TIMEOUT') ?: 5));
$rateLimit = max(10, (int) ($_ENV['RATE_LIMIT_PER_MINUTE'] ?? getenv('RATE_LIMIT_PER_MINUTE') ?: 60));

$cache = new FileCache($cacheDir);
$renderer = new SvgRenderer();
$client = new ChessClient($httpTimeout);
$limiter = new RateLimiter($rateLimitDir, $rateLimit, 60);

$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
if (!$limiter->allow($ip)) {
    http_response_code(429);
    header('Retry-After: ' . $limiter->retryAfterSeconds());
    respondSvg($renderer->render(
        ['avatar' => null, 'username' => 'rate-limited', 'ratingLabel' => 'N/A'],
        'rapid',
        'black'
    ));
    exit;
}

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

if ($method !== 'GET') {
    http_response_code(405);
    respondSvg($renderer->render(['avatar' => null, 'username' => 'method-not-allowed', 'ratingLabel' => 'N/A'], 'rapid', 'black'));
    exit;
}

if (!preg_match('#^/pub/player/([^/]+)/stats/([^/]+)/([^/]+)$#', $path, $matches)) {
    http_response_code(404);
    respondSvg($renderer->render(['avatar' => null, 'username' => 'not-found', 'ratingLabel' => 'N/A'], 'rapid', 'black'));
    exit;
}

$username = Validator::normalizeUsername($matches[1]);
$mode = Validator::normalizeMode($matches[2]);
$theme = Validator::normalizeTheme($matches[3]);

if ($username === null || $mode === null || $theme === null) {
    http_response_code(400);
    respondSvg($renderer->render(['avatar' => null, 'username' => 'invalid-params', 'ratingLabel' => 'N/A'], $mode ?? 'rapid', $theme ?? 'black'));
    exit;
}

$cacheKey = "chess:{$username}:{$mode}";
$data = $cache->get($cacheKey);

if (!is_array($data)) {
    $data = $client->fetchBadgeData($username, $mode);
    $cache->set($cacheKey, $data, $cacheTtl);
}

respondSvg($renderer->render($data, $mode, $theme));

function respondSvg(string $svg): void
{
    header('Content-Type: image/svg+xml; charset=UTF-8');
    header('Cache-Control: public, max-age=300');
    header('X-Content-Type-Options: nosniff');
    echo $svg;
}
