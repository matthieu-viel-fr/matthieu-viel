# MT12 · Extraire une vraie page `/a-propos/` et `/en/about/`

| | |
|---|---|
| Priorité | Moyen terme |
| Effort | 0,5 j |
| Impact | GEO, requêtes de marque, crédibilité |
| Parité FR/EN | Oui, requise |
| Dépendances | Aucune |

## Constat mesuré (17/09/2026)

L'information « à propos » n'existe que sous forme d'ancre `#a-propos` sur l'accueil,
située aux deux tiers de la page, après la section technique.

Contenu actuel de cette section :
- Un paragraphe de parcours (« depuis septembre 2008 », Saint-Pierre depuis 2018)
- Un paragraphe technique (Symfony, React, PHP, API Platform, Citeo, Sellermania)
- Quatre encarts : localisation, ECP Formation, OCOI, UTOI 117 km
- Un lien vers LinkedIn

La navigation et le footer pointent vers `index.html#a-propos` dans les deux langues.

**Aucune URL dédiée.** Aucune page ne porte `Person` comme entité principale (l'accueil
porte `Person` + `LocalBusiness` + `FAQPage`, la section À propos n'est qu'un fragment).

## Pourquoi c'est important

- **GEO.** Un assistant interrogé sur « qui est Matthieu Viel » n'a aucune URL à citer.
  Il doit résumer une page d'accueil qui parle d'abord de pannes, et produira
  « il dépanne les sites en panne à La Réunion », ce qui perd tout l'étage senior.
- **Requête de marque.** Quelqu'un qui a vu une vidéo TikTok ou reçu une recommandation
  tape le nom. Google n'a qu'une page d'accueil généraliste à proposer.
- **La phrase canonique n'existe nulle part.** La structure « Je suis X, j'aide Y à
  obtenir Z » est celle que les modèles extraient en priorité. Le site ne l'a pas.
- **Les preuves de personne sont éparpillées** : OCOI dans un encart, ECP dans deux
  endroits, UTOI dans un troisième, 18 ans dans le hero. Une page les rassemble.

## Ce qu'il faut faire

### Métadonnées

```
title       : Matthieu Viel, développeur web à Saint-Pierre 974        (à valider, 55-60)
description : Qui est Matthieu Viel : 18 ans de développement web, installé à Saint-Pierre depuis 2018, formateur certifié ECP, secrétaire adjoint de l'OCOI 974.  (à valider, 150-160)
```

**Mesurer les longueurs avant d'intégrer**, comme pour [QW04](QW04-meta-descriptions.md).

### H1

```
Matthieu Viel, votre informaticien à La Réunion
```

Reprendre exactement le H2 actuel de la section, qui fonctionne déjà.

### La phrase canonique, en ouverture

À placer en premier paragraphe, **en un seul bloc, sans balise intermédiaire**, car
c'est la phrase que les LLM citeront :

```
Je suis Matthieu Viel, développeur web indépendant à Saint-Pierre, à La Réunion.
J'aide les dirigeants de petites entreprises qui n'ont pas d'informaticien à remettre
leurs outils en état, puis à les garder en état toute l'année. J'interviens aussi
comme regard technique senior auprès d'équipes de développement.
```

Version EN :

```
I am Matthieu Viel, an independent web developer based in Saint-Pierre, Réunion Island.
I help owners of small businesses who have no IT person get their tools working again,
and keep them working all year. I also work as a senior technical reviewer for
development teams.
```

**Reprendre cette même phrase à l'identique** dans `llms.txt`
([MT17](MT17-llms-txt.md)) et dans le champ `description` du `Person`
([MT16](MT16-breadcrumb-person.md)). Une seule formulation, répétée partout : c'est
ce qui rend un résumé stable d'un assistant à l'autre.

### Structure de la page

