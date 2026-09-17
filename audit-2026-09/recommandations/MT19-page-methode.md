# MT19 · Créer la page `/methode/` si elle sert le parcours

| | |
|---|---|
| Priorité | Moyen terme |
| Effort | 0,5 j |
| Impact | Levée d'objection ; effet SEO non présumé |
| Parité FR/EN | Oui, requise |
| Dépendances | [QW10](QW10-phrase-anti-dependance.md) (formulations révisées) |

## Constat mesuré (17/09/2026)

Le process en trois étapes existe sur l'accueil, sous le H2 « Trois étapes, aucune
mauvaise surprise » :

```
1. Vous m'expliquez avec vos mots
   Décrivez simplement ce que vous voyez. Vous n'avez rien à préparer,
   et il n'y a pas de question bête.

2. Je regarde, puis je vous dis le prix
   Ce qui se passe, ce que ça coûte, combien de temps ça prend.
   Vous décidez ensuite, en connaissance de cause.

3. Je répare, et je vous montre
   Je vous explique ce qui a changé et ce qu'il faut surveiller.
   Mon objectif n'est pas que vous m'appeliez toutes les semaines.
```

Neuf lignes au total. Aucune URL dédiée. L'absence de balisage `HowTo` n'est pas un
problème : Google ne propose plus de résultat enrichi HowTo.

À comparer avec les pages d'audit, qui portent toutes un `HowTo` balisé : la recette
est connue et appliquée pour la cible technique, pas pour la cible TPE.

## Pourquoi c'est important

- **C'est la meilleure levée d'objection du site.** Les trois freins d'un dirigeant
  non technicien sont : je ne saurai pas expliquer, je ne saurai pas combien ça coûte,
  je vais devenir dépendant. Les trois étapes répondent aux trois, dans l'ordre. En
  neuf lignes, cette réponse est sous-exploitée.
- **C'est une page vers laquelle pointer.** Un prospect qui hésite au téléphone, un
  lien dans un email, une réponse sur LinkedIn : aujourd'hui il faut renvoyer vers
  l'accueil entier.

## Ce qu'il faut faire

### Métadonnées

```
title       : Comment je travaille, étape par étape · Matthieu Viel   (à valider, 55-60)
description : Comment se passe une intervention : vous décrivez le problème avec vos mots, je regarde et j'annonce le prix, puis je répare et je vous explique. Sans jargon.   (à valider, 150-160)
```

**Mesurer les longueurs avant intégration.**

### H1

```
Comment ça se passe, concrètement
```

### Structure

| Section | Contenu |
|---|---|
| Intro | « Vous n'avez jamais fait appel à un informaticien, ou la dernière fois s'est mal passée. Voici exactement ce qui se passe quand vous me contactez. » |
| H2 « Étape 1 : vous m'expliquez avec vos mots » | Développer. Ce qu'il n'est **pas** nécessaire d'avoir : le nom du problème, les accès, le nom de l'hébergeur, un cahier des charges. Ce qui aide : ce que vous voyez à l'écran, depuis quand. |
| H2 « Étape 2 : je regarde, puis je vous dis le prix » | Développer. Combien de temps prend le diagnostic. Ce qu'il coûte (gratuit ou non : le dire). Ce que contient la réponse : ce qui se passe, ce que ça coûte, combien de temps, et ce qui arrive si vous ne faites rien. |
| H2 « Étape 3 : je répare, et je vous montre » | Développer. Ce que vous recevez à la fin : ce qui a changé, ce qu'il faut surveiller, et les accès, **à votre nom**. |
| H2 « Ce que je ne fais jamais » | Commencer sans accord sur le prix. Garder des accès à votre place. Facturer une surprise. Parler en jargon. **Section la plus forte de la page.** |
| H2 « Et si je ne peux pas vous aider » | « Ça arrive. Je vous le dis tout de suite, et si je connais quelqu'un de mieux placé, je vous donne son nom. » Signal de confiance très fort, et rare. |
| CTA | Formulaire, puis Calendly, puis `tel:` |

### Balisage facultatif

