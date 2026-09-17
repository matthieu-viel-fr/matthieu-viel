# LT20 · Ouvrir une section ressources, un article toutes les deux semaines

| | |
|---|---|
| Priorité | Long terme, continu |
| Effort | 0,5 j de mise en place, puis 2 à 3 h par article |
| Impact | Acquisition potentielle et nurturing |
| Parité FR/EN | À arbitrer (voir ci-dessous) |
| Dépendances | [MT11](MT11-page-accompagnement.md) (destination des liens sortants) |

## Constat mesuré (17/09/2026)

Le site n'a **ni blog, ni ressources, ni contenu qui ne soit pas une page de vente**.

Les 7 pages d'audit sont le plus proche équivalent, et elles sont excellentes : H1 en
question directe, `HowTo` et `FAQPage` balisés, réponses concrètes. Mais elles visent
une cible technique (« dette technique SaaS », « pipeline CI/CD », « Strangler Fig
Pattern »).

Pour la cible TPE, il n'existe **rien**.

## Pourquoi c'est important

Un dirigeant de TPE ne cherche jamais « audit technique freelance ». Il cherche :

- « mon site ne s'affiche plus »
- « qui est propriétaire de mon nom de domaine »
- « comment savoir si mes sauvegardes fonctionnent »
- « est-ce que je dois payer la maintenance de mon site »

Ces requêtes sont **informationnelles, à faible concurrence, et à fort potentiel de
conversion différée**. Elles alimentent trois choses à la fois :

1. **Le SEO classique** : longue traîne, peu disputée, surtout en ciblage local.
2. **Le GEO** : ce sont exactement les questions posées telles quelles à un assistant.
   Une réponse claire et sourcée a de bonnes chances d'être reprise.
3. **La conversion** : le lecteur arrive avec une question, repart avec une réponse,
   et croise `/accompagnement/` en chemin.

Ce n'est pas un blog d'actualité. C'est **un corpus de réponses**, qui se construit
lentement et ne se périme pas.

## Ce qu'il faut faire

### 1. Structure

Une section `/ressources/` (et `/en/resources/`), avec une page index listant les
articles, et un article par URL : `/ressources/<slug>/`.

Réutiliser le gabarit des pages d'audit pour sa clarté :
H1 en question, sections courtes, CTA en fin de page,
`BreadcrumbList` ([MT16](MT16-breadcrumb-person.md)).

### 2. Les douze premiers sujets

Ordre de priorité, du plus rentable au moins :

| # | Sujet | Intention | Renvoie vers |
|---|---|---|---|
| 1 | Vos sauvegardes existent-elles vraiment ? La vérification en 10 minutes | Informationnelle | `/accompagnement/` |
| 2 | Qui est vraiment propriétaire de votre nom de domaine | Informationnelle | `/reprendre-son-site/` |
| 3 | Ce qu'il faut demander à un prestataire web avant de signer | Commerciale | `/accompagnement/` |
| 4 | Cinq tâches que toute petite entreprise peut automatiser cette semaine | Informationnelle | Contact |
| 5 | Faut-il payer une maintenance pour son site internet ? | Commerciale | `/accompagnement/` |
| 6 | Mon site est lent : les cinq causes les plus fréquentes | Informationnelle | Contact |
| 7 | Combien coûte un site internet pour une petite entreprise en 2026 | Commerciale | Contact |
| 8 | Que faire quand votre site affiche une page blanche | Informationnelle | `/site-internet-pirate/` |
| 9 | Hébergement mutualisé, VPS, cloud : lequel pour une TPE | Informationnelle | `/accompagnement/` |
| 10 | Les six réflexes de sécurité pour un dirigeant qui n'est pas informaticien | Informationnelle | `/accompagnement/` |
| 11 | Créer un site internet quand on est artisan à La Réunion | Transactionnelle | Contact |
| 12 | J'ai construit mon site avec une IA : que vérifier avant de le mettre en ligne | Informationnelle | `/audit/application-vibe-coding-production/` |

Le sujet 10 recoupe directement le contenu LinkedIn déjà produit (« des réflexes de
sécurité accessibles à tout dirigeant ») et le mandat OCOI. Le sujet 12 fait le pont
entre les deux portes du site.

### 3. Recycler ce qui existe déjà

Les contenus produits pour les réseaux sont sous-exploités :

- La **série de 9 vidéos** tournée avec Marc Ah-Thione sur la sécurité et la qualité
  d'une application : 9 articles potentiels, chacun avec la vidéo intégrée. Le travail
  éditorial est déjà fait.
