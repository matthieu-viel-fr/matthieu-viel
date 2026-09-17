# QW10 · Reformuler la phrase anti-dépendance

| | |
|---|---|
| Priorité | Quick win |
| Effort | 30 min |
| Impact | Positionnement, prépare MT11 |
| Parité FR/EN | Oui, requise |
| Dépendances | Aucune, mais à faire **avant** [MT11](MT11-page-accompagnement.md) |

## Constat mesuré (17/09/2026)

Trois formulations de la même idée, sur la seule page d'accueil :

| Où | Texte actuel |
|---|---|
| Étape 3 du process | « Mon objectif n'est pas que vous m'appeliez toutes les semaines. » |
| Encart formateur, sous le process | « Formateur certifié ECP Formation : je transmets, je ne me rends pas indispensable. » |
| Section À propos, encart ECP | « Je transmets les bonnes pratiques, je ne crée pas de dépendance » |

Plus, dans le corps du texte À propos : « sans chercher à me rendre indispensable ».

Soit **quatre occurrences** de la même promesse sur une seule page.

## Pourquoi c'est important

Cette promesse est juste, elle est différenciante, et elle désarme une objection
réelle : la peur d'être pris en otage par son prestataire. **Il ne faut pas la
supprimer.**

Mais telle qu'elle est formulée, elle dit littéralement : *ne me rappelez pas*.

C'est un problème direct pour la suite du plan. [MT11](MT11-page-accompagnement.md)
crée une offre d'accompagnement récurrent. Une page qui vend un suivi mensuel, sur un
site qui répète quatre fois « mon objectif n'est pas que vous m'appeliez », se
contredit elle-même.

La distinction à faire est simple, et elle est vraie :

> La non-dépendance porte sur le **savoir**, pas sur la **relation**.
> Vous ne devez pas dépendre de moi pour comprendre ce qui se passe chez vous.
> Vous pouvez parfaitement choisir de me garder pour le faire.

C'est aussi ce que dit déjà la certification ECP : transmettre n'est pas prendre congé.

## Ce qu'il faut faire

### 1. Étape 3 du process

```
Avant :
Je vous explique ce qui a changé et ce qu'il faut surveiller.
Mon objectif n'est pas que vous m'appeliez toutes les semaines.

Après :
Je vous explique ce qui a changé et ce qu'il faut surveiller, pour que vous
sachiez quoi faire seul. Et quand quelque chose dépasse, vous savez qui appeler.
```

### 2. Encart formateur sous le process

```
Avant :
Formateur certifié ECP Formation : je transmets, je ne me rends pas indispensable.

Après :
Formateur certifié ECP Formation : je vous explique ce que je fais, vous ne
restez jamais dans le noir.
```

### 3. Encart ECP de la section À propos

```
Avant :
Je transmets les bonnes pratiques, je ne crée pas de dépendance

Après :
Je transmets les bonnes pratiques, vous gardez la main sur vos outils
```

### 4. Corps du texte À propos

```
Avant :
Mon approche : comprendre d'abord, proposer ensuite, sans chercher à me rendre
indispensable.

Après :
Mon approche : comprendre d'abord, proposer ensuite, et vous laisser décider en
sachant ce que vous décidez.
```

### Miroir EN

Les mêmes quatre passages existent dans `src/templates/en/index.html.twig`. Traductions
proposées :

- « I explain what changed and what to keep an eye on, so you know what to do on your own. And when something is beyond that, you know who to call. »
- « Certified trainer (ECP Formation): I explain what I am doing, you are never left in the dark. »
- « I pass on good practice, you keep control of your own tools »
- « My approach: understand first, propose second, and let you decide knowing what you are deciding. »

## Ce qu'il ne faut pas faire

- **Ne pas supprimer purement et simplement** la promesse. Elle est un actif.
- **Ne pas la remplacer par une promesse de disponibilité permanente** que vous ne
  tiendrez pas.
- **Ne pas introduire « partenaire », « accompagnement » ou « à vos côtés » ici.**
  Ce vocabulaire n'existe pas encore dans le `seed/`, et la règle 1 de `CLAUDE.md`
  interdit d'introduire un terme marketing non validé. Il sera introduit dans
  [MT11](MT11-page-accompagnement.md), avec une mise à jour du `seed/` en même temps.
- **Ne pas répéter la reformulation quatre fois.** Deux occurrences suffisent
  largement. Envisager de supprimer une des deux mentions ECP redondantes.

## Critères d'acceptation

- [ ] Les quatre passages sont reformulés
- [ ] La promesse de non-dépendance reste lisible et crédible
- [ ] Aucune formulation ne décourage plus le rappel
- [ ] Aucun terme marketing non présent dans `seed/` n'est introduit
- [ ] Aucun tiret cadratin
- [ ] Miroir EN fait
- [ ] Le nombre total d'occurrences est réduit de 4 à 2 ou 3

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
php src/export.php
grep -c "indispensable\|toutes les semaines\|dépendance" dist/index.html
grep -c "indispensable\|every week\|dependency"           dist/en/index.html
grep -c "—" dist/index.html dist/en/index.html
```

Relire ensuite les deux accueils d'un bout à l'autre : la promesse doit rester perçue,
sans jamais fermer la porte.

## Règles `CLAUDE.md` engagées

- **Règle 1, ton** : aucun terme marketing non validé par `seed/`, voix active, phrases courtes
- **Règle 5, parité FR/EN**
- Mémoire projet : aucun tiret cadratin

## Suite

Une fois cette fiche appliquée, [MT11](MT11-page-accompagnement.md) peut introduire le
vocabulaire de l'accompagnement sans contredire l'accueil.
