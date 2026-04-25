<?php

declare(strict_types=1);

final class ChessClient
{
    private const BASE_URL = 'https://api.chess.com/pub/player/';

    public function __construct(private readonly int $timeoutSeconds = 5)
    {
    }

    /** @return array{avatar: ?string, username: string, ratingLabel: string, countryCode: ?string} */
    public function fetchBadgeData(string $username, string $mode): array
    {
        $profile = $this->fetchJson(self::BASE_URL . rawurlencode($username));
        $stats = $this->fetchJson(self::BASE_URL . rawurlencode($username) . '/stats');

        $avatar = is_array($profile) ? ($profile['avatar'] ?? null) : null;
        $displayName = is_array($profile) && isset($profile['username']) ? (string) $profile['username'] : $username;
        $countryCode = $this->extractCountryCode($profile);

        if (!is_array($stats)) {
            return ['avatar' => $avatar, 'username' => $displayName, 'ratingLabel' => 'N/A', 'countryCode' => $countryCode];
        }

        $statsKey = Validator::modeStatsKey($mode);
        $modeStats = $stats[$statsKey] ?? null;
        if (!is_array($modeStats)) {
            return ['avatar' => $avatar, 'username' => $displayName, 'ratingLabel' => 'Unrated', 'countryCode' => $countryCode];
        }

        $rating = null;
        if (isset($modeStats['last']['rating'])) {
            $rating = (int) $modeStats['last']['rating'];
        } elseif (isset($modeStats['best']['rating'])) {
            $rating = (int) $modeStats['best']['rating'];
        }

        return [
            'avatar' => is_string($avatar) ? $avatar : null,
            'username' => $displayName,
            'ratingLabel' => $rating !== null && $rating > 0 ? (string) $rating : 'Unrated',
            'countryCode' => $countryCode,
        ];
    }

    private function extractCountryCode(mixed $profile): ?string
    {
        if (!is_array($profile) || !isset($profile['country']) || !is_string($profile['country'])) {
            return null;
        }

        $countryUrl = trim($profile['country']);
        if ($countryUrl === '') {
            return null;
        }

        $countryCode = strtoupper((string) basename($countryUrl));
        if (!preg_match('/^[A-Z]{2}$/', $countryCode)) {
            return null;
        }

        return $countryCode;
    }

    private function fetchJson(string $url): ?array
    {
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'timeout' => $this->timeoutSeconds,
                'ignore_errors' => true,
                'header' => "User-Agent: chess-stats-card-badge/1.0\r\nAccept: application/json\r\n",
            ],
        ]);

        $response = @file_get_contents($url, false, $context);
        if ($response === false) {
            return null;
        }

        $statusCode = 0;
        if (isset($http_response_header[0]) && preg_match('/\s(\d{3})\s/', $http_response_header[0], $m)) {
            $statusCode = (int) $m[1];
        }
        if ($statusCode >= 400) {
            return null;
        }

        $json = json_decode($response, true);
        return is_array($json) ? $json : null;
    }
}
