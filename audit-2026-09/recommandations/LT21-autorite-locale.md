# LT21 · Construire l'autorité locale

| | |
|---|---|
| Priorité | Long terme, latence longue |
| Effort | 1 j de mise en place, puis entretien mensuel |
| Impact | SEO local, le plus rentable pour une activité de proximité |
| Parité FR/EN | Sans objet (signaux locaux FR) |
| Dépendances | [QW01](QW01-unifier-email.md) (NAP unifié) **impérativement d'abord** |

## Constat mesuré (17/09/2026)

### Signaux locaux présents sur le site

Solides et cohérents : Saint-Pierre, 97410, La Réunion, 974 répétés sur toutes les
pages. `LocalBusiness` complet avec `geo` (latitude -21.3393, longitude 55.4781),
`areaServed`, `telephone`, `priceRange`, `hasOfferCatalog`.

### Ce qui manque hors du site

| Signal | État |
|---|---|
| **Fiche Google Business Profile** | Non confirmée depuis le crawl : vérifier dans le compte Google et les résultats locaux |
| Annuaires locaux 974 | Non constaté |
| Chambre de métiers, réseaux d'entrepreneurs réunionnais | Non constaté |
| Lien entrant depuis le site de l'OCOI | Non constaté |
| Cohérence NAP entre site et profils externes | **Compromise** : deux emails différents (voir QW01) |

### Communes non mentionnées

Le site annonce intervenir « dans le sud de La Réunion », mais ne nomme que
Saint-Pierre. **Le Tampon, Saint-Louis, Étang-Salé, Saint-Joseph, Petite-Île
n'apparaissent nulle part.**

## Pourquoi c'est important

Sur une requête comme « dépannage informatique Saint-Pierre », **c'est le pack local
qui capte les clics**, pas les résultats bleus. Sans fiche Google Business Profile,
le site ne peut pas y figurer, quelle que soit la qualité de ses pages.

C'est le levier de SEO local le plus rentable qui existe pour une activité de service
de proximité, et il n'est pas utilisé. Toutes les autres recommandations de ce dossier
travaillent le référencement organique ; celle-ci travaille un canal distinct, souvent
plus gros en volume sur ce type d'activité.

La latence est longue (vérification postale, temps d'accumulation des avis), d'où le
classement en long terme malgré une priorité réelle élevée. **À lancer tôt, même si
les résultats arrivent tard.**

## Ce qu'il faut faire

### 1. Vérifier l'éligibilité avant de créer la fiche Google Business Profile

- Confirmer que l'activité reçoit ou visite réellement les clients selon les règles
  Google ; une activité exclusivement en ligne n'est pas éligible.
- **Catégorie principale** : à choisir après analyse des catégories et concurrents locaux ;
  « Service de réparation informatique » est une hypothèse de départ.
- **Catégories secondaires** : « Concepteur de sites Web », « Consultant en informatique »
- **NAP strictement identique au site** : Matthieu Viel, Rue des bons enfants,
  97410 Saint-Pierre, +262 693 85 28 12, `contact@matthieu-viel.fr`.
  **Faire [QW01](QW01-unifier-email.md) avant**, sinon la fiche naît avec l'incohérence.
- **Zone desservie** : déclarer les communes du sud réellement couvertes
- **Horaires** : cohérents avec « du lundi au vendredi, heure de La Réunion » affiché
  sur `/contact.html`
- **Description** : reprendre la phrase canonique de [MT12](MT12-page-a-propos.md)
- **Photos** : portrait, et si possible des visuels d'intervention. Pas de banque d'images.
- **Lien** : vers `https://www.matthieu-viel.fr/`

Point d'attention : la fiche demande une adresse. Si vous travaillez depuis votre
domicile, GBP permet de **masquer l'adresse** et de ne déclarer qu'une zone desservie.
Les mentions légales affichent déjà « Rue des bons enfants », donc l'information est
publique, mais le choix reste le vôtre.

### 2. Collecter des avis

C'est le facteur numéro un du classement local, et le plus lent à construire.

- Demander un avis Google **en même temps** que le témoignage de
  [MT15](MT15-temoignages-tpe.md) : même effort pour le client, double bénéfice.
- Viser 5 avis sur trois mois, puis 1 par mois. La régularité compte plus que le volume.
- Répondre à **tous** les avis, y compris négatifs. Une réponse calme à un avis
  négatif est plus convaincante que dix avis cinq étoiles.
- **Ne jamais acheter d'avis, ni en fabriquer.**

### 3. Annuaires et réseaux

Par ordre de valeur décroissante :

1. **Site de l'OCOI**, avec lien retour. Vous en êtes secrétaire adjoint : c'est le
   lien le plus légitime et le plus facile à obtenir de toute cette liste.
2. **Chambre de commerce et chambre de métiers de La Réunion**
3. **Réseaux d'entrepreneurs réunionnais** (clubs d'affaires, réseaux BNI locaux)
4. **Annuaires professionnels locaux**, en vérifiant leur sérieux avant inscription
5. **Malt**, déjà en place, à garder à jour et cohérent en NAP

