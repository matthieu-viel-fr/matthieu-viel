# MT14 · Ajouter un formulaire de contact court

| | |
|---|---|
| Priorité | Moyen terme |
| Effort | 0,5 j |
| Impact | Hypothèse de conversion à instrumenter |
| Parité FR/EN | Oui, requise |
| Dépendances | Choix d'un mécanisme d'envoi (voir ci-dessous) |

## Constat mesuré (17/09/2026)

**Le site n'a aucun formulaire de contact.**

```bash
$ grep -l "<form" dist/**/*.html
dist/quiz.html
```

Le seul `<form>` du site est sur `quiz.html`, la page orpheline que **rien ne lie**
(voir [QW03](QW03-sitemap.md)).

`/contact.html` propose : une adresse email en texte et en `mailto:`, un `tel:`, un
lien Calendly, et quatre liens de réseaux sociaux. Rien d'autre.

Parcours réel d'un visiteur mobile :

```
Accueil → clic « Expliquez-moi votre problème »
        → /contact.html
        → clic sur l'adresse email
        → ouverture (ou non) du client mail du téléphone
        → rédaction depuis zéro, sans aucune indication de ce qu'il faut dire
```

## Pourquoi c'est important

Le formulaire peut réduire la friction pour une partie des visiteurs, mais le point
de fuite n'est pas mesuré à ce stade. Téléphone, Calendly et email peuvent aussi être
préférés selon l'urgence et l'équipement du visiteur.

- Sur mobile, `mailto:` échoue silencieusement quand aucun client mail n'est configuré,
  ce qui est fréquent chez les utilisateurs de webmail.
- Rédiger un email depuis une page blanche demande de savoir quoi écrire. L'accueil
  dit pourtant « Vous n'avez pas besoin de nommer le problème » : le formulaire est
  l'endroit où tenir cette promesse, avec un champ déjà amorcé.
- Calendly engage 30 minutes et un créneau futur. Pour quelqu'un qui n'est pas sûr que
  son problème mérite un appel, c'est trop.
- Écrire trois lignes dans un champ est potentiellement moins engageant qu'un appel ou
  un rendez-vous, ce qui doit être confirmé par les événements de [LT23](LT23-mesure.md).

## Ce qu'il faut faire

### Champs, trois maximum

```html
<form method="POST" action="..." class="contact-form">
  <label for="cf-name">Votre nom</label>
  <input type="text" id="cf-name" name="name" required autocomplete="name">

  <label for="cf-reach">Où vous joindre</label>
  <input type="text" id="cf-reach" name="reach" required
         autocomplete="email tel"
         placeholder="Un email ou un numéro de téléphone">

  <label for="cf-message">Qu'est-ce qui se passe ?</label>
  <textarea id="cf-message" name="message" rows="5" required
            placeholder="Décrivez ce que vous voyez, avec vos mots. Pas besoin de terme technique."></textarea>

  <button type="submit" class="btn btn--primary">Envoyer</button>
  <p class="contact-form__note">Je réponds sous 24 h. Vos informations ne servent qu'à vous répondre.</p>
</form>
```

**Ce qu'il ne faut surtout pas ajouter** : menu déroulant « type de projet », champ
budget, champ « comment nous avez-vous connus », case à cocher newsletter, champ
société. Chaque champ supplémentaire fait chuter le taux de complétion, et aucun de
ceux-là ne vous apprend quoi que ce soit que le premier échange ne vous dira.

Un seul champ « où vous joindre » plutôt que deux champs email et téléphone : le
visiteur choisit son canal.

### Mécanisme d'envoi

Le site est statique, déployé par FTP sur Nuxit. Trois options :

| Option | Avantages | Inconvénients |
|---|---|---|
| **A. Script PHP local** | Aucune dépendance tierce, aucune donnée qui sort, cohérent avec « ce site ne collecte aucune donnée ». Nuxit sert déjà du PHP. | À écrire, avec protection anti-spam |
| **B. Service tiers** (Formspree, Web3Forms...) | 10 minutes à intégrer | Dépendance externe, données qui transitent chez un tiers, **oblige à modifier les mentions légales** |
| **C. `mailto:` pré-rempli** | Zéro backend | Reproduit le problème actuel |

