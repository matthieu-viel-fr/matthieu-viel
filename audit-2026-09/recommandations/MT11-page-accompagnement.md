# MT11 · Créer la page `/accompagnement/` et `/en/support-plan/`

| | |
|---|---|
| Priorité | Conditionnelle : après validation de l'offre (A4) |
| Effort | 1 j de rédaction et d'intégration |
| Impact | Revenu récurrent, positionnement « partenaire tech » |
| Parité FR/EN | Oui, requise |
| Dépendances | Décision d'offre et capacité de delivery (A4 de `TODO.md`), puis [QW10](QW10-phrase-anti-dependance.md) |

## Constat mesuré (17/09/2026)

Recherche sur les 29 pages servies :

| Terme | Occurrences |
|---|---|
| « accompagnement », « suivi », « partenaire », « toute l'année », « mensuel », « abonnement » | **0** |
| « panne », « piraté », « disparu », « récupérer », « nettoyer », « réparer » | omniprésents |

Le site n'a **aucune offre récurrente**, aucune page Offre ou Services, et le champ
lexical est entièrement celui de la panne.

Le process en trois étapes s'arrête à « Je répare, et je vous montre ». Après cette
étape, le site ne propose rien.

## Pourquoi c'est une opportunité à valider

Le modèle actuel est du **break/fix** : un client entre en urgence, paie une fois,
et sort. Chaque euro de chiffre d'affaires demande un nouveau lead.

Le modèle visé est le **partenariat tech** : le même client, une fois rassuré par une
première intervention réussie, reste. Le coût d'acquisition est amorti sur des mois.

Le dépannage n'est pas une erreur de positionnement, c'est **la meilleure porte
d'entrée possible** vers une TPE : elle s'ouvre au moment exact où le dirigeant a un
problème et un budget. Ce qui manque n'est pas de remplacer cette porte, c'est
d'installer l'étage au-dessus.

C'est aussi cette page qui porte le vocabulaire de « partenaire tech » et de « CTO à
la demande », absent partout ailleurs.

## Décision préalable : le modèle de service

`TODO.md` (point **A4**) a explicitement mis ce choix en attente, et la mémoire projet
confirme : aucun prix ni forfait sur le site pour l'instant.

Une borne de prix peut améliorer l'auto-qualification, mais elle n'est pas une
condition universelle de conversion. Elle ne doit apparaître que si le périmètre, la
marge et la promesse de service sont stabilisés. Une offre imprécise ou un tarif
provisoire publié trop tôt créerait une dette commerciale plus coûteuse qu'une page
absente.

Ce qu'il faut trancher, par ordre croissant d'engagement :

| Option | Formulation type | Engagement |
|---|---|---|
| A | « À partir de X € par mois, selon le nombre d'outils à suivre. » | Minimal, recommandé pour démarrer |
| B | Deux ou trois paliers nommés avec leur prix | Fort, demande d'avoir cadré les périmètres |
| C | « Prix défini ensemble après un premier échange » | Aucun, mais reproduit le problème actuel |

Ne choisir A, B ou C qu'après des entretiens clients et quelques interventions : qui
demande du suivi, quel périmètre est répétable, quel délai de réponse est tenable ?
Tant que cette réponse manque, ne pas créer cette page ni afficher un montant
provisoire. Documenter la décision dans `visibilite/actions/positionnement.md`, qui
reste la source de vérité.

## Contenu proposé

### Métadonnées

```
title       : Votre informaticien attitré, sans l'embaucher · TPE 974     (55)
description : Un informaticien joignable toute l'année pour votre TPE, sans l'embaucher : surveillance, sauvegardes, dépannage, petites évolutions. Saint-Pierre 974.   (151)
```

Longueurs validées, conformes à la règle 2.

### H1

```
Votre informaticien, sans la fiche de paie
```

### Intro

```
Embaucher un informaticien coûte environ 45 000 € par an. La plupart des petites
entreprises n'en ont pas besoin à plein temps. Elles ont besoin de quelqu'un qui
connaît déjà leurs outils, qui répond quand ça coince, et qui s'assure que rien ne
dérive entre deux appels.

C'est ce que je fais.
```

Vérifier le chiffre de 45 000 € avant publication (coût employeur d'un profil junior
à La Réunion, charges comprises). **Ne pas publier un chiffre non vérifié** : la règle
GEO du projet impose des faits précis et exacts, et c'est aussi la base de la
crédibilité du site.

### H2 « Ce qui est inclus »

- Surveillance du site et vérification effective des sauvegardes
- Mises à jour de sécurité
- Dépannage, sans facture à la ligne
- Petites évolutions : une page, un formulaire, un réglage
- Un point tous les trimestres sur ce qui va et ce qui vient
- Un interlocuteur unique, qui connaît déjà votre installation

### H2 « Ce qui n'est pas inclus »

- Une refonte complète de votre site
- Le développement d'une nouvelle application
- L'achat de votre matériel
- L'assistance sur les postes de travail de vos salariés

**Cette section est la plus importante de la page.** Dire ce qu'on ne fait pas est le
signal de confiance le plus fort qu'une page d'offre puisse envoyer, et c'est
exactement le ton du `seed/` : honnête, sans promesse creuse.

### H2 « Combien ça coûte »

Selon l'option retenue. Avec l'option A :

```
À partir de X € par mois, selon le nombre d'outils à suivre et leur état de départ.

Je ne fais pas de devis à l'aveugle. On regarde ensemble ce que vous avez, je vous
dis ce que ça représente, et vous décidez. Si votre installation est saine, le suivi
coûte moins cher. Si elle ne l'est pas, on commence par la remettre d'aplomb, et ça,
c'est une intervention ponctuelle, pas un abonnement.
```

