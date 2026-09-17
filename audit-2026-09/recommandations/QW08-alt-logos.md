# QW08 · Nommer les logos clients dans les `alt`

| | |
|---|---|
| Priorité | Quick win |
| Effort | 20 min |
| Impact | SEO, GEO, accessibilité |
| Parité FR/EN | Oui, requise |
| Dépendances | Aucune |

## Constat mesuré (17/09/2026)

Les 14 `<img>` de l'accueil se décomposent ainsi :

```html
<img src="assets/images/portrait.webp" alt="Matthieu Viel, dépannage et conseil informatique à Saint-Pierre, La Réunion" width="400" height="400" loading="eager">
<img src="assets/images/logos/logo-citeo.webp"          alt="" width="158" height="96" loading="lazy">
<img src="assets/images/logos/logo-sellermania.webp"    alt="" width="371" height="96" loading="lazy">
<img src="assets/images/logos/logo-neosylva.webp"       alt="" width="464" height="96" loading="lazy">
<img src="assets/images/logos/logo-akeneo.webp"         alt="" width="256" height="96" loading="lazy">
<img src="assets/images/logos/logo-geofit.webp"         alt="" width="264" height="96" loading="lazy">
<img src="assets/images/logos/logo-tennis-contact.webp" alt="" width="349" height="96" loading="lazy">
... les six mêmes, dupliqués pour le défilement infini ...
<img src="assets/images/portrait.webp" alt="Matthieu Viel, développeur web indépendant basé à Saint-Pierre, La Réunion" width="360" height="450" loading="lazy">
```

**Les 12 logos sont tous en `alt=""`**, donc déclarés purement décoratifs. Le bloc est
dupliqué : 12 balises pour 6 logos distincts.

Les deux portraits ont des `alt` corrects et bien différenciés. Rien à changer de ce côté.

## Pourquoi c'est important

- **Ce sont les meilleurs signaux d'autorité du site**, et ils sont invisibles pour les
  crawlers comme pour les assistants IA. Citeo, Akeneo et Geofit sont des noms qui
  pèsent : les laisser en `alt=""` revient à afficher une preuve uniquement aux
  visiteurs voyants.
- **GEO.** Un assistant qui résume la page ne verra jamais ces noms depuis les images.
  Ils apparaissent bien dans le texte ailleurs sur la page, donc la perte est partielle,
  mais gratuite à récupérer.
- **Accessibilité.** Un lecteur d'écran annonce aujourd'hui une section
  « Ils m'ont fait confiance » suivie de rien du tout.

## Ce qu'il faut faire

**Première série** : `alt` nommant le client.
**Copie de défilement** : `alt=""` **et** `aria-hidden="true"` sur le conteneur, pour
ne pas faire annoncer deux fois la même liste.

```html
<!-- première série, celle qui porte l'information -->
<img src="assets/images/logos/logo-citeo.webp"          alt="Citeo"          width="158" height="96" loading="lazy">
<img src="assets/images/logos/logo-sellermania.webp"    alt="Sellermania"    width="371" height="96" loading="lazy">
<img src="assets/images/logos/logo-neosylva.webp"       alt="Néosylva"       width="464" height="96" loading="lazy">
<img src="assets/images/logos/logo-akeneo.webp"         alt="Akeneo"         width="256" height="96" loading="lazy">
<img src="assets/images/logos/logo-geofit.webp"         alt="Geofit"         width="264" height="96" loading="lazy">
<img src="assets/images/logos/logo-tennis-contact.webp" alt="Tennis Contact" width="349" height="96" loading="lazy">

<!-- copie de défilement, purement visuelle -->
<div class="logos__track" aria-hidden="true">
  <img src="assets/images/logos/logo-citeo.webp" alt="" width="158" height="96" loading="lazy">
  ...
</div>
```

Garder les `alt` **courts** : le nom de la marque, rien de plus. Un `alt` de logo ne
doit pas décrire le dessin ni ajouter de contexte marketing. Ne pas écrire
« Logo de Citeo, client de Matthieu Viel » : c'est du remplissage, et la règle
« pas de contenu artificiel » de `CLAUDE.md` s'y applique.

**Vérifier au passage le droit d'usage.** Afficher un logo client suppose un accord,
au moins tacite. Si un des six n'a jamais donné son accord, la question se pose
indépendamment de cette fiche.

### Optimisation liée

Les 6 logos dupliqués provoquent 6 requêtes supplémentaires. Si le navigateur les
sert depuis son cache mémoire, le coût est nul ; sinon il double. Après
[QW05](QW05-cache-et-404.md), ce point devient négligeable. À ne traiter que si une
mesure montre un vrai surcoût.

## Critères d'acceptation

- [ ] Les 6 logos de la première série ont un `alt` nommant le client
- [ ] La copie de défilement est en `alt=""` et son conteneur en `aria-hidden="true"`
- [ ] Aucun `alt` ne dépasse le nom de la marque
- [ ] Miroir EN fait (mêmes noms, ce sont des marques)
- [ ] Un lecteur d'écran annonce les six noms **une seule fois**
- [ ] `width`, `height` et `loading` inchangés

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
php src/export.php
grep -oP '<img[^>]*logo-[^>]*>' dist/index.html | grep -oP 'alt="[^"]*"' | sort | uniq -c
grep -oP '<img[^>]*logo-[^>]*>' dist/en/index.html | grep -oP 'alt="[^"]*"' | sort | uniq -c
echo "img sans alt sur tout le site :"
grep -roP '<img(?![^>]*alt=)[^>]*>' dist --include=*.html | wc -l
```

Attendu : 6 `alt` nommés et 6 `alt=""` par page d'accueil, `0` image sans attribut `alt`.

## Règles `CLAUDE.md` engagées

- **Règle 2, SEO** : tout `<img>` a un `alt` descriptif
- **Règle 4, accessibilité** : structure sémantique correcte
- **Règle 5, parité FR/EN**
- « Ne pas générer de contenu artificiel » : `alt` courts, pas de bourrage
