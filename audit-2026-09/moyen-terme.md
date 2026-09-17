# Moyen terme, 1 à 2 semaines

Neuf chantiers : création de pages, structure, preuves sociales, données structurées.
Chacun a sa fiche détaillée dans `recommandations/`.

Ordre d'exécution recommandé : **11, 15, 14, 12, 17, 16, 13, 19, 18**
(la page qui débloque le modèle économique en premier, la décision de périmètre en dernier).

Rappel parité : la règle 5 de `CLAUDE.md` est non négociable. Toute page FR créée ici
a son miroir EN **dans la même tâche**, jamais reporté. Voir `src/routes.php`.

---

## 11. Créer la page `/accompagnement/` et `/en/support-plan/`

**Cette recommandation dépend d'une décision commerciale encore ouverte.**

**Constat.** Le site n'a aucune offre récurrente. Le champ lexical entier est celui de
la panne : panne, piraté, disparu, récupérer, nettoyer, réparer. Zéro occurrence de
« accompagnement », « suivi », « partenaire », « toute l'année ». Un visiteur en déduit
logiquement : j'appelle quand ça casse.

**Pourquoi.** Cette page peut transformer une première intervention en relation
récurrente, si la demande, le périmètre et la capacité de réponse sont validés. Sans
ces éléments, elle risquerait de vendre une promesse encore imprécise.

**Bloquant.** Exige de trancher le modèle tarifaire, en attente depuis le point A4 de
`TODO.md`. La page ne convertit pas sans au moins une borne de prix.

**Effort.** 1 j. **Fiche :** [MT11](recommandations/MT11-page-accompagnement.md)

---

## 12. Extraire une vraie page `/a-propos/` et `/en/about/`

**Constat.** L'information « à propos » n'est qu'une ancre `#a-propos` de l'accueil,
située aux deux tiers de la page, en concurrence avec tout le reste pour le résumé.

**Pourquoi.** Un LLM interrogé sur « qui est Matthieu Viel » n'a aucune URL dédiée à
citer. Google n'a aucune page à faire remonter sur la requête de marque. C'est aussi
là que doit vivre la phrase canonique « Je suis X, j'aide Y à Z », qui n'existe
aujourd'hui nulle part sur le site.

**Effort.** 0,5 j. **Fiche :** [MT12](recommandations/MT12-page-a-propos.md)

---

## 13. Créer deux pages problème à forte intention

**Constat.** Les deux situations les plus fréquentes et les plus urgentes de la cible
(« mon site est piraté », « mon prestataire ne répond plus ») ne sont traitées que par
une carte de 3 lignes sur l'accueil. Aucune page dédiée, donc aucune chance de ranker.

**Pourquoi.** Ces requêtes peuvent correspondre à une intention commerciale urgente.
Leur volume, la concurrence locale et leur pertinence doivent être vérifiés dans
Search Console et les SERP avant de créer les pages.

Pages à créer : `/site-internet-pirate/` et `/reprendre-son-site/`, plus miroirs EN.

**Effort.** 1 j. **Fiche :** [MT13](recommandations/MT13-pages-probleme.md)

---

## 14. Ajouter un formulaire de contact court

**Constat.** **Le site n'a aucun formulaire de contact.** Le seul existant est sur
`quiz.html`, la page que rien ne lie. Un dirigeant sur mobile qui clique
« Expliquez-moi votre problème » atterrit sur une page où il doit copier une adresse
email et basculer dans son client mail.

**Pourquoi.** Un formulaire court peut réduire la friction pour certains visiteurs,
mais cette hypothèse doit être instrumentée et comparée aux canaux existants.

**Effort.** 0,5 j. **Fiche :** [MT14](recommandations/MT14-formulaire-contact.md)

---

## 15. Obtenir et publier deux témoignages de TPE

**Constat.** Les 3 témoignages viennent d'un Head of IT de Citeo, d'un CEO de SaaS
e-commerce et d'un Lead Dev. Les 6 logos sont des grands comptes. Les 3 « missions
récentes » parlent de 500+ scénarios Cypress, de migration Symfony 2 vers 4 et de
Strangler Fig Pattern.

