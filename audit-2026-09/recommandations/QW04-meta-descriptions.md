# QW04 · Réécrire 20 méta-descriptions et 6 titres

| | |
|---|---|
| Priorité | Quick win |
| Effort | 2 h |
| Impact | CTR dans les SERP, GEO |
| Parité FR/EN | Oui, requise |
| Dépendances | Faire [QW01](QW01-unifier-email.md) avant, pour ne pas repasser deux fois |

## Constat mesuré (17/09/2026)

Cibles imposées par la règle 2 de `CLAUDE.md` : **titre 55-60**, **description 150-160**.

Sur les 29 pages servies : **20 descriptions hors cible** (de 113 à 236 caractères)
et **6 titres au-dessus de 60 caractères**, tous côté EN.

La pire : `/en/audit/technical-debt-saas-application/` à **236 caractères**.

Les blocs sont tous à la même place dans chaque template :
`{% block title %}` ligne 3, `{% block meta_description %}` ligne 4.

**Attention aux entités HTML :** `en/index.html.twig` contient `&amp;`, qui compte
5 caractères dans la source mais 1 dans le rendu. Ce titre fait 64 en source et
**60 en rendu**, il est donc conforme. Toujours mesurer sur `dist/`, pas sur le Twig.

## Pourquoi c'est important

Google tronque autour de 155-160 caractères. Sur
`/audit/tests-automatises-application/` (233 car.), le « 500+ scénarios Cypress »
final, qui est l'argument de preuve, est **coupé dans la SERP**. La description la
plus longue du site perd précisément ce qui la rendait convaincante.

À l'inverse, `/en/portfolio.html` (113 car.) laisse 45 caractères de place inutilisée.

Déjà identifié en **A2** dans `TODO.md`.

---

## Remplacements, longueurs déjà validées

### Titres, 6 à corriger (tous EN)

| Fichier | Actuel | Nouveau (longueur) |
|---|---|---|
| `src/templates/en/audit/application-solo-founder-clients.html.twig:3` | 63 | `Is my solo-built app safe for clients? · Réunion Island` (55) |
| `src/templates/en/audit/application-vibe-coding-production.html.twig:3` | 65 | `Audit an AI-built app before production · Réunion Island` (56) |
| `src/templates/en/audit/automated-tests-application.html.twig:3` | 61 | `Set up automated tests from scratch · Réunion Island 974` (56) |
| `src/templates/en/audit/cicd-pipeline-application.html.twig:3` | 65 | `CI/CD pipeline to deploy without stress · Réunion Island` (56) |
| `src/templates/en/audit/freelance-technical-audit-startup.html.twig:3` | 65 | `Senior freelance vs firm for a technical audit · Réunion` (56) |
| `src/templates/en/audit/technical-debt-saas-application.html.twig:3` | 65 | `Identify and reduce SaaS technical debt · Réunion Island` (56) |

### Titre optionnel, accueil FR

Le titre actuel (`Matthieu Viel · Dépannage informatique à Saint-Pierre 974`, 57 car.)
est **conforme**. Il peut rester tel quel.

Alternative si vous voulez libérer l'espace occupé par le nom au profit de mots-clés,
sachant que les requêtes de marque continueront de matcher via le H2 « À propos », le
JSON-LD et le nom de domaine :

```
Dépannage informatique TPE · Saint-Pierre, La Réunion 974   (57)
```

Décision à prendre, pas une correction. Le gain est faible, le risque aussi.

### Descriptions, 20 à corriger

#### FR

