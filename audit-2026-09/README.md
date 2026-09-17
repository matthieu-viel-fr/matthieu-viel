# Audit SEO / GEO / conversion, matthieu-viel.fr

Audit réalisé le **17 septembre 2026** sur la version en ligne (`https://www.matthieu-viel.fr`),
recoupée avec les sources Twig de `src/templates/`.

29 pages servies, 29 pages analysées (22 crawlées au premier passage, 7 pages EN d'audit
ajoutées au second). Headers HTTP, poids des assets, contrastes et JSON-LD mesurés,
pas estimés.

---

## Comment utiliser ce dossier

Chaque recommandation a **sa propre fiche** dans `recommandations/`, autonome et
directement exploitable dans une session neuve : constat mesuré, fichiers exacts,
contenu à écrire, critères d'acceptation, commande de vérification.

Ouvrir une session sur une fiche, l'appliquer, cocher, passer à la suivante.

```
audit-2026-09/
├── README.md              ← vous êtes ici : index, ordre de priorité, annexes
├── quick-wins.md          ← QW01 à QW10, moins d'une journée au total
├── moyen-terme.md         ← MT11 à MT19, 1 à 2 semaines
├── long-terme.md          ← LT20 à LT23, 1 à 3 mois
└── recommandations/       ← 23 fiches détaillées, une par recommandation
```

---

## Ordre de priorité

Trier par ratio impact / effort, pas par numéro. L'ordre ci-dessous est l'ordre
d'exécution recommandé.

| Ordre | Fiche | Titre | Effort | Impact |
|---|---|---|---|---|
| 1 | **[LT23](recommandations/LT23-mesure.md)** | **Établir la mesure et la ligne de base** | **0,5 j** | **Décisions fondées sur des données** |
| 2 | [QW02](recommandations/QW02-contraste-clr-muted.md) | Corriger le contraste `--clr-muted` | 15 min | Accessibilité AA |
| 3 | [QW01](recommandations/QW01-unifier-email.md) | Unifier l'adresse email | 20 min | Crédibilité, cohérence |
| 4 | [QW07](recommandations/QW07-images-og.md) | Créer une vraie `og:image` | 1 h | Partage |
| 5 | [QW03](recommandations/QW03-sitemap.md) | Aligner le sitemap sur les décisions d'indexation | 30 min | Hygiène d'indexation |
| 6 | [QW05](recommandations/QW05-cache-et-404.md) | En-têtes de cache + page 404 | 30 min | Hygiène technique |
| 7 | [QW06](recommandations/QW06-google-fonts.md) | Remplacer le `@import` après mesure | 30 min | Performance potentielle |
| 8 | [QW10](recommandations/QW10-phrase-anti-dependance.md) | Reformuler la phrase anti-dépendance | 30 min | Cohérence de positionnement |
| 9 | [MT15](recommandations/MT15-temoignages-tpe.md) | Un témoignage TPE précis | 2 j (dont attente) | Réassurance à valider |
| 10 | [MT14](recommandations/MT14-formulaire-contact.md) | Tester un formulaire de contact court | 0,5 j | Conversion à mesurer |
| 11 | [QW09](recommandations/QW09-cta-telephone-hero.md) | Tester un CTA téléphone dans le hero mobile | 30 min | Conversion à mesurer |
| 12 | [MT11](recommandations/MT11-page-accompagnement.md) | Créer `/accompagnement/` après décision d'offre | 1 j | Revenu récurrent potentiel |
| 13 | [LT21](recommandations/LT21-autorite-locale.md) | Google Business Profile si éligible | 1 à 3 mois | Présence locale |
| 14 | [MT13](recommandations/MT13-pages-probleme.md) | Pages problème après validation de la demande | 1 j | Acquisition potentielle |
| 15 | [LT22](recommandations/LT22-portfolio.md) | Réaligner le portfolio | 2 j | Conversion |
| 16 | [MT12](recommandations/MT12-page-a-propos.md) | Page `/a-propos/` autonome | 0,5 j | Marque |
| 17 | [QW04](recommandations/QW04-meta-descriptions.md) | Réviser les métadonnées prioritaires | 2 h | CTR à mesurer |
| 18 | [MT18](recommandations/MT18-sort-senior-tech.md) | Clarifier le rôle de `senior-tech.html` | Décision | Cohérence de navigation |
| 19 | [MT16](recommandations/MT16-breadcrumb-person.md) | Fil d'Ariane pour les pages profondes | 0,5 j | UX, présentation SERP possible |
| 20 | [LT20](recommandations/LT20-ressources.md) | Corpus de ressources fondé sur la demande | Continu | Acquisition progressive |
| 21 | [MT19](recommandations/MT19-page-methode.md) | Page `/methode/` si elle sert le parcours | 0,5 j | Réassurance |
| 22 | [QW08](recommandations/QW08-alt-logos.md) | Rendre les logos accessibles | 20 min | Accessibilité |
| 23 | [MT17](recommandations/MT17-llms-txt.md) | Expérimenter `llms.txt` | 0,5 j | Hypothèse GEO |