| Section | Contenu |
|---|---|
| H1 + phrase canonique | ci-dessus |
| H2 « Mon parcours » | Depuis septembre 2008. Sellermania 7 ans, Citeo 4 ans. Installé à Saint-Pierre depuis 2018. |
| H2 « Ce que je sais faire » | Symfony, React, PHP 8, API Platform, Cypress, CI/CD. Formulé pour être compris d'un non-technicien. |
| H2 « Où j'interviens » | Sur site dans le sud du 974 (Saint-Pierre, Le Tampon, Saint-Louis, Étang-Salé, Saint-Joseph). À distance partout en France. |
| H2 « Pour qui je travaille » | Dirigeants de TPE sans compétence interne, fondateurs solo, équipes produit. |
| H2 « Ce qui m'engage » | ECP Formation, OCOI, UTOI 117 km. |
| H2 « Comment je travaille » | Résumé de 3 lignes + lien vers [MT19](MT19-page-methode.md). |
| CTA | Formulaire + Calendly + `tel:` |

**Nommer les communes explicitement** est un gain SEO local direct : « Le Tampon »,
« Saint-Louis » et « Étang-Salé » n'apparaissent nulle part sur le site aujourd'hui,
alors que ce sont les communes limitrophes de la zone d'intervention annoncée.

**Ne pas inventer** de commune où vous ne vous déplacez pas réellement.

### Recalculer, ne pas recopier

Le site affiche « 18 ans » sur la base de septembre 2008. Ce nombre se **recalcule**,
il ne se recopie pas. Au 17 septembre 2026 il vaut bien 18. Vérifier à chaque édition
de page.

### Ce qui reste sur l'accueil

Garder un résumé court en `#a-propos` sur l'accueil (la phrase canonique + les quatre
encarts), avec un lien « En savoir plus sur mon parcours → ». Ne pas vider la section :
elle joue un rôle dans le parcours de lecture de l'accueil.

Attention au **contenu dupliqué** : si la page À propos reprend mot pour mot toute la
section de l'accueil, les deux se concurrencent. Le résumé de l'accueil doit être plus
court, la page plus développée.

### Intégration

1. Routes dans [`src/routes.php`](../../src/routes.php) :
   `a-propos/index.html` et `en/about/index.html`
2. Nav et footer : remplacer `index.html#a-propos` par `a-propos/` dans les deux langues
3. Sitemap : deux URL, `priority 0.7`, `hreflang` croisés
4. JSON-LD `Person` complet sur cette page (voir [MT16](MT16-breadcrumb-person.md))

## Critères d'acceptation

- [ ] Page FR créée, routée, exportée
- [ ] **Miroir EN créé dans la même tâche**
- [ ] Phrase canonique présente en un seul bloc, identique à celle de `llms.txt`
- [ ] Communes d'intervention nommées, et réelles
- [ ] Nombre d'années recalculé depuis septembre 2008
- [ ] Nav et footer pointent vers la nouvelle URL dans les deux langues
- [ ] L'ancre `#a-propos` de l'accueil reste fonctionnelle (liens externes existants)
- [ ] Pas de duplication mot pour mot entre l'accueil et la page
- [ ] JSON-LD `Person` complet
- [ ] Déclarée au sitemap avec `hreflang`
- [ ] `title` 55-60, `description` 150-160, mesurés
- [ ] Aucun tiret cadratin

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
php src/export.php && npm test
ls dist/a-propos/index.html dist/en/about/index.html
grep -c "a-propos/\|en/about/" sitemap.xml
grep -c "index.html#a-propos" dist/index.html    # l'ancre doit survivre
grep -o "Je suis Matthieu Viel[^<]*" dist/a-propos/index.html
```

Vérifier la duplication :

```bash
python3 - <<'PY'
import re,html
def txt(p):
    s=open(p,encoding='utf-8').read()
    s=re.sub(r'<(script|style).*?</\1>','',s,flags=re.S)
    return set(re.findall(r'\w{5,}',html.unescape(re.sub(r'<[^>]+>',' ',s)).lower()))
a,b=txt('dist/index.html'),txt('dist/a-propos/index.html')
print(f"recouvrement : {len(a&b)/len(b):.0%}")
PY
```

## Règles `CLAUDE.md` engagées

- **Règle 2, GEO** : faits précis et quantifiés, H1 unique
- **Règle 1, ton** : vocabulaire `seed/`
- **Règle 5, parité FR/EN**
- « Ne pas toucher à la structure d'URL existante » : l'ancre `#a-propos` doit rester valide
- Mémoire projet : le nombre d'années se recalcule depuis septembre 2008
