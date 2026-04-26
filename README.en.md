🌎 Language: **English** | [Português](README.md)

# Chess.com Badge API

Generate an animated card with your Chess.com rating to use on GitHub, your portfolio, or personal website.

## Overview

With this API, you can generate an SVG image with:

- your username;
- your rating (`rapid`, `blitz`, or `bullet`);
- light or dark theme (`black` or `white`);

## Endpoint
https://chesscom-badge-production.up.railway.app/pub/player/YOUR_USERNAME/stats/MODE/THEME

Examples:

```text
https://chesscom-badge-production.up.railway.app/pub/player/alyson_waly/stats/rapid/black

https://chesscom-badge-production.up.railway.app/pub/player/lpsupi/stats/blitz/white

https://chesscom-badge-production.up.railway.app/pub/player/magnuscarlsen/stats/bullet/black

https://chesscom-badge-production.up.railway.app/pub/player/GMKrikor/stats/rapid/black
```
![Chess](https://chesscom-badge-production.up.railway.app/pub/player/alyson_waly/stats/rapid/black)
![Chess](https://chesscom-badge-production.up.railway.app/pub/player/lpsupi/stats/blitz/white)
![Chess](https://chesscom-badge-production.up.railway.app/pub/player/magnuscarlsen/stats/bullet/black)
![Chess](https://chesscom-badge-production.up.railway.app/pub/player/GMKrikor/stats/rapid/white)

## Available Parameters

- `username`: your Chess.com username
- `mode`: `rapid`, `blitz`, `bullet`
- `theme`: `white` or `black`

## Adding It to Your GitHub README

Use the API URL inside an image tag:

```md
![Chess](https://chesscom-badge-production.up.railway.app/pub/player/alyson_waly/stats/rapid/black)
```

## When Something Is Not Available

- If the user does not exist or the API request fails: it shows `N/A`
- If there is no rating for the selected mode: it shows `Unrated`

📄 License

This project is licensed under the MIT License — feel free to use, modify, and distribute it as you wish.