**Pourquoi.** Pour un artisan ou un commerçant de Saint-Pierre, tout cela signale
« il travaille pour des gros, je ne suis pas son client ». **C'est le déficit de
conversion numéro un du site.** Ce seul ajout fera plus que les six logos grands
comptes réunis. Déjà identifié en A3 dans `TODO.md`.

**Effort.** 2 j dont l'essentiel en attente de réponse.
**Fiche :** [MT15](recommandations/MT15-temoignages-tpe.md)

---

## 16. Ajouter `BreadcrumbList` et enrichir le `Person` de l'accueil

**Constat.** Zéro `BreadcrumbList` sur les 29 pages, alors que les pages
`/audit/<slug>/` sont à 3 niveaux de profondeur. Le `Person` de l'accueil n'a ni
`description`, ni `email`, ni `telephone`, ni `knowsAbout`, alors que celui de
`senior-tech.html` les possède tous.

**Pourquoi.** Un fil d'Ariane visible et balisé améliore la navigation et peut être
repris dans les SERP. L'affichage et l'effet sur le CTR ne sont pas garantis ; enrichir
`Person` n'est pas un levier GEO démontré.

**Effort.** 0,5 j. **Fiche :** [MT16](recommandations/MT16-breadcrumb-person.md)

---

## 17. Créer `/llms.txt` et `/en/llms.txt`

**Constat.** `https://matthieu-viel.fr/llms.txt` renvoie **404**. Aucun
`llms-full.txt`, aucun `.well-known/ai.txt`.

**Pourquoi.** `llms.txt` est une convention expérimentale, sans adoption garantie par
les assistants. Le fichier peut être testé en fin de backlog, sans promesse de citation
ni d'effet GEO.

**Effort.** 0,5 j. Contenu déjà rédigé dans la fiche.
**Fiche :** [MT17](recommandations/MT17-llms-txt.md)

---

## 18. Trancher le sort de `senior-tech.html`

**Constat.** Cette page vend du renfort en mission longue à des ESN et grands comptes,
c'est-à-dire exactement le marché dont vous sortez. Elle est absente du sitemap, sans
équivalent EN, et présente dans la nav de toutes les pages sous le libellé « Missions ».

**Pourquoi.** Elle occupe un des six emplacements de navigation principale, que
`/accompagnement/` devrait prendre. C'est une décision, pas une tâche : trois options
sont posées dans la fiche, avec un avis.

**Effort.** Décision, puis 1 h d'exécution.
**Fiche :** [MT18](recommandations/MT18-sort-senior-tech.md)

---

## 19. Créer la page `/methode/` si elle sert le parcours

**Constat.** Le process en trois étapes de l'accueil est excellent mais tient en
neuf lignes et n'est pas balisé.

**Pourquoi.** Cette page peut devenir un support utile à partager avec un prospect.
Le balisage `HowTo` n'apporte plus de résultat enrichi Google et ne justifie pas à lui
seul la création de la page.

**Effort.** 0,5 j. **Fiche :** [MT19](recommandations/MT19-page-methode.md)

---

## Vérification globale après les neuf

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
php src/export.php
npm test

# Parité FR/EN : chaque nouvelle route doit exister dans les deux langues
grep -c "accompagnement\|support-plan" src/routes.php   # attendu : >= 2
grep -c "a-propos\|about"              src/routes.php   # attendu : >= 2
grep -c "methode\|method"              src/routes.php   # attendu : >= 2

# Sitemap : toutes les nouvelles pages déclarées
for u in accompagnement a-propos methode site-internet-pirate reprendre-son-site; do
  printf "%-24s " "$u"; grep -c "/$u/" sitemap.xml
done

# llms.txt en ligne
curl -sS -o /dev/null -w "llms.txt : %{http_code}\n" https://www.matthieu-viel.fr/llms.txt

# BreadcrumbList sur les pages d'audit
grep -rl "BreadcrumbList" dist --include=*.html | wc -l   # attendu : 16
```
