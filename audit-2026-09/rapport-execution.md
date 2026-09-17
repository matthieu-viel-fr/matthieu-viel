# Rapport d'exécution des dix quick wins

Journal de traitement du dossier d'audit de septembre 2026.
Une section par quick win, dans l'ordre d'exécution recommandé (1, 2, 5, 6, 3, 7, 8, 4, 9, 10).

Chaque quick win a été confié à un sous-agent dédié, vérifié, puis commité seul.
Le hook de pré-commit lance `npm test` : aucun commit n'est passé sans les 82 tests au vert.

---

## QW01 · Unifier l'adresse email

**Statut :** fait. Commit `9d6699b`.

48 occurrences de `matthieu.viel.fr@gmail.com` remplacées par `contact@matthieu-viel.fr`
dans 23 templates, les deux arbres de langue dans la même passe.

**Vérifications :** 0 adresse Gmail restante dans `src/` et dans `dist/`.
52 occurrences de la nouvelle adresse dans `dist/`, dont le JSON-LD `LocalBusiness`
des deux accueils. Mentions légales FR et EN inchangées, elles étaient déjà correctes.
Diff de 48 insertions et 48 suppressions, aucune ligne touchée hors adresse email.

**Reste à faire, hors dépôt :** aligner la signature LinkedIn, le profil Malt et les
bios Instagram et TikTok sur la même adresse. La cohérence NAP se joue aussi hors site.

---

## QW02 · Corriger le contraste de `--clr-muted`

**Statut :** fait. Commit à suivre.

`--clr-muted` passe de `#718ea4` à `#5a7386` dans `src/assets/css/main.css`.
Un seul token, donc parité FR et EN automatique.

**Vérifications :** 4,96:1 sur `#ffffff` et 4,60:1 sur `#f2f7fb`, contre 3,44:1 et
3,19:1 avant. Le seuil AA de 4,5:1 est franchi sur les deux fonds. `npm test` au vert.

**Cas du fond sombre, vérifié avant de conclure :** aucun des cinq sélecteurs concernés
n'apparaît sur `--clr-bg-dark` ni sur `--clr-bg-dark-alt`. Les sections sombres ne
contiennent que des eyebrow, titres, textes de CTA, boutons et items de links-strip.
Un second token `--clr-muted-on-dark` n'était donc pas nécessaire.

**Point de vigilance :** l'écart de contraste entre `--clr-slate` et `--clr-muted`
tombe de 2,36:1 à 1,64:1. La hiérarchie tient sur le papier mais mérite un coup d'oeil
humain sur l'accueil, le portfolio et une page d'audit. Si elle s'aplatit, la fiche
demande d'assombrir `--clr-slate` plutôt que d'éclaircir `--clr-muted`.

**Note :** `.offer-price-sep` est défini dans `components.css` mais n'est utilisé par
aucun template, cohérent avec le choix de ne pas afficher de prix pour l'instant.

---

## QW05 · En-têtes de cache et page 404

**Statut :** fait. Commit à suivre.

**Cache.** `.htaccess` à la racine, copié dans `dist/` par `src/export.php` :
`Cache-Control: public, max-age=604800` sur css, js, webp, svg et woff2,
`max-age=600, must-revalidate` sur le HTML, avec les `ExpiresByType` alignés
sur les mêmes durées. L'arbitrage de la fiche est tranché sur l'option prudente :
une semaine et non un an, parce que les noms d'assets ne portent pas de hash.
Un cache d'un an empêcherait un correctif CSS d'atteindre les visiteurs déjà venus.

**Page 404.** `src/templates/404.html.twig` et son miroir `en/404.html.twig`,
ajoutés à `getPages()` dans `src/routes.php`. Nav et footer du site, trois portes de
sortie (accueil, contact, audit technique), un lien `tel:` pour les cas urgents,
et `noindex, follow`. Titres de 58 et 56 caractères, descriptions de 159 et 152.
Absente du sitemap, comme demandé.

**Découverte non prévue par la fiche.** Apache sert la page d'erreur à l'URL cassée
réellement demandée, pas à `/404.html`. Les chemins relatifs calculés par profondeur
auraient donc cherché le CSS dans `/audit/assets/css/main.css` sur une URL cassée en
profondeur, et servi une page sans style ni navigation. `pageContext()` force des
chemins absolus pour ces deux pages seulement.

