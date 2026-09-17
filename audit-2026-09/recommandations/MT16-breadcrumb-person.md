# MT16 · Ajouter `BreadcrumbList` et enrichir le `Person` de l'accueil

| | |
|---|---|
| Priorité | Moyen terme |
| Effort | 0,5 j |
| Impact | UX et présentation SERP possible |
| Parité FR/EN | Oui, requise |
| Dépendances | [MT12](MT12-page-a-propos.md) de préférence (source de la `description`) |

## Constat mesuré (17/09/2026)

### Aucun `BreadcrumbList` sur les 29 pages

```bash
$ grep -rl "BreadcrumbList" dist --include=*.html | wc -l
0
```

Or 14 pages sont à trois niveaux de profondeur (`/audit/<slug>/`), et il n'existe ni
fil d'Ariane visuel, ni fil d'Ariane balisé.

### `Person` de l'accueil incomplet

Comparaison des deux `Person` du site :

| Champ | `index.html` | `senior-tech.html` |
|---|---|---|
| `name` | ✅ | ✅ |
| `jobTitle` | ✅ | ✅ |
| `url` | ✅ | ✅ |
| `image` | ✅ | ✅ |
| `sameAs` | ✅ (4 profils) | ✅ (2 profils) |
| `address` | ✅ | ✅ |
| `description` | ❌ | ✅ |
| `knowsAbout` | ❌ | ✅ (9 entrées) |
| `email` | ❌ | ❌ |
| `telephone` | ❌ | ❌ |
| `hasOfferCatalog` | ❌ | ✅ |
| `memberOf` | ❌ | ❌ |

**La page la plus consultée du site est la moins bien renseignée.**

Note : le `LocalBusiness` de l'accueil est lui très complet (`geo`, `areaServed`,
`hasOfferCatalog` avec plusieurs `Offer`, `telephone`, `email`, `priceRange`). C'est
le `Person` qui est pauvre, et c'est lui qui répond à « qui est Matthieu Viel ».

### Autres manques

- **Aucun `Service` ni `ProfessionalService`** balisé hors du `hasOfferCatalog` de l'accueil
- **Les 7 pages d'audit n'ont aucun `Offer`**
- **Le portfolio n'a aucun JSON-LD du tout**

## Pourquoi c'est important

- **`BreadcrumbList`** peut permettre à Google d'afficher un chemin dans la SERP et,
  avec un fil visible, aide aussi l'utilisateur à naviguer. L'affichage n'est pas
  garanti et son effet sur le CTR doit être mesuré.
- **`Person` enrichi** : garder des données exactes et visibles peut améliorer la
  compréhension des entités, sans garantie de visibilité ni d'effet GEO. Le contenu
  visible et les preuves externes restent prioritaires.
- **`memberOf` pour l'OCOI** : le mandat de secrétaire adjoint de l'Observatoire
  Cybersécurité de l'Océan Indien est un signal d'autorité fort et vérifiable,
  aujourd'hui invisible pour les machines.

## Ce qu'il faut faire

### 1. `BreadcrumbList` sur les pages profondes

Ajouter un bloc générique dans [`src/templates/base.html.twig`](../../src/templates/base.html.twig),
alimenté depuis le contexte de `routes.php` (qui connaît déjà la profondeur via
`substr_count($output, '/')`).

```json
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Accueil",         "item": "https://www.matthieu-viel.fr/" },
    { "@type": "ListItem", "position": 2, "name": "Audit technique", "item": "https://www.matthieu-viel.fr/audit/" },
    { "@type": "ListItem", "position": 3, "name": "Tests automatisés" }
  ]
}
```

Le dernier élément n'a **pas** de `item` : c'est la page courante.

**Ajouter aussi le fil d'Ariane visuel**, pas seulement le balisage. Google demande que
les données structurées correspondent à un contenu visible. Un `<nav aria-label="Fil
d'Ariane">` avec une liste ordonnée, discret, au-dessus du H1.

Pages concernées : les 14 sous-pages d'audit, plus toute nouvelle page profonde créée
par [MT13](MT13-pages-probleme.md).

### 2. `Person` : compléter seulement les informations utiles et visibles

Dans `{% block schema_ld %}` de `index.html.twig` et `en/index.html.twig` :

