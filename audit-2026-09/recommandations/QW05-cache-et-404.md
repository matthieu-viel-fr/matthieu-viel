# QW05 · En-têtes de cache et page 404 personnalisée

| | |
|---|---|
| Priorité | Quick win |
| Effort | 30 min |
| Impact | Performance sur visites répétées, rétention |
| Parité FR/EN | Oui, pour la page 404 |
| Dépendances | Que Nuxit autorise `mod_expires` et `mod_headers` |

## Constat mesuré (17/09/2026)

### Aucun en-tête de cache, nulle part

```
$ curl -sSI https://www.matthieu-viel.fr/assets/css/main.css
HTTP/1.1 200 OK
server: Apache
last-modified: Wed, 16 Sep 2026 12:55:11 GMT
etag: "2692-65b992d7cddaa"
vary: Accept-Encoding
content-type: text/css
strict-transport-security: max-age=86400; preload;
```

**Ni `Cache-Control`, ni `Expires`.** Idem sur les images et le JS. Chaque visite
revalide 3 CSS, 1 JS et 8 images, soit 12 requêtes conditionnelles évitables.

Bonne nouvelle : **gzip est bien actif** (accueil 44 382 o → 9 907 o, `vary` correct).
Ce n'est donc pas la compression qu'il faut ajouter, seulement le cache.

### Aucune page 404

```
$ curl -sSL -o /dev/null -w "%{http_code}\n" https://www.matthieu-viel.fr/page-qui-nexiste-pas
404
```

C'est la page Apache par défaut : fond blanc, « Not Found », aucune navigation, aucun
lien de retour. Aucun `ErrorDocument` dans `.htaccess` ni dans `dist/.htaccess`.

## Pourquoi c'est important

- **Cache.** Gain immédiat et gratuit sur toute visite répétée, et sur toute navigation
  de page en page à l'intérieur du site. C'est la règle 3 de `CLAUDE.md` sur la
  performance inconditionnelle.
- **404.** Un visiteur qui atterrit sur un lien mort aujourd'hui sort du site. Les
  sources de liens morts existent : `me-suivre.html` et `tiktok.html` sont redirigées,
  mais un partage social ancien ou une faute de frappe ne le sont pas.

## Ce qu'il faut faire

### 1. Ajouter les règles de cache

Dans `.htaccess` à la racine du dépôt (il est copié dans `dist/` par
[`src/export.php:65`](../../src/export.php#L65), ne pas éditer `dist/.htaccess`
directement) :

```apache
# Cache des ressources statiques
<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType text/css               "access plus 1 year"
  ExpiresByType application/javascript "access plus 1 year"
  ExpiresByType text/javascript        "access plus 1 year"
  ExpiresByType image/webp             "access plus 1 year"
  ExpiresByType image/svg+xml          "access plus 1 year"
  ExpiresByType font/woff2             "access plus 1 year"
  ExpiresByType text/html              "access plus 10 minutes"
</IfModule>

<IfModule mod_headers.c>
  <FilesMatch "\.(css|js|webp|svg|woff2)$">
    Header set Cache-Control "public, max-age=31536000, immutable"
  </FilesMatch>
  <FilesMatch "\.html$">
    Header set Cache-Control "public, max-age=600, must-revalidate"
  </FilesMatch>
</IfModule>
```

**Attention au cache d'un an sans versionnage.** Les assets n'ont pas de hash dans
leur nom (`main.css`, pas `main.a3f9c1.css`). Avec `max-age=31536000, immutable`, une
correction CSS ne parviendra pas aux visiteurs déjà venus. Deux options :

- **Prudente, recommandée pour commencer** : ramener les assets à
  `max-age=604800` (1 semaine). Le gain est déjà là, le risque disparaît.
- **Complète** : ajouter un paramètre de version aux liens d'assets dans
  `base.html.twig` (`main.css?v=2026-09-17`) et garder l'année. Nécessite de penser à
  bump le paramètre à chaque modification CSS, donc de le dériver d'une constante.

Commencer par l'option prudente. Passer à la seconde seulement si le versionnage est
automatisé.

### 2. Créer la page 404

Ajouter dans `.htaccess` :

```apache
ErrorDocument 404 /404.html
```

Créer `src/templates/404.html.twig`, étendant `base.html.twig`, et l'ajouter à
`getPages()` dans [`src/routes.php`](../../src/routes.php).

**Contenu proposé (FR).** Ton conforme au `seed/` : direct, sans jargon, sans
plaisanterie geek.

- H1 : `Cette page n'existe pas (ou plus).`
- Corps : `Le lien que vous avez suivi ne mène nulle part. Ce n'est pas votre faute,
  et ce n'est pas grave. Voici par où reprendre.`
- Trois liens : `Accueil`, `Expliquez-moi votre problème` (contact), `Audit technique`
- Un `tel:` : `Si c'est urgent, appelez le +262 693 85 28 12`
- `<meta name="robots" content="noindex, follow">`

**Miroir EN** `src/templates/en/404.html.twig`, servi à `/en/404.html`.
Apache ne peut déclarer qu'un seul `ErrorDocument` par répertoire : ajouter un
`.htaccess` dans `dist/en/` avec `ErrorDocument 404 /en/404.html`, ou accepter que la
404 FR serve aussi les URL EN cassées. La seconde option est acceptable au vu du
trafic EN attendu.

### 3. Ne pas oublier

`404.html` **ne doit pas** figurer dans `sitemap.xml`.

## Critères d'acceptation

- [ ] `Cache-Control` présent sur CSS, JS, WebP, SVG
- [ ] `Cache-Control` présent et court sur le HTML
- [ ] gzip toujours actif (ne pas casser le `vary`)
- [ ] `/page-qui-nexiste-pas` renvoie la 404 personnalisée, avec nav et footer
- [ ] La 404 porte `noindex, follow`
- [ ] La 404 n'est pas dans le sitemap
- [ ] Miroir EN créé
- [ ] Une modification de `main.css` est bien visible après déploiement (tester en navigation privée)

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
php src/export.php
grep -n "ExpiresByType\|Cache-Control\|ErrorDocument" .htaccess dist/.htaccess

# Après déploiement
for a in assets/css/main.css assets/js/main.js assets/images/portrait.webp; do
  printf "%-34s " "$a"
  curl -sSI "https://www.matthieu-viel.fr/$a" | grep -i "cache-control" || echo "MANQUANT"
done
curl -sSI https://www.matthieu-viel.fr/ | grep -iE "cache-control|content-encoding"
curl -sSL https://www.matthieu-viel.fr/page-qui-nexiste-pas | grep -c "nav__logo"
```

Attendu : `Cache-Control` sur les trois assets et sur le HTML, `content-encoding: gzip`
toujours présent, et la 404 qui contient bien la navigation du site.

## Règles `CLAUDE.md` engagées

- **Règle 3, performance** : pas de ressource bloquante injustifiée, cache exploité
- **Règle 4, accessibilité** : la 404 doit être navigable au clavier, focus visible
- **Règle 5, parité FR/EN**

## Référence

Point **11** de `TODO.md` (« Add cache/compression rules if server supports them »).
