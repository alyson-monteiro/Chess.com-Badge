<?php

declare(strict_types=1);

final class FileCache
{
    public function __construct(private readonly string $directory)
    {
        if (!is_dir($this->directory)) {
            mkdir($this->directory, 0777, true);
        }
    }

    public function get(string $key): mixed
    {
        $path = $this->pathFor($key);
        if (!is_file($path)) {
            return null;
        }

        $raw = file_get_contents($path);
        if ($raw === false) {
            return null;
        }

        $payload = json_decode($raw, true);
        if (!is_array($payload) || !isset($payload['expires_at'])) {
            @unlink($path);
            return null;
        }

        if ((int) $payload['expires_at'] < time()) {
            @unlink($path);
            return null;
        }

        return $payload['value'] ?? null;
    }

    public function set(string $key, mixed $value, int $ttlSeconds): void
    {
        $payload = [
            'expires_at' => time() + $ttlSeconds,
            'value' => $value,
        ];

        file_put_contents($this->pathFor($key), json_encode($payload, JSON_UNESCAPED_SLASHES));
    }

    private function pathFor(string $key): string
    {
        return $this->directory . DIRECTORY_SEPARATOR . sha1($key) . '.json';
    }
}