**ErrorDocument du répertoire /en/.** La solution propre a suffi : un fichier
`en/.htaccess` à la racine du dépôt, copié dans `dist/en/` par l'export. Apache
fusionne les `.htaccess` par répertoire, donc une URL EN cassée reçoit la 404 EN.
Le repli accepté par la fiche (404 FR pour tout le site) n'a pas été nécessaire.

**Test ajusté.** `tests/links.test.js` vérifiait le lien vers les mentions légales
dans le footer sous sa seule forme relative. L'assertion accepte désormais aussi la
forme absolue. Le test est élargi, pas affaibli : il continue d'exiger le lien.

**Vérifications :** `.htaccess` et `dist/.htaccess` identiques, `ErrorDocument` et
règles de cache présents des deux côtés, nav et footer présents dans les deux pages
404, tous leurs liens et assets en chemin absolu, aucun tiret cadratin.
`npm test` : 84 tests au vert, contre 82 avant.

**Reste à vérifier après déploiement,** ces contrôles exigent le serveur :
les en-têtes `Cache-Control` renvoyés par Nuxit sur les assets et sur le HTML,
le maintien de `content-encoding: gzip`, et le rendu réel de `/page-qui-nexiste-pas`.
Nuxit doit autoriser `mod_expires` et `mod_headers` : les blocs `IfModule` font que
leur absence dégrade sans casser, mais le gain serait alors nul.

**Observation hors périmètre :** le bouton de langue actif porte `href=""` sur toutes
les pages du site, pas seulement sur la 404. Pré-existant, non corrigé ici.

## QW06 · Sortir Google Fonts du `@import` CSS

**Statut :** fait, option B. Commit à suivre.

**Arbitrage tranché par Matthieu :** auto-hébergement, pas le simple `preconnect`.
La raison qui a emporté la décision : les mentions légales affirment que le site
n'utilise aucun cookie tiers et ne collecte aucune donnée personnelle, alors qu'un
appel à `fonts.gstatic.com` transmet l'adresse IP du visiteur à Google.
L'auto-hébergement rend cette promesse vraie. Il supprime aussi les deux domaines
tiers du chemin de rendu, donc deux points de défaillance.

**Découverte qui a simplifié l'implémentation.** Google ne sert plus Inter en
fichiers statiques : les cinq graisses demandées pointaient toutes vers le même
woff2, une police variable à axe `wght`. Un seul fichier auto-hébergé de 47 ko couvre
donc les cinq graisses, avec un unique `@font-face` déclarant `font-weight: 400 800`.
C'est le fichier exact que Google servait, le rendu est inchangé par construction.

**Graisses.** Les cinq (400, 500, 600, 700, 800) sont réellement utilisées, aucune
n'a été écartée. Le `grep` sur les `font-weight` numériques proposé par la fiche ne
renvoyait rien : le code n'utilise que des tokens `--fw-*`, dont l'usage a été
retracé un par un. Aucun italique n'est utilisé pour Inter.

**Sous-ensemble latin seul,** suffisant : son `unicode-range` couvre tous les
accents français employés sur le site, y compris le œ vérifié dans l'accueil et la FAQ.

**Fichiers ajoutés :** `src/assets/fonts/inter-var-latin.woff2` (47 ko) et `OFL.txt`,
la licence SIL Open Font License que le fichier de police doit obligatoirement
accompagner. Aucune modification de `src/export.php` n'a été nécessaire, la copie
récursive de `src/assets/` existait déjà, et la règle de cache `woff2` du `.htaccess`
posée en QW05 les couvre.

**Vérifications :** plus aucun `@import` dans le CSS, `font-display: swap` conservé,
pile de repli système déjà correcte dans `--ff` et laissée telle quelle.
Le `preload` se résout correctement à chaque profondeur, y compris en chemin absolu
sur les deux pages 404. `npm test` : 84 au vert. Le woff2 est un fichier valide,
vérifié par sa signature.

**Mentions légales :** relues dans les deux langues, elles ne nomment ni Google ni
aucun service de police. Leurs formulations génériques restent vraies. Rien changé.

**Observation hors périmètre, à traiter :** `quiz.html.twig` charge encore Montserrat
par un `<link>` Google Fonts qui lui est propre. La fiche ne le couvre pas, et rien
n'a été touché. Cette page fait l'objet de QW03, où la question de son sort se pose
de toute façon. L'appel à Google y persiste donc pour l'instant.

