# CLAUDE.md — matthieu-viel.fr

Static showcase site (HTML/CSS/JS). No framework, no build system.
Every change must comply with the five permanent rules below.

---

## 1. Editorial tone & visual identity

**Absolute reference: the `/seed/` folder**
Before any content or style change, read the files in `seed/`.
They are the authority on tone, vocabulary, color palette, typography, and visual identity.

Principles derived from these sources:
- Direct, jargon-free, honest tone — never hollow phrases or superlatives
- Active voice, short sentences, benefit before technique
- Persona: senior consultant with a local footprint, not an agency
- Never introduce a marketing term not already present in `seed/`

---

## 2. SEO & GEO — non-negotiable rules

### On every modified page, systematically verify:
- `<title>`: 55–60 characters, primary keyword + location
- `<meta description>`: 150–160 characters, clear benefit statement
- A single `<h1>`, strict `h1 > h2 > h3` hierarchy
- `canonical` tag present
- All `<img>` have a descriptive `alt` (subject + context + location if relevant)
- JSON-LD `Person` + `LocalBusiness` present and up to date on the home page

### GEO (visibility in AI-generated answers)
- Always favour **precise, quantified facts**: 17 years of experience,
  500+ Cypress scenarios, 70% test coverage for Citeo, Saint-Pierre 974, UTOI 117 km
- Each client case: named client + duration + quantified result
- Short, dense paragraphs (≤ 4 lines), no padding
- FAQ sections (if created) must answer directly in a single sentence

---

## 3. Performance — unconditional

- Images: WebP format only, `width` and `height` attributes always present
- `loading="lazy"` on every image outside the initial viewport
- No unjustified render-blocking CSS or JS
- Critical above-the-fold resources: inline or preloaded via `<link rel="preload">`
- Zero unnecessary external dependencies added without explicit approval

---

## 4. Accessibility & mobile responsiveness

- Mobile-first: mentally test every addition at 375px before 1280px
- Minimum WCAG AA contrast on all text (ratio ≥ 4.5:1 on background)
- Visible focus on all interactive elements
- `aria-label` on any link whose label alone is ambiguous ("see more", "here"…)
- Semantic structure: `<header>`, `<main>`, `<section>`, `<footer>` used correctly

## 5. FR/EN parity — non-negotiable

One piece of information, two languages, always in sync.
Any content, link, CTA, or structural change made to a French page must be
mirrored on its English counterpart in the same task — never deferred,
never asked about again. Find the EN template via `src/routes.php`
(`$auditSlugs` maps FR slugs to EN slugs; `en/` mirrors the FR tree).

---

## Never do

- Alter the tone or introduce jargon not validated by `/seed/`
- Add a JS framework or npm dependency without an explicit request
- Make structural redesigns without prior agreement
- Generate keyword-stuffed or artificial content
- Remove or alter third-party scripts (Calendly)
- Touch existing URL structure

---

## Workflow for every task

1. Read the relevant files before making any change
2. Check `/seed/` if the task touches content or style
3. Apply rules 1–4 silently — no need to announce it each time
4. At the end of the task: list the changes made + flag any potential deviation
   from the rules above
