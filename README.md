# matthieu-viel.fr

Site vitrine professionnel de Matthieu Viel, consultant technique web senior à La Réunion.

## Structure

```
matthieu-viel.fr/
├── index.html              ← Page principale (PME non-tech)
├── tech.html               ← Page CTO/tech (placeholder)
├── portfolio.html          ← Portfolio détaillé (placeholder)
├── sitemap.xml
├── assets/
│   ├── css/
│   │   ├── main.css        → Reset, variables, layout, nav, hero, footer
│   │   ├── components.css  → Boutons, cards, steps, testimonials, formulaire
│   │   └── responsive.css  → Media queries (1024 / 768 / 480px)
│   ├── js/
│   │   └── main.js         → Menu burger, scroll actif, fade-up animations
│   └── images/             → portrait.jpg, hero-banner.jpg, cta-quiz.jpg, favicon.svg
├── .github/
│   └── workflows/
│       └── deploy.yml      → Validation HTML + tests + déploiement FTP Gandi
├── tests/
│   └── links.test.js       → Tests Node.js natif (balises critiques, images, alt)
└── seed/                   → Assets sources (exclu du déploiement FTP)
```

## Lancer les tests en local

```bash
node tests/links.test.js
```

Aucune dépendance NPM — Node.js seul suffit.

## Déploiement

Le pipeline CI/CD (GitHub Actions) se déclenche sur chaque push sur `main` :

1. Validation HTML (`html-validate`)
2. Tests Node.js
3. Déploiement FTP vers le serveur mutualisé Gandi

### Configurer les secrets GitHub

Dans le repo → **Settings → Secrets and variables → Actions**, ajouter :

| Secret         | Valeur                                             |
|----------------|----------------------------------------------------|
| `FTP_SERVER`   | Hôte FTP       |
| `FTP_USERNAME` | Identifiant FTP                              |
| `FTP_PASSWORD` | Mot de passe FTP                             |
| `FTP_PATH`     | Chemin cible sur le serveur (ex: `/www/matthieu-viel`)              |

## TODOs restants

- [ ] **Lien test de performance** — remplacer `href="#"` dans le CTA hero (index.html:82)
- [ ] **web3forms** — configurer `action` du formulaire de contact et ajouter `access_key`
      Voir : https://web3forms.com
- [ ] **Mentions légales** — créer `mentions-legales.html` et brancher le lien footer
- [ ] **Logo** — remplacer le favicon SVG "MV" par un vrai logo si disponible
- [ ] **tech.html** — développer la page version technique / CTO as a service
- [ ] **portfolio.html** — développer le portfolio détaillé
- [ ] **Nom du repo GitHub** — à confirmer pour que les liens du README soient exacts
