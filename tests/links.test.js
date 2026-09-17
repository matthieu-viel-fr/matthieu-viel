'use strict';

const fs   = require('fs');
const path = require('path');

const ROOT = path.resolve(__dirname, '..');
const DIST = path.join(ROOT, 'dist');
let failures = 0;
let passes   = 0;

function pass(msg) { console.log('  ✓', msg); passes++; }
function fail(msg) { console.error('  ✗', msg); failures++; }
function section(title) { console.log('\n' + title); }
function rel(file) { return path.relative(DIST, file).replace(/\\/g, '/'); }

function walk(dir, files = []) {
  for (const entry of fs.readdirSync(dir, { withFileTypes: true })) {
    if (entry.name === 'node_modules' || entry.name === '.git') continue;

    const full = path.join(dir, entry.name);
    if (entry.isDirectory()) {
      walk(full, files);
    } else if (entry.isFile()) {
      files.push(full);
    }
  }
  return files;
}

const htmlFiles = walk(DIST).filter(file => file.endsWith('.html'));
const htmlByFile = new Map(
  htmlFiles.map(file => [rel(file), fs.readFileSync(file, 'utf8')])
);

/* ------------------------------------------------------------------ */
section('1. Fichiers obligatoires');

['index.html', 'tech.html', 'portfolio.html',
 'mentions-legales.html', 'en/legal-notice.html',
].forEach(f => {
  const full = path.join(DIST, f);
  fs.existsSync(full) ? pass(`dist/${f} existe`) : fail(`dist/${f} MANQUANT`);
});

['assets/css/main.css', 'assets/css/components.css', 'assets/css/responsive.css',
 'assets/js/main.js', 'assets/images/favicon.svg',
].forEach(f => {
  const full = path.join(ROOT, 'src', f);
  fs.existsSync(full) ? pass(`src/${f} existe`) : fail(`src/${f} MANQUANT`);
});

/* ------------------------------------------------------------------ */
section('2. Balises critiques dans index.html');

const html = htmlByFile.get('index.html');

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
section('3. Mentions légales et pied de page');

const legalPages = [
  ['mentions-legales.html', 'Mentions légales FR'],
  ['en/legal-notice.html', 'Legal notice EN'],
];

legalPages.forEach(([file, label]) => {
  if (!htmlByFile.has(file)) {
    fail(`${label} manquante (${file})`);
    return;
  }

  const content = htmlByFile.get(file);
  /<h1[^>]*>[\s\S]*?<\/h1>/i.test(content)
    ? pass(`${label} : h1 présent`)
    : fail(`${label} : h1 manquant`);
  /<link rel="canonical"/i.test(content)
    ? pass(`${label} : canonical présent`)
    : fail(`${label} : canonical manquant`);
});

htmlByFile.forEach((content, file) => {
  const hasFooter = /<footer\b/i.test(content);
  const isFrench = /^en\//.test(file) === false;
  const legalHref = isFrench ? /href="(?:\.\.\/)*mentions-legales\.html"/ : /href="(?:\.\.\/)*legal-notice\.html"/;
  /* The 404 pages use absolute paths on purpose: Apache's ErrorDocument
     serves them for whatever broken URL was requested, at any depth, so
     relative paths would resolve against that URL instead of /404.html. */
  const legalHrefAbsolute = isFrench ? /href="\/mentions-legales\.html"/ : /href="\/en\/legal-notice\.html"/;

  if (hasFooter) {
    (legalHref.test(content) || legalHrefAbsolute.test(content))
      ? pass(`[${file}] lien légal présent dans le footer`)
      : fail(`[${file}] lien légal manquant dans le footer`);
  }

  if (/href="#"[^>]*data-todo="(?:mentions-legales|legal-notice)"/i.test(content)) {
    fail(`[${file}] placeholder de mentions légales encore présent`);
  }

  if (/© 2025 Matthieu Viel/.test(content)) {
    fail(`[${file}] année de copyright obsolète (2025)`);
  }
});

/* ------------------------------------------------------------------ */
section('4. Liens href="#" non intentionnels');

