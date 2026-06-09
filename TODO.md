# TODO — matthieu-viel.fr

This file captures the current improvement backlog for the personal website.
It is written so future Codex/Claude sessions can continue without redoing the
full project analysis.

## Context

- Static personal website for Matthieu Viel, senior web technical consultant in La Reunion.
- No framework and no build system today: hand-authored HTML/CSS/JS.
- Main positioning: help SME leaders whose digital tools are starting to show limits.
- Strong proof points to preserve: 17 years experience, Citeo, Sellermania, 500+ Cypress scenarios, 70% test coverage, Saint-Pierre 974, ECP Formation, UTOI 117 km.
- Tone reference: `seed/presentation_matthieu.txt`.
- Project rules: `CLAUDE.md`.

## Done

### Remove AI-generated em dashes — all pages ✓

All "—" (em dash) symbols removed from the entire site and replaced with contextually appropriate punctuation:
- `:` where the dash introduced an explanation or clarification
- `,` where the dash connected two clauses or expressed contrast
- `.` where the dash separated two independent sentences
- `·` for visual list bullets (FAQ pricing/timeline lists)

Affected files: `index.html`, `en/index.html`, `site-web-14-jours.html`, `en/website-14-days.html`, `portfolio.html`, `en/portfolio.html`, `quiz.html`, all `audit/` and `en/audit/` pages.

### Remove `<em>` tags from hero titles ✓

`<em>` tags in `site-web-14-jours.html` and `en/website-14-days.html` replaced with `<span class="hero__title-highlight">`. CSS rule updated from `.hero__title em` to `.hero__title-highlight`.

## Priority 0 — Safety And Production Hygiene

### 4. Remove or justify all remaining `href="#"`

Current issue:
- `index.html` and `en/index.html` legal links use `href="#"` with `data-todo`.
- `quiz.html` has `href="#"` for the result CTA before JS sets it.

Files likely involved:
- `index.html`
- `en/index.html`
- `quiz.html`
- `tests/links.test.js`

Acceptance checks:
- Search for `href="#"` returns no unintended result.
- Dynamic quiz CTA starts with the real Calendly URL or is rendered as a disabled/non-link element until populated.
- Test suite fails on bare `href="#"` across all HTML files, not only `index.html`.

## Priority 1 — Test And CI Hardening

### 5. Make CI validate every HTML page

Current issue:
- `.github/workflows/deploy.yml` runs `npx --yes html-validate *.html`, which only validates top-level HTML files.
- Nested pages under `audit/` and `en/audit/` are not validated by CI.

Files likely involved:
- `.github/workflows/deploy.yml`
- `package.json`

Acceptance checks:
- CI validates all `*.html` files except `node_modules`.
- Use the same command locally and in CI, ideally `npm test`.
- Pull requests fail on invalid nested audit pages.

### 6. Expand `tests/links.test.js` to all pages

Current issue:
- The custom test currently checks mainly `index.html`, `tech.html`, and `portfolio.html`.
- Most audit and English pages can regress silently.

Files likely involved:
- `tests/links.test.js`

Acceptance checks:
- Test discovers HTML files recursively, excluding `node_modules`.
- Checks every page for:
  - exactly one `<h1>`
  - `<title>`
  - meta description
  - canonical link
  - missing local image/script/stylesheet assets
  - missing `alt` on `<img>`
  - unintended `href="#"`
  - external links using `target="_blank"` also using `rel="noopener noreferrer"`
- Tests produce clear file-specific errors.

### 7. Add SEO metadata length checks

Current issue:
- `CLAUDE.md` requires title length 55-60 chars and meta description 150-160 chars on modified pages.
- Existing pages do not consistently follow that rule.

Files likely involved:
- `tests/links.test.js`
- Possibly HTML pages after failures are revealed

Acceptance checks:
- Test reports title and description lengths by page.
- Decide whether to enforce strict failure or warning first.
- Align the rule with real SEO practice if needed; 55-60 and 150-160 may be too rigid.

### 8. Add sitemap consistency test

Current issue:
- Many pages exist, and `sitemap.xml` must stay aligned manually.

Files likely involved:
- `sitemap.xml`
- `tests/links.test.js`

