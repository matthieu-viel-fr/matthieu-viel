# TODO — matthieu-viel.fr

This file captures the current improvement backlog for the personal website.
It is written so future Codex/Claude sessions can continue without redoing the
full project analysis.

## Context

- Static personal website for Matthieu Viel, senior web technical consultant in La Reunion.
- No framework. Twig templates under `src/templates/` are the source, exported
  to the static `dist/` tree by `php src/export.php`. Never edit `dist/` by hand,
  it is regenerated. The rest of this backlog is not yet updated for that layout,
  see item A6.
- Main positioning since 2026-09-16: help non-technical business owners whose site
  or tools have broken, been hacked, or been abandoned by their provider. Senior
  technical consulting is still on the site, behind a labelled second door, and
  still carries the recruiter and CTO signal. Source of truth for positioning:
  `visibilite/actions/positionnement.md`.
- Strong proof points to preserve: 18 years experience (started September 2008), Citeo, Sellermania, 500+ Cypress scenarios, 70% test coverage, Saint-Pierre 974, ECP Formation, UTOI 117 km.
- Tone reference: `seed/presentation_matthieu.txt`.
- Project rules: `CLAUDE.md`.

## Done

### Remove AI-generated em dashes, every served file (finished 2026-09-16, `88fbc53`)

The first pass cleaned body copy only. Titles, og:titles, meta descriptions, CSS
comments, HTML comments and `sitemap.xml` comments still carried em dashes until
2026-09-16. Replacement is by role, not blind:
- `:` where the dash introduced an explanation or clarification
- `,` where the dash connected two clauses or expressed contrast
- `.` where the dash separated two independent sentences
- `·` where the dash separated title segments, which is the separator the site
  already uses and keeps the character count identical

Verified: zero em dashes across all 29 pages in `dist/`, the CSS, the JS and the
sitemap. Internal files that are never served still carry them, see item A8.

### Remove `<em>` tags from hero titles ✓

`<em>` tags in `site-web-14-jours.html` and `en/website-14-days.html` replaced with `<span class="hero__title-highlight">`. CSS rule updated from `.hero__title em` to `.hero__title-highlight`.

## Raised 2026-09-16, Homepage Repositioning Session

The homepage was restructured to lead with plain-language help for non-technical
business owners, keeping the technical content behind a labelled second door
(commits `753ec6b` and `88fbc53`). The points below were found during that work
and deliberately left untouched. Ranked most important first.

### A1. `--clr-muted` fails WCAG AA on white

Current issue:
- `--clr-muted` (`#718ea4`) on `--clr-bg` gives a contrast ratio of 3.16:1.
- `CLAUDE.md` rule 4 requires at least 4.5:1 on all text, so this is a live
  violation of a non-negotiable rule, not a nice-to-have.
- Five selectors use it, all small text, all shipping on every page:
  `.nav__logo-tagline`, `.hero__stat-label`, `.testimonial__role`,
  `.portfolio-hero__stat-label`, `.offer-price-sep`.
- The homepage components added on 2026-09-16 avoid the token on purpose and use
  `--clr-slate` (8.1:1) instead, so the fix is a token change, not a rewrite.

Files likely involved:
- `src/assets/css/main.css` (token definition, `.nav__logo-tagline`, `.hero__stat-label`)
- `src/assets/css/components.css`

Acceptance checks:
- The token reaches at least 4.5:1 on both `--clr-bg` (`#ffffff`) and
  `--clr-bg-alt` (`#f2f7fb`). `#5a7386` measures 4.96:1 and 4.60:1 and is a
  reasonable starting point, but verify rather than trust it.
- Visual check on home, portfolio and one audit page: the muted text must stay
  visibly secondary to `--clr-slate`, otherwise the hierarchy flattens.
- Consider a separate darker token if one call site genuinely needs the lighter
  grey on a dark background.

### A2. Meta descriptions are far too long on the audit pages

Current issue:
- Measured on 2026-09-16 across the 29 exported pages: 20 descriptions and 9
  titles fall outside the ranges required by `CLAUDE.md`.
- Descriptions run from 113 to 231 characters against a 150-160 target. The worst
  are `en/audit/technical-debt-saas-application` (231),
  `audit/tests-automatises-application` (226) and
  `en/audit/automated-tests-application` (215). Anything past roughly 160 is
  truncated in search results, so the benefit statement is cut mid-sentence.
- Too short at the other end: `en/portfolio` (113), `en/legal-notice` (116),
  `mentions-legales` (124).
- Titles past 60: the six EN audit pages (61 to 65) and `portfolio.html` (66).
  Titles under 55: `en/legal-notice` (53) and `quiz.html` (53).
- This predates the repositioning work. The em dash pass moved only three pages
  by one or two characters, all of them closer to the target.

Files likely involved:
- All templates under `src/templates/audit/` and `src/templates/en/audit/`
- `src/templates/portfolio.html.twig`, `src/templates/en/portfolio.html.twig`
- `src/templates/quiz.html.twig`, `src/templates/en/legal-notice.html.twig`

Acceptance checks:
- Every page lands inside 55-60 for the title and 150-160 for the description,
  or the rule in `CLAUDE.md` is consciously relaxed and the file updated to say so.
- Rewrites keep the primary keyword and the location, and stay a benefit
  statement rather than a truncated list of features.
- Pairs with items 7 and 19, which add the automated check. Do the measurement
  test first so the rewrite has a pass/fail signal.

### A3. No testimonial speaks to the non-technical audience