**Option à confirmer : A.** Un `contact.php` d'une trentaine de lignes, avec
`mail()` ou SMTP Nuxit. Cohérent avec la règle « zéro dépendance externe inutile
ajoutée sans accord explicite » de `CLAUDE.md`, et avec la promesse des mentions
légales. Cela implique que `dist/` n'est plus 100 % statique : c'est un changement
d'architecture à assumer, mais limité à un seul fichier.

Si l'option B est retenue, **les mentions légales FR et EN doivent être mises à jour
dans la même tâche** : elles affirment aujourd'hui « Ce site ne collecte aucune donnée
personnelle » et « n'utilise aucun cookie tiers ». Ce serait faux.

### Protection anti-spam

Pas de captcha (friction, et problème d'accessibilité). Utiliser :
- un champ honeypot masqué, ignoré des lecteurs d'écran (`aria-hidden`, `tabindex="-1"`)
- un horodatage : rejeter une soumission en moins de 3 secondes
- une limitation par IP côté serveur

### Où le placer

1. **`/contact.html`**, en premier élément de la page, avant email et téléphone
2. **`/accompagnement/`** ([MT11](MT11-page-accompagnement.md))
3. **Les deux pages problème** ([MT13](MT13-pages-probleme.md))
4. **Pas sur l'accueil** : garder le parcours en deux temps, le bouton de l'accueil
   amène au formulaire

### Page de confirmation

Une vraie page `/message-envoye/` (et `/en/message-sent/`), en `noindex`, qui :
- confirme la réception
- redonne le `tel:` pour les urgences (« si c'est bloquant, appelez plutôt »)
- rappelle le délai de 24 h

Ne pas se contenter d'un message JavaScript : une page permet de déclarer un objectif
de conversion dans Plausible ([LT23](LT23-mesure.md)).

### Accessibilité

- `<label>` réel associé à chaque champ, jamais un `placeholder` seul
- Messages d'erreur liés par `aria-describedby`
- `aria-live="polite"` sur la zone de retour
- Focus visible sur tous les champs
- Navigation clavier complète

### Sort de `quiz.html`

Le quiz contient le seul formulaire existant. Deux possibilités : le remettre dans le
parcours comme outil de qualification, ou le laisser orphelin en `noindex`
([QW03](QW03-sitemap.md)). Ne pas laisser l'état actuel : indexable et introuvable.

## Critères d'acceptation

- [ ] Formulaire de 3 champs sur `/contact.html` FR et EN
- [ ] Mécanisme d'envoi fonctionnel, testé de bout en bout
- [ ] Protection anti-spam sans captcha
- [ ] Page de confirmation FR et EN, en `noindex`
- [ ] `<label>` réels, `aria-describedby`, focus visible, navigation clavier
- [ ] Mentions légales cohérentes avec le traitement réel des données (FR et EN)
- [ ] Politique de conservation des messages documentée
- [ ] Objectif Plausible sur la page de confirmation
- [ ] Comparaison du formulaire avec les clics téléphone, email et Calendly après une période définie
- [ ] Testé à 375 px
- [ ] Un email de test arrive bien dans la boîte
- [ ] Décision prise sur `quiz.html`

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
php src/export.php && npm test
grep -l "<form" dist/**/*.html
grep -c "<label" dist/contact.html dist/en/contact.html
grep -oP '<input[^>]*>' dist/contact.html | grep -c "aria-\|autocomplete"
```

Puis test manuel : soumettre depuis un téléphone réel, vérifier l'arrivée du message,
vérifier la page de confirmation, vérifier que le honeypot bloque une soumission
automatisée.

## Règles `CLAUDE.md` engagées

- **Règle 4, accessibilité** : labels, focus, clavier, mobile-first
- **Règle 3, performance** : pas de dépendance JS lourde
- **Règle 5, parité FR/EN**
- « Zéro dépendance externe ajoutée sans accord explicite » : d'où la recommandation A
- « Ne pas retirer ou altérer les scripts tiers (Calendly) » : le formulaire s'ajoute, Calendly reste

## Référence

Points **14** et **18** de `TODO.md`.
