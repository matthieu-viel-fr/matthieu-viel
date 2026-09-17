# MT18 · Trancher le sort de `senior-tech.html`

| | |
|---|---|
| Priorité | Moyen terme |
| Effort | Décision, puis 1 h d'exécution |
| Impact | Clarté du positionnement, place en navigation |
| Parité FR/EN | Dépend de l'option retenue |
| Dépendances | [MT11](MT11-page-accompagnement.md) (c'est elle qui réclame la place en nav) |

## Constat mesuré (17/09/2026)

### Ce qu'est la page

```
title : Matthieu Viel · Dev Senior Symfony/React · Missions longues   (59)
desc  : Développeur fullstack senior Symfony/React, 18 ans d'expérience sur SaaS.
        Missions 3 à 12 mois pour ESN, grands comptes et SaaS. Remote depuis La Réunion.   (154)
H1    : Renfort senior Symfony/React pour vos missions critiques.
```

45 618 octets, la page la plus lourde du site après le quiz. JSON-LD `Person` très
complet (`knowsAbout` de 9 entrées, `hasOfferCatalog`, `description` détaillée),
plus complet que celui de l'accueil.

Contenu : positionnement senior, 4 réalisations, 6 situations d'intervention,
témoignages, FAQ, CTA Calendly ×3.

### Ses anomalies

| Anomalie | Détail |
|---|---|
| **Absente du sitemap** | `grep -c "senior-tech" sitemap.xml` → `0` |
| **Sans équivalent EN** | `lang_en_url` pointe vers `en/index.html`, donc pas de `hreflang="en"` |
| **Occupe la nav** | Libellé « Missions », présent sur les 29 pages |
| **Doublon d'URL** | `tech.html` redirige vers elle par méta-refresh |
| **Cible en contradiction** | Elle vend du renfort aux ESN et grands comptes, marché dont vous sortez |

## Pourquoi il faut trancher

Deux raisons concrètes, pas théoriques :

1. **La navigation est pleine.** Elle compte déjà 6 entrées en FR (Dépannage, Audit,
   Missions, À propos, Portfolio, Contact), plus le sélecteur de langue et le bouton
   Calendly. `TODO.md` signale déjà (point **A7**) que la nav passe à la ligne à
   1024 px. [MT11](MT11-page-accompagnement.md) a besoin d'une place, et
   [MT12](MT12-page-a-propos.md) transforme « À propos » en vraie page. Sans
   arbitrage, la nav casse.

2. **La page brouille le message.** Un dirigeant de TPE qui clique sur « Missions »
   atterrit sur « Renfort senior Symfony/React pour vos missions critiques ». Il en
   conclut que le site n'est pas pour lui.

## Les trois options

### Option A : la conserver telle quelle, hors nav principale

- Retirer « Missions » de la nav, garder le lien en footer
- L'ajouter au sitemap (`priority 0.7`, `hreflang="fr"` + `x-default` seulement)
- Ne pas créer d'équivalent EN

**Pour** : conserve le signal recruteur et le référencement sur « développeur Symfony
senior », qui reste une source de revenus. Libère une place en nav. Coût quasi nul.
**Contre** : une page orpheline de plus dans la nav principale, moins de trafic interne.

### Option B : la fondre dans `/accompagnement/` sous l'angle « CTO à temps partagé »

- Reprendre le contenu senior et le reformuler pour une cible dirigeant, pas ESN
- H1 du type « Un regard technique senior, sans recruter un CTO »
- Rediriger `senior-tech.html` en 301 vers la nouvelle section

**Pour** : un seul message, aligné sur le positionnement visé. Le `seed/` contient déjà
la formule « sans recruter un CTO à temps plein », donc le vocabulaire est validé.
**Contre** : perte du positionnement ESN, qui paie encore. Rédaction lourde.
Modifie une URL existante, ce que `CLAUDE.md` décourage (une 301 reste acceptable).

### Option C : la supprimer

- 301 vers l'accueil, retrait de la nav et du footer

**Pour** : simplicité maximale.
**Contre** : destruction pure d'un actif qui fonctionne. **À écarter.**

## Recommandation

**Option A maintenant, option B à réévaluer dans six mois.**

Raison : le marché ESN paie encore, même s'il se contracte. Le retirer de la nav coûte
presque rien et règle le problème de place immédiatement. La fusion de l'option B est
un pari sur un positionnement qui n'est pas encore prouvé : la faire **après** que
[MT11](MT11-page-accompagnement.md) ait démontré qu'elle génère des leads, pas avant.

Trancher pour l'option B dès maintenant reviendrait à démonter une source de revenus
actuelle au profit d'une hypothèse.

## Exécution de l'option A

1. Dans [`src/templates/base.html.twig`](../../src/templates/base.html.twig), retirer
   l'entrée `nav.senior` de la nav FR. La laisser dans le footer FR.
2. Ajouter à sa place l'entrée `/accompagnement/` de MT11.
3. Ajouter `senior-tech.html` au `sitemap.xml` (voir [QW03](QW03-sitemap.md)),
   avec `hreflang="fr"` et `x-default` **seulement**. Ne pas déclarer de
   `hreflang="en"` vers `en/index.html` : les deux pages n'ont pas le même contenu,
   ce serait une déclaration fausse.
4. Vérifier que la nav ne passe plus à la ligne à 1024 px (point **A7** de `TODO.md`).
5. Ajouter un lien contextuel depuis l'accueil, dans la seconde porte
   (« Vous avez une équipe technique »), où il a du sens.

### Cas de `tech.html`

Page de redirection par méta-refresh (454 octets), avec `canonical` vers
`senior-tech.html`. Elle fonctionne, mais une **301 côté serveur** serait plus propre
et plus rapide, et `.htaccess` gère déjà ce type de redirection pour `me-suivre.html`
et `tiktok.html` :

```apache
RewriteRule ^tech\.html$ /senior-tech.html [R=301,L]
```

Puis supprimer `src/templates/tech.html.twig` et son entrée dans `routes.php`.

C'est le point **15** de `TODO.md` (« Finish or remove `tech.html` »), qui peut être
clos par cette fiche.

## Critères d'acceptation

- [ ] Décision consignée, avec sa date, dans `TODO.md`
- [ ] Option A : « Missions » retirée de la nav FR, conservée en footer
- [ ] `senior-tech.html` déclarée au sitemap, sans `hreflang="en"` fallacieux
- [ ] La nav ne passe plus à la ligne à 1024 px
- [ ] `tech.html` convertie en 301 serveur, template et route supprimés
- [ ] Aucun lien interne cassé (`npm test`)
- [ ] `/senior-tech.html` répond toujours 200
- [ ] `/tech.html` répond 301 vers `/senior-tech.html`

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
php src/export.php && npm test
grep -c "senior-tech" sitemap.xml
grep -c "nav.senior" src/templates/base.html.twig
grep -rl "senior-tech" dist --include=*.html | wc -l

# Après déploiement
curl -sSI https://www.matthieu-viel.fr/tech.html        | grep -iE "HTTP/|location"
curl -sSI https://www.matthieu-viel.fr/senior-tech.html | grep -i "HTTP/"
```

Puis contrôle visuel de la nav à 1024 px, 768 px et 375 px.

## Règles `CLAUDE.md` engagées

- « Ne pas toucher à la structure d'URL existante » : l'option A n'en modifie aucune, l'option B impose des 301
- **Règle 4, accessibilité** : nav lisible à tous les paliers
- **Règle 5, parité FR/EN** : l'option A assume l'absence d'EN, et le déclare correctement

## Référence

Points **A7** et **15** de `TODO.md`.