### H2 « Pour qui »

Trois profils, à raccrocher aux situations déjà décrites sur l'accueil :

1. **Vous avez un site, et personne pour s'en occuper.** Il tourne, mais vous ne savez
   pas s'il est à jour, ni s'il est sauvegardé, ni qui appeler s'il tombe.
2. **Vous venez de récupérer vos accès.** Votre ancien prestataire est parti, vous avez
   repris la main, et vous ne voulez pas revivre ça.
3. **Vos outils marchent, mais vous y passez trop de temps.** Recopier, renommer,
   renvoyer. Chaque mois, on en automatise un bout.

### H2 « Comment on commence »

Renvoyer vers [MT19](MT19-page-methode.md), ou reprendre les trois étapes.

### CTA

Bouton primaire : `Parlons de votre installation` vers le formulaire de
[MT14](MT14-formulaire-contact.md).
Secondaire : Calendly. Tertiaire : `tel:`.

### JSON-LD

```json
{
  "@context": "https://schema.org",
  "@type": "Service",
  "name": "Accompagnement informatique pour TPE",
  "provider": { "@type": "Person", "name": "Matthieu Viel" },
  "areaServed": [
    { "@type": "Place", "name": "La Réunion" },
    { "@type": "Place", "name": "France" }
  ],
  "serviceType": "Maintenance et suivi informatique",
  "description": "Surveillance, sauvegardes, mises à jour de sécurité, dépannage et petites évolutions pour les petites entreprises sans service informatique interne.",
  "offers": {
    "@type": "Offer",
    "priceCurrency": "EUR",
    "price": "...",
    "priceSpecification": {
      "@type": "UnitPriceSpecification",
      "unitCode": "MON"
    }
  }
}
```

## Intégration

1. **Routes.** Ajouter dans `getPages()` de [`src/routes.php`](../../src/routes.php) :
   ```php
   ['accompagnement/index.html', 'accompagnement.html.twig', 'fr', 'accompagnement', 'accompagnement/', 'en/support-plan/'],
   ['en/support-plan/index.html', 'en/support-plan.html.twig', 'en', 'accompagnement', 'accompagnement/', 'en/support-plan/'],
   ```
2. **Navigation.** Ajouter l'entrée dans `base.html.twig` et dans les deux fichiers de
   traduction (`nav.support`). La nav compte déjà 6 entrées : voir
   [MT18](MT18-sort-senior-tech.md) pour libérer la place de « Missions ».
3. **Sitemap.** Déclarer les deux URL, `priority 0.9`, avec `xhtml:link` croisés.
4. **Liens entrants.** Depuis l'étape 3 du process de l'accueil, depuis la section
   À propos, depuis `/contact.html`, et depuis chaque page problème de
   [MT13](MT13-pages-probleme.md).
5. **Bande de transition sur l'accueil**, juste après le process :
   ```
   Réparé. Et ensuite ?
   La plupart de mes clients préfèrent ne pas attendre la prochaine panne.
   → Voir comment je reste joignable toute l'année
   ```
6. **`seed/`.** La règle 1 de `CLAUDE.md` interdit d'introduire un terme marketing non
   présent dans `seed/`. Le vocabulaire de l'accompagnement n'y est pas. **Mettre à
   jour `seed/presentation_matthieu.txt` dans la même tâche**, sinon la page viole la
   règle qu'elle est censée respecter. Le `seed/` mentionne déjà « sans recruter un
   CTO à temps plein » : c'est le point d'accroche naturel.

## Critères d'acceptation

- [ ] Offre, périmètre, capacité de réponse et décision tarifaire validés sur des retours réels
- [ ] Chiffre du coût d'embauche vérifié
- [ ] Page FR créée, routée, exportée
- [ ] **Miroir EN créé dans la même tâche** (règle 5)
- [ ] Section « Ce qui n'est pas inclus » présente
- [ ] JSON-LD `Service` valide
- [ ] Déclarée dans `sitemap.xml`, `priority 0.9`, `hreflang` croisés
- [ ] Au moins 4 liens entrants internes
- [ ] Bande de transition ajoutée sur l'accueil FR et EN
- [ ] `seed/` mis à jour avec le vocabulaire de l'accompagnement
- [ ] `title` 55-60, `description` 150-160
- [ ] Aucun tiret cadratin
- [ ] Testée à 375 px avant 1280 px
- [ ] `npm test` passe

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
php src/export.php && npm test
ls dist/accompagnement/index.html dist/en/support-plan/index.html
grep -c "accompagnement\|support-plan" sitemap.xml         # attendu : >= 2
grep -rl "accompagnement/" dist --include=*.html | wc -l   # liens entrants
python3 -c "
import json,re
s=open('dist/accompagnement/index.html',encoding='utf-8').read()
for b in re.findall(r'ld\+json[^>]*>(.*?)</script>',s,re.S):
    print(json.loads(b).get('@type'))"
```

## Règles `CLAUDE.md` engagées

- **Règle 1, ton** : `seed/` fait autorité, mise à jour requise
- **Règle 2, SEO/GEO** : longueurs, H1 unique, faits quantifiés
- **Règle 4, accessibilité** : mobile-first 375 px
- **Règle 5, parité FR/EN** : non négociable, dans la même tâche

## Référence

Point **A4** de `TODO.md` (décision tarifaire en attente), et mémoire projet
« aucun prix ni forfait sur le site pour l'instant », que cette fiche propose
explicitement de rouvrir.
