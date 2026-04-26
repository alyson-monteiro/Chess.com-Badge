# Chess.com Badge API

Gere um card animado com seu rating do Chess.com para colocar no GitHub, portfólio ou site pessoal.

## Para que serve

Com esta API, voce cria uma imagem SVG com:

- seu nome de usuario;
- seu rating (`rapid`, `blitz` ou `bullet`);
- tema claro ou escuro: (`black` ou `white`);

https://chesscom-badge-production.up.railway.app/pub/player/SEU_USUARIO/stats/RITMO/TEMA

Exemplos:

```text
https://chesscom-badge-production.up.railway.app/pub/player/alyson_waly/stats/rapid/black

https://chesscom-badge-production.up.railway.app/pub/player/lpsupi/stats/blitz/white

https://chesscom-badge-production.up.railway.app/pub/player/magnuscarlsen/stats/bullet/black
```

## Parametros disponiveis

- `username`: seu usuario no Chess.com
- `mode`: `rapid`, `blitz`, `bullet`
- `theme`: `white` ou `black`


## Colocando no README do GitHub

Use a URL da API dentro de uma tag de imagem:

```md
![Chess](https://chesscom-badge-production.up.railway.app/pub/player/alyson_waly/stats/rapid/black)
```

## Quando algo nao estiver disponivel

- Se o usuario nao existir ou der erro de consulta: aparece `N/A`
- Se nao houver rating no modo escolhido: aparece `Unrated`