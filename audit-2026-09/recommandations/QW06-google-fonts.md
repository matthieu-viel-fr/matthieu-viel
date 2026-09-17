# QW06 · Sortir Google Fonts du `@import` CSS

| | |
|---|---|
| Priorité | Quick win |
| Effort | 30 min (option A) à 1 h (option B) |
| Impact | LCP mobile, indépendance vis-à-vis d'un tiers |
| Parité FR/EN | Automatique (CSS et `base.html.twig` partagés) |
| Dépendances | Aucune |

## Constat mesuré (17/09/2026)

[`src/assets/css/main.css:1`](../../src/assets/css/main.css#L1) :

```css
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
```

Chaîne de chargement qui en résulte :

```
1. HTML                       (9,9 ko gzip)
2. → main.css                 (découvert dans le <head>)
3. → fonts.googleapis.com     (découvert seulement à l'intérieur du CSS)
4. → fonts.gstatic.com        (découvert seulement dans la réponse précédente)
```

Aucun `<link rel="preconnect">`, aucun `<link rel="preload">` dans
[`src/templates/base.html.twig`](../../src/templates/base.html.twig). Cinq graisses
demandées (400, 500, 600, 700, 800).

## Pourquoi c'est important

- **C'est le pire cas possible pour une police web.** Un `@import` à l'intérieur d'un
  CSS est invisible pour le scanner de préchargement du navigateur : la police n'est
  découverte qu'au troisième saut réseau, après deux allers-retours DNS et TLS sur des
  domaines tiers. Impact direct et mesurable sur le LCP mobile, qui est le contexte
  principal de la cible (un dirigeant qui consulte son téléphone en constatant que son
  site est en panne).
- **Violation de la règle 3 de `CLAUDE.md`** : « Pas de CSS ou JS bloquant injustifié »,
  « ressources critiques au-dessus de la ligne de flottaison : inline ou préchargées ».
- Deux domaines tiers de plus dans le chemin critique, donc deux points de défaillance.

## Ce qu'il faut faire

### Option A, rapide : déplacer dans le `<head>` avec `preconnect`

Dans [`src/templates/base.html.twig`](../../src/templates/base.html.twig), **avant**
les trois `<link rel="stylesheet">` existants :

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap">
```

Et supprimer la ligne 1 de `src/assets/css/main.css`.

Supprime un saut de la chaîne et ouvre les connexions en parallèle du HTML.

**Au passage, vérifier les graisses réellement utilisées :**

```bash
grep -rhoP "font-weight:\s*\K[0-9]+" src/assets/css/ | sort -u
```

Si `500` n'apparaît pas, la retirer de l'URL (c'est un fichier de police en moins à
télécharger). Ne pas retirer une graisse sans avoir vérifié.

### Option B, recommandée à terme : auto-héberger

Télécharger les deux ou trois fichiers `woff2` d'Inter réellement utilisés, les placer
dans `src/assets/fonts/`, et déclarer :

```css
@font-face {
  font-family: 'Inter';
  src: url('../fonts/inter-400.woff2') format('woff2');
  font-weight: 400;
  font-display: swap;
}
/* idem 600, 700, 800 */
```

Avec, dans `base.html.twig`, un préchargement de la seule graisse du texte courant :

```html
<link rel="preload" href="{{ asset_base }}assets/fonts/inter-400.woff2" as="font" type="font/woff2" crossorigin>
```

Élimine complètement les deux domaines tiers du chemin critique, supprime la
dépendance à Google, et retire un point de collecte de données. Comme les mentions
légales affirment que le site « n'utilise aucun cookie tiers » et « ne collecte aucune
donnée personnelle », l'auto-hébergement rapproche aussi le site de cette promesse :
un appel à `fonts.gstatic.com` transmet l'adresse IP du visiteur à Google.

Vérifier la licence : Inter est sous SIL Open Font License, l'auto-hébergement est
autorisé, le fichier de licence doit accompagner les polices.

**Recommandation : option A maintenant, option B dans la foulée si le temps le permet.**

### Repli système

Vérifier que la pile de repli est correcte dans `--ff`, pour que la page reste lisible
si la police ne charge pas :

```css
--ff: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, system-ui, sans-serif;
```

## Critères d'acceptation

- [ ] Plus aucun `@import` dans `src/assets/css/`
- [ ] `preconnect` présents avant la feuille de style des polices (option A), ou polices auto-hébergées (option B)
- [ ] Graisses inutilisées retirées, après vérification
- [ ] `font-display: swap` conservé
- [ ] Pile de repli système déclarée
- [ ] Rendu visuellement identique sur accueil, portfolio et une page d'audit
- [ ] Option B : fichier de licence SIL OFL présent à côté des polices

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
grep -rn "@import" src/assets/css/ && echo "IL RESTE UN @import" || echo "Aucun @import"
grep -n "preconnect\|fonts.googleapis\|preload" src/templates/base.html.twig
grep -rhoP "font-weight:\s*\K[0-9]+" src/assets/css/ | sort -u
php src/export.php && npm test
```

Après déploiement, contrôler dans l'onglet réseau des outils de développement que
`fonts.gstatic.com` est demandé **tôt** (option A) ou **plus du tout** (option B).

## Règles `CLAUDE.md` engagées

- **Règle 3, performance** : pas de bloquant injustifié, ressources critiques préchargées
- « Zéro dépendance externe inutile ajoutée sans accord explicite » : cette fiche en retire, elle n'en ajoute pas

## Référence

Point **10** de `TODO.md` (« Avoid render-blocking Google Fonts import »).