**Reste à vérifier après déploiement :** dans l'onglet réseau, que `fonts.gstatic.com`
n'est plus appelé du tout sur les pages autres que le quiz.

## QW03 · Corriger le `sitemap.xml`

**Statut :** fait. Commit à suivre.

**Arbitrages tranchés par Matthieu :** quiz.html en option B, et sitemap généré depuis
`routes.php` plutôt que maintenu à la main.

**Contenu corrigé.** `senior-tech.html` est déclarée, elle était absente alors que la
nav et le footer de toutes les pages pointent vers elle sous le libellé « Missions ».
Elle n'a pas d'équivalent EN, donc seuls `hreflang="fr"` et `x-default` la déclarent,
tous deux vers elle-même : inventer un `hreflang="en"` vers l'accueil EN aurait été une
déclaration fausse. `tech.html` reste absente, c'est une redirection par méta-refresh,
et les deux pages 404 sont exclues. `priority` et `changefreq` sont retirés, Google les
ignore. 27 URL déclarées.

**quiz.html.** Retirée du sitemap et passée en `noindex, follow`. L'URL continue de
résoudre, les liens LinkedIn existants fonctionnent toujours, mais la page n'est plus
proposée à l'indexation. Elle n'est reliée à aucune page, son orphelinat reste
délibéré. À noter : ce template n'étend pas `base.html.twig`, c'est un document
autonome, donc le block `robots` ajouté en QW05 ne s'y applique pas ; sa balise
existante a été corrigée directement.

**Génération.** `src/sitemap.php` construit le XML depuis `getPages()`,
`src/generate-sitemap.php` régénère le fichier versionné à la racine, que l'export
copie ensuite dans `dist/`. Le sitemap reste donc lisible en diff lors des revues.

**Lastmod, le point sensible.** Aucune date existante n'a bougé. Elles sont portées
dans une table explicite, recopiées telles quelles depuis l'ancien fichier, et non
dérivées du git log ni du mtime : les commits du jour ont touché presque tous les
templates pour une simple adresse email, les dater d'aujourd'hui aurait été un faux
signal. `senior-tech.html`, nouvelle entrée, prend le 2026-09-16, date du dernier
commit ayant modifié son contenu réel.

**Garde-fou, point 8 du backlog.** `tests/sitemap-consistency.test.php` vérifie que
toute page de `getPages()` est soit exclue explicitement, soit déclarée. Le test a été
éprouvé dans les deux sens : il échoue bien quand on ajoute une page fantôme.

Une faille subsistait dans sa première version : il comparait `routes.php` au XML
généré en mémoire, jamais au fichier réellement présent sur le disque. Une modification
de routage sans régénération serait passée au vert. Un quatrième contrôle a donc été
ajouté, lui aussi éprouvé sur un sitemap volontairement périmé.

**Dépassement de périmètre à signaler.** Le sous-agent a également modifié
`package.json` et `.github/workflows/deploy.yml` pour brancher ce test sur `npm test`
et sur la CI, et a corrigé `TODO.md` dont une phrase devenait littéralement fausse.
L'étape CI a été vérifiée : le job `validate` installe déjà PHP 8.3, elle ne cassera
pas le déploiement. Ces changements sortent du périmètre strict de la fiche mais
servent son objectif ; ils sont signalés ici pour relecture.

**Vérifications :** XML valide, 27 URL, `senior-tech` présente, `tech.html` et `quiz`
absents, zéro `priority` ou `changefreq`, `dist/sitemap.xml` synchronisé.
`robots.txt` inchangé et cohérent : il autorise le crawl, ce qui est nécessaire pour
que la balise `noindex` du quiz soit effectivement lue. `npm test` au vert.

## QW07 · Redimensionner les images et créer une vraie `og:image`

**Statut :** fait. Commit à suivre. Visuel validé par Matthieu.

**Redimensionnements.**

| Fichier | Avant | Après |
|---|---|---|
| `portrait.webp` | 1600 × 1600, 57 ko | 800 × 800, 20 ko |
| `hero-banner.webp` | 1600 × 400, 40 ko | 1200 × 300, 22 ko |
| `site-mockup.webp` | 1600 × 836, 58 ko | 1200 × 627, 33 ko |
| `cta-quiz.webp` | 1600 × 836, 48 ko | 1200 × 627, 29 ko |

