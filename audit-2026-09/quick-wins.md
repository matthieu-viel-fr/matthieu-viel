# Quick wins, moins d'une journée au total

Dix modifications sans refonte, sans nouvelle page, sans décision stratégique.
Chacune a sa fiche détaillée dans `recommandations/`.

Ordre d'exécution recommandé : **1, 2, 5, 6, 3, 7, 8, 4, 9, 10**
(les plus courtes et les plus mécaniques d'abord, la réécriture éditoriale ensuite).

---

## 1. Unifier l'adresse email sur `contact@matthieu-viel.fr`

**Constat.** Deux adresses coexistent : `contact@matthieu-viel.fr` dans les mentions
légales, `matthieu.viel.fr@gmail.com` partout ailleurs, soit **48 occurrences dans
23 templates**, y compris dans le JSON-LD `LocalBusiness` de l'accueil.

**Pourquoi.** L'incohérence nuit surtout à la crédibilité et à la maintenabilité des
coordonnées. Son effet SEO local n'est pas mesuré. Une adresse Gmail affichée comme
contact principal affaiblit aussi la crédibilité sur un site qui vend
précisément la reprise en main de ses propres accès.

**Effort.** 20 min. **Fiche :** [QW01](recommandations/QW01-unifier-email.md)

---

## 2. Corriger le contraste de `--clr-muted`

**Constat.** `#718ea4` mesure **3,44:1** sur blanc et **3,19:1** sur `--clr-bg-alt`,
contre un seuil AA de 4,5:1. Cinq sélecteurs concernés, présents sur **toutes les pages** :
`.nav__logo-tagline`, `.hero__stat-label`, `.testimonial__role`,
`.portfolio-hero__stat-label`, `.offer-price-sep`.

**Pourquoi.** Violation active de la règle 4 de `CLAUDE.md`, qui est non négociable.
Et ce sont les libellés des chiffres clés, donc les preuves, qui passent le plus mal.

**Effort.** 15 min, un seul token. **Fiche :** [QW02](recommandations/QW02-contraste-clr-muted.md)

---

## 3. Corriger le `sitemap.xml`

**Constat.** 27 URL déclarées pour 29 pages servies.
- `senior-tech.html` est **absente**, alors qu'elle est liée depuis la nav et le footer de toutes les pages.
- `quiz.html` est **présente** alors qu'elle est orpheline, sans `meta description`, sans `canonical` et sans `hreflang`.
- 19 URL sur 27 partagent `priority 0.8`, signal quasi nul.

**Pourquoi.** Une page de service majeure invisible dans le sitemap, et une page
déclarée indexable que rien ne recommande : deux signaux de qualité qui se dégradent
mutuellement.

**Effort.** 30 min. **Fiche :** [QW03](recommandations/QW03-sitemap.md)

---

## 4. Réécrire 20 méta-descriptions et 6 titres

**Constat.** Sur 29 pages : **20 descriptions hors de la cible 150-160** (de 113 à
236 caractères) et **6 titres au-dessus de 60 caractères**, tous côté EN.
La pire : `/en/audit/technical-debt-saas-application/` à 236 caractères.

**Pourquoi.** Google peut tronquer selon la largeur disponible ou réécrire le snippet.
Sur
`/audit/tests-automatises-application/`, le « 500+ scénarios Cypress » final, qui est
l'argument de preuve, est coupé dans la SERP.

**Effort.** 2 h. Prioriser les URL qui reçoivent des impressions dans Search Console,
la qualité et l'unicité avant une longueur cible stricte. **Fiche :** [QW04](recommandations/QW04-meta-descriptions.md)

---

## 5. Ajouter les en-têtes de cache et une page 404

**Constat.** **Aucun `Cache-Control`, aucun `Expires`** sur aucune ressource. Chaque
visite revalide 3 CSS, 1 JS et 8 images. `/page-qui-nexiste-pas` renvoie la page
Apache par défaut, sans navigation ni retour possible.

**Pourquoi.** Gain immédiat sur les visites répétées, et un visiteur perdu sur une
404 aujourd'hui sort du site.

**Effort.** 30 min. **Fiche :** [QW05](recommandations/QW05-cache-et-404.md)

---

## 6. Sortir Google Fonts du `@import` CSS

**Constat.** `src/assets/css/main.css:1` charge Inter par `@import`, ce qui crée la
chaîne HTML → `main.css` → `fonts.googleapis.com` → `fonts.gstatic.com`. Aucun
`preconnect`, aucun `preload`. Cinq graisses demandées, dont au moins une inutilisée.

**Pourquoi.** Le navigateur découvre la police tardivement. L'effet sur le LCP mobile
doit toutefois être mesuré avant de le présenter comme direct, et la règle 3 de
`CLAUDE.md` sur le CSS bloquant injustifié.

**Effort.** 30 min. **Fiche :** [QW06](recommandations/QW06-google-fonts.md)

---

## 7. Redimensionner les images et créer une vraie `og:image`

**Constat.** `portrait.webp` fait **1600 × 1600 pour 57 ko**, chargé en
`loading="eager"` dans le hero pour un rendu 400 × 400, puis réutilisé en 360 × 450,
soit deux ratios différents pour un fichier carré. Les trois autres visuels sont
également en 1600 px de large. `og:image` pointe sur ce portrait carré, que LinkedIn
et WhatsApp recadreront de façon imprévisible.

**Pourquoi.** 4 fois trop de pixels sur l'image la plus lourde du chemin critique,
et un aperçu social abîmé sur chaque partage.

**Effort.** 1 h. **Fiche :** [QW07](recommandations/QW07-images-og.md)

---

## 8. Nommer les logos clients dans les `alt`

**Constat.** Les 6 logos (Citeo, Sellermania, Néosylva, Akeneo, Geofit,
Tennis Contact) sont tous en `alt=""`. Le bloc est dupliqué pour le défilement
infini : 12 `<img>` pour 6 logos.

**Pourquoi.** Ce sont des preuves importantes pour les visiteurs et aujourd'hui peu
accessibles aux lecteurs d'écran. Les marques figurent déjà dans le texte : le gain
SEO ou GEO du seul attribut `alt` ne doit pas être surestimé.

**Effort.** 20 min. **Fiche :** [QW08](recommandations/QW08-alt-logos.md)

---

## 9. Ajouter un CTA téléphone dans le hero mobile

**Constat.** Le seul `tel:` de l'accueil est dans la FAQ, tout en bas de page. Sur
mobile, aucun CTA n'est visible avant environ 600 px de défilement.

**Pourquoi.** Une partie des visiteurs peut arriver en urgence (« mon site est hors ligne »).
Calendly peut alors être un frein. Tester le bouton d'appel dans le premier écran et
comparer les événements, sans promettre un gain de conversion.

**Effort.** 30 min. **Fiche :** [QW09](recommandations/QW09-cta-telephone-hero.md)

---

## 10. Reformuler la phrase anti-dépendance

**Constat.** « Mon objectif n'est pas que vous m'appeliez toutes les semaines » et
« je ne me rends pas indispensable » apparaissent **trois fois** sur l'accueil.

**Pourquoi.** Ces phrases sont vraies et elles rassurent, mais telles quelles elles
disent « ne me rappelez pas ». Elles travaillent directement contre l'offre récurrente
de MT11. La non-dépendance doit porter sur le **savoir transmis**, pas sur la relation.

**Effort.** 30 min. **Fiche :** [QW10](recommandations/QW10-phrase-anti-dependance.md)

---

## Vérification globale après les dix

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
php src/export.php
npm test
python3 - <<'PY'
import re,html,glob
bad=0
for p in sorted(glob.glob('dist/**/*.html',recursive=True)):
    s=open(p,encoding='utf-8').read()
    if 'http-equiv="refresh"' in s: continue
    t=re.search(r'<title>(.*?)</title>',s,re.S)
    d=re.search(r'<meta\s+name="description"\s+content="(.*?)"',s,re.S)
    lt=len(html.unescape(t.group(1).strip())) if t else 0
    ld=len(html.unescape(d.group(1).strip())) if d else 0
    if not (55<=lt<=60) or not (150<=ld<=160):
        print(f"{p}  title={lt}  desc={ld}"); bad+=1
print(f"\n{bad} page(s) hors cible")
PY
grep -rc "matthieu.viel.fr@gmail.com" dist --include=*.html | grep -v ":0" || echo "Aucune adresse Gmail restante"
```

Attendu après les dix quick wins : **0 page hors cible**, **aucune adresse Gmail**.
