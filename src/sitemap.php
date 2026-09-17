<?php

require_once __DIR__ . '/routes.php';

/**
 * Turn a getPages()/getSitemapLastmod() style path ("audit/index.html",
 * "portfolio.html", "index.html") into the URL path sitemap.xml expects
 * ("/audit/", "/portfolio.html", "/"). Mirrors the directory-URL rule
 * getRoutes() already uses in routes.php, so a page's sitemap <loc> is
 * always exactly the URL the live router serves it at.
 */
function sitemapUrlPath(string $path): string
{
    if ($path === 'index.html') {
        return '/';
    }

    if (str_ends_with($path, '/index.html')) {
        return '/' . substr($path, 0, -strlen('index.html'));
    }

    return '/' . $path;
}

/**
 * Build sitemap.xml from getPages(), the single source of truth for
 * routing (QW03). Pages listed in getSitemapExclusions() are skipped;
 * every other page must have a getSitemapLastmod() entry or generation
 * fails loudly instead of silently under-declaring the sitemap again.
 */
function buildSitemapXml(string $baseUrl = 'https://www.matthieu-viel.fr'): string
{
    $exclusions = getSitemapExclusions();
    $lastmods = getSitemapLastmod();
    $noTranslation = array_flip(getSitemapPagesWithoutTranslation());

    $url = fn (string $path): string => $baseUrl . sitemapUrlPath($path);

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
    $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n\n";

    foreach (getPages() as $page) {
        [$output, , , , $frPath, $enPath] = $page;

        if (isset($exclusions[$output])) {
            continue;
        }

        if (!isset($lastmods[$output])) {
            throw new RuntimeException(
                "Sitemap generation failed: no lastmod declared for page '{$output}' in " .
                "getSitemapLastmod() (src/routes.php). Add one, or exclude the page via " .
                'getSitemapExclusions() if it should not be indexed.'
            );
        }

        $loc = $url($output);
        $frUrl = $url($frPath);

        $xml .= "  <url>\n";
        $xml .= "    <loc>{$loc}</loc>\n";
        $xml .= "    <lastmod>{$lastmods[$output]}</lastmod>\n";
        $xml .= "    <xhtml:link rel=\"alternate\" hreflang=\"fr\" href=\"{$frUrl}\"/>\n";

        if (!isset($noTranslation[$output])) {
            $enUrl = $url($enPath);
            $xml .= "    <xhtml:link rel=\"alternate\" hreflang=\"en\" href=\"{$enUrl}\"/>\n";
        }

        $xml .= "    <xhtml:link rel=\"alternate\" hreflang=\"x-default\" href=\"{$frUrl}\"/>\n";
        $xml .= "  </url>\n\n";
    }

    $xml .= "</urlset>\n";

    return $xml;
}

/**
 * QW03 / TODO.md point 8 consistency check: every page declared in
 * getPages() that is neither a redirect nor a noindex/error page must be
 * declared in the generated sitemap. Throws (rather than returning a
 * bool) so both the CLI test and buildSitemapXml() itself fail loudly if
 * a new page is added without deciding its sitemap status, instead of
 * silently reproducing the senior-tech.html omission this fiche fixes.
 */
function assertSitemapConsistency(): void
{
    $exclusions = getSitemapExclusions();
    $lastmods = getSitemapLastmod();
    $declaredLocs = array_flip(
        array_map(
            fn (string $path): string => 'https://www.matthieu-viel.fr' . sitemapUrlPath($path),
            array_keys($lastmods)
        )
    );

    $missing = [];

    foreach (getPages() as $page) {
        $output = $page[0];

        if (isset($exclusions[$output])) {
            continue;
        }

        $loc = 'https://www.matthieu-viel.fr' . sitemapUrlPath($output);

        if (!isset($lastmods[$output]) || !isset($declaredLocs[$loc])) {
            $missing[] = $output;
        }
    }

    if ($missing !== []) {
        throw new RuntimeException(
            'Sitemap consistency test failed. These getPages() entries are neither excluded ' .
            '(getSitemapExclusions) nor declared with a lastmod (getSitemapLastmod): ' .
            implode(', ', $missing)
        );
    }
}