```json
{
  "@context": "https://schema.org",
  "@type": "HowTo",
  "name": "Comment se passe une intervention informatique avec Matthieu Viel",
  "description": "Le déroulement d'une intervention, du premier contact à la remise des accès.",
  "step": [
    {
      "@type": "HowToStep",
      "position": 1,
      "name": "Vous expliquez le problème avec vos mots",
      "text": "Vous décrivez ce que vous voyez à l'écran et depuis quand. Aucune préparation, aucun vocabulaire technique n'est nécessaire."
    },
    {
      "@type": "HowToStep",
      "position": 2,
      "name": "Diagnostic puis annonce du prix",
      "text": "Je regarde ce qui se passe, puis je vous annonce le prix et le délai. Vous décidez ensuite, avant que le travail commence."
    },
    {
      "@type": "HowToStep",
      "position": 3,
      "name": "Réparation et restitution",
      "text": "Je répare, je vous explique ce qui a changé et ce qu'il faut surveiller, et je vous remets les accès à votre nom."
    }
  ]
}
```

Le texte de chaque `HowToStep` doit **correspondre au texte visible** de la page. Ne
l'ajouter que pour l'interopérabilité s'il est simple à maintenir ; il n'est pas un
critère d'acceptation ni une promesse de résultat enrichi.

### Ce qui reste sur l'accueil

Garder les trois étapes sur l'accueil, avec un lien « Le détail de chaque étape → ».
Ne pas les retirer : elles jouent un rôle dans le parcours de lecture.

**Éviter le doublon strict** : l'accueil garde la version courte, la page développe.

### Liens entrants

Depuis l'accueil (sous les trois étapes), depuis `/accompagnement/`
([MT11](MT11-page-accompagnement.md)), depuis `/a-propos/`
([MT12](MT12-page-a-propos.md)), et depuis les deux pages problème
([MT13](MT13-pages-probleme.md)).

### Ton

C'est la page où le ton du `seed/` compte le plus : direct, sans jargon, honnête,
bénéfice avant technique. Aucun superlatif. Paragraphes de 4 lignes maximum
(règle GEO du projet). Aucun tiret cadratin.

Attention à la **cohérence avec [QW10](QW10-phrase-anti-dependance.md)** : l'étape 3
ne doit pas reprendre l'ancienne formulation « mon objectif n'est pas que vous
m'appeliez ».

## Critères d'acceptation

- [ ] Page FR créée, routée, exportée
- [ ] **Miroir EN créé dans la même tâche** (`/en/how-i-work/`)
- [ ] La page apporte un niveau de détail utile au-delà de l'accueil, testé dans les échanges prospect
- [ ] Section « Ce que je ne fais jamais » présente
- [ ] Section « Et si je ne peux pas vous aider » présente
- [ ] Les trois étapes restent sur l'accueil, avec un lien vers la page
- [ ] Pas de duplication mot pour mot avec l'accueil
- [ ] Au moins 4 liens entrants internes
- [ ] Formulations cohérentes avec QW10
- [ ] `title` 55-60, `description` 150-160, mesurés
- [ ] Paragraphes de 4 lignes maximum
- [ ] Aucun tiret cadratin
- [ ] Déclarée au sitemap avec `hreflang`

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
php src/export.php && npm test
ls dist/methode/index.html dist/en/how-i-work/index.html
python3 -c "
import re,json,html
s=open('dist/methode/index.html',encoding='utf-8').read()
print('h1 x',len(re.findall(r'<h1',s)))
for b in re.findall(r'ld\+json[^>]*>(.*?)</script>',s,re.S):
    o=json.loads(b); print(o.get('@type'), len(o.get('step',[])) if o.get('@type')=='HowTo' else '')"
grep -rl "methode/" dist --include=*.html | wc -l
grep -c "—" dist/methode/index.html
```

## Règles `CLAUDE.md` engagées

- **Règle 1, ton** : `seed/` fait autorité, bénéfice avant technique, phrases courtes
- **Règle 2, GEO** : paragraphes denses de 4 lignes maximum, H1 unique
- **Règle 5, parité FR/EN**
- Mémoire projet : aucun tiret cadratin