**Si vous ne faites qu'une chose : LT23.** Instrumenter les parcours et relever une
ligne de base avant toute modification. La décision d'offre (A4 de `TODO.md`) et les
preuves client détermineront ensuite si MT11 est le bon investissement.

---

## Le diagnostic en une page

Le site vend aujourd'hui du **dépannage** : ponctuel, urgent, faible ticket.
La cible annoncée est le **partenariat tech** : récurrent, ticket élevé.
Ces deux modèles ne se vendent pas avec les mêmes pages.

Ce n'est pas une erreur de positionnement, c'est un étage manquant. Le dépannage est
la meilleure porte d'entrée possible vers une TPE : elle s'ouvre au moment exact où le
dirigeant a un problème et un budget. Ce qui manque, c'est ce qui se passe après la
réparation. Aujourd'hui, un lead entre, paie une fois, et sort.

### Ce qui fonctionne déjà, à ne pas casser
- Le H1 parle la langue du client : « personne à appeler » nomme la solitude du dirigeant.
- Le process en trois étapes lève les objections dans le bon ordre : jargon, devis opaque, dépendance.
- « Vous n'avez pas besoin de nommer le problème » lève le frein numéro un.
- Socle technique sain : HTTPS forcé, canoniques propres, hreflang complet, WebP dimensionnés, `loading="lazy"`, JSON-LD Person + LocalBusiness + FAQPage, Plausible sans cookie, gzip actif.
- Les 7 pages d'audit présentent un contenu structuré et directement utile. Cela aide
  leur lisibilité, sans garantie de reprise par les assistants ni d'effet des balisages.
- Chiffres vérifiables et contextualisés : « 500+ scénarios Cypress **pour Citeo** », « 70 % de couverture **atteinte** ».

### Les trois manques structurels
1. **Une offre récurrente reste à décider.** Elle peut devenir un étage pertinent,
mais le modèle, le prix et la capacité de delivery doivent d'abord être validés. → A4, MT11
2. **La preuve issue d'une TPE est insuffisante.** C'est une hypothèse de réassurance
forte à tester avec un témoignage réel, pas encore un déficit de conversion mesuré. → MT15
3. **Le contact repose sur email, téléphone et Calendly.** Un formulaire peut réduire
la friction pour certains visiteurs mais doit être testé, sécurisé et mesuré. → MT14, LT23

---

## Annexe A : inventaire des 29 pages

### FR (16)