Current issue:
- The homepage now leads with business owners who have no IT background, but the
  three testimonials are signed Head of IT (Citeo), CEO (Sellermania) and Lead
  Dev (Néosylva).
- They work perfectly for the second door and for recruiters. They say nothing to
  someone whose site is down and who wants to know they will be treated kindly.
- The whole point of the first door is that the visitor recognises themselves.
  The social proof currently contradicts that.

Acceptance checks:
- At least one testimonial from a non-technical client, placed first in the
  `#preuves` section, mentioning plain speech or reassurance rather than velocity
  or code quality.
- FR and EN in sync as always.
- Wait for a real quote. Do not write a plausible one.

### A4. Decide the offer model for the non-technical segment

Current issue:
- No price, no package and no retainer appear anywhere on the site. That is a
  deliberate decision taken on 2026-09-16: not enough client feedback yet, and
  Matthieu prefers being underpaid to not being paid at all while he learns the
  segment.
- The open question, still undecided in `visibilite/actions/positionnement.md`,
  is whether to split reactive break/fix billed per incident from proactive
  monthly support.
- Reactive work fills a calendar without building an asset. If volume arrives,
  the retainer stops being a bonus and becomes the thing that makes the segment
  viable at the 4000 euro per month target.

Acceptance checks:
- Revisit once there is real volume, not before.
- If a retainer is adopted, the CTA in the `#aide` section and step 2 of
  `#deroulement` both change, and `hasOfferCatalog` in the homepage JSON-LD gains
  an entry.
- Keep `visibilite/actions/positionnement.md` as the source of truth for the
  decision and mirror it here, not the other way round.

### A5. `quiz.html` is intentionally orphaned

Current issue:
- The quiz is no longer linked from anywhere on the site. The CTA was removed
  from the homepage on 2026-09-16 because it no longer fits the positioning.
- The page is still built and still routed in `src/routes.php`, on purpose:
  LinkedIn posts still point at it and those links must keep working.
- Since QW03 (2026-09-17) it is deliberately removed from `sitemap.xml` and
  carries `<meta name="robots" content="noindex, follow">`: the URL still
  resolves for existing links, but it is no longer offered for indexing.
  See `getSitemapExclusions()` in `src/routes.php`.
- Without this note a future session will read the orphan either as a bug to fix
  by re-adding a link, or as dead code to delete. Both would be wrong.

Acceptance checks:
- Keep the page reachable at its current URL until the LinkedIn links are retired.
- Do not re-link it from the homepage without revisiting the positioning.
- Keep it excluded from `sitemap.xml` and `noindex` unless the decision to make
  it an acquisition page again is revisited.
- Revisit the whole page if and when it is genuinely retired, see item 14.

### A6. This backlog still describes the pre-Twig layout

Current issue:
- Items 4 to 22 reference root-level files such as `index.html`, `assets/images/`
  and `tests/links.test.js` as if the site were still hand-authored HTML. The
  site is now Twig templates under `src/templates/`, exported to `dist/`.
- `site-web-14-jours.html` and `en/website-14-days.html` are referenced in three
  places and no longer exist.
- Item 9 asks to convert JPG assets to WebP. All 11 images are already WebP, so
  the item is done and should be closed.
- A session that trusts these paths wastes time or edits `dist/`, which is
  regenerated and would silently lose the work.

Acceptance checks:
- Every file path in this backlog points at something that exists.
- Items that are already done are moved to the Done section with a date.
- The Context section states clearly that `src/templates/` is the source and
  `dist/` is generated by `php src/export.php`.

### A7. Nav wraps at 1024px

Current issue:
- Between roughly 900px and 1100px the nav puts "À propos" on two lines.
- This predates the repositioning. It used to be worse: two items wrapped before
  `nav.senior` was shortened from "Missions Senior" to "Missions" on 2026-09-16.
- Reviewed on 2026-09-16 and judged not a problem. Recorded for completeness only.

Acceptance checks:
- Only act on this if it starts bothering someone. Reducing the nav gap or moving
  the burger breakpoint up would both work.

### A8. Em dashes remain in files that are never served

Current issue:
- `README.md` (7), `TODO.md` (10), `CLAUDE.md` (7) and `tests/links.test.js` (1)
  still contain em dashes.
- None of them reach a visitor, so the rule does not strictly apply. Noted so the
  next grep does not read as a regression.

Acceptance checks:
- Purely cosmetic. Clean them only as a side effect of editing those files for
  another reason.

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

Status: implemented in QW03 (2026-09-17), not yet committed at time of writing.
`sitemap.xml` is now generated from `getPages()` (`src/generate-sitemap.php` +
`src/sitemap.php`), instead of being hand-maintained, which removes the class of
drift this item was written against. `tests/sitemap-consistency.test.php` (wired
into `npm test` and CI) fails if a `getPages()` entry is neither excluded
(`getSitemapExclusions()`) nor given a `lastmod` (`getSitemapLastmod()`);
`tests/links.test.js` section 7 cross-checks the same thing from the rendered
`dist/` output independently. Move this to Done once committed.

Current issue (pre-QW03, kept for context):
- Many pages exist, and `sitemap.xml` must stay aligned manually.

Files likely involved:
- `sitemap.xml`
- `tests/links.test.js`

Acceptance checks:
- Every public HTML page appears in `sitemap.xml`. ✓
- No sitemap URL points to a missing local page. ✓
- `noindex` pages such as `tech.html` are intentionally excluded or clearly documented. ✓

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
