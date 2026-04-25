
## Overview

brand colors:
#73AA4A
#404040
#FFFFFF

Chess Stats Card is a public badge-as-a-service that allows users to display their Chess.com ratings dynamically inside GitHub READMEs or any markdown-supported environment.

The service fetches data from the Chess.com public API, processes it, and returns a visually appealing SVG card inspired by Duolingo-style stat cards.

---

## Features

- Dynamic Chess.com rating badges
- Support for multiple game modes:
    - Rapid
    - Blitz
    - Bullet
- Customizable card themes (colors)
- Clean, modern UI (Duolingo-inspired)
- SVG-based rendering (lightweight and scalable)
- Public API for community usage
- Cache layer for performance and rate-limit protection

---

## Example Usage


```md
![Chess.com Rating](https://chess-stats-card.vercel.app/pub/player/alyson_waly/stats/rapid/blue)
![Chess.com Rating](https://chess-stats-card.vercel.app/pub/player/alyson_waly/stats/bullet/red)
![Chess.com Rating](https://chess-stats-card.vercel.app/pub/player/alyson_waly/stats/blitz/dark)
```

---

### Endpoint

```
GET /pub/player/{username}/stats/{mode}/{theme}
```


---

## Response

### Content-Type

```
image/svg+xml
```

### Example Output

The response is an SVG card containing:

- Player avatar
- Username
- Rating value
- Game mode

---

## Visual Design

Inspired by Duolingo cards:

- Rounded corners
- Gradient background
- Clear hierarchy of information

---

## Data Source

Data is fetched from:

```
https://api.chess.com/pub/player/{username}
https://api.chess.com/pub/player/{username}/stats
```

### Extracted Fields

- "avatar": {image} //from https://api.chess.com/pub/player/{username}
- "chess_rapid":{"best"{"rating": xxx}} //from https://api.chess.com/pub/player/{username}/stats
- "chess_bullet":{"best"{"rating": xxxx}} // from https://api.chess.com/pub/player/{username}/stats
- "chess_blitz":{"best"{"rating": xxx}} // from https://api.chess.com/pub/player/{username}/stats

---

## Caching Strategy


### Cache Layer
ensure performance and avoid API rate limits:

- Redis (recommended)
- Fallback: file-based cache

### Cache Key

```
chess:{username}:{mode}
```

### TTL

- Default: 10 minutes

---

## Request Flow

1. Client requests badge
2. Validate parameters
3. Check cache
4. If cache miss → call Chess.com API
5. Extract rating data
6. Store in cache
7. Generate SVG
8. Return response

---

## Error Handling

The API always returns a valid SVG.

### Fallback States

| Scenario        | Output          |
| --------------- | --------------- |
| User not found  | Rating: N/A     |
| API failure     | Rating: N/A     |
| No games played | Rating: Unrated |

---

## HTTP Headers

```
Content-Type: image/svg+xml
Cache-Control: public, max-age=300
```

---

## Rate Limiting

To prevent abuse:

- Per-IP request limiting
- Optional global throttling

---

## Security Considerations

- Input sanitization (username)
- Prevent long/invalid queries
- No external URL fetching (avoid SSRF)

---

## Tech Stack

### Backend

- PHP (Core service)
- Optional: Laravel

### Badge construction figma dowloaded files
- Typescrypt
- Css
- html

### Infrastructure

- Redis (cache)
- CDN (Cloudflare recommended)

---

## Summary

Chess Stats Card provides a scalable and customizable way to showcase Chess.com ratings visually, with a focus on performance, simplicity, and developer-friendly integration.