**Le NAP doit être identique partout, au caractère près.** « Saint-Pierre » et
« St-Pierre » comptent comme deux entités différentes.

### 4. Valoriser l'OCOI

Le mandat est un actif d'autorité sous-exploité. Il n'apparaît que dans un encart de
l'accueil.

- Ajouter `memberOf` au JSON-LD ([MT16](MT16-breadcrumb-person.md))
- Écrire un article co-signé ou une contribution sur le site de l'OCOI, avec lien retour
- Le mentionner sur `/a-propos/` ([MT12](MT12-page-a-propos.md)) avec une phrase qui
  explique ce que c'est : « Observatoire Cybersécurité de l'Océan Indien » ne dit rien
  à un artisan.

### 5. Nommer les communes sur le site

Ajouter explicitement les communes réellement couvertes sur `/a-propos/`,
`/accompagnement/` et `/contact.html` :

```
Sur site à Saint-Pierre, Le Tampon, Saint-Louis, Étang-Salé, Saint-Joseph et
Petite-Île. À distance partout ailleurs en France.
```

**Ne pas lister une commune où vous ne vous déplacez pas.** Une page bourrée de noms
de communes sans intervention réelle derrière est exactement le « contenu artificiel »
que `CLAUDE.md` interdit, et Google le détecte.

**Ne pas créer de pages « dépannage informatique à [commune] »** dupliquées. C'est la
technique classique, elle est pénalisée, et elle contredit la règle du projet.

## Critères d'acceptation

- [ ] [QW01](QW01-unifier-email.md) fait, NAP unifié
- [ ] Fiche GBP créée, vérifiée, avec la bonne catégorie
- [ ] NAP identique au caractère près entre site, GBP, Malt, LinkedIn
- [ ] Au moins 5 avis Google obtenus sur trois mois
- [ ] Tous les avis ont reçu une réponse
- [ ] Lien retour obtenu depuis au moins une source d'autorité locale
- [ ] `memberOf` OCOI dans le JSON-LD
- [ ] Communes réellement couvertes nommées sur le site
- [ ] Aucune page de commune dupliquée
- [ ] Aucun avis acheté ou fabriqué

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
echo "Communes mentionnées :"
for c in "Saint-Pierre" "Le Tampon" "Saint-Louis" "Étang-Salé" "Saint-Joseph" "Petite-Île"; do
  printf "  %-16s %s\n" "$c" "$(grep -rl "$c" dist --include=*.html | wc -l)"
done
echo "NAP téléphone :"; grep -roh "+262693852812\|+262 693 85 28 12" dist --include=*.html | sort | uniq -c
echo "NAP email :";     grep -roh "contact@matthieu-viel\.fr"        dist --include=*.html | wc -l
```

Vérifications manuelles, mensuelles :
- Rechercher « dépannage informatique Saint-Pierre » depuis La Réunion et noter la position
- Vérifier que la fiche GBP apparaît
- Comparer le NAP affiché sur GBP, Malt, LinkedIn et le site

## Règles `CLAUDE.md` engagées

- **Règle 2, SEO local et GEO** : cohérence NAP, faits précis
- « Ne jamais générer de contenu bourré de mots-clés ou artificiel » : pas de pages de commune dupliquées

## Note

C'est la seule fiche du dossier dont l'essentiel se joue **hors du dépôt**. Les
modifications du site (communes nommées, `memberOf`) sont mineures ; le travail réel
est administratif et relationnel.
