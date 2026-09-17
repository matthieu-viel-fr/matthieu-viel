# QW09 · Ajouter un CTA téléphone dans le hero mobile

| | |
|---|---|
| Priorité | Quick win |
| Effort | 30 min |
| Impact | Conversion, notamment sur les visites en urgence |
| Parité FR/EN | Oui, requise |
| Dépendances | Aucune |

## Constat mesuré (17/09/2026)

Liens de l'accueil, par destination :

```
4 × contact.html
2 × https://calendly.com/matthieu-viel-fr/30min
1 × tel:+262693852812        ← unique, et situé dans la FAQ, tout en bas de page
```

Le hero propose deux CTA : « Expliquez-moi votre problème » (vers `contact.html`) et
« Réserver un appel de 30 min » (Calendly). Aucun appel direct.

Sur mobile, le premier écran contient le bandeau de localisation, le H1, le paragraphe
d'accroche et les deux boutons. Le `tel:` n'apparaît qu'après environ 30 titres, dans
la réponse « En combien de temps répondez-vous ? ».

## Pourquoi c'est important

Le visiteur type de cette page arrive **en urgence** : son site est hors ligne, il a
reçu une alerte de piratage, son prestataire ne répond plus. Le H1 le dit lui-même :
« Un problème informatique, et personne à appeler ? »

Or la page ne lui donne personne à appeler avant d'avoir tout lu.

- **Calendly engage 30 minutes** et impose de choisir un créneau futur. Pour quelqu'un
  dont le site est tombé ce matin, c'est un frein, pas une facilité.
- **Un email engage une rédaction**, et la certitude d'attendre.
- **Un appel est le seul canal qui correspond à l'urgence promise par le H1.**

Le numéro existe, il est déjà dans le JSON-LD `LocalBusiness`, il est simplement absent
de l'endroit où il sert.

## Ce qu'il faut faire

Dans le hero de [`src/templates/index.html.twig`](../../src/templates/index.html.twig),
en troisième CTA, visuellement moins appuyé que les deux autres pour ne pas brouiller
la hiérarchie :

```html
<a href="tel:+262693852812"
   class="btn btn--ghost hero__cta-phone"
   aria-label="Appeler Matthieu Viel au 06 93 85 28 12">
  Urgence : 0693 85 28 12
</a>
```

Miroir EN dans `src/templates/en/index.html.twig` :

```html
<a href="tel:+262693852812"
   class="btn btn--ghost hero__cta-phone"
   aria-label="Call Matthieu Viel on +262 693 85 28 12">
  Urgent: +262 693 85 28 12
</a>
```

### Règles de présentation

- **Format affiché** : `0693 85 28 12` en FR (format local, celui que lit un
  Réunionnais), `+262 693 85 28 12` en EN. Le `href` reste au format international
  `tel:+262693852812` dans les deux cas.
- **Sur desktop**, où cliquer un numéro ne sert à rien, deux options : masquer le
  bouton sous 768 px inversé (`display: none` au-dessus de 768 px), ou le laisser
  affiché comme simple information. Préférer le laisser affiché : un dirigeant qui
  consulte depuis son bureau notera le numéro.
- **Ne pas** en faire le CTA principal. Le bouton primaire reste
  « Expliquez-moi votre problème ». Le téléphone est un recours, pas le chemin par défaut.
- **Mentionner les horaires** si la disponibilité est limitée. La page contact dit
  déjà « Heure de La Réunion, du lundi au vendredi ». Ne pas promettre implicitement
  une astreinte 24/7 qui n'existe pas.

### Étendre aux autres pages

Même logique sur `/audit/` et `/portfolio.html`, qui n'ont **aucun `tel:`** aujourd'hui.
Pour le portfolio c'est encore plus net : la page n'a aucun moyen de contact direct
(voir [LT22](LT22-portfolio.md)).

### Mesure

Déclarer un objectif Plausible sur les clics `tel:` en même temps, sinon l'effet de
cette fiche sera invisible. Voir [LT23](LT23-mesure.md).

## Critères d'acceptation

- [ ] Un `tel:` est visible dans le premier écran mobile de l'accueil (375 px de large)
- [ ] `aria-label` explicite sur le lien
- [ ] Format d'affichage local en FR, international en EN
- [ ] Le `href` reste au format international dans les deux langues
- [ ] Le bouton primaire n'est pas déclassé visuellement
- [ ] Zone tactile d'au moins 44 × 44 px
- [ ] Focus clavier visible
- [ ] Miroir EN fait
- [ ] Objectif Plausible déclaré sur les clics `tel:`

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
php src/export.php
echo "tel: sur l'accueil FR :"; grep -c 'href="tel:' dist/index.html
echo "tel: sur l'accueil EN :"; grep -c 'href="tel:' dist/en/index.html
echo "tel: sur /audit/ :";      grep -c 'href="tel:' dist/audit/index.html
grep -oP '<a[^>]*href="tel:[^>]*>' dist/index.html
```

Puis contrôle visuel à **375 px de large** : le bouton d'appel doit être atteignable
sans défilement.

## Règles `CLAUDE.md` engagées

- **Règle 4, accessibilité** : `aria-label` sur tout lien ambigu, focus visible, mobile-first testé à 375 px avant 1280 px
- **Règle 1, ton** : « Urgence » est factuel, pas un superlatif marketing
- **Règle 5, parité FR/EN**

## Référence

Point **18** de `TODO.md` (« Improve CTAs by intent »).
