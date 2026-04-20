'use strict';

const fs   = require('fs');
const path = require('path');

const ROOT = path.resolve(__dirname, '..');
let failures = 0;
let passes   = 0;

function pass(msg) { console.log('  ✓', msg); passes++; }
function fail(msg) { console.error('  ✗', msg); failures++; }
function section(title) { console.log('\n' + title); }

/* ------------------------------------------------------------------ */
section('1. Fichiers obligatoires');

['index.html', 'tech.html', 'portfolio.html',
 'assets/css/main.css', 'assets/css/components.css', 'assets/css/responsive.css',
 'assets/js/main.js', 'assets/images/favicon.svg'
].forEach(f => {
  const full = path.join(ROOT, f);
  fs.existsSync(full) ? pass(`${f} existe`) : fail(`${f} MANQUANT`);
});

/* ------------------------------------------------------------------ */
section('2. Balises critiques dans index.html');

const html = fs.readFileSync(path.join(ROOT, 'index.html'), 'utf8');

const checks = [
  [/<title>[^<]{10,}<\/title>/i,       'title non vide (≥10 car.)'],
  [/<meta name="description"/i,         'meta description présente'],
  [/<h1[^>]*>/i,                        'balise h1 présente'],
  [/schema\.org/i,                      'schema.org JSON-LD présent'],
  [/<link rel="icon"/i,                 'favicon déclaré'],
  [/lang="fr"/i,                        'attribut lang="fr" sur <html>'],
  [/rel="noopener noreferrer"/i,        'noopener/noreferrer sur liens externes'],
  [/loading="lazy"/i,                   'lazy loading natif sur images secondaires'],
  [/aria-label/i,                       'attributs aria-label présents'],
];

checks.forEach(([regex, label]) => {
  regex.test(html) ? pass(label) : fail(label);
});

/* ------------------------------------------------------------------ */
section('3. Liens href="#" non intentionnels');

/* Un lien href="#" est accepté s'il porte data-todo="..." (placeholder connu) */
const bareHashes = [...html.matchAll(/href="#"(?![^>]*data-todo=")/g)];
if (bareHashes.length === 0) {
  pass('Aucun lien href="#" non intentionnel (les placeholders ont data-todo)');
} else {
  bareHashes.forEach((_, i) => fail(`href="#" sans data-todo (#${i + 1}) — ajouter data-todo="..." si intentionnel`));
}

/* ------------------------------------------------------------------ */
section('4. Images référencées dans les HTML → existent dans assets/images/');

const htmlFiles = ['index.html', 'tech.html', 'portfolio.html'];

htmlFiles.forEach(file => {
  const content = fs.readFileSync(path.join(ROOT, file), 'utf8');
  const srcRefs  = [...content.matchAll(/src="(assets\/images\/[^"]+)"/g)];
  const hrefRefs = [...content.matchAll(/href="(assets\/images\/[^"]+)"/g)];

  [...srcRefs, ...hrefRefs].forEach(([, ref]) => {
    const full = path.join(ROOT, ref);
    fs.existsSync(full)
      ? pass(`[${file}] ${ref}`)
      : fail(`[${file}] ${ref} INTROUVABLE`);
  });
});

/* ------------------------------------------------------------------ */
section('5. Attribut alt sur toutes les <img>');

const allHtmlContent = htmlFiles
  .map(f => fs.readFileSync(path.join(ROOT, f), 'utf8'))
  .join('\n');

const imgTags = [...allHtmlContent.matchAll(/<img[^>]+>/g)];
imgTags.forEach(([tag]) => {
  /alt="[^"]*"/.test(tag)
    ? pass(`alt présent : ${tag.slice(0, 60)}…`)
    : fail(`alt MANQUANT : ${tag.slice(0, 80)}…`);
});

/* ------------------------------------------------------------------ */
console.log(`\n${'─'.repeat(50)}`);
console.log(`Résultat : ${passes} ✓ passés · ${failures} ✗ échoués`);
console.log('─'.repeat(50));

if (failures > 0) {
  console.error(`\n❌ ${failures} test(s) échoué(s). Corrigez avant de déployer.\n`);
  process.exit(1);
} else {
  console.log('\n✅ Tous les tests sont passés.\n');
}
