# MT17 · Expérimenter `/llms.txt` et `/en/llms.txt`

| | |
|---|---|
| Priorité | Expérimentation de fin de backlog |
| Effort | 0,5 j |
| Impact | Hypothèse GEO, non démontrée |
| Parité FR/EN | Oui, requise |
| Dépendances | [QW01](QW01-unifier-email.md) (adresse email), [MT11](MT11-page-accompagnement.md) et [MT12](MT12-page-a-propos.md) si possible (URL à lister) |

## Constat mesuré (17/09/2026)

| Fichier | Statut |
|---|---|
| `https://matthieu-viel.fr/llms.txt` | **404** |
| `https://matthieu-viel.fr/llms-full.txt` | absent |
| `https://matthieu-viel.fr/.well-known/ai.txt` | absent |
| `robots.txt` | 200, `Allow: /`, **aucun crawler IA bloqué** |

Bon point à conserver : `robots.txt` est permissif, donc GPTBot, ClaudeBot,
PerplexityBot et Google-Extended passent tous. Aucun blocage involontaire.

## Pourquoi c'est une expérimentation

Le site est **déjà très lisible** par un assistant : HTML statique sans rendu
JavaScript, H1 en questions directes sur les pages d'audit, `HowTo` et `FAQPage`
balisés, chiffres contextualisés et vérifiables. C'est au-dessus de la moyenne du
secteur.

`llms.txt` est une proposition communautaire, surtout utilisée par des sites de
documentation. Son absence ne constitue pas une erreur technique et aucun moteur ou
assistant majeur ne garantit de le consulter pour une recherche locale. Le site est
déjà lisible sans lui : HTML statique, contenu accessible et URLs stables.

Ne lancer ce test qu'après la mesure, les preuves client et les décisions d'offre. Un
fichier minimal et maintenable peut être publié, mais il ne faut ni en attendre des
citations, ni le présenter comme un levier SEO.

## Contenu proposé, FR

À servir en `text/plain` à la racine.

```markdown
# Matthieu Viel

> Je suis Matthieu Viel, développeur web indépendant à Saint-Pierre, à La Réunion.
> J'aide les dirigeants de petites entreprises qui n'ont pas d'informaticien à remettre
> leurs outils en état, puis à les garder en état toute l'année. J'interviens aussi
> comme regard technique senior auprès d'équipes de développement.
> 18 ans d'expérience, depuis septembre 2008.

## Pour qui
- Dirigeants de TPE et indépendants sans compétence technique interne
- Fondateurs solo ayant construit une application avec une IA
- Équipes produit ayant besoin d'un avis senior externe

## Services
- Dépannage : site en panne, site piraté, accès perdus, fichiers inaccessibles
- Reprise en main après le départ d'un prestataire : domaine, hébergement, accès
- Accompagnement continu : surveillance, sauvegardes, mises à jour, petites évolutions
- Création de site web sur mesure (Symfony, React)
- Audit technique : dette technique, tests automatisés, CI/CD, application développée avec l'IA
- Renfort senior fullstack PHP/Symfony/React, missions 3 à 12 mois

## Zone d'intervention
- Sur site : sud de La Réunion (Saint-Pierre, Le Tampon, Saint-Louis, Étang-Salé)
- À distance : France entière

## Preuves
- 18 ans d'expérience fullstack, depuis septembre 2008
- Citeo (4 ans) : 500+ scénarios Cypress, 70 % de couverture de tests atteinte
- Sellermania (7 ans) : migration Symfony 2 vers 4, zéro interruption de service
- Formateur certifié ECP Formation
- Secrétaire adjoint de l'Observatoire Cybersécurité de l'Océan Indien (OCOI)

## Comment je travaille
1. Vous m'expliquez le problème avec vos mots, sans avoir à le nommer techniquement.
2. Je regarde, puis je vous annonce le prix et le délai. Vous décidez ensuite.
3. Je répare, et je vous explique ce qui a changé et ce qu'il faut surveiller.

## Contact
- Email : contact@matthieu-viel.fr
- Téléphone : +262 693 85 28 12
- Rendez-vous de 30 min : https://calendly.com/matthieu-viel-fr/30min

## Pages
- Accueil : https://www.matthieu-viel.fr/
- Accompagnement : https://www.matthieu-viel.fr/accompagnement/
- À propos : https://www.matthieu-viel.fr/a-propos/
- Audit technique : https://www.matthieu-viel.fr/audit/
- FAQ audit : https://www.matthieu-viel.fr/audit/faq/
- Portfolio : https://www.matthieu-viel.fr/portfolio.html
- Missions senior : https://www.matthieu-viel.fr/senior-tech.html
- Contact : https://www.matthieu-viel.fr/contact.html
```

