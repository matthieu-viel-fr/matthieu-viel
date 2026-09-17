# MT13 · Créer deux pages problème à forte intention

| | |
|---|---|
| Priorité | Moyen terme |
| Effort | 1 j pour les deux, plus miroirs EN |
| Impact | Acquisition potentielle |
| Parité FR/EN | Oui, requise |
| Dépendances | [MT11](MT11-page-accompagnement.md) de préférence (cible des liens sortants) |

## Constat mesuré (17/09/2026)

Deux situations urgentes plausibles pour la cible ne sont traitées que par une carte
de trois lignes sur l'accueil :

```
🔒 Votre site a été piraté
Je nettoie, je referme la porte d'entrée, et je vous explique comment
c'est arrivé pour que ça ne recommence pas.

🔑 Votre prestataire a disparu
Je récupère les accès, le nom de domaine et l'hébergement, puis je reprends
la main sur votre site. Vous redevenez propriétaire de vos outils.
```

Aucune page dédiée. Aucune chance de ranker sur ces requêtes avec un fragment de
page d'accueil.

## Pourquoi c'est important

- L'intention peut être commerciale, mais le volume, la concurrence et la capacité à
  convertir doivent être vérifiés dans Search Console et une analyse de SERP locale
  avant rédaction. Aucun de ces éléments n'est mesuré dans cette fiche.
- Les réponses utiles peuvent soutenir la confiance, sans garantie de reprise par un
  assistant ni de gain de visibilité lié au balisage.
- Ces pages alimentent directement [MT11](MT11-page-accompagnement.md) : quelqu'un qui
  vient de se faire pirater est le prospect le plus réceptif à une offre de surveillance.

## Page 1 : `/site-internet-pirate/`

```
title       : Site internet piraté, que faire ? · Dépannage La Réunion    (56)
description : Votre site affiche un message suspect ou a disparu de Google ? Nettoyage, remise en ligne et sécurisation. Diagnostic gratuit, prix annoncé avant travaux.   (154)
```

Longueurs validées.

**H1** : `Mon site internet est piraté, que faire ?`

**Structure** :