Le portrait est l'image chargée en `eager` dans le hero : le navigateur décodait
2,56 millions de pixels pour en afficher 160 000. Le coût se payait en mémoire et en
temps de décodage sur mobile, pas seulement en octets. L'original 1600 × 1600 est
archivé dans `seed/`, qui est hors dépôt, pour toute régénération future.

**Image de partage.** `og-cover.jpg` et `og-cover-en.jpg` en 1200 × 630, composées
sur le fond navy de la charte, portrait recadré depuis l'original, typographie Inter
instanciée depuis le woff2 auto-hébergé en QW06, donc aucune fausse graisse.
Deux versions parce que le visuel porte le métier, « Développeur web indépendant »
d'un côté et « Independent web developer » de l'autre. Les balises `og:image:width`,
`og:image:height`, `og:image:alt` et `twitter:image` accompagnent désormais chaque
`og:image` sur les 28 templates concernés, dans les deux langues.

**Déviation assumée à la règle 3, à signaler.** CLAUDE.md impose le WebP uniquement.
L'image de partage est en JPEG, sur décision de Matthieu. Raison : certains
agrégateurs sociaux lisent mal le WebP, et un aperçu vide serait pire que le
recadrage imprévisible que cette fiche corrige. Le surcoût est nul, cette image
n'est jamais chargée par un visiteur du site, uniquement par les crawlers, donc les
55 ko ne pèsent sur aucune page. Les variantes WebP ont été retirées du dépôt et de
`dist/` plutôt que laissées inutilisées.

**Double usage du portrait, point 3 de la fiche.** Vérifié, aucun correctif
nécessaire. La CSS applique déjà `object-fit: cover` et `object-position: center top`
aux deux usages. Dans le hero, source carrée dans un cadre carré, donc aucun
recadrage. Dans la section à propos, le cadre 4:5 rogne 45 px de chaque côté à
l'horizontale et rien à la verticale : le visage reste entier et centré. Le cadrage
est donc intentionnel et correct, ni second fichier ni modification de CSS.

**Découverte non prévue par la fiche.** `hero-banner.webp`, `site-mockup.webp` et
`cta-quiz.webp` ne sont référencés nulle part, ni dans les templates, ni dans la CSS,
ni dans le JS. La fiche les décrivait comme « affichés en taille variable », ils ne
sont en réalité pas affichés du tout. Ils ont été redimensionnés quand même, sans
risque, mais leur sort reste à trancher : restes d'une ancienne maquette à supprimer,
ou assets en attente d'un usage. Environ 85 ko déployés pour rien en attendant.

**Vérifications :** zéro `<img>` sans `width`, zéro sans `alt`, les 14 images de
l'accueil conservent leurs `width`, `height` et `loading`. `npm test` : 142 au vert.

**Reste à faire après déploiement :** vérifier l'aperçu réel avec le Post Inspector
de LinkedIn, qui force aussi le rafraîchissement du cache, et par un partage WhatsApp
avec soi-même.

## QW08 · Nommer les logos clients dans les `alt`

**Statut :** fait. Commit à suivre.

Les six logos de la première série portent désormais le nom de la marque : Citeo,
Sellermania, Néosylva, Akeneo, Geofit, Tennis Contact. La copie de défilement garde
`alt=""`. Les `alt` se limitent au nom, sans description du dessin ni ajout marketing,
comme l'exige la règle « pas de contenu artificiel ».

**Le constat de la fiche était partiellement inexact, à retenir.** Elle affirmait
qu'un lecteur d'écran annonçait « Ils m'ont fait confiance » suivi de rien du tout.
En réalité le bandeau portait déjà `aria-hidden="true"` sur `.clients__marquee`, qui
englobe les deux séries, doublé d'une liste `sr-only` énumérant les six noms en texte.
Ce dispositif date de la migration vers Twig, il est antérieur à l'audit.
L'accessibilité était donc déjà correcte, et les six noms étaient déjà annoncés une
seule fois.

Le gain réel de cette fiche est donc SEO et GEO, pas accessibilité : les crawlers
lisent les `alt` indépendamment de `aria-hidden`, qui ne s'adresse qu'aux technologies
d'assistance. Gain modeste, puisque les marques figurent déjà dans le texte de la page,
mais gratuit. Ni la structure DOM, ni la CSS d'animation, ni le dispositif
d'accessibilité existant n'ont été touchés.

