# QW02 · Corriger le contraste de `--clr-muted`

| | |
|---|---|
| Priorité | Quick win |
| Effort | 15 min |
| Impact | Accessibilité WCAG AA, lisibilité des preuves |
| Parité FR/EN | Automatique (CSS partagé) |
| Dépendances | Aucune |

## Constat mesuré (17/09/2026)

Token défini dans [`src/assets/css/main.css:20`](../../src/assets/css/main.css#L20) :

```css
--clr-muted: #718ea4;
```

Ratios calculés selon la formule WCAG 2.1 :

| Couleur | Fond | Ratio | Verdict |
|---|---|---|---|
| `#718ea4` | `#ffffff` (`--clr-bg`) | **3,44:1** | échec AA (seuil 4,5:1) |
| `#718ea4` | `#f2f7fb` (`--clr-bg-alt`) | **3,19:1** | échec AA |
| `#3a5268` (`--clr-slate`) | `#ffffff` | 8,12:1 | conforme |
| `#5a7386` (candidat) | `#ffffff` | **4,96:1** | conforme |
| `#5a7386` (candidat) | `#f2f7fb` | **4,60:1** | conforme |

Cinq sélecteurs utilisent le token, tous en petit texte, tous présents sur **chaque
page du site** :

| Sélecteur | Ce que ça affiche |
|---|---|
| `.nav__logo-tagline` | « Développeur web indépendant » sous le logo |
| `.hero__stat-label` | « ans de métier », « délai de réponse », « La Réunion » |
| `.testimonial__role` | « Head of IT · Citeo », « CEO · Sellermania » |
| `.portfolio-hero__stat-label` | libellés des chiffres du portfolio |
| `.offer-price-sep` | séparateur de prix |

## Pourquoi c'est important

- **C'est une violation active de la règle 4 de `CLAUDE.md`**, qui exige un ratio
  minimum de 4,5:1 et est déclarée non négociable. Ce n'est pas une amélioration,
  c'est une mise en conformité.
- Les sélecteurs concernés portent **les libellés des chiffres clés et les fonctions
  des personnes qui témoignent**, c'est-à-dire précisément les preuves. Ce sont elles
  qui passent le plus mal.
- Déjà identifié en **A1** dans `TODO.md`. Les composants ajoutés le 16/09/2026
  évitent délibérément ce token et utilisent `--clr-slate` : la correction est un
  changement de token, pas une réécriture.

## Ce qu'il faut faire

Dans [`src/assets/css/main.css:20`](../../src/assets/css/main.css#L20) :

```css
/* avant */
--clr-muted:        #718ea4;

/* après */
--clr-muted:        #5a7386;
```

Puis vérifier visuellement sur trois pages (accueil, portfolio, une page d'audit) que
le texte reste **visiblement secondaire** par rapport à `--clr-slate`. Si la hiérarchie
s'aplatit, ne pas éclaircir `--clr-muted` : assombrir plutôt `--clr-slate`, ou
augmenter légèrement la taille du texte muet.

**Cas particulier à vérifier :** si un des cinq sélecteurs apparaît sur fond sombre
(`--clr-bg-dark` `#0c1c2c` ou `--clr-bg-dark-alt` `#162d42`), `#5a7386` y sera trop
foncé. Dans ce cas, introduire un second token `--clr-muted-on-dark` plutôt que de
compromettre celui sur fond clair.

## Critères d'acceptation

- [ ] `--clr-muted` atteint au moins 4,5:1 sur `#ffffff` **et** sur `#f2f7fb`
- [ ] Contrôle visuel sur accueil, portfolio et une page d'audit : la hiérarchie tient
- [ ] Aucun des cinq sélecteurs ne se retrouve illisible sur fond sombre
- [ ] `npm test` passe

## Vérification

```bash
cd /home/matthieu/Projets/dev/matthieu-viel
grep -n "clr-muted" src/assets/css/main.css
python3 - <<'PY'
def lum(h):
    h=h.lstrip('#'); c=[int(h[i:i+2],16)/255 for i in (0,2,4)]
    c=[x/12.92 if x<=0.03928 else ((x+0.055)/1.055)**2.4 for x in c]
    return 0.2126*c[0]+0.7152*c[1]+0.0722*c[2]
def ratio(a,b):
    l1,l2=sorted([lum(a),lum(b)],reverse=True); return round((l1+0.05)/(l2+0.05),2)
import re
css=open('src/assets/css/main.css',encoding='utf-8').read()
m=re.search(r'--clr-muted:\s*(#[0-9a-fA-F]{6})',css)
c=m.group(1)
for bg,name in [('#ffffff','--clr-bg'),('#f2f7fb','--clr-bg-alt')]:
    r=ratio(c,bg)
    print(f"{c} sur {bg} ({name}) : {r}:1  {'OK AA' if r>=4.5 else 'ECHEC AA'}")
PY
php src/export.php && npm test
```

## Règles `CLAUDE.md` engagées

- **Règle 4, accessibilité : contraste WCAG AA minimum 4,5:1** (non négociable)

## Référence

Point **A1** de `TODO.md`, soulevé le 16/09/2026 lors de la session de repositionnement.
