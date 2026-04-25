<?php

declare(strict_types=1);

final class SvgRenderer
{
    /** @var array<string, array{bg: string, fg: string, muted: string, accent: string}> 
     * #73AA4A
     * #404040
     * #FFFFFF
     * #666666
     * #E6E6E6
     * bg: background color
     * fg: foreground color
     * muted: muted color
     * accent: accent color
    */
    private const THEMES = [
        'white' => ['bg' => '#FFFFFF', 'fg' => '#404040', 'muted' => '#666666', 'accent' => '#73AA4A', 'nameColor' => '#73AA4A'],
        'black' => ['bg' => '#404040', 'fg' => '#FFFFFF', 'muted' => '#E6E6E6', 'accent' => '#73AA4A', 'nameColor' => '#73AA4A'],
    ];

    /** @param array{avatar: ?string, username: string, ratingLabel: string} $data */
    public function render(array $data, string $mode, string $theme): string
    {
        $colors = self::THEMES[$theme] ?? self::THEMES['white'];
        $username = $this->escape($data['username']);
        $ratingLabel = $this->escape($data['ratingLabel']);
        $modeLabel = strtoupper($this->escape($mode));
        $logoHref = $this->themeLogoHref($theme);
        $modeIcon = $this->modeIconPath($mode);

        $avatarBlock = $this->buildAvatarBlock($data['avatar']);

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="230" height="230" viewBox="0 0 230 230" role="img" aria-label="Chess.com {$modeLabel} rating">
  <defs>
    <clipPath id="avatarClip">
      <rect x="75" y="44" width="80" height="80" rx="14" ry="14"/>
    </clipPath>
  </defs>
  <rect width="230" height="230" rx="24" fill="{$colors['bg']}"/>
  <rect x="1.5" y="1.5" width="227" height="227" rx="22.5" fill="none" stroke="{$colors['accent']}" stroke-opacity="0.18" stroke-width="1"/>
  <image href="{$logoHref}" x="12" y="11" width="84" height="22" preserveAspectRatio="xMinYMid meet"/>
  <g transform="translate(188,14) scale(1)">
    <path d="{$modeIcon}" fill="{$colors['accent']}"/> <!-- tirar o modeIcon e colocar a bandeira do pais -->
  </g>
  {$avatarBlock}
  <text x="115" y="141" text-anchor="middle" fill="{$colors['nameColor']}" font-size="15" font-weight="700" font-family="Arial, Helvetica, sans-serif">{$username}</text>
  <text x="115" y="164" text-anchor="middle" fill="{$colors['fg']}" font-size="13" font-weight="700" font-family="Arial, Helvetica, sans-serif">highest rating:</text>
  <text x="115" y="192" text-anchor="middle" fill="{$colors['fg']}" font-size="30" font-weight="700" font-family="Arial, Helvetica, sans-serif">{$ratingLabel}</text>
  <g transform="translate(55,170) scale(1)"><path d="{$modeIcon}" fill="{$colors['accent']}"/></g>
  <text x="115" y="214" text-anchor="middle" fill="{$colors['muted']}" font-size="11" font-weight="600" letter-spacing="1.2" font-family="Arial, Helvetica, sans-serif">{$modeLabel}</text>
</svg>
SVG;
    }

    private function buildAvatarBlock(?string $avatarUrl): string
    {
        if ($avatarUrl === null || !filter_var($avatarUrl, FILTER_VALIDATE_URL)) {
            return '<rect x="75" y="44" width="80" height="80" rx="14" fill="#D9D9D9"/><text x="115" y="89" text-anchor="middle" fill="#6D6D6D" fill-opacity="0.95" font-size="12" font-family="Arial, Helvetica, sans-serif">NO AVATAR</text>';
        }

        $safeUrl = $this->escape($avatarUrl);
        return '<rect x="75" y="44" width="80" height="80" rx="14" fill="#D9D9D9"/><image href="' . $safeUrl . '" x="75" y="44" width="80" height="80" preserveAspectRatio="xMidYMid slice" clip-path="url(#avatarClip)"/>';
    }

    private function modeIconPath(string $mode): string
    {
        return match (strtolower($mode)) {
            'rapid' => 'M11.97 14.63C11.07 14.63 10.1 13.9 10.47 12.4L11.5 8H12.5L13.53 12.37C13.9 13.9 12.9 14.64 11.96 14.64L11.97 14.63ZM12 22.5C6.77 22.5 2.5 18.23 2.5 13C2.5 7.77 6.77 3.5 12 3.5C17.23 3.5 21.5 7.77 21.5 13C21.5 18.23 17.23 22.5 12 22.5ZM12 19.5C16 19.5 18.5 17 18.5 13C18.5 9 16 6.5 12 6.5C8 6.5 5.5 9 5.5 13C5.5 17 8 19.5 12 19.5ZM10.5 5.23V1H13.5V5.23H10.5ZM15.5 2H8.5C8.5 0.3 8.93 0 12 0C15.07 0 15.5 0.3 15.5 2Z',
            'bullet' => 'M7.17005 15.2999L8.60005 16.7699L0.330049 23.6699L7.17005 15.2999ZM0.300049 17.5999L4.80005 11.5999L5.70005 13.5999L0.300049 17.5999ZM10.77 10.0999C14.24 6.49994 16.7 4.89994 19.47 3.69994C17.07 3.69994 14.17 4.06994 9.67005 8.29994C9.70005 8.79994 10.37 9.76994 10.77 10.0999ZM21.83 2.16994C21.83 2.16994 22.06 3.26994 22.06 4.93994C22.06 7.60994 21.39 11.7699 17.89 15.2699L15.72 17.4399C15.05 18.1099 14.39 18.0399 13.59 17.7099L6.12005 24.0099L15.92 11.8399L10.69 15.8699C10.26 15.4699 9.76005 15.0399 9.36005 14.6399C7.63005 12.9399 5.23005 9.63994 6.59005 8.26994L8.79005 6.13994C12.32 2.63994 16.42 1.93994 19.09 1.93994C20.72 1.93994 21.82 2.16994 21.82 2.16994H21.83Z',
            default => 'M5.77002 15C4.74002 15 4.40002 14.6 4.57002 13.6L6.10002 3.4C6.27002 2.4 6.73002 2 7.77002 2H13.57C14.6 2 14.9 2.4 14.64 3.37L11.41 15H5.77002ZM18.83 9C19.86 9 20.03 9.33 19.4 10.13L9.73002 22.86C8.50002 24.49 8.13002 24.33 8.46002 22.29L10.66 8.99L18.83 9Z',
        };
    }

    private function themeLogoHref(string $theme): string
    {
        $root = dirname(__DIR__, 2);
        $file = $theme === 'black'
            ? $root . '/src/assets/white_logo.png'
            : $root . '/src/assets/black_logo.png';

        if (!is_file($file)) {
            return '';
        }

        $contents = file_get_contents($file);
        if (!is_string($contents)) {
            return '';
        }

        return 'data:image/png;base64,' . base64_encode($contents);
    }

    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }
}
