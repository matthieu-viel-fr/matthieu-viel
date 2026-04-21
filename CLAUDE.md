# CLAUDE.md — matthieu-viel.fr

Site vitrine statique (HTML/CSS/JS). Pas de framework, pas de build system.
Toute modification doit respecter les quatre règles permanentes ci-dessous.

---

## 1. Ton éditorial & charte graphique

**Référence absolue : dossier `/seed/`**
Avant toute modification de contenu ou de style, consulte les fichiers du dossier `seed/`.
Ils font foi sur le ton, le vocabulaire, la palette, la typographie et l'identité visuelle.

Principes extraits de ces sources :
- Ton direct, sans jargon, honnête — jamais de formules creuses ou de superlatifs
- Voix active, phrases courtes, bénéfice avant la technique
- Persona : consultant senior ancré localement, pas une agence
- Ne jamais introduire de nouveau terme marketing non présent dans `seed/`

---

## 2. SEO & GEO — règles non négociables

### Sur chaque page modifiée, vérifier systématiquement :
- `<title>` : 55-60 caractères, mot-clé principal + localisation
- `<meta description>` : 150-160 caractères, bénéfice clair
- Une seule `<h1>`, hiérarchie `h1 > h2 > h3` stricte
- Balise `canonical` présente
- Tous les `<img>` ont un `alt` descriptif (sujet + contexte + lieu si pertinent)
- JSON-LD `Person` + `LocalBusiness` présents sur la home, à jour

### GEO (visibilité dans les réponses IA)
- Toujours privilégier des **faits précis et chiffrés** : 17 ans d'expérience,
  500+ scénarios Cypress, 70% couverture tests Citeo, Saint-Pierre 974, UTOI 117 km
- Chaque cas client : client nommé + durée + résultat chiffré
- Paragraphes courts et denses (≤ 4 lignes), sans remplissage
- Les sections FAQ (si créées) doivent répondre directement en une phrase

---

## 3. Performance — inconditionnelle

- Images : format WebP uniquement, attributs `width` et `height` toujours présents
- `loading="lazy"` sur toute image hors viewport initial
- Pas de CSS ou JS render-blocking non justifié
- Ressources critiques (above the fold) : inline ou préchargées via `<link rel="preload">`
- Zéro dépendance externe non nécessaire ajoutée sans validation explicite

---

## 4. Accessibilité & responsive mobile

- Mobile-first : tester mentalement tout ajout sur 375px avant 1280px
- Contraste WCAG AA minimum sur tout texte (ratio ≥ 4.5:1 sur fond)
- Focus visible sur tous les éléments interactifs
- `aria-label` sur tout lien dont l'intitulé seul est ambigu ("voir plus", "ici"...)
- Structure sémantique : `<header>`, `<main>`, `<section>`, `<footer>` correctement utilisés

---

## À ne jamais faire

- Modifier le ton ou introduire du jargon non validé par `/seed/`
- Ajouter un framework JS ou une dépendance npm sans demande explicite
- Faire une refonte structurelle sans accord préalable
- Générer du contenu keyword-stuffed ou artificiel
- Supprimer ou altérer les scripts tiers (Calendly)
- Toucher à la structure des URLs existantes

---

## Workflow sur chaque tâche

1. Lire les fichiers concernés avant toute modification
2. Consulter `/seed/` si la tâche touche au contenu ou au style
3. Appliquer les règles 1 à 4 silencieusement — pas besoin de le signaler à chaque fois
4. En fin de tâche : lister les changements effectués + signaler tout écart potentiel
   avec les règles ci-dessus