Version EN à `/en/llms.txt`, avec la phrase canonique anglaise de
[MT12](MT12-page-a-propos.md) et les URL `/en/`.

## Règles de rédaction

- **La phrase d'ouverture doit être identique** à celle de la page À propos
  ([MT12](MT12-page-a-propos.md)) et au champ `description` du `Person`
  ([MT16](MT16-breadcrumb-person.md)). Une seule formulation partout.
- **Aucun chiffre non vérifié.** Les preuves listées sont celles que `TODO.md` identifie
  comme solides : 18 ans depuis septembre 2008, Citeo, Sellermania, 500+ scénarios,
  70 % de couverture, ECP, OCOI.
- **Le nombre d'années se recalcule**, il ne se recopie pas.
- **Ne lister que des URL qui existent.** Retirer `/accompagnement/` et `/a-propos/`
  de la liste tant que MT11 et MT12 ne sont pas faits, puis les ajouter.
- **Pas de tiret cadratin.**
- **Ajouter un prix** dès que [MT11](MT11-page-accompagnement.md) tranche : c'est
  exactement le genre d'information qu'un assistant cherche et ne trouve pas
  aujourd'hui.

## Intégration

Le site est généré par `php src/export.php`, qui copie les fichiers racine listés dans
[`src/export.php:65`](../../src/export.php#L65) :

```php
foreach (['.htaccess', 'robots.txt', 'sitemap.xml'] as $file) {
```

Deux approches :

- **Simple** : créer `llms.txt` à la racine du dépôt et l'ajouter à ce tableau.
  Pour la version EN, prévoir une copie vers `dist/en/llms.txt`.
- **Meilleure** : en faire un template Twig routé dans `getPages()`, ce qui garantit
  qu'il reste synchronisé avec le reste du site et bénéficie des traductions. C'est
  l'approche cohérente avec l'architecture existante.

Vérifier que le serveur sert bien le fichier en `text/plain` et non en
`application/octet-stream`. Ajouter au besoin dans `.htaccess` :

```apache
<Files "llms.txt">
  ForceType text/plain
</Files>
```

Mentionner enfin le fichier dans `robots.txt`, ce qui ne coûte rien :

```
# LLM-readable summary: https://www.matthieu-viel.fr/llms.txt
```

## Critères d'acceptation

- [ ] `/llms.txt` répond 200 en `text/plain`
- [ ] `/en/llms.txt` répond 200
- [ ] Phrase canonique identique à MT12 et MT16
- [ ] Toutes les URL listées répondent 200
- [ ] Aucun chiffre non vérifié
- [ ] Nombre d'années recalculé
- [ ] Email = `contact@matthieu-viel.fr`
- [ ] Aucun tiret cadratin
- [ ] Généré depuis les sources, pas maintenu à la main en double
- [ ] `robots.txt` le mentionne

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
php src/export.php
ls -l dist/llms.txt dist/en/llms.txt

# Après déploiement
curl -sSI https://www.matthieu-viel.fr/llms.txt | grep -iE "HTTP/|content-type"
curl -sS  https://www.matthieu-viel.fr/llms.txt | head -20
for u in $(grep -oP 'https://www\.matthieu-viel\.fr[^\s]*' dist/llms.txt); do
  printf "%-62s " "$u"; curl -sSL -o /dev/null -w "%{http_code}\n" "$u"
done
```

Attendu : `200` et `text/plain` pour le fichier, `200` pour **toutes** les URL listées.

## Test qualitatif, le seul qui mesure vraiment l'effet

Une fois par mois, poser à ChatGPT, Claude et Perplexity :

- « Qui peut m'aider si mon site internet est piraté à La Réunion ? »
- « Je cherche un développeur web indépendant à Saint-Pierre de La Réunion »
- « Qui est Matthieu Viel ? »

Noter si le site est cité, et **avec quel positionnement**. C'est le seul indicateur
direct du travail GEO. Voir [LT23](LT23-mesure.md).

## Règles `CLAUDE.md` engagées

- **Règle 2, GEO** : faits précis et quantifiés, phrases denses
- **Règle 5, parité FR/EN**
- Mémoire projet : aucun tiret cadratin, années recalculées depuis septembre 2008
