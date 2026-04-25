
# chess badge


This repository contains:
- A frontend card prototype exported from Figma.
- A PHP backend that serves dynamic Chess.com SVG badges.

Original Figma project: https://www.figma.com/design/lI6lv1ZDzqVbcncIPgZS1P/chess-badge

## Frontend (prototype)

Install and run:

```bash
npm i
npm run dev
```

## Backend (PHP badge API)

Start local API server (from repository root):

```bash
php -S 127.0.0.1:8000 -t api api/index.php
```

Endpoint format:

```text
GET /pub/player/{username}/stats/{mode}/{theme}
```

Example:

```text
http://127.0.0.1:8000/pub/player/erik/stats/rapid/white
```

Supported values:
- `mode`: `rapid`, `blitz`, `bullet`
- `theme`: `white`, `black`

Response headers:
- `Content-Type: image/svg+xml; charset=UTF-8`
- `Cache-Control: public, max-age=300`

Fallback behavior:
- Invalid user or upstream error -> `N/A`
- No games in selected mode -> `Unrated`

## Optional environment variables

- `CACHE_TTL` (seconds, default `600`)
- `CHESS_TIMEOUT` (seconds, default `5`)
- `RATE_LIMIT_PER_MINUTE` (default `60`)
  