```json
{
  "@context": "https://schema.org",
  "@type": "Person",
  "name": "Matthieu Viel",
  "jobTitle": "Développeur web indépendant",
  "description": "Je suis Matthieu Viel, développeur web indépendant à Saint-Pierre, à La Réunion. J'aide les dirigeants de petites entreprises qui n'ont pas d'informaticien à remettre leurs outils en état, puis à les garder en état toute l'année. J'interviens aussi comme regard technique senior auprès d'équipes de développement.",
  "url": "https://www.matthieu-viel.fr",
  "image": "https://www.matthieu-viel.fr/assets/images/portrait.webp",
  "email": "contact@matthieu-viel.fr",
  "telephone": "+262693852812",
  "knowsAbout": [
    "Dépannage informatique", "Sécurité des sites web", "Sauvegarde et restauration",
    "PHP 8", "Symfony", "API Platform", "React", "TypeScript",
    "Cypress", "CI/CD", "Docker"
  ],
  "memberOf": {
    "@type": "Organization",
    "name": "Observatoire Cybersécurité de l'Océan Indien"
  },
  "areaServed": [
    { "@type": "Place", "name": "La Réunion" },
    { "@type": "Place", "name": "France" }
  ],
  "sameAs": [ "... les 4 profils existants ..." ],
  "address": { "... inchangé ..." }
}
```

La `description` doit correspondre à la présentation visible. Une formulation
cohérente est souhaitable, sans supposer qu'elle stabilise les résumés d'assistants.

**`email` doit être la nouvelle adresse** de [QW01](QW01-unifier-email.md).

`knowsAbout` mélange volontairement le vocabulaire TPE et le vocabulaire technique :
c'est la seule structure du site qui peut porter les deux portes sans hiérarchie
visuelle.

### 3. `Offer` sur les pages d'audit

Chaque page d'audit décrit une prestation. Ajouter un `Service` avec `provider`
pointant sur le `Person`, en gardant les `HowTo` et `FAQPage` existants qui
fonctionnent bien.

### 4. JSON-LD sur le portfolio

Le portfolio n'a **aucun** JSON-LD. Ajouter au minimum un `Person` et, si les cas sont
restructurés par [LT22](LT22-portfolio.md), un `ItemList` de `CreativeWork`.

### Précaution

**Ne pas déclarer ce qui n'est pas visible sur la page.** Google pénalise les données
structurées sans contrepartie visible. Chaque champ ajouté doit correspondre à un
contenu réellement affiché.

## Critères d'acceptation

- [ ] `BreadcrumbList` sur les 14 pages d'audit FR et EN
- [ ] Fil d'Ariane **visuel** correspondant, accessible au clavier
- [ ] `Person` de l'accueil complété seulement lorsque l'information est visible et maintenable
- [ ] `email` = `contact@matthieu-viel.fr`
- [ ] `memberOf` OCOI présent
- [ ] `Service` sur les pages d'audit
- [ ] JSON-LD présent sur le portfolio
- [ ] Tous les JSON-LD passent le Rich Results Test de Google
- [ ] Aucune donnée structurée sans contrepartie visible
- [ ] Miroir EN fait

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
php src/export.php && npm test
echo "Pages avec BreadcrumbList :"; grep -rl "BreadcrumbList" dist --include=*.html | wc -l
echo "Pages sans aucun JSON-LD :"
for f in $(find dist -name "*.html"); do grep -q "ld+json" "$f" || echo "  $f"; done
python3 - <<'PY'
import re,json,glob
for p in sorted(glob.glob('dist/**/*.html',recursive=True)):
    s=open(p,encoding='utf-8').read()
    for b in re.findall(r'ld\+json[^>]*>(.*?)</script>',s,re.S):
        try: json.loads(b)
        except Exception as e: print(f"JSON invalide dans {p}: {e}")
print("Validation JSON terminée")
PY
```

Puis passer l'accueil et une page d'audit dans le Rich Results Test de Google et dans
le validateur schema.org.

## Règles `CLAUDE.md` engagées

- **Règle 2, SEO/GEO** : JSON-LD `Person` + `LocalBusiness` présents et à jour
- **Règle 4, accessibilité** : le fil d'Ariane visuel doit être navigable
- **Règle 5, parité FR/EN**

## Référence

Point **21** de `TODO.md` (« Add structured data consistency checks »).