/* Un lien href="#" est accepté s'il porte data-todo="..." (placeholder connu) */
const bareHashes = [...html.matchAll(/href="#"(?![^>]*data-todo=")/g)];
if (bareHashes.length === 0) {
  pass('Aucun lien href="#" non intentionnel (les placeholders ont data-todo)');
} else {
  bareHashes.forEach((_, i) => fail(`href="#" sans data-todo (#${i + 1}) — ajouter data-todo="..." si intentionnel`));
}

/* ------------------------------------------------------------------ */
section('5. Images référencées dans les HTML → existent dans assets/images/');

['index.html', 'tech.html', 'portfolio.html', 'mentions-legales.html'].forEach(file => {
  const content = htmlByFile.get(file);
  const srcRefs  = [...content.matchAll(/src="(assets\/images\/[^"]+)"/g)];
  const hrefRefs = [...content.matchAll(/href="(assets\/images\/[^"]+)"/g)];

  [...srcRefs, ...hrefRefs].forEach(([, ref]) => {
    const full = path.join(ROOT, 'src', ref);
    fs.existsSync(full)
      ? pass(`[${file}] ${ref}`)
      : fail(`[${file}] ${ref} INTROUVABLE`);
  });
});

/* ------------------------------------------------------------------ */
section('6. Attribut alt sur toutes les <img>');

const allHtmlContent = ['index.html', 'tech.html', 'portfolio.html', 'mentions-legales.html']
  .map(f => htmlByFile.get(f))
  .join('\n');

const imgTags = [...allHtmlContent.matchAll(/<img[^>]+>/g)];
imgTags.forEach(([tag]) => {
  /alt="[^"]*"/.test(tag)
    ? pass(`alt présent : ${tag.slice(0, 60)}…`)
    : fail(`alt MANQUANT : ${tag.slice(0, 80)}…`);
});

/* ------------------------------------------------------------------ */
section('7. Cohérence dist/sitemap.xml vs. pages réellement rendues');

/* Recoupement indépendant de tests/sitemap-consistency.test.php (PHP,
   basé sur getPages()) : ici on repart du HTML réellement produit dans
   dist/, sans supposer quoi que ce soit sur routes.php, pour détecter le
   cas où un template et sa déclaration de routage se contrediraient. */
const sitemapPath = path.join(DIST, 'sitemap.xml');

if (!fs.existsSync(sitemapPath)) {
  fail('dist/sitemap.xml MANQUANT (lancer php src/export.php)');
} else {
  const sitemapXml = fs.readFileSync(sitemapPath, 'utf8');
  const declaredLocs = new Set(
    [...sitemapXml.matchAll(/<loc>([^<]+)<\/loc>/g)].map(([, loc]) => loc)
  );

  function fileToUrlPath(file) {
    if (file === 'index.html') return '/';
    if (file.endsWith('/index.html')) return '/' + file.slice(0, -'index.html'.length);
    return '/' + file;
  }

  htmlByFile.forEach((content, file) => {
    const isNoindex = /<meta\s+name="robots"\s+content="noindex/i.test(content);
    const isRedirect = /<meta\s+http-equiv="refresh"/i.test(content);
    const url = 'https://www.matthieu-viel.fr' + fileToUrlPath(file);
    const isDeclared = declaredLocs.has(url);

    if (isNoindex || isRedirect) {
      isDeclared
        ? fail(`[${file}] noindex/redirect mais présent dans sitemap.xml (${url})`)
        : pass(`[${file}] noindex/redirect, absent du sitemap comme attendu`);
    } else {
      isDeclared
        ? pass(`[${file}] déclaré dans sitemap.xml (${url})`)
        : fail(`[${file}] indexable mais ABSENT de sitemap.xml (${url})`);
    }
  });

  declaredLocs.forEach(loc => {
    const urlPath = loc.replace('https://www.matthieu-viel.fr', '');
    const file = urlPath === '/' ? 'index.html' : urlPath.replace(/^\//, '') + (urlPath.endsWith('/') ? 'index.html' : '');
    htmlByFile.has(file)
      ? pass(`[sitemap.xml] ${loc} pointe vers une page existante`)
      : fail(`[sitemap.xml] ${loc} pointe vers dist/${file} INTROUVABLE`);
  });
}

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