| Section | Contenu |
|---|---|
| Intro | Rassurer en trois lignes. « C'est réparable. Voici dans quel ordre procéder. » |
| H2 « Comment savoir si votre site est vraiment piraté » | Signes concrets : message d'avertissement du navigateur, redirection vers un site inconnu, disparition de Google, mails d'alerte de l'hébergeur, pages qu'on n'a pas écrites. |
| H2 « Ce qu'il ne faut pas faire tout de suite » | Ne pas supprimer le site. Ne pas changer tous les mots de passe avant d'avoir identifié la faille. Ne pas payer une rançon. **Section très forte pour le GEO**, c'est une réponse directe et utile. |
| H2 « Les cinq étapes de la remise en état » | Constat et sauvegarde de l'état, identification du point d'entrée, nettoyage, fermeture de la faille, remise en ligne et surveillance. |
| H2 « Combien de temps ça prend » | Fourchette honnête. Ne pas promettre « dans la journée » systématiquement. |
| H2 « Et après » | Lien vers `/accompagnement/`. C'est ici que la conversion récurrente se joue. |
| FAQ | `FAQPage` balisé : « Vais-je perdre mes données ? », « Mon référencement est-il perdu ? », « Est-ce que ça peut recommencer ? », « Faut-il prévenir mes clients ? » |
| CTA | `tel:` en premier (contexte d'urgence), puis formulaire, puis Calendly |

Miroir EN : `/en/hacked-website/`

## Page 2 : `/reprendre-son-site/`

```
title       : Prestataire web disparu : reprendre la main sur son site    (56)
description : Votre prestataire web ne répond plus ? Je récupère domaine, hébergement et accès, puis je reprends la maintenance. Saint-Pierre 974, réponse sous 24 h.   (150)
```

Longueurs validées.

**H1** : `Mon prestataire web ne répond plus, comment reprendre la main ?`

**Structure** :

| Section | Contenu |
|---|---|
| Intro | Expliquer prudemment que la propriété dépend des contrats, du titulaire du domaine et des licences. Ne pas promettre une récupération qui peut être juridiquement ou techniquement impossible. |
| H2 « Ce qui vous appartient vraiment » | Nom de domaine, contenu, données clients, et ce qui est plus ambigu (le code sur mesure, les licences de thème). Section de vulgarisation juridique simple. |
| H2 « Comment récupérer un nom de domaine » | `HowTo` : vérifier le whois, identifier le bureau d'enregistrement, procédure de récupération, délais réels. |
| H2 « Comment récupérer l'hébergement et les accès » | Idem, cas par cas. |
| H2 « Si le prestataire est injoignable ou a cessé son activité » | Le cas le plus dur, et le plus recherché. |
| H2 « Reprendre la maintenance ensuite » | Lien vers `/accompagnement/`. |
| FAQ | `FAQPage` : « Combien de temps pour récupérer un domaine ? », « Et si le domaine est au nom du prestataire ? », « Puis-je repartir de zéro ? », « Combien ça coûte ? » |
| CTA | Formulaire en premier (moins urgent que le piratage), puis `tel:` |

Miroir EN : `/en/reclaim-your-website/`

## Règles de rédaction communes

- **Répondre vraiment à la question**, y compris quand la réponse ne mène pas à une
  vente. Une page qui explique comment faire soi-même convertit mieux qu'une page qui
  retient l'information, et c'est le seul moyen d'être cité par un assistant.
- **Paragraphes de 4 lignes maximum**, règle GEO du projet.
- Réponses courtes et directement vérifiables ; ne pas ajouter de FAQ uniquement pour
  le balisage.
- **Pas de superlatif, pas de peur commerciale.** Le ton du `seed/` est calme. Une
  personne qui vient de se faire pirater n'a pas besoin qu'on en rajoute.
- **Aucun terme marketing non validé par `seed/`.**
- **Aucun tiret cadratin.**

## Intégration

1. Quatre routes dans [`src/routes.php`](../../src/routes.php)
2. Liens entrants : depuis les cartes correspondantes de l'accueil (« Votre site a été
   piraté » et « Votre prestataire a disparu » deviennent cliquables), depuis
   `/accompagnement/`, et l'une vers l'autre
3. Sitemap : 4 URL, `priority 0.8`, `hreflang` croisés
4. `BreadcrumbList` si elles sont placées sous un répertoire

## Critères d'acceptation

- [ ] Quatre pages créées (2 FR, 2 EN) **dans la même tâche**
- [ ] Demande et concurrence validées dans Search Console et les SERP locales avant publication
- [ ] Balisage facultatif, strictement conforme au contenu visible ; aucun effet SEO présumé
- [ ] H1 unique, en question directe
- [ ] Paragraphes de 4 lignes maximum
- [ ] Réponses de FAQ en une phrase
- [ ] Chaque page pointe vers une suite réellement proposée, sans présumer que `/accompagnement/` existe
- [ ] Les cartes de l'accueil deviennent cliquables vers ces pages
- [ ] `title` 55-60, `description` 150-160
- [ ] Aucun tiret cadratin, aucun superlatif
- [ ] Déclarées au sitemap avec `hreflang`
- [ ] Testées à 375 px

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
php src/export.php && npm test
for p in site-internet-pirate reprendre-son-site; do
  echo "--- $p ---"
  python3 -c "
import re,json,html
s=open('dist/$p/index.html',encoding='utf-8').read()
t=re.search(r'<title>(.*?)</title>',s,re.S).group(1)
d=re.search(r'name=\"description\" content=\"(.*?)\"',s,re.S).group(1)
print('title',len(html.unescape(t)),'| desc',len(html.unescape(d)))
print('h1 x',len(re.findall(r'<h1',s)))
print('jsonld',[json.loads(b).get('@type') for b in re.findall(r'ld\+json[^>]*>(.*?)</script>',s,re.S)])
print('lien accompagnement:', 'accompagnement/' in s)"
done
```

## Règles `CLAUDE.md` engagées

- **Règle 2, SEO et GEO** : H1 unique, longueurs, paragraphes courts, FAQ en une phrase
- **Règle 1, ton** : calme, sans jargon, sans superlatif
- **Règle 5, parité FR/EN**