| URL | `<title>` | H1 | Contenu |
|---|---|---|---|
| `/` | Matthieu Viel · Dépannage informatique à Saint-Pierre 974 | Un problème informatique, et personne à appeler ? | Accueil deux portes : dépannage TPE puis interventions techniques |
| `/portfolio.html` | Portfolio réalisations · Matthieu Viel · Développeur web 974 | Des projets qui résolvent de vrais problèmes métier | 4 typologies de problèmes + 4 réalisations |
| `/senior-tech.html` | Matthieu Viel · Dev Senior Symfony/React · Missions longues | Renfort senior Symfony/React pour vos missions critiques. | Page ESN / grands comptes, missions 3 à 12 mois |
| `/contact.html` | Matthieu Viel · Contact : email, téléphone · Réunion 974 | Contactez-moi directement, sans intermédiaire | Email, téléphone, Calendly, 4 réseaux |
| `/audit/` | Audit technique web freelance · Matthieu Viel · Réunion | Votre application a besoin d'un regard technique externe. | Hub de 7 cas d'audit + FAQ |
| `/audit/faq/` | FAQ audit technique freelance · Matthieu Viel · Réunion | Questions fréquentes sur l'audit technique freelance | Coût, délais, périmètre, pentest |
| `/audit/application-vibe-coding-production/` | Audit app développée avec l'IA · Matthieu Viel · Réunion | Comment vérifier qu'une application développée avec l'IA est prête pour la production ? | 5 points critiques post-IA |
| `/audit/dette-technique-application-saas/` | Identifier et réduire la dette technique SaaS · Réunion 974 | Comment identifier et réduire la dette technique d'une application SaaS existante ? | Cartographie, priorisation, Strangler Fig |
| `/audit/tests-automatises-application/` | Tests automatisés sans suite existante · Matthieu Viel 974 | Comment mettre en place des tests automatisés sur une application qui n'en a pas ? | Cypress, couverture minimale viable |
| `/audit/cicd-pipeline-application/` | Pipeline CI/CD pour déployer sereinement · Matthieu Viel 974 | Comment mettre en place un pipeline CI/CD pour déployer mon application sans stress ? | GitHub Actions, lint, tests |
| `/audit/freelance-audit-technique-startup/` | Freelance senior vs cabinet pour audit technique · Réunion | Pourquoi faire appel à un freelance senior pour un audit technique plutôt qu'à un cabinet ? | Comparatif freelance / cabinet |
| `/audit/application-solo-founder-clients/` | Mon app solo est-elle prête pour mes clients ? · Réunion 974 | J'ai développé mon application seul, comment savoir si je peux la proposer à mes clients ? | Checklist 8 points |
| `/audit/integration-wetransform-saas/` | Intégrer WeTransform dans une application SaaS · Réunion | Comment intégrer WeTransform dans une application SaaS B2B ? | Embed, Power Functions, ERP |
| `/quiz.html` | Diagnostic · Matthieu Viel · Développeur web indépendant | Votre application est-elle un atout ou un risque ? | Quiz interactif, **orpheline** |
| `/mentions-legales.html` | Mentions légales · Matthieu Viel · Développeur web Réunion | Mentions légales | Éditeur, SIRET, hébergeur |
| `/tech.html` | (méta-refresh) | aucun | Redirection vers `senior-tech.html` |

### EN (13)
`/en/`, `/en/portfolio.html`, `/en/contact.html`, `/en/legal-notice.html`, `/en/audit/`
et 8 sous-pages d'audit (dont `faq`). Miroir fidèle du FR.

**Sans équivalent EN :** `senior-tech.html` et `quiz.html`. Leur bascule de langue
renvoie vers `en/index.html`, ce qui explique l'absence de `hreflang="en"` sur
`senior-tech.html`.

### Pages clés pour la conversion
- **Accueil** : porte d'entrée unique, 2 CTA Calendly, 4 liens contact, 1 `tel:` (en bas de page seulement)
- **Contact** : email, téléphone, Calendly, aucun formulaire
- **Hub `/audit/`** : la meilleure page SEO du site, 3 CTA Calendly
- **Portfolio** : preuve, mais **0 CTA direct, 0 JSON-LD**
- **Pas de page Offre / Services** : c'est le trou principal
- **Pas de blog ni de ressources**

