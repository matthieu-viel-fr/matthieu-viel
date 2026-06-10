# matthieu-viel.fr

Professional showcase website for Matthieu Viel, senior web technical consultant based in La Réunion.

Static HTML generated from Twig templates via a PHP export script. No framework. No runtime PHP on the server.

---

## How it works

```
src/templates/      ← Twig source templates
       ↓
src/export.php      ← renders every template with the right locale + variables
       ↓
dist/               ← static HTML output (committed, deployed by CI)
       ↓
FTP (Nuxit)         ← only dist/ is uploaded
```

Local dev uses Docker + the PHP built-in server with `src/router.php` to serve templates dynamically — same render logic as export, no need to re-export on every change.

---

## Directory structure

```
/
├── assets/                 ← CSS / JS / images — served as-is, unchanged
│   ├── css/
│   │   ├── main.css        ← reset, variables, layout, nav, hero, footer
│   │   ├── components.css  ← buttons, cards, steps, testimonials
│   │   └── responsive.css  ← media queries (1024 / 768 / 480px)
│   ├── js/main.js          ← burger menu, scroll, fade-up animations
│   └── images/
├── dist/                   ← generated HTML (do not edit by hand)
│   ├── index.html
│   ├── portfolio.html
│   ├── ...
│   ├── audit/index.html
│   └── en/
│       ├── index.html
│       └── ...
├── src/
│   ├── templates/
│   │   ├── base.html.twig              ← shared head, nav, footer, scripts
│   │   ├── index.html.twig
│   │   ├── portfolio.html.twig
│   │   ├── site-web-14-jours.html.twig
│   │   ├── senior-tech.html.twig
│   │   ├── tech.html.twig
│   │   ├── mentions-legales.html.twig
│   │   ├── quiz.html.twig
│   │   ├── audit/index.html.twig
│   │   └── en/
│   │       ├── index.html.twig
│   │       ├── portfolio.html.twig
│   │       ├── website-14-days.html.twig
│   │       └── legal-notice.html.twig
│   ├── translations/
│   │   ├── messages.fr.yaml            ← nav, footer, shared UI strings (FR)
│   │   └── messages.en.yaml            ← nav, footer, shared UI strings (EN)
│   ├── bootstrap.php                   ← wires Twig + Translation, exports createTwig()
│   ├── router.php                      ← dev server entry point (URL → template)
│   ├── export.php                      ← generates all pages into dist/
│   ├── composer.json
│   ├── composer.lock                   ← committed — CI uses this exact version set
│   └── Dockerfile                      ← php:8-cli + Composer
├── tests/
│   └── links.test.js                   ← Node.js tests (no deps): critical tags, images, alt
├── seed/                               ← editorial reference (tone, palette, vocabulary)
├── docker-compose.yml
├── Makefile                            ← developer shortcuts
├── .github/workflows/deploy.yml        ← CI: validate → export → FTP deploy
└── CLAUDE.md                           ← AI assistant rules (content, SEO, a11y, perf)
```

---

## Local development

### Prerequisites
- Docker Desktop (or Docker Engine + Compose)
- Make (optional but convenient)

### Start the dev server

```bash
make dev       # build image + start container + composer install
# → http://localhost:8080
```

Or without Make:
```bash
docker compose up --build
```

`composer install` runs automatically on container start. `src/vendor/` is created inside the container and gitignored.

### Make targets

```bash
make up        # start without rebuilding the image
make down      # stop container
make shell     # open a shell inside the container
make logs      # follow container logs
make export    # run export.php → regenerates dist/
make clean     # delete dist/*.html (keeps assets)
```

### Manual export (without Make)

```bash
docker compose exec web php export.php
```

---

## Running tests

```bash
node tests/links.test.js
npx html-validate 'dist/*.html' 'dist/en/*.html'
```

Run `make export` first — tests read from `dist/`.

---

## CI/CD pipeline

Triggers on push or PR to `main`.

### `validate` job
1. Checkout
2. Setup Node.js 24
3. Setup PHP 8.3
4. `composer install --working-dir=src`
5. `php src/export.php` — generates `dist/`
6. `html-validate 'dist/*.html' 'dist/en/*.html'`
7. `node tests/links.test.js`

### `deploy` job (push to `main` only, runs after `validate`)
1. Checkout
2. Setup PHP 8.3 + Composer install + export (regenerates `dist/` in CI runner)
3. FTP upload of `dist/` to Nuxit via `SamKirkland/FTP-Deploy-Action@4.3.0`

### GitHub secrets required

| Secret | Value |
|---|---|
| `FTP_SERVER` | FTP host |
| `FTP_USERNAME` | FTP username |
| `FTP_PASSWORD` | FTP password |
| `FTP_PATH` | Target path on server (e.g. `/www/matthieu-viel`) |

---

## PHP packages (Composer)

| Package | Role |
|---|---|
| `twig/twig ^3` | Templating engine |
| `symfony/translation ^7` | i18n (`\|trans` filter) |
| `symfony/twig-bridge ^7` | Connects Translation to Twig |
| `symfony/yaml ^7` | Parses `.yaml` translation files |

No Symfony framework. No database. No ORM.

---

## Template variables

Every template receives these variables from `router.php` and `export.php`:

| Variable | Type | Example | Purpose |
|---|---|---|---|
| `locale` | string | `'fr'` / `'en'` | `<html lang>`, passed to `createTwig()` |
| `current_page` | string | `'portfolio'` | Adds `class="is-active"` on the nav link |
| `asset_base` | string | `''` / `'../'` | Prefix for `assets/` paths in subfolders |
| `lang_fr_url` | string | `'../index.html'` | Href for the FR language switcher |
| `lang_en_url` | string | `'index.html'` | Href for the EN language switcher |

`asset_base` is `''` for root pages and `'../'` for `audit/` and `en/` subfolders.

---

## i18n

Only shared UI strings are in YAML (nav labels, footer, aria-labels, lang switcher). Page-specific content is hardcoded in each template.

Translation files: `src/translations/messages.fr.yaml` and `messages.en.yaml`.

Usage in templates:
```twig
{{ 'nav.portfolio'|trans }}
{{ 'footer.tagline'|trans }}
```

---

## Twig block structure (`base.html.twig`)

```
{% block lang %}          ← 'fr' or 'en', used on <html lang="...">
{% block title %}         ← page <title>
{% block meta_description %}
{% block og %}            ← Open Graph tags
{% block canonical %}     ← canonical + hreflang pair
{% block schema_ld %}     ← JSON-LD (varies per page)
{% block body %}          ← main page content (everything between nav and footer)
```

Nav and footer are hardcoded in `base.html.twig` — identical on every page.

---

## Adding a new page

1. Create `src/templates/my-page.html.twig` extending `base.html.twig`
2. Add a route in `src/router.php` (for local dev)
3. Add an entry in `src/export.php` (for static export)
4. Add the output path to `tests/links.test.js` if it should be checked
5. Run `make export` and test locally

For an EN version, also create `src/templates/en/my-page.html.twig` and add both routes (FR + EN) to `router.php` and `export.php`.

---

## Key constraints

- Images: WebP only, always `width`/`height` + `loading="lazy"` outside viewport
- No JS framework, no new npm dependency without approval
- `<title>` 55–60 chars, `<meta description>` 150–160 chars, single `<h1>` per page
- JSON-LD (`Person` + `LocalBusiness`) on the home page
- Tone and vocabulary governed by `seed/` — read it before any content change
- No em dashes anywhere on the site
