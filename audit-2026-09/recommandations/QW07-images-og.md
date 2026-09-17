# QW07 · Redimensionner les images et créer une vraie `og:image`

| | |
|---|---|
| Priorité | Quick win |
| Effort | 1 h |
| Impact | LCP, poids de page, aperçus de partage |
| Parité FR/EN | Oui, pour les balises `og` |
| Dépendances | `cwebp` ou un équivalent installé |

## Constat mesuré (17/09/2026)

| Fichier | Dimensions réelles | Poids | Affiché en |
|---|---|---|---|
| `portrait.webp` | **1600 × 1600** | 57 ko | 400 × 400 (hero, `eager`) **et** 360 × 450 (à propos, `lazy`) |
| `hero-banner.webp` | 1600 × 400 | 40 ko | variable |
| `site-mockup.webp` | 1600 × 836 | 58 ko | variable |
| `cta-quiz.webp` | 1600 × 836 | 48 ko | variable |

Trois problèmes distincts :

1. **`portrait.webp` est 4 fois trop grand** pour son affichage principal, et c'est
   l'image chargée en `loading="eager"` dans le hero, donc sur le chemin critique.
2. **Le même fichier carré est affiché en 400 × 400 puis en 360 × 450.** Un carré
   rendu dans un cadre 4:5 est soit déformé, soit recadré par `object-fit`. À vérifier
   visuellement : si c'est `object-fit: cover`, le recadrage est peut-être involontaire.
3. **`og:image` pointe sur ce portrait carré 1600 × 1600.**

```html
<meta property="og:image" content="https://www.matthieu-viel.fr/assets/images/portrait.webp">
<meta name="twitter:card" content="summary_large_image">
```

Aucun `og:image:width`, aucun `og:image:height`, aucun `twitter:image` dédié.

## Pourquoi c'est important

- **Performance.** Le poids est déjà correct en absolu (57 ko), mais le navigateur
  décode 2,56 millions de pixels pour en afficher 160 000. Le coût est en mémoire et
  en temps de décodage, pas seulement en octets, et il se paie sur mobile bas de gamme.
  Règle 3 de `CLAUDE.md`.
- **Partage social.** `summary_large_image` attend un format paysage. LinkedIn, WhatsApp
  et Slack recadreront un carré 1:1 de façon imprévisible, souvent en coupant le visage.
  Chaque partage du site produit aujourd'hui un aperçu abîmé, alors même que le portrait
  est un actif de confiance pour une activité de proximité.

## Ce qu'il faut faire

### 1. Générer les variantes

```bash
cd /home/matthieu/Projets/dev/matthieu-viel/src/assets/images
cp portrait.webp portrait-1600.webp.bak   # garder l'original

# Portrait principal : 800 x 800 suffit pour un affichage 400 x 400 en 2x
cwebp -q 82 -resize 800 800 portrait-1600.webp.bak -o portrait.webp

# Les trois autres : 1200 px de large suffisent
cwebp -q 82 -resize 1200 0 hero-banner.webp  -o hero-banner.webp
cwebp -q 82 -resize 1200 0 site-mockup.webp  -o site-mockup.webp
cwebp -q 82 -resize 1200 0 cta-quiz.webp     -o cta-quiz.webp
```

Attendu : `portrait.webp` autour de 18 ko, les autres autour de 25 à 35 ko.

**Conserver l'original 1600 px hors dépôt** (ou dans `seed/`), il servira pour toute
régénération future.

### 2. Créer l'image de partage

Composer une `og-cover.webp` en **1200 × 630** : le portrait à gauche, le nom, le
métier et la localisation à droite, sur le fond de la charte. Ne pas réutiliser le
portrait brut.

Puis dans chaque `{% block og %}` (29 templates, mais seuls ceux qui déclarent
`og:image` sont concernés) :

```html
<meta property="og:image" content="https://www.matthieu-viel.fr/assets/images/og-cover.webp">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="Matthieu Viel, développeur web indépendant à Saint-Pierre, La Réunion">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="https://www.matthieu-viel.fr/assets/images/og-cover.webp">
```

**Miroir EN** avec un `og:image:alt` traduit. Si le visuel contient du texte français,
prévoir une `og-cover-en.webp`.

Note : certains agrégateurs acceptent mal le WebP pour les aperçus sociaux. Si un test
révèle un aperçu vide sur LinkedIn ou WhatsApp, produire aussi une version JPEG et la
déclarer en `og:image` (le WebP reste pour le site).

### 3. Vérifier le double usage du portrait

Regarder comment `portrait.webp` est affiché dans la section « À propos » (déclaré
`width="360" height="450"`). Si la CSS applique `object-fit: cover` sur une source
carrée, le cadrage du visage est décidé par le navigateur. Deux options : produire une
seconde image réellement en 4:5, ou ajouter `object-position` pour fixer le cadrage.

### 4. Ne pas casser ce qui marche déjà

Les attributs `width`, `height` et `loading="lazy"` sont **déjà tous corrects** sur les
14 `<img>` de l'accueil. Ne pas les retirer en régénérant.

## Critères d'acceptation

- [ ] `portrait.webp` fait au plus 800 × 800 et moins de 25 ko
- [ ] Les trois autres visuels font au plus 1200 px de large
- [ ] `og-cover.webp` existe en 1200 × 630
- [ ] `og:image`, `og:image:width`, `og:image:height`, `og:image:alt`, `twitter:image` présents
- [ ] Miroir EN fait
- [ ] Tous les `<img>` conservent `width`, `height` et leur `loading`
- [ ] Le portrait reste net sur écran Retina (test à 2x)
- [ ] Le cadrage du portrait en 4:5 est intentionnel
- [ ] Aperçu vérifié sur au moins un agrégateur réel

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
php src/export.php
for f in dist/assets/images/*.webp; do
  printf "%-46s %8s o  " "$f" "$(stat -c%s "$f")"
  python3 -c "
import struct,sys
d=open('$f','rb').read()
if d[12:16]==b'VP8X':
    print(f\"{int.from_bytes(d[24:27],'little')+1}x{int.from_bytes(d[27:30],'little')+1}\")
elif d[12:16]==b'VP8L':
    v=int.from_bytes(d[21:25],'little'); print(f'{(v&0x3FFF)+1}x{((v>>14)&0x3FFF)+1}')
else:
    w,h=struct.unpack('<HH',d[26:30]); print(f'{w&0x3FFF}x{h&0x3FFF}')"
done
echo "img sans width :"; grep -roP '<img(?![^>]*width=)[^>]*>' dist --include=*.html | wc -l
echo "img sans alt   :"; grep -roP '<img(?![^>]*alt=)[^>]*>'   dist --include=*.html | wc -l
```

Attendu : `0` image sans `width`, `0` sans `alt`.

Puis tester l'aperçu réel : partager `https://www.matthieu-viel.fr/` dans une
conversation WhatsApp avec soi-même, ou utiliser le Post Inspector de LinkedIn (qui
force aussi le rafraîchissement du cache de l'aperçu).

## Règles `CLAUDE.md` engagées

- **Règle 3, performance** : WebP uniquement, `width` et `height` toujours présents, `loading="lazy"` hors viewport initial
- **Règle 2, SEO** : `alt` descriptif (sujet + contexte + localisation)
- **Règle 5, parité FR/EN**

## Référence

Point **9** de `TODO.md` (« Convert raster assets to WebP or AVIF », déjà fait pour le
format, pas pour les dimensions).