| Fichier (ligne 4) | Actuel | Nouvelle |
|---|---|---|
| `index.html.twig` | 153 (conforme) | **optionnel**, voir ci-dessous |
| `portfolio.html.twig` | 149 | `Réalisations de Matthieu Viel : sites de TPE, outils métier, migrations legacy, automatisation. 18 ans d'expérience fullstack, Saint-Pierre La Réunion.` (151) |
| `mentions-legales.html.twig` | 124 | `Mentions légales du site matthieu-viel.fr : éditeur, SIRET, contact, propriété intellectuelle, hébergement, cookies et données personnelles. Réunion 974.` (153) |
| `audit/index.html.twig` | 192 | `Audit technique freelance à La Réunion : application développée avec l'IA, dette technique SaaS, tests automatisés, CI/CD. Matthieu Viel, 18 ans de métier.` (155) |
| `audit/faq.html.twig` | 193 | `Coût, délais, périmètre d'un audit technique freelance, différence avec un pentest, apps développées avec l'IA. Réponses directes de Matthieu Viel, 974.` (152) |
| `audit/application-solo-founder-clients.html.twig` | 211 | `J'ai développé mon application seul : comment savoir si je peux la proposer à mes clients ? Checklist de 8 points. Matthieu Viel, 18 ans de métier, 974.` (152) |
| `audit/application-vibe-coding-production.html.twig` | 215 | `Votre app construite avec Claude Code, Cursor ou Bolt est-elle prête pour la production ? Audit en 5 points critiques. Matthieu Viel, Saint-Pierre 974.` (151) |
| `audit/cicd-pipeline-application.html.twig` | 195 | `Comment arrêter de déployer votre application à la main ? Pipeline GitHub Actions, lint, tests et déploiement automatique. Matthieu Viel, La Réunion 974.` (153) |
| `audit/dette-technique-application-saas.html.twig` | 217 | `Comment identifier et réduire la dette technique d'un SaaS existant ? Audit, plan priorisé, pattern Strangler Fig. Matthieu Viel, 18 ans d'expérience.` (150) |
| `audit/freelance-audit-technique-startup.html.twig` | 211 | `Freelance senior ou cabinet pour un audit technique ? Coût, disponibilité, recommandations applicables. Matthieu Viel, 18 ans d'expérience, La Réunion.` (151) |
| `audit/tests-automatises-application.html.twig` | 233 | `Comment mettre en place des tests automatisés quand il n'y en a aucun ? Parcours critiques, Cypress, CI/CD. 500+ scénarios écrits pour Citeo. Réunion 974.` (154) |

Accueil FR, **optionnel mais recommandé** : la description actuelle est conforme
(153 car.) mais ne dit rien de la récurrence. Variante qui introduit le suivi dès la
SERP, en préparation de [MT11](MT11-page-accompagnement.md) :

```
Site en panne, piraté, ou plus personne pour s'en occuper ? Je répare, puis je reste joignable. 18 ans de métier à Saint-Pierre 974. Réponse sous 24 h.   (151)
```

#### EN

| Fichier (ligne 4) | Actuel | Nouvelle |
|---|---|---|
| `en/portfolio.html.twig` | 113 | `Matthieu Viel's work: small-business websites, custom internal tools, legacy migrations, automation. 18 years of fullstack experience, Réunion Island.` (150) |
| `en/legal-notice.html.twig` | 116 | `Legal notice for matthieu-viel.fr: publisher, company number, contact details, intellectual property, hosting, cookies and personal data. Réunion 974.` (150) |
| `en/audit/index.html.twig` | 202 | `Freelance technical audit in Réunion Island: AI-built apps, SaaS technical debt, automated testing, CI/CD pipelines. Matthieu Viel, 18 years in the trade.` (154) |
| `en/audit/faq.html.twig` | 206 | `Cost, timelines and scope of a freelance technical audit, how it differs from a pentest, and AI-built apps. Direct answers from Matthieu Viel, Réunion 974.` (155) |
| `en/audit/application-solo-founder-clients.html.twig` | 194 | `I built my app alone: how do I know it is safe to offer it to my clients? An 8-point checklist. Matthieu Viel, 18 years of experience, Réunion Island.` (150) |
| `en/audit/application-vibe-coding-production.html.twig` | 206 | `Is your app built with Claude Code, Cursor or Bolt ready for production? A 5-point critical audit. Matthieu Viel, web developer in Réunion Island 974.` (150) |
| `en/audit/automated-tests-application.html.twig` | 215 | `How do you add automated tests when there are none at all? Critical paths, Cypress, CI/CD integration. 500+ scenarios written for Citeo. Réunion Island.` (152) |
| `en/audit/cicd-pipeline-application.html.twig` | 194 | `How do you stop deploying your app by hand? GitHub Actions pipeline, lint, tests and automatic deployment. Matthieu Viel, freelance in Réunion Island.` (150) |
| `en/audit/freelance-technical-audit-startup.html.twig` | 209 | `Senior freelance or consulting firm for a technical audit? Cost, availability, actionable findings. Matthieu Viel, 18 years fullstack, Réunion Island.` (150) |
| `en/audit/technical-debt-saas-application.html.twig` | 236 | `How do you identify and reduce technical debt in an existing SaaS? Audit, prioritised plan, Strangler Fig pattern. Matthieu Viel, 18 years of experience.` (153) |

