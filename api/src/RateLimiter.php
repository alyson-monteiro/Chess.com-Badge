<?php

declare(strict_types=1);

final class RateLimiter
{
    private int $retryAfterSeconds = 0;

    public function __construct(
        private readonly string $directory,
        private readonly int $limitPerWindow = 60,
        private readonly int $windowSeconds = 60
    ) {
        if (!is_dir($this->directory)) {
            mkdir($this->directory, 0777, true);
        }
    }

    public function allow(string $ip): bool
    {
        $path = $this->directory . DIRECTORY_SEPARATOR . sha1($ip) . '.json';
        $now = time();
        $payload = ['start' => $now, 'count' => 0];

        if (is_file($path)) {
            $raw = file_get_contents($path);
            $saved = is_string($raw) ? json_decode($raw, true) : null;
            if (is_array($saved) && isset($saved['start'], $saved['count'])) {
                $payload = [
                    'start' => (int) $saved['start'],
                    'count' => (int) $saved['count'],
                ];
            }
        }

        if (($now - $payload['start']) >= $this->windowSeconds) {
            $payload = ['start' => $now, 'count' => 0];
        }

        $payload['count']++;
        file_put_contents($path, json_encode($payload));

        if ($payload['count'] > $this->limitPerWindow) {
            $this->retryAfterSeconds = max(1, $this->windowSeconds - ($now - $payload['start']));
            return false;
        }

        return true;
    }

    public function retryAfterSeconds(): int
    {
        return $this->retryAfterSeconds;
    }
}
