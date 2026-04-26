# Chess.com Badge API

Gere um card animado com seu rating do Chess.com para colocar no GitHub, portfólio ou site pessoal.

## Para que serve

Com esta API, voce cria uma imagem SVG com:

- seu nome de usuario;
- seu rating (`rapid`, `blitz` ou `bullet`);
- tema claro ou escuro;
- visual pronto para usar em perfil.

## Como usar em 1 minuto

### 1) Rode a API localmente

Na pasta do projeto, execute:

```bash
php -S 127.0.0.1:8000 -t api api/index.php
```

### 2) Monte sua URL

Formato:

```text
http://127.0.0.1:8000/pub/player/{username}/stats/{mode}/{theme}
```

Exemplo real:

```text
http://127.0.0.1:8000/pub/player/erik/stats/rapid/white
```

## Parametros disponiveis

- `username`: seu usuario no Chess.com
- `mode`: `rapid`, `blitz`, `bullet`
- `theme`: `white` ou `black`

Exemplos:

```text
/pub/player/hikaru/stats/blitz/black
/pub/player/magnuscarlsen/stats/bullet/white
```

## Colocando no README do GitHub

Use a URL da API dentro de uma tag de imagem:

```md
![Meu rating Chess.com](http://127.0.0.1:8000/pub/player/SEU_USUARIO/stats/rapid/white)
```

Se voce publicar essa API online, troque `127.0.0.1` pela URL publica do seu servidor.

## Quando algo nao estiver disponivel

- Se o usuario nao existir ou der erro de consulta: aparece `N/A`
- Se nao houver rating no modo escolhido: aparece `Unrated`

## Configuracoes opcionais

Se quiser, voce pode ajustar:

- `CACHE_TTL` (tempo de cache)
- `CHESS_TIMEOUT` (tempo limite de consulta)
- `RATE_LIMIT_PER_MINUTE` (limite de requisicoes por minuto)

Exemplo no PowerShell:

```powershell
$env:CACHE_TTL = "900"
$env:CHESS_TIMEOUT = "6"
$env:RATE_LIMIT_PER_MINUTE = "120"
php -S 127.0.0.1:8000 -t api api/index.php
```

## Dica final

Para mostrar no seu perfil do GitHub, o ideal e:

1. subir esta API em um host (VPS, Render, Railway etc.);
2. usar a URL publica no seu `README.md`;
3. escolher o modo (`rapid`, `blitz` ou `bullet`) que voce mais joga.