**Vérifications :** 6 `alt` nommés et 6 `alt=""` sur chaque accueil, FR et EN,
zéro image sans `alt` sur tout le site, `width`, `height`, `loading` et classes
inchangés. `npm test` : 142 au vert. Le diff se limite à douze lignes par template.

**Hors périmètre technique, à traiter par Matthieu :** la fiche demande de vérifier
que l'accord d'affichage est acquis pour chacun des six logos. Nommer explicitement
les marques dans les `alt` rend cette question un peu plus sensible qu'avec un
`alt` vide.

**Note :** `logo-wetransform.webp`, sur la page de cas client, a déjà un `alt` correct
dans les deux langues. Non concerné, non touché.

---

## QW04 · Réécrire 20 méta-descriptions et 6 titres

**Statut :** fait. Commit à suivre.

20 méta-descriptions (10 FR, 10 EN) et 6 titres EN réécrits avec les textes déjà
validés par la fiche, longueurs vérifiées sur `dist/` régénéré. `og:title` mis à jour
sur les 6 pages EN concernées ; `og:description` laissé tel quel partout (divergence
volontaire déjà présente), cohérence relue page par page après réécriture.

Hors périmètre strict de la fiche, sur décision explicite de Matthieu et traité dans
la même passe pour la parité FR/EN : le titre et la description de l'accueil FR
changent (titre : le poste plutôt que « Dépannage informatique » ; description : la
variante qui introduit la joignabilité et le délai de réponse). L'accueil EN est
réécrit en miroir : titre avec « Independent web developer », description reprenant
le même message (réparation, joignabilité, 18 ans de métier, réponse sous 24 h),
jamais « consultant ».

**Vérifications :** script de la fiche → `1 page(s) hors cible` (`quiz.html`
uniquement, desc=0, attendu : elle est noindex depuis QW03 et le script ne filtre que
les redirections meta-refresh, pas les pages noindex). `tech.html` correctement
ignoré. 0 tiret cadratin sur tout `dist/`. `npm test` : 142 ✓ existants + le nouveau
test toujours au vert.

**Point 7 du backlog traité :** `tests/meta-lengths.test.php`, sur le modèle de
`tests/sitemap-consistency.test.php` (lecture de `getPages()`, mesure sur `dist/`,
compteur d'échecs, `exit(1)`). Branché dans `package.json` (`npm test`) et dans
`.github/workflows/deploy.yml`, juste après le test de sitemap. Il exclut `tech.html`
(redirection) et `quiz.html` (noindex) via une liste dédiée documentée dans le fichier,
volontairement différente de `getSitemapExclusions()` : celle-ci exclut aussi les deux
pages 404 en tant que documents d'erreur, alors que la présente tâche demande de les
garder dans le périmètre vérifié puisqu'elles sont déjà conformes. Mesure en points de
code Unicode via PCRE (`/./us`) plutôt que `mb_strlen`, l'extension `mbstring` n'étant
pas installée dans cet environnement.

**Textes retenus pour l'accueil, pour mémoire.**

- Titre FR, 60 caractères : `Matthieu Viel · Développeur web indépendant Saint-Pierre 974`
- Titre EN, 56 caractères : `Matthieu Viel · Independent web developer Réunion Island`
- Description FR, 151 : `Site en panne, piraté, ou plus personne pour s'en occuper ? Je répare, puis je reste joignable. 18 ans de métier à Saint-Pierre 974. Réponse sous 24 h.`
- Description EN, 156 : `Website down, hacked, or no one left to look after it? I fix it, then stay reachable. 18 years in the trade, based in Réunion Island. Reply within 24 hours.`

Le titre FR abandonne « Dépannage informatique » pour le titre de poste retenu le
2026-09-16. La formulation exacte demandée par Matthieu faisait 43 caractères, sous la
cible : elle a été complétée par « Saint-Pierre 974 », que portait déjà l'ancien titre,
pour atteindre 60 tout en gardant le marqueur local. À 60 caractères il est à la limite
haute de la cible, donc à surveiller dans la SERP, où la troncature se joue en pixels
et non en caractères.

**Contrôle du garde-fou.** Le test a été éprouvé et non seulement exécuté : une
description volontairement raccourcie à 11 caractères le fait bien échouer avec le nom
de la page en cause, et il repasse au vert une fois la page restaurée.

**Vérification indépendante de l'orchestrateur :** en excluant explicitement les
redirections et les pages `noindex`, le script de la fiche affiche zéro page hors cible
sur l'ensemble du site, et aucun tiret cadratin.