- Les publications LinkedIn sur les réflexes de sécurité.

Un article accompagné de sa vidéo est plus fort qu'une vidéo seule, et il est indexable.

### 4. Cadence

Fixer une cadence tenable après un premier lot de 3 à 4 contenus fondés sur une
demande observée. La régularité peut aider l'organisation éditoriale, mais n'est pas
un signal SEO démontré en elle-même.

### 5. Règles de rédaction

- **Répondre vraiment, y compris quand la réponse ne mène pas à une vente.** Un article
  qui explique comment vérifier ses sauvegardes soi-même convertit mieux qu'un article
  qui retient l'information. C'est aussi la seule façon d'être cité par un assistant.
- La longueur suit la question traitée : éviter un plancher arbitraire et viser une
  réponse complète, lisible et sourcée.
- Paragraphes de 4 lignes maximum, règle GEO du projet.
- Balisage facultatif, fidèle au contenu visible ; ne pas l'ajouter pour un effet SEO
  présumé.
- Un CTA unique en fin d'article, jamais trois.
- Ton du `seed/` : direct, sans jargon, sans superlatif.
- Aucun tiret cadratin.
- **Aucun chiffre non vérifié.** L'article 7 (« combien coûte un site ») exige des
  fourchettes réelles du marché réunionnais, pas des moyennes nationales recopiées.

### 6. Parité FR/EN : à arbitrer

La règle 5 de `CLAUDE.md` impose la parité sur les pages existantes. Pour une section
de contenu continue, traduire chaque article double le coût pour un trafic EN
probablement marginal sur des sujets très locaux.

Trois options, à trancher **avant** de publier le premier article :

| Option | Conséquence |
|---|---|
| A. Section FR uniquement, non reflétée en EN | Écart assumé avec la règle 5. À documenter explicitement dans `CLAUDE.md`, sinon chaque session future rouvrira la question. |
| B. Parité complète | Coût doublé, bénéfice faible sur les sujets locaux |
| C. Parité sélective | Seuls les articles non locaux (12, 10) sont traduits. Règle à écrire noir sur blanc. |

**Recommandation : option C**, avec la règle inscrite dans `CLAUDE.md`. C'est la seule
qui ne crée ni dette ni ambiguïté pour les sessions suivantes.

### 7. Intégration technique

Le générateur actuel liste les pages une par une dans `getPages()`. Douze articles,
puis vingt-cinq, rendront ce tableau difficile à tenir.

Prévoir soit une convention de nommage balayée automatiquement
(`src/templates/ressources/*.html.twig`), soit un index de métadonnées par article.
C'est le point **12** de `TODO.md` (« Decide whether to introduce a tiny static
generation step »), qui devient réellement pertinent ici.

Prévoir aussi la génération automatique du sitemap à ce moment-là
(voir [QW03](QW03-sitemap.md)).

## Critères d'acceptation

- [ ] Décision prise et documentée sur la parité FR/EN
- [ ] `/ressources/` créée et liée depuis la nav ou le footer
- [ ] Les six premiers articles publiés, à cadence régulière
- [ ] Chaque article : H1 unique, CTA cohérent ; balisage seulement s'il décrit le contenu visible
- [ ] Chaque article pointe vers une page de conversion
- [ ] Aucun chiffre non vérifié
- [ ] Génération des routes et du sitemap non manuelle au-delà de 10 articles
- [ ] Ton conforme au `seed/`, aucun tiret cadratin

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
php src/export.php && npm test
ls dist/ressources/
python3 - <<'PY'
import re,json,glob
for p in sorted(glob.glob('dist/ressources/*/index.html')):
    s=open(p,encoding='utf-8').read()
    types=[json.loads(b).get('@type') for b in re.findall(r'ld\+json[^>]*>(.*?)</script>',s,re.S)]
    words=len(re.findall(r'\w+',re.sub(r'<[^>]+>',' ',s)))
    print(f"{p:52} h1={len(re.findall(r'<h1',s))} mots~{words} {types}")
PY
```

## Règles `CLAUDE.md` engagées

- **Règle 1, ton** : `seed/` fait autorité
- **Règle 2, SEO/GEO** : H1 unique, paragraphes denses, FAQ directes, faits quantifiés
- **Règle 5, parité FR/EN** : arbitrage explicite requis
- « Ne jamais générer de contenu bourré de mots-clés ou artificiel »

## Référence

Point **12** de `TODO.md`.
