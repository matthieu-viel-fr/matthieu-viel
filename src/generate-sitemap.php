<?php

/**
 * Regenerates the root-level sitemap.xml from getPages() (QW03). This is
 * the single source of truth for the file from now on: do not hand-edit
 * sitemap.xml directly, edit getSitemapExclusions()/getSitemapLastmod()
 * in src/routes.php instead and re-run this script.
 *
 * `php src/export.php` still just copies the resulting root sitemap.xml
 * into dist/, same as .htaccess and robots.txt, so run this script first
 * whenever routing or lastmod data changes, then export.
 */

require_once __DIR__ . '/sitemap.php';

$rootDir = dirname(__DIR__);
$xml = buildSitemapXml();

if (file_put_contents($rootDir . '/sitemap.xml', $xml) === false) {
    fwrite(STDERR, "\n✗ Could not write sitemap.xml\n");
    exit(1);
}

$urlCount = substr_count($xml, '<url>');
echo "✓ sitemap.xml regenerated from getPages() ({$urlCount} URLs)\n";
