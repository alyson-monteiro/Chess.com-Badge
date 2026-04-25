<?php

declare(strict_types=1);

final class Validator
{
    /** @var array<string, string> */
    private const MODE_MAP = [
        'rapid' => 'chess_rapid',
        'blitz' => 'chess_blitz',
        'bullet' => 'chess_bullet',
    ];

    /** @var string[] */
    private const THEMES = ['white', 'black'];

    public static function normalizeUsername(string $username): ?string
    {
        $username = trim($username);
        if ($username === '' || strlen($username) > 25) {
            return null;
        }

        if (!preg_match('/^[A-Za-z0-9_-]{1,25}$/', $username)) {
            return null;
        }

        return strtolower($username);
    }

    public static function normalizeMode(string $mode): ?string
    {
        $mode = strtolower(trim($mode));
        return array_key_exists($mode, self::MODE_MAP) ? $mode : null;
    }

    public static function modeStatsKey(string $mode): string
    {
        return self::MODE_MAP[$mode];
    }

    public static function normalizeTheme(string $theme): ?string
    {
        $theme = strtolower(trim($theme));
        return in_array($theme, self::THEMES, true) ? $theme : null;
    }
}
