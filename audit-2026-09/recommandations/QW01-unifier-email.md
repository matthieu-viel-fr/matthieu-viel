# QW01 · Unifier l'adresse email sur `contact@matthieu-viel.fr`

| | |
|---|---|
| Priorité | Quick win, 1er du dossier |
| Effort | 20 min |
| Impact | Crédibilité, cohérence NAP (SEO local), GEO |
| Parité FR/EN | Oui, requise |
| Dépendances | Que la boîte `contact@matthieu-viel.fr` soit relevée |

## Constat mesuré (17/09/2026)

Deux adresses coexistent sur le site :

| Adresse | Où |
|---|---|
| `contact@matthieu-viel.fr` | `mentions-legales.html.twig:41`, `en/legal-notice.html.twig:41` |
| `matthieu.viel.fr@gmail.com` | **48 occurrences dans 23 templates**, dont le JSON-LD `LocalBusiness` de l'accueil |

Répartition des 48 occurrences :

```
src/templates/index.html.twig                                   1   (JSON-LD LocalBusiness)
src/templates/en/index.html.twig                                1   (JSON-LD LocalBusiness)
src/templates/contact.html.twig                                 3   (JSON-LD + lien + libellé)
src/templates/en/contact.html.twig                              3
src/templates/senior-tech.html.twig                             2
src/templates/audit/faq.html.twig                               3
src/templates/en/audit/faq.html.twig                            3
src/templates/audit/*.html.twig (7 autres fichiers)             2 chacun
src/templates/en/audit/*.html.twig (7 autres fichiers)          2 chacun
src/templates/audit/index.html.twig                             2
src/templates/en/audit/index.html.twig                          2
```

## Pourquoi c'est important

- **SEO local.** La cohérence NAP (Name, Address, Phone, et par extension l'email) est
  un signal direct pour le référencement local. Deux adresses différentes entre les
  mentions légales et le reste du site est exactement l'incohérence que les moteurs
  pénalisent.
- **Crédibilité.** Une adresse Gmail affichée comme contact principal sur un site qui
  vend la reprise en main de ses propres accès et la récupération de noms de domaine
  est une contradiction visible par n'importe quel dirigeant.
- **GEO.** Le JSON-LD `LocalBusiness` de l'accueil porte l'adresse Gmail. C'est celle
  qu'un assistant IA citera.

## Ce qu'il faut faire

1. **Vérifier d'abord** que `contact@matthieu-viel.fr` existe et est relevée. Si elle
   n'existe pas, la créer chez Nuxit avant toute modification. Ne pas faire le
   remplacement sur une boîte morte.

2. Remplacer les 48 occurrences dans `src/templates/` :

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
grep -rl "matthieu.viel.fr@gmail.com" src/templates --include=*.twig \
  | xargs sed -i 's/matthieu\.viel\.fr@gmail\.com/contact@matthieu-viel.fr/g'
```

3. Vérifier qu'aucun libellé visible ne reste désaligné (le texte affiché du lien doit
   changer en même temps que le `href`, ce que fait le `sed` puisque les deux portent
   la même chaîne).

4. Regénérer : `php src/export.php`

5. **Ne pas oublier** les profils externes, hors dépôt : la signature LinkedIn, le
   profil Malt, la bio Instagram et TikTok. L'incohérence NAP se joue aussi hors site.

## Critères d'acceptation

- [ ] `contact@matthieu-viel.fr` existe et est relevée
- [ ] `grep -rc "gmail" src/templates --include=*.twig` ne retourne rien
- [ ] `grep -rc "gmail" dist --include=*.html` ne retourne rien
- [ ] Le JSON-LD `LocalBusiness` de `dist/index.html` et `dist/en/index.html` porte la nouvelle adresse
- [ ] Les mentions légales FR et EN sont inchangées (elles étaient déjà correctes)
- [ ] Profils LinkedIn, Malt, Instagram, TikTok alignés

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
php src/export.php
echo "Gmail restants dans src/ :"; grep -ro "matthieu.viel.fr@gmail.com" src/templates | wc -l
echo "Gmail restants dans dist/ :"; grep -ro "matthieu.viel.fr@gmail.com" dist | wc -l
echo "Nouvelle adresse dans dist/ :"; grep -ro "contact@matthieu-viel.fr" dist --include=*.html | wc -l
```

Attendu : `0`, `0`, et un nombre supérieur à 48 (les 48 remplacées plus les 2 déjà
présentes dans les mentions légales).

## Règles `CLAUDE.md` engagées

- Règle 2, SEO : cohérence NAP
- Règle 5, parité FR/EN : le remplacement touche les deux arbres dans la même tâche