Acceptance checks:
- Every public HTML page appears in `sitemap.xml`.
- No sitemap URL points to a missing local page.
- `noindex` pages such as `tech.html` are intentionally excluded or clearly documented.

## Priority 2 — Performance And Asset Cleanup

### 9. Convert raster assets to WebP or AVIF

Current issue:
- `CLAUDE.md` says WebP-only images.
- Current images are JPG:
  - `portrait.jpg`
  - `site-mockup.jpg`
  - `hero-banner.jpg`
  - `cta-quiz.jpg`

Files likely involved:
- `assets/images/`
- All HTML files referencing `.jpg`
- Possibly `sitemap.xml` or OG tags

Acceptance checks:
- In-page images use WebP or AVIF.
- `width` and `height` remain present.
- Images outside the initial viewport use `loading="lazy"`.
- OG images remain valid and preferably use a social-friendly 1200x630 asset.
- Search for `.jpg` in HTML is either empty or limited to intentional OG fallbacks.

### 10. Avoid render-blocking Google Fonts import

Current issue:
- `assets/css/main.css` imports Inter with `@import`, which is render-blocking and slower.
- `quiz.html` separately imports Montserrat.

Files likely involved:
- `assets/css/main.css`
- All HTML heads
- `quiz.html`

Acceptance checks:
- Fonts are loaded with `<link rel="preconnect">` and `<link rel="stylesheet">`, or replaced by system fonts.
- Avoid duplicate font strategies unless the quiz intentionally has a separate identity.
- Check the visual result on home, portfolio, audit page, and quiz.

### 11. Add cache/compression rules if server supports them

Current issue:
- `.htaccess` only handles HTTPS and www redirects.
- Static assets may benefit from cache headers and compression.

Files likely involved:
- `.htaccess`

Acceptance checks:
- CSS, JS, images, and fonts receive appropriate cache headers.
- HTML remains short-cache or no-cache as appropriate.
- Rules are compatible with the hosting provider.

## Priority 3 — Maintainability

### 12. Decide whether to introduce a tiny static generation step

Current issue:
- Navigation, language switchers, footers, Calendly links, and social links are duplicated across many pages.
- This is manageable now but fragile.

Candidate approaches:
- Keep pure static HTML and accept duplication.
- Add a minimal Node script to inject shared partials.
- Use Eleventy if a small build step is acceptable.

Acceptance checks:
- If no build step is added, document the duplication and update checklist.
- If a build step is added:
  - Source files remain simple.
  - Output remains static.
  - CI builds and tests generated files.
  - Deployment excludes source-only files if needed.

### 13. Centralize repeated constants

Current issue:
- Calendly URL, LinkedIn URL, Malt URL, site name, and footer metadata appear in many files.

Acceptance checks:
- Future updates to core contact links require one edit or a documented search checklist.
- Tests catch inconsistent Calendly URLs if centralization is not implemented.

### 14. Split or document `quiz.html`

Current issue:
- `quiz.html` is a large standalone file with inline CSS and JS.
- It is harder to test and maintain than the rest of the site.

Candidate approaches:
- Keep it standalone but add clear section comments and tests.
- Extract CSS to `assets/css/quiz.css` and JS to `assets/js/quiz.js`.

Acceptance checks:
- Quiz behavior remains unchanged.
- No regressions on mobile viewport.
- Quiz form submission, result rendering, and Calendly CTA are covered by at least lightweight tests.

## Priority 4 — Content And Conversion

### 15. Finish or remove `tech.html`

Current issue:
- `tech.html` is a noindex placeholder.
- It is linked from the home footer as "Version tech".

Files likely involved:
- `tech.html`
- `index.html`
- Other footer copies if present

Acceptance checks:
- Either build the page properly or remove links to it.
- If built, page should target technical decision-makers: CTO, lead dev, founders with technical context.
- Keep the tone factual, not buzzword-heavy.

### 16. Strengthen the portfolio page

Current state:
- `portfolio.html` is no longer just a placeholder, but it can become a stronger trust asset.

Potential improvements:
- Make each case study more concrete: context, constraint, intervention, result.
- Add project dates/durations when possible.
- Add links only when public and appropriate.
- Clarify which projects were freelance, employment, or personal projects if relevant.

