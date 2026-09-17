# LT22 · Réaligner le portfolio sur la cible

| | |
|---|---|
| Priorité | Long terme |
| Effort | 2 j |
| Impact | Conversion, GEO |
| Parité FR/EN | Oui, requise |
| Dépendances | [MT15](MT15-temoignages-tpe.md) de préférence (cas TPE à raconter) |

## Constat mesuré (17/09/2026)

```
URL         : /portfolio.html
title       : Portfolio réalisations · Matthieu Viel · Développeur web 974   (60)
description : 149 caractères (hors cible)
H1          : Des projets qui résolvent de vrais problèmes métier
JSON-LD     : AUCUN
CTA         : 2 liens Calendly, aucun tel:, aucun email, aucun formulaire
Images      : 0
```

### Contenu actuel

**H2 « Quatre problèmes que je résous en récurrence »** : automatiser un process
manuel, sortir d'Excel, digitaliser une activité locale, migrer un legacy. Cette
section est **bonne** et parle à la cible TPE.

**H2 « Réalisations principales »** : Tennis-Contact, Sellermania, migration frontend
React, Herbarius. Toutes techniques, aucune TPE.

### Les quatre problèmes

| Anomalie | Détail |
|---|---|
| **Aucun JSON-LD** | Seule page de contenu du site sans aucune donnée structurée |
| **Aucun moyen de contact direct** | Ni `tel:`, ni email, ni formulaire. Un visiteur convaincu n'a que Calendly. |
| **Aucun cas TPE** | Les quatre réalisations sont des projets techniques B2B |
| **Cas non homogènes** | Pas de structure Contexte / Problème / Solution / Résultat |

Ironie de la page : la section « quatre problèmes » décrit parfaitement des situations
de TPE, et les quatre réalisations qui suivent n'en illustrent aucune.

## Pourquoi c'est important

- **C'est la page de preuve, et elle ne convertit pas.** Un visiteur qui arrive au bout,
  convaincu, n'a nulle part où cliquer sauf un Calendly engageant.
- **Un dirigeant de TPE n'y trouve aucun projet qui lui ressemble.** Même effet que
  [MT15](MT15-temoignages-tpe.md) : « il travaille pour des gros ».
- **GEO** : sans structure homogène et sans balisage, les réalisations ne sont pas
  exploitables par un assistant. La règle GEO du projet demande pourtant « client nommé
  + durée + résultat quantifié » pour chaque cas client.

## Ce qu'il faut faire

### 1. Scinder en deux sections explicites

```
H2 · Pour les petites entreprises
H2 · Pour les équipes produit et les éditeurs
```

La première section **en premier**, comme sur l'accueil. Même logique de deux portes,
avec le même avertissement de bascule de vocabulaire.

### 2. Homogénéiser chaque cas

Quatre sous-titres fixes pour tous les cas, sans exception :

| Sous-titre | Contenu |
|---|---|
| **Contexte** | Type de structure, taille, secteur, durée de la mission |
| **Problème** | Ce qui ne marchait pas, en langage de client |
| **Ce que j'ai fait** | Les actions, pas les technologies |
| **Résultat** | Chiffré si possible, qualitatif sinon, jamais vague |

Exemple de reformulation, cas Citeo :

```
Contexte   Citeo, plateforme SaaS à fort trafic. Mission de 4 ans.
Problème   Chaque mise en production était un pari. L'équipe hésitait avant
           chaque déploiement, et les régressions passaient en clientèle.
Ce que     J'ai conçu et écrit plus de 500 scénarios de tests automatisés,
j'ai fait  formé deux ingénieurs QA, et intégré le tout au pipeline de
           déploiement.
Résultat   70 % de couverture de tests atteinte. Les mises en production
           sont devenues une routine.
```

La différence avec la version actuelle : le problème est raconté avant la solution, et
le résultat est une conséquence business, pas une métrique isolée.

### 3. Ajouter deux cas TPE

Issus de [MT15](MT15-temoignages-tpe.md). Même s'ils sont petits. Même anonymisés.

Un cas « j'ai remis en ligne le site d'un fleuriste en 24 h après un piratage » vaut,
pour cette cible, plus que Sellermania sur 7 ans.

### 4. Ajouter les CTA manquants

- Un `tel:` ([QW09](QW09-cta-telephone-hero.md))
- Le formulaire de [MT14](MT14-formulaire-contact.md)
- Un lien vers `/accompagnement/` ([MT11](MT11-page-accompagnement.md))
- Garder le Calendly existant

Le H2 final actuel (« Votre situation ressemble à l'un de ces cas ? ») est une bonne
accroche, mal servie par un seul bouton engageant.

### 5. Ajouter le JSON-LD

`Person`, plus un `ItemList` de `CreativeWork` ou de `Project`, un par réalisation,
avec `about`, `datePublished` et `description`. Voir
[MT16](MT16-breadcrumb-person.md).

### 6. Corriger les métadonnées

Déjà prévu dans [QW04](QW04-meta-descriptions.md) :

```
description FR : Réalisations de Matthieu Viel : sites de TPE, outils métier, migrations legacy, automatisation. 18 ans d'expérience fullstack, Saint-Pierre La Réunion.   (151)
description EN : Matthieu Viel's work: small-business websites, custom internal tools, legacy migrations, automation. 18 years of fullstack experience, Réunion Island.   (150)
```

Si les cas TPE sont ajoutés, réviser aussi le `title`, qui parle aujourd'hui de
« Portfolio réalisations », terme de métier plutôt que de client.

### 7. Envisager des visuels

La page ne contient **aucune image**. Une capture d'écran par réalisation
(avec accord, et floutage des données clients) rendrait la page nettement plus
convaincante. Contrainte : WebP, `width` et `height`, `loading="lazy"`
([QW07](QW07-images-og.md)).

## Critères d'acceptation

- [ ] Deux sections explicites, TPE en premier
- [ ] Chaque cas suit Contexte / Problème / Ce que j'ai fait / Résultat
- [ ] Au moins deux cas TPE
- [ ] Chaque cas a un résultat chiffré ou une conséquence business claire
- [ ] `tel:`, formulaire et lien `/accompagnement/` présents
- [ ] JSON-LD `Person` + `ItemList` valides
- [ ] `description` corrigée FR et EN
- [ ] Miroir EN fait
- [ ] Images en WebP dimensionnées, si ajoutées
- [ ] Aucun tiret cadratin
- [ ] Testée à 375 px

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
php src/export.php && npm test
for f in dist/portfolio.html dist/en/portfolio.html; do
  echo "--- $f ---"
  python3 -c "
import re,json,html
s=open('$f',encoding='utf-8').read()
d=re.search(r'name=\"description\" content=\"(.*?)\"',s,re.S).group(1)
print('desc',len(html.unescape(d)))
print('h1 x',len(re.findall(r'<h1',s)),'| h2 x',len(re.findall(r'<h2',s)))
print('jsonld',[json.loads(b).get('@type') for b in re.findall(r'ld\+json[^>]*>(.*?)</script>',s,re.S)])
print('tel:',s.count('href=\"tel:'),'| form:',s.count('<form'),'| accompagnement:',s.count('accompagnement/'))"
done
```

## Règles `CLAUDE.md` engagées

- **Règle 2, GEO** : chaque cas client avec client nommé, durée, résultat quantifié
- **Règle 1, ton** : bénéfice avant technique
- **Règle 3, performance** : WebP dimensionnés si images ajoutées
- **Règle 5, parité FR/EN**

## Référence

Point **16** de `TODO.md` (« Strengthen the portfolio page »).
