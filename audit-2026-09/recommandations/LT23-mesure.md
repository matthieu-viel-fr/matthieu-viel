# LT23 · Mesurer avant d'optimiser à nouveau

| | |
|---|---|
| Priorité | Long terme par son horizon, **à lancer en premier** |
| Effort | 0,5 j |
| Impact | Conditionne la validation de toutes les autres fiches |
| Parité FR/EN | Sans objet |
| Dépendances | Aucune. **À faire en parallèle des quick wins.** |

## Constat mesuré (17/09/2026)

Plausible est bien installé, sur toutes les pages, via
[`src/templates/base.html.twig`](../../src/templates/base.html.twig) :

```html
<script defer data-domain="matthieu-viel.fr" src="https://plausible.io/js/script.js"></script>
```

Bon choix : `defer`, sans cookie, cohérent avec les mentions légales qui affirment
« Ce site n'utilise aucun cookie tiers ».

**Mais aucun objectif n'est déclaré.** Le script de base ne mesure que les pages vues.
Aucun événement sur :

- les clics Calendly (le CTA principal, présent sur 21 pages)
- les clics `tel:`
- les clics email
- les soumissions de formulaire (il n'y en a pas encore, voir [MT14](MT14-formulaire-contact.md))

Statut Google Search Console : inconnu, non vérifiable depuis l'extérieur.

Note : `data-domain` vaut `matthieu-viel.fr` alors que le domaine canonique est
`www.matthieu-viel.fr`. Plausible accepte les deux, mais vérifier que le site est bien
déclaré ainsi dans l'interface, sinon une partie du trafic est perdue.

## Pourquoi c'est important

**Sans mesure, aucune des 22 autres fiches ne peut être validée ou invalidée.**

Ce dossier repose sur un diagnostic : le site attrape des visiteurs en urgence mais
n'a aucun étage récurrent. Les recommandations en découlent. Mais la démonstration que
[MT11](MT11-page-accompagnement.md) génère des leads, ou que le bouton d'appel de
[QW09](QW09-cta-telephone-hero.md) change quelque chose, demande des chiffres.

Aujourd'hui, le site ne peut répondre ni à « combien de personnes cliquent sur
Calendly », ni à « combien appellent », ni à « quelles pages amènent les contacts ».

C'est la fiche la moins visible et la plus structurante. Elle est classée en long terme
par son horizon d'exploitation, mais **elle doit être lancée en même temps que les
quick wins**, sinon leur effet sera invisible.

## Ce qu'il faut faire

### 1. Déclarer les objectifs Plausible

Quatre objectifs, dans l'interface Plausible puis dans le code.

Plausible suit automatiquement les clics sortants et les liens `tel:`/`mailto:` si le
script étendu est utilisé :

```html
<script defer data-domain="matthieu-viel.fr"
        src="https://plausible.io/js/script.outbound-links.tagged-events.js"></script>
```

Ce script couvre les clics Calendly (lien sortant), `tel:` et `mailto:` sans code
supplémentaire. Le poids reste négligeable.

Pour les événements nommés, taguer les éléments :

```html
<a href="https://calendly.com/matthieu-viel-fr/30min" class="btn btn--primary plausible-event-name=Calendly">
<a href="tel:+262693852812" class="plausible-event-name=Appel">
```

### 2. Objectif de conversion sur la page de confirmation

Quand [MT14](MT14-formulaire-contact.md) sera fait, déclarer `/message-envoye/` comme
objectif de page vue. C'est la conversion la plus fiable à mesurer, parce qu'elle ne
dépend d'aucun tagage JavaScript.

### 3. Google Search Console

- Vérifier la propriété `https://www.matthieu-viel.fr/` (propriété de domaine de
  préférence, qui couvre apex et `www`)
- Soumettre `sitemap.xml`
- Vérifier la couverture d'indexation : combien des 29 pages sont réellement indexées
- Relever les requêtes réelles, qui infirmeront ou confirmeront l'annexe B du
  [README](../README.md)

**C'est aussi le seul moyen de savoir si `senior-tech.html`, absente du sitemap
([QW03](QW03-sitemap.md)), est indexée ou non.**

### 4. Bing Webmaster Tools

Souvent négligé, et pertinent ici : **Bing alimente une partie des réponses de
ChatGPT**. L'inscription prend dix minutes et importe directement depuis Search Console.

### 5. Établir la ligne de base

**Avant** d'appliquer les quick wins, relever et consigner :

- pages vues par mois, et pages d'entrée principales
- taux de rebond par page
- répartition mobile / desktop
- position et impressions sur les requêtes locales (Search Console)
- nombre de pages indexées

Sans point de départ, les mesures ultérieures ne diront rien.

### 6. Veille GEO exploratoire, non attribuable

Une fois par mois, il est possible de poser à ChatGPT, Claude et Perplexity :

- « Qui peut m'aider si mon site internet est piraté à La Réunion ? »
- « Je cherche un développeur web indépendant à Saint-Pierre de La Réunion »
- « Qui est Matthieu Viel ? »
- « Combien coûte un accompagnement informatique pour une TPE ? »

Consigner le contexte et le résultat comme une observation. Ces réponses sont
personnalisées, variables et non attribuables à une modification donnée ; elles ne
mesurent donc ni l'effet de [MT17](MT17-llms-txt.md), ni celui d'un travail GEO.

Tenir un fichier `audit-2026-09/mesures.md` avec une entrée datée par mois.

### 7. Ne pas ajouter Google Analytics

Plausible suffit, ne pose pas de cookie, et les mentions légales affirment que le site
n'en utilise aucun. Ajouter GA imposerait une bannière de consentement, dégraderait
les performances, et contredirait la promesse affichée. **À ne pas faire.**

## Critères d'acceptation

- [ ] Script Plausible étendu en place (clics sortants et événements tagués)
- [ ] Quatre objectifs déclarés : Calendly, Appel, Email, Formulaire
- [ ] `data-domain` cohérent avec le site déclaré dans Plausible
- [ ] Search Console vérifiée, sitemap soumis
- [ ] Couverture d'indexation relevée (combien des 29 pages sont indexées)
- [ ] Bing Webmaster Tools inscrit
- [ ] Ligne de base consignée **avant** les quick wins
- [ ] `audit-2026-09/mesures.md` créé, avec une première entrée
- [ ] Veille GEO, si réalisée, consignée comme observation exploratoire
- [ ] Aucun cookie ajouté, mentions légales toujours exactes

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
grep -n "plausible" src/templates/base.html.twig
grep -rc "plausible-event-name" dist --include=*.html | grep -v ":0" | head
grep -c "cookie" dist/mentions-legales.html
```

Puis, dans l'interface Plausible, vérifier que les quatre objectifs remontent après
un test manuel de chaque clic.

## Ce qu'il faut regarder à 3 mois

| Indicateur | Où | Cible réaliste |
|---|---|---|
| Clics `tel:` par mois | Plausible | en hausse, quel que soit le point de départ |
| Soumissions du formulaire | Plausible | premier repère à établir |
| Réservations Calendly | Plausible | doit rester stable même si les autres montent |
| Impressions sur requêtes locales | Search Console | apparition sur « dépannage informatique » + commune |
| Pages d'entrée hors accueil | Plausible | les pages de [MT13](MT13-pages-probleme.md) dans le top 5 |
| Citations dans les réponses IA | veille manuelle | observation qualitative, sans cible ni attribution |

## Règles `CLAUDE.md` engagées

- **Règle 3, performance** : pas de script lourd ajouté
- « Zéro dépendance externe inutile ajoutée sans accord explicite » : le script Plausible étendu remplace l'existant, il ne s'y ajoute pas
- Cohérence avec les mentions légales sur l'absence de cookie
