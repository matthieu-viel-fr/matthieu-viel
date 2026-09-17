# QW03 · Corriger le `sitemap.xml`

| | |
|---|---|
| Priorité | Quick win |
| Effort | 30 min |
| Impact | Indexation, signaux de qualité |
| Parité FR/EN | Oui, requise |
| Dépendances | La décision sur `quiz.html` (voir plus bas) |

## Constat mesuré (17/09/2026)

`sitemap.xml` est **maintenu à la main** à la racine du dépôt, puis copié dans `dist/`
par [`src/export.php:65`](../../src/export.php#L65). Il n'est pas généré depuis
`routes.php`, d'où la dérive.

**27 URL déclarées pour 29 pages servies.**

### Problème 1 : `senior-tech.html` absente

```bash
$ grep -c "senior-tech" sitemap.xml
0
```

Cette page est pourtant liée depuis la **nav et le footer de toutes les pages** du
site, sous le libellé « Missions ». C'est une page de service majeure, invisible dans
le sitemap.

`tech.html` est légitimement absente : c'est une page de redirection par méta-refresh
vers `senior-tech.html`, elle ne doit pas être déclarée.

### Problème 2 : `quiz.html` présente mais orpheline

`https://www.matthieu-viel.fr/quiz.html` est déclarée dans le sitemap, et :

- `<meta name="description">` : **absente**
- `<link rel="canonical">` : **absent**
- `hreflang` : **aucun**
- Pages du site qui pointent vers elle : **zéro**

Elle contient pourtant le seul formulaire du site (56 ko de HTML).

L'orphelinat est délibéré (point **A5** de `TODO.md`), mais la présence dans le
sitemap ne l'est probablement pas : déclarer indexable une page que rien ne recommande
est un signal de faible qualité.

### Problème 3 : `priority` non discriminant

```
19 URL sur 27 à priority 0.8
```

Les 7 sous-pages d'audit sont au même niveau que le portfolio et les pages EN.
Sans gravité, mais le signal est nul.

## Ce qu'il faut faire

### 1. Ajouter `senior-tech.html`

Dans `sitemap.xml`, avec le même format `xhtml:link` que les autres entrées. Attention :
cette page n'a **pas d'équivalent EN**, sa bascule de langue pointe vers `en/index.html`.
Deux options :

- **Recommandée** : déclarer seulement `hreflang="fr"` et `x-default` pointant sur
  elle-même, ce que fait déjà le template. Ne pas inventer un `hreflang="en"` vers
  `en/index.html`, ce serait une déclaration fausse (les deux pages n'ont pas le même
  contenu).
- Ou créer la page EN, ce qui relève de [MT18](MT18-sort-senior-tech.md).

```xml
<url>
  <loc>https://www.matthieu-viel.fr/senior-tech.html</loc>
  <lastmod>2026-09-16</lastmod>
  <changefreq>monthly</changefreq>
  <priority>0.7</priority>
  <xhtml:link rel="alternate" hreflang="fr" href="https://www.matthieu-viel.fr/senior-tech.html"/>
  <xhtml:link rel="alternate" hreflang="x-default" href="https://www.matthieu-viel.fr/senior-tech.html"/>
</url>
```

**Note :** si [MT18](MT18-sort-senior-tech.md) aboutit à la suppression de cette page,
cette étape devient sans objet. Faire QW03 d'abord quand même : une page liée partout
doit être déclarée tant qu'elle existe.

### 2. Trancher sur `quiz.html`

| Option | Quoi faire |
|---|---|
| **A** | La conserver dans le sitemap et la compléter (description, canonical, hreflang) si elle doit rester indexable et recevoir du trafic depuis LinkedIn. L'orphelinat interne est alors un choix documenté, pas un défaut. |
| **B** | La retirer du sitemap et lui ajouter `<meta name="robots" content="noindex, follow">` si elle doit seulement continuer à fonctionner pour les liens existants, sans être une page d'acquisition. |

Le point A5 de `TODO.md` impose de conserver l'URL, pas son indexation. Décider sur
la base de Search Console et du rôle réellement assigné au quiz. Ne pas le relier à
l'accueil par défaut : cela contredirait le positionnement actuel.

### 3. Retirer `priority` et `changefreq`

Google ignore ces deux champs. Conserver des `lastmod` exacts, mis à jour uniquement
quand le contenu principal change, et concentrer la vérification sur les URL
canoniques que l'on souhaite réellement voir indexées.

### 4. Envisager la génération automatique

La dérive constatée vient du fait que `sitemap.xml` est maintenu à la main alors que
`routes.php` est déjà la source de vérité unique pour le routage. Générer le sitemap
depuis `getPages()` supprime la classe entière de problème.

C'est le point **8** de `TODO.md` (« Add sitemap consistency test »). À défaut de
générer, ajouter au moins le test de cohérence : toute page de `getPages()` qui n'est
pas une redirection doit être dans le sitemap.

## Critères d'acceptation

- [ ] `senior-tech.html` déclarée dans `sitemap.xml`
- [ ] `tech.html` toujours absente
- [ ] `quiz.html` : soit conservée et complétée pour l'indexation, soit retirée + `noindex`
- [ ] `priority` et `changefreq` retirés ; `lastmod` reste fiable
- [ ] `lastmod` mis à jour sur les entrées modifiées
- [ ] Le sitemap reste un XML valide
- [ ] `dist/sitemap.xml` régénéré par `php src/export.php`

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
python3 -c "import xml.dom.minidom,sys; xml.dom.minidom.parse('sitemap.xml'); print('XML valide')"
echo "URL déclarées :"; grep -c "<url>" sitemap.xml
echo "senior-tech :"; grep -c "senior-tech" sitemap.xml
echo "tech.html seul :"; grep -c "fr/tech.html" sitemap.xml
echo "quiz :"; grep -c "quiz" sitemap.xml
php src/export.php
diff <(grep -o "<loc>[^<]*" sitemap.xml) <(grep -o "<loc>[^<]*" dist/sitemap.xml) && echo "dist/ synchronisé"
```

Attendu : `senior-tech` présent, `tech.html` absent ; statut de `quiz.html` cohérent
avec la décision documentée ci-dessus.

## Règles `CLAUDE.md` engagées

- Règle 2, SEO : indexation, cohérence des canoniques
- Règle 5, parité FR/EN
- « Ne pas toucher à la structure d'URL existante » : cette fiche n'en modifie aucune

## Référence

Points **A5** et **8** de `TODO.md`.
