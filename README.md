# matthieu-viel.fr

Professional showcase website for Matthieu Viel, senior web technical consultant based in La Réunion.

## Structure

```
matthieu-viel.fr/
├── index.html              ← Main page (non-tech SMEs)
├── tech.html               ← CTO/tech page (placeholder)
├── portfolio.html          ← Detailed portfolio (placeholder)
├── sitemap.xml
├── assets/
│   ├── css/
│   │   ├── main.css        → Reset, variables, layout, nav, hero, footer
│   │   ├── components.css  → Buttons, cards, steps, testimonials, contact form
│   │   └── responsive.css  → Media queries (1024 / 768 / 480px)
│   ├── js/
│   │   └── main.js         → Burger menu, active scroll, fade-up animations
│   └── images/             → portrait.jpg, hero-banner.jpg, cta-quiz.jpg, favicon.svg
├── .github/
│   └── workflows/
│       └── deploy.yml      → HTML validation + tests + FTP deployment to Gandi
├── tests/
│   └── links.test.js       → Native Node.js tests (critical tags, images, alt attributes)
└── seed/                   → Source assets (excluded from FTP deployment)
```

## Running tests locally

```bash
node tests/links.test.js
```

No NPM dependencies — Node.js alone is sufficient.

## Deployment

The CI/CD pipeline (GitHub Actions) triggers on every push to `main`:

1. HTML validation (`html-validate`)
2. Node.js tests
3. FTP deployment to the Gandi shared server

### Configuring GitHub secrets

In the repo → **Settings → Secrets and variables → Actions**, add:

| Secret         | Value                                              |
|----------------|----------------------------------------------------|
| `FTP_SERVER`   | FTP host                                           |
| `FTP_USERNAME` | FTP username                                       |
| `FTP_PASSWORD` | FTP password                                       |
| `FTP_PATH`     | Target path on the server (e.g. `/www/matthieu-viel`) |

## Remaining TODOs

- [ ] **Performance test link** — replace `href="#"` in the hero CTA (index.html:82)
- [ ] **web3forms** — configure the contact form `action` and add `access_key`
      See: https://web3forms.com
- [ ] **Legal notice** — create `mentions-legales.html` and wire up the footer link
- [ ] **Logo** — replace the "MV" SVG favicon with a real logo if available
- [ ] **tech.html** — develop the technical / CTO as a service page
- [ ] **portfolio.html** — develop the detailed portfolio page
- [ ] **GitHub repo name** — to confirm so that README links are accurate