---

## Ne pas oublier les `og:description`

Chaque template a aussi un `{% block og %}` avec sa propre `og:description`, qui est
souvent **différente** de la `meta description`. Exemple sur l'accueil :

- `meta description` : « ...Je remets vos outils informatiques d'aplomb, sans jargon... »
- `og:description`   : « ...Je m'en occupe et je vous explique avec des mots normaux... »

Cette divergence est acceptable (la contrainte de longueur n'est pas la même), mais
vérifier que le message reste cohérent après réécriture. Mettre à jour `og:title` en
même temps que `{% block title %}` sur les 6 pages EN concernées.

## Critères d'acceptation

- [ ] Les 29 pages de `dist/` ont un titre entre 55 et 60 caractères **en rendu**
- [ ] Les 29 pages ont une description entre 150 et 160 caractères, hors `tech.html` (redirection) et `quiz.html` (voir QW03)
- [ ] `og:title` mis à jour sur les 6 pages EN dont le titre change
- [ ] Aucun tiret cadratin introduit (voir mémoire projet : jamais de `—` sur le site)
- [ ] Le vocabulaire reste conforme au `seed/` : pas de superlatif, pas de jargon marketing
- [ ] `npm test` passe

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
php src/export.php
python3 - <<'PY'
import re,html,glob
bad=0
for p in sorted(glob.glob('dist/**/*.html',recursive=True)):
    s=open(p,encoding='utf-8').read()
    if 'http-equiv="refresh"' in s: continue
    t=re.search(r'<title>(.*?)</title>',s,re.S)
    d=re.search(r'<meta\s+name="description"\s+content="(.*?)"',s,re.S)
    lt=len(html.unescape(t.group(1).strip())) if t else 0
    ld=len(html.unescape(d.group(1).strip())) if d else 0
    ok_t, ok_d = 55<=lt<=60, 150<=ld<=160
    if not ok_t or not ok_d:
        print(f"{p:60} title={lt}{'' if ok_t else ' KO'}  desc={ld}{'' if ok_d else ' KO'}")
        bad+=1
print(f"\n{bad} page(s) hors cible")
PY
grep -rc "—" dist --include=*.html | grep -v ":0" || echo "Aucun tiret cadratin"
```

Attendu : **0 page hors cible**, **aucun tiret cadratin**.

## Règles `CLAUDE.md` engagées

- **Règle 2, SEO** : titre 55-60, description 150-160, bénéfice clair
- **Règle 1, ton** : vocabulaire validé par `seed/`, pas de superlatif
- **Règle 5, parité FR/EN**
- Mémoire projet : aucun tiret cadratin nulle part sur le site

## Référence

Point **A2** de `TODO.md`, et point **7** (« Add SEO metadata length checks », test
automatisé à ajouter pour que la dérive ne revienne pas).
