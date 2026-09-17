# MT15 · Obtenir et publier deux témoignages de TPE

| | |
|---|---|
| Priorité | Moyen terme, **déficit de conversion numéro un** |
| Effort | 2 j, dont l'essentiel en attente de réponse |
| Impact | Conversion |
| Parité FR/EN | Oui, requise |
| Dépendances | Accord des clients concernés |

## Constat mesuré (17/09/2026)

### Les trois témoignages actuels

| Citation | Auteur | Fonction |
|---|---|---|
| « A permis de sécuriser les mises en production et d'augmenter la vélocité de l'équipe. » | Stéphane Bourdon | **Head of IT · Citeo** |
| « Sérieux, fiable, fédérateur, n'a pas peur d'aborder de nouveaux challenges. » | Stéphane Jauffret | **CEO · Sellermania** |
| « Tout ce qu'on attend d'un développeur expérimenté : précis, autonome, et pédagogue. » | Pierre-Charles Bertineau | **Lead Dev · Néosylva** |

### Les six logos

Citeo, Sellermania, Néosylva, Akeneo, Geofit, Tennis Contact. **Tous des structures
qui ont un service informatique.**

### Les trois « missions récentes »

- « 500+ scénarios de tests E2E automatisés (Cypress) », « 70 % de couverture »
- « Migration Symfony 2 → 3 → 4 sans interruption », « CI/CD avec Jenkins »
- « Strangler Fig Pattern », « toolkit Aurora »

**Aucune preuve, nulle part, ne vient d'une TPE.**

## Pourquoi c'est la priorité de conversion

L'accueil s'adresse en premier à un dirigeant qui « n'est pas informaticien ». Il lit
le H1, se reconnaît, descend, et tombe sur : un Head of IT, un CEO de SaaS, un Lead
Dev, six logos de grands comptes, et du vocabulaire Cypress et Symfony.

La conclusion qu'il en tire est mécanique : **« il travaille pour des gros, je ne suis
pas son client »**.

Ce n'est pas un problème de quantité de preuves, il y en a beaucoup. C'est un problème
de **correspondance**. Un témoignage d'artisan vaut ici plus que les six logos réunis,
parce qu'il est le seul qui réponde à la question réellement posée : « est-ce que ce
type-là répond à quelqu'un comme moi ? »

Déjà identifié en **A3** dans `TODO.md`.

## Ce qu'il faut faire

### 1. Identifier les clients à solliciter

Parmi les interventions déjà réalisées auprès de petites structures, même modestes,
même anciennes, même non facturées. Chercher dans : historique de facturation, boîte
mail, contacts locaux, réseau OCOI, retours sur les vidéos LinkedIn et TikTok.

**Si aucun client TPE n'existe encore**, c'est une information en soi, et cette fiche
change de nature : il faut alors réaliser deux ou trois interventions à prix réduit
avec accord explicite de témoignage, et les traiter comme un investissement
d'acquisition. Ne pas fabriquer de faux témoignage, jamais.

### 2. Demander correctement

Ne pas demander « un témoignage ». Demander de répondre à trois questions :

1. Quel était le problème, avant ?
2. Qu'est-ce que j'ai fait ?
3. Qu'est-ce que ça a changé pour vous, concrètement ?

Puis rédiger une version courte à partir des réponses, et **la faire valider par écrit**
avant publication.

### 3. Le format cible

```
« Mon site était hors ligne depuis trois jours, et plus personne ne répondait chez
mon ancien prestataire. Matthieu l'a remis en ligne le lendemain, et il m'a expliqué
ce qui s'était passé sans que j'aie à comprendre l'informatique. »

Karine, fleuriste à Saint-Pierre
```

Ce qui compte, dans l'ordre :
- **Le problème est nommé en langage de client**, pas de technicien
- **Un délai concret** (« le lendemain ») vaut mieux qu'un adjectif (« rapide »)
- **Le prénom, le métier et la commune** suffisent à créer l'identification
- **La promesse du site est confirmée** par quelqu'un d'autre que vous

### 4. Ce qui est acceptable en l'absence d'accord complet

| Niveau | Format | Valeur |
|---|---|---|
| Idéal | Prénom, métier, commune, photo, logo | Maximale |
| Bon | Prénom, métier, commune | Suffisante |
| Acceptable | « Un traiteur du Tampon », sans prénom | Correcte |
| **Inacceptable** | Témoignage inventé ou reformulé au-delà de ce qui a été dit | Aucune, et risque réel |

Même anonymisé, un témoignage **doit correspondre à une intervention réelle et à des
propos réellement tenus**.

### 5. Où les placer

- **Accueil FR et EN**, dans la section « 18 ans de métier, et des clients qui le
  disent », **avant** les trois témoignages actuels. Un visiteur non technicien doit
  rencontrer d'abord quelqu'un qui lui ressemble.
- `/accompagnement/` ([MT11](MT11-page-accompagnement.md))
- Les pages problème correspondantes ([MT13](MT13-pages-probleme.md))

Ne pas retirer les trois témoignages existants : ils servent la seconde porte, celle
des équipes techniques. Les conserver, plus bas, dans la section technique.

### 6. Balisage

Ajouter un `Review` schema.org à chaque témoignage, pour que les assistants puissent
les citer. **Ne pas ajouter d'`aggregateRating`** sans notes réelles et vérifiables :
c'est une violation des règles de Google sur les données structurées.

### 7. Réutiliser ailleurs

Ces témoignages servent aussi la fiche Google Business Profile
([LT21](LT21-autorite-locale.md)). Demander en même temps un avis Google : c'est le
même effort pour le client, et le double du bénéfice.

## Critères d'acceptation

- [ ] Au moins deux témoignages de petites structures, réels et validés par écrit
- [ ] Chacun nomme le problème en langage de client
- [ ] Chacun contient un élément concret : délai, chiffre, ou changement précis
- [ ] Prénom, métier et commune, ou anonymisation honnête
- [ ] Placés **avant** les témoignages techniques sur l'accueil
- [ ] Les trois témoignages existants conservés, déplacés dans la section technique
- [ ] `Review` balisé, sans `aggregateRating` fabriqué
- [ ] Miroir EN fait (traduction fidèle, en signalant qu'il s'agit d'une traduction)
- [ ] Avis Google demandé aux mêmes clients
- [ ] Aucun tiret cadratin

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
php src/export.php && npm test
grep -c "testimonial" dist/index.html dist/en/index.html
python3 -c "
import re,json
s=open('dist/index.html',encoding='utf-8').read()
print([json.loads(b).get('@type') for b in re.findall(r'ld\+json[^>]*>(.*?)</script>',s,re.S)])"
```

Test qualitatif, le seul qui compte : faire lire l'accueil à une personne non
technicienne dirigeant une petite structure, et lui demander si elle a l'impression
que ce site s'adresse à elle.

## Règles `CLAUDE.md` engagées

- **Règle 2, GEO** : chaque cas client avec client nommé, durée, résultat quantifié
- **Règle 1, ton** : honnête, jamais de superlatif
- **Règle 5, parité FR/EN**
- « Ne jamais générer de contenu artificiel »

## Référence

Point **A3** de `TODO.md`, soulevé le 16/09/2026 : « No testimonial speaks to the
non-technical audience ».