Acceptance checks:
- Every featured case has a measurable or concrete result.
- Claims remain verifiable and not inflated.
- Page has a clear CTA near the end.

### 17. Reduce generic visual feel

Current issue:
- The design is clean but somewhat generic SaaS-blue.
- It could feel more personal and local without becoming decorative.

Potential improvements:
- Add a stronger first-viewport signal of Matthieu as a person.
- Use one or two real visuals from La Reunion or work context if available.
- Tune palette away from a one-note blue theme while keeping trust and readability.

Acceptance checks:
- Visual changes preserve WCAG AA contrast.
- Mobile layout remains clean at 375px.
- No decorative overload or stock-photo feeling.

### 18. Improve CTAs by intent

Current issue:
- CTAs are mostly Calendly, quiz, or "Voir le cas".
- The site could guide visitors better depending on their maturity.

Potential improvements:
- Home: "Testez votre site" for exploratory visitors, Calendly for ready visitors.
- Audit pages: "Discuter de mon projet" plus a lower-friction email option.
- Quiz result: tailored CTA by result type.

Acceptance checks:
- Every major page ends with one clear next action.
- CTA labels are specific and not generic.
- Calendly URLs are consistent.

## Priority 5 — SEO/GEO Refinement

### 19. Full SEO/GEO audit of the site

Audit every public page against the rules in `CLAUDE.md` and GEO best practices for AI-generated answers.

**SEO checklist per page:**
- `<title>`: 55–60 chars, primary keyword + location
- `<meta description>`: 150–160 chars, benefit statement, no padding
- Single `<h1>`, strict `h1 > h2 > h3` hierarchy, no skipped levels
- `canonical` tag present and pointing to the correct URL
- All `<img>` have descriptive `alt` (subject + context + location if relevant)
- `hreflang` pairs accurate and symmetrical between FR/EN equivalents

**JSON-LD checklist:**
- Home: `Person` + `LocalBusiness` up to date (name, address, URL, sameAs)
- Audit pages: `FAQPage` blocks contain real answers, not padded prose
- All `application/ld+json` blocks are valid JSON (parseable)

**GEO checklist (visibility in AI-generated answers):**
- Quantified facts present on each page: 17 years, 500+ Cypress scenarios, 70% coverage, Saint-Pierre 974, UTOI 117 km
- Each client case: named client + duration + measurable result
- FAQ sections answer directly in the first sentence — no preamble
- Paragraphs ≤ 4 lines, no filler sentences
- Verify `site-web-14-jours.html` and `en/website-14-days.html` have adequate GEO signals (these pages are new and may be thin)

**Files to audit:**
- `index.html` + `en/index.html`
- `site-web-14-jours.html` + `en/website-14-days.html`
- `portfolio.html` + `en/portfolio.html`
- `quiz.html`
- All `audit/` and `en/audit/` pages (index + 6 sub-pages each)

Acceptance checks:
- No page has a title outside 50–65 chars or a description outside 140–165 chars.
- No page has more than one `<h1>` or a skipped heading level.
- Every `<img>` has a non-empty `alt`.
- Every FR page links to its EN equivalent and vice versa via `hreflang`.
- JSON-LD on every FAQ page parses without error.

### 21. Add structured data consistency checks

Current issue:
- Home has `Person` and `LocalBusiness`.
- Audit pages use various JSON-LD types.
- There is no automated check that JSON-LD remains valid JSON.

Acceptance checks:
- Tests parse every `application/ld+json` block.
- Invalid JSON-LD fails CI.
- Home keeps `Person` and `LocalBusiness`.

### 22. Review English route completeness

Current issue:
- English pages exist, but language links may not be complete or symmetrical everywhere.
- `tech.html` points EN language toggle to `en/index.html`, not an English tech page.

Acceptance checks:
- Every FR page with an EN equivalent links to the exact EN page.
- Every EN page links back to the exact FR page.
- Pages without equivalents use a deliberate fallback.
- hreflang tags match actual page pairs.

## Known Verification Limitations From Initial Analysis

- `node` and `npm` were not available in the shell during analysis, so tests could not be executed locally.
- `rg` was not available; file searches used `find` and `grep`.
- Before implementing changes, install/use Node locally or rely on CI to run `npm test`.
