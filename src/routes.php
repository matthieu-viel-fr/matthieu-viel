<?php

/**
 * Single source of truth for page routing and static export.
 *
 * Each page is [output path relative to dist/, twig template, locale,
 * current_page (for nav highlighting), fr page path, en page path].
 * The fr/en page paths are used to build the language-toggle links.
 */
function getPages(): array
{
    // FR slug => EN slug, for the audit sub-pages (translated URLs)
    $auditSlugs = [
        'application-vibe-coding-production' => 'application-vibe-coding-production',
        'dette-technique-application-saas'   => 'technical-debt-saas-application',
        'tests-automatises-application'      => 'automated-tests-application',
        'cicd-pipeline-application'          => 'cicd-pipeline-application',
        'freelance-audit-technique-startup'  => 'freelance-technical-audit-startup',
        'application-solo-founder-clients'   => 'application-solo-founder-clients',
        'faq'                                 => 'faq',
    ];

    $pages = [
        ['index.html',             'index.html.twig',             'fr', 'home',      'index.html',             'en/index.html'],
        ['portfolio.html',         'portfolio.html.twig',         'fr', 'portfolio', 'portfolio.html',         'en/portfolio.html'],
        ['senior-tech.html',       'senior-tech.html.twig',       'fr', 'senior',    'senior-tech.html',       'en/index.html'],
        ['tech.html',              'tech.html.twig',              'fr', '',          'tech.html',              'en/index.html'],
        ['mentions-legales.html',  'mentions-legales.html.twig',  'fr', 'legal',     'mentions-legales.html',  'en/legal-notice.html'],
        ['quiz.html',              'quiz.html.twig',              'fr', 'quiz',      'quiz.html',              'en/index.html'],
        ['audit/index.html',       'audit/index.html.twig',       'fr', 'audit',     'audit/',                 'en/audit/'],

        ['en/index.html',           'en/index.html.twig',           'en', 'home',      'index.html',            'en/index.html'],
        ['en/portfolio.html',       'en/portfolio.html.twig',       'en', 'portfolio', 'portfolio.html',         'en/portfolio.html'],
        ['en/legal-notice.html',    'en/legal-notice.html.twig',    'en', 'legal',     'mentions-legales.html',  'en/legal-notice.html'],
        ['en/audit/index.html',     'en/audit/index.html.twig',     'en', 'audit',     'audit/',                 'en/audit/'],
    ];

    foreach ($auditSlugs as $fr => $en) {
        $pages[] = ["audit/$fr/index.html",    "audit/$fr.html.twig",    'fr', 'audit', "audit/$fr/", "en/audit/$en/"];
        $pages[] = ["en/audit/$en/index.html", "en/audit/$en.html.twig", 'en', 'audit', "audit/$fr/", "en/audit/$en/"];
    }

    return $pages;
}

/**
 * Build the Twig render context for a page entry. asset_base, nav_base
 * and the language-toggle URLs are all derived from the output path's
 * depth, since the dist/ tree mirrors the URL structure.
 */
function pageContext(array $page): array
{
    [$output, $template, $locale, $current_page, $fr_path, $en_path] = $page;

    $depth = substr_count($output, '/');
    $asset_base = str_repeat('../', $depth);
    $nav_base = $locale === 'en' ? str_repeat('../', max(0, $depth - 1)) : $asset_base;

    return [
        'output'       => $output,
        'template'     => $template,
        'locale'       => $locale,
        'current_page' => $current_page,
        'asset_base'   => $asset_base,
        'nav_base'     => $nav_base,
        'lang_fr_url'  => $locale === 'fr' ? '' : $asset_base . $fr_path,
        'lang_en_url'  => $locale === 'en' ? '' : $asset_base . $en_path,
    ];
}

/**
 * Build the URI => render context map used by the live router, including
 * both the directory form ("/audit/") and the explicit "index.html" form.
 */
function getRoutes(): array
{
    $routes = [];

    foreach (getPages() as $page) {
        $ctx = pageContext($page);
        $output = $ctx['output'];

        if (str_ends_with($output, '/index.html')) {
            $dir = '/' . substr($output, 0, -strlen('index.html'));
            $routes[$dir] = $ctx;
            $routes[$dir . 'index.html'] = $ctx;
        } else {
            $routes['/' . $output] = $ctx;
        }
    }

    $routes['/'] = $routes['/index.html'];

    return $routes;
}