---

## Annexe B : mots-clés à cibler

| # | Expression | Intention | Page cible | Fiche |
|---|---|---|---|---|
| 1 | `dépannage informatique Saint-Pierre / La Réunion` | Transactionnelle | `/` (déjà là, à consolider) | QW04 |
| 2 | `site internet piraté que faire` | Informationnelle → commerciale | **Nouvelle** `/site-internet-pirate/` | MT13 |
| 3 | `prestataire web ne répond plus`, `récupérer accès site web` | Transactionnelle | **Nouvelle** `/reprendre-son-site/` | MT13 |
| 4 | `maintenance site internet TPE tarif` | Commerciale | **Nouvelle** `/accompagnement/` | MT11 |
| 5 | `informaticien à la demande petite entreprise` | Commerciale | `/accompagnement/` | MT11 |
| 6 | `CTO à temps partagé`, `CTO freelance PME` | Commerciale | `/accompagnement/` + `/senior-tech.html` | MT11, MT18 |
| 7 | `créer site internet artisan / commerçant Réunion` | Transactionnelle | **Nouvelle** `/site-internet-tpe/` | LT20 |
| 8 | `automatiser tâches répétitives petite entreprise` | Informationnelle | Ressource / blog | LT20 |
| 9 | `sauvegarde site internet entreprise` | Informationnelle → commerciale | Ressource + `/accompagnement/` | LT20, MT11 |
| 10 | `audit technique application IA` | Commerciale | `/audit/application-vibe-coding-production/` (déjà bien positionnée) | QW04 |

Les volumes locaux 974 sont faibles, c'est structurel. La valeur est dans l'intention :
quelqu'un qui tape « prestataire web ne répond plus » est à une semaine de signer.
Les entrées 2, 3, 8 et 9 sont aussi les formulations que les LLM recyclent, ce qui
les rend doublement rentables.

---

## Annexe C : mesures brutes du 17 septembre 2026

| Mesure | Valeur |
|---|---|
| Redirections | apex → `www` en 1 saut, HTTPS forcé, HSTS `max-age=86400` |
| `robots.txt` | 200, `Allow: /`, sitemap déclaré, aucun crawler IA bloqué |
| `sitemap.xml` | 200, 27 URL, `lastmod` + `xhtml:link` complets |
| `llms.txt` | **404** |
| Accueil | 44 382 o brut, 9 907 o gzip |
| CSS | 3 fichiers, 10 290 o brut au total |
| JS | 1 041 o |
| `Cache-Control` | **absent sur toutes les ressources** |
| `portrait.webp` | 1600 × 1600, 57 ko, affiché en 400 × 400 puis 360 × 450 |
| `hero-banner.webp` | 1600 × 400, 40 ko |
| `site-mockup.webp` | 1600 × 836, 58 ko |
| `cta-quiz.webp` | 1600 × 836, 48 ko |
| `--clr-muted` sur blanc | **3,44:1**, échec AA |
| `--clr-muted` sur `--clr-bg-alt` | **3,19:1**, échec AA |
| `--clr-slate` sur blanc | 8,12:1, conforme |
| Titres hors cible 55-60 | 6 (toutes EN) |
| Descriptions hors cible 150-160 | 20 sur 29 |
| Formulaires sur le site | 1, sur la page orpheline `quiz.html` |
| `BreadcrumbList` | 0 page |
| Page 404 personnalisée | absente |

---

## Réserve assumée

Plusieurs recommandations (MT11 en particulier) supposent de trancher la question du
modèle tarifaire, que `TODO.md` a explicitement mise en attente (point A4). Je n'ai pas
contourné ce choix, je l'ai posé là où il bloque : la page `/accompagnement/` ne peut
pas convertir sans au moins une borne de prix.
