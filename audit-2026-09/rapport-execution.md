# Rapport d'exécution des dix quick wins

Journal de traitement du dossier d'audit de septembre 2026.
Une section par quick win, dans l'ordre d'exécution recommandé (1, 2, 5, 6, 3, 7, 8, 4, 9, 10).

Chaque quick win a été confié à un sous-agent dédié, vérifié, puis commité seul.
Le hook de pré-commit lance `npm test` : aucun commit n'est passé sans les 82 tests au vert.

---

## QW01 · Unifier l'adresse email

**Statut :** fait. Commit `9d6699b`.

48 occurrences de `matthieu.viel.fr@gmail.com` remplacées par `contact@matthieu-viel.fr`
dans 23 templates, les deux arbres de langue dans la même passe.

**Vérifications :** 0 adresse Gmail restante dans `src/` et dans `dist/`.
52 occurrences de la nouvelle adresse dans `dist/`, dont le JSON-LD `LocalBusiness`
des deux accueils. Mentions légales FR et EN inchangées, elles étaient déjà correctes.
Diff de 48 insertions et 48 suppressions, aucune ligne touchée hors adresse email.

**Reste à faire, hors dépôt :** aligner la signature LinkedIn, le profil Malt et les
bios Instagram et TikTok sur la même adresse. La cohérence NAP se joue aussi hors site.

---

## QW02 · Corriger le contraste de `--clr-muted`

**Statut :** fait. Commit à suivre.

`--clr-muted` passe de `#718ea4` à `#5a7386` dans `src/assets/css/main.css`.
Un seul token, donc parité FR et EN automatique.

**Vérifications :** 4,96:1 sur `#ffffff` et 4,60:1 sur `#f2f7fb`, contre 3,44:1 et
3,19:1 avant. Le seuil AA de 4,5:1 est franchi sur les deux fonds. `npm test` au vert.

**Cas du fond sombre, vérifié avant de conclure :** aucun des cinq sélecteurs concernés
n'apparaît sur `--clr-bg-dark` ni sur `--clr-bg-dark-alt`. Les sections sombres ne
contiennent que des eyebrow, titres, textes de CTA, boutons et items de links-strip.
Un second token `--clr-muted-on-dark` n'était donc pas nécessaire.

**Point de vigilance :** l'écart de contraste entre `--clr-slate` et `--clr-muted`
tombe de 2,36:1 à 1,64:1. La hiérarchie tient sur le papier mais mérite un coup d'oeil
humain sur l'accueil, le portfolio et une page d'audit. Si elle s'aplatit, la fiche
demande d'assombrir `--clr-slate` plutôt que d'éclaircir `--clr-muted`.

**Note :** `.offer-price-sep` est défini dans `components.css` mais n'est utilisé par
aucun template, cohérent avec le choix de ne pas afficher de prix pour l'instant.

---
