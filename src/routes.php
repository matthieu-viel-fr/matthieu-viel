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
        'integration-wetransform-saas'       => 'wetransform-integration-saas',
        'faq'                                 => 'faq',
    ];

    $pages = [
        ['index.html',             'index.html.twig',             'fr', 'home',      'index.html',             'en/index.html'],
        ['portfolio.html',         'portfolio.html.twig',         'fr', 'portfolio', 'portfolio.html',         'en/portfolio.html'],
        ['senior-tech.html',       'senior-tech.html.twig',       'fr', 'senior',    'senior-tech.html',       'en/index.html'],
        ['tech.html',              'tech.html.twig',              'fr', '',          'tech.html',              'en/index.html'],
        ['mentions-legales.html',  'mentions-legales.html.twig',  'fr', 'legal',     'mentions-legales.html',  'en/legal-notice.html'],
        ['quiz.html',              'quiz.html.twig',              'fr', 'quiz',      'quiz.html',              'en/index.html'],
        ['contact.html',           'contact.html.twig',           'fr', 'contact',   'contact.html',           'en/contact.html'],
        ['audit/index.html',       'audit/index.html.twig',       'fr', 'audit',     'audit/',                 'en/audit/'],
        ['404.html',               '404.html.twig',               'fr', '',          '404.html',               'en/404.html'],

        ['en/index.html',           'en/index.html.twig',           'en', 'home',      'index.html',            'en/index.html'],
        ['en/portfolio.html',       'en/portfolio.html.twig',       'en', 'portfolio', 'portfolio.html',         'en/portfolio.html'],
        ['en/legal-notice.html',    'en/legal-notice.html.twig',    'en', 'legal',     'mentions-legales.html',  'en/legal-notice.html'],
        ['en/contact.html',        'en/contact.html.twig',         'en', 'contact',   'contact.html',           'en/contact.html'],
        ['en/audit/index.html',     'en/audit/index.html.twig',     'en', 'audit',     'audit/',                 'en/audit/'],
        ['en/404.html',              'en/404.html.twig',            'en', '',          '404.html',               'en/404.html'],
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

    // The 404 page is served by Apache's ErrorDocument for whatever broken
    // URL the visitor requested, at any depth, so relative paths would
    // resolve against that URL instead of against /404.html. Force
    // absolute paths so assets and nav links always work.
    if (str_ends_with($output, '404.html')) {
        $asset_base = '/';
        $nav_base = $locale === 'en' ? '/en/' : '/';
    }

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

/**
 * Pages from getPages() that must never appear in sitemap.xml, keyed by
 * output path (the tuple's first element), with the reason documented.
 *
 * - tech.html is a meta-refresh redirect to senior-tech.html: redirects
 *   are never sitemap entries.
 * - quiz.html is deliberately orphaned (see TODO.md, item A5): it must
 *   keep working for existing LinkedIn links but is not offered for
 *   indexing, hence <meta name="robots" content="noindex, follow"> on
 *   its template and its removal here.
 * - 404.html / en/404.html are error documents served via Apache's
 *   ErrorDocument directive, not content pages; both already carry a
 *   noindex meta tag (see 404.html.twig / en/404.html.twig).
 */
function getSitemapExclusions(): array
{
    return [
        'tech.html'   => 'meta-refresh redirect to senior-tech.html',
        'quiz.html'   => 'deliberately orphaned/noindex, see TODO.md item A5',
        '404.html'    => 'error document (ErrorDocument), not a content page',
        'en/404.html' => 'error document (ErrorDocument), not a content page',
    ];
}

/**
 * Output paths that intentionally have no translated equivalent. For
 * these, the sitemap must declare hreflang="fr" and x-default only, both
 * pointing at the page itself. senior-tech.html's language toggle points
 * at en/index.html for navigation purposes only (there is no EN page
 * with the same content), so declaring hreflang="en" -> en/index.html in
 * the sitemap would be a false equivalence. See MT18 for the plan to
 * resolve this by creating a real EN page.
 */
function getSitemapPagesWithoutTranslation(): array
{
    return ['senior-tech.html'];
}

/**
 * Explicit lastmod per sitemap URL, keyed by output path. Seeded from the
 * exact dates already published in sitemap.xml as of the QW03 audit
 * (2026-09-17); update an entry by hand only when that page's main
 * content actually changes.
 *
 * Deliberately NOT derived from git log or filesystem mtime: both are
 * skewed by repo-wide mechanical edits that touch many templates without
 * changing their substance (e.g. the 2026-09-17 email address
 * unification across the whole site), which would misdate every page.
 */
function getSitemapLastmod(): array
{
    return [
        'index.html'                                              => '2026-05-10',
        'en/index.html'                                           => '2026-05-10',
        'portfolio.html'                                          => '2026-05-10',
        'en/portfolio.html'                                       => '2026-05-10',
        // New to the sitemap (QW03), not new to the site: routes.php has
        // always routed and rendered it, it was just missing here. Dated
        // to commit 753ec6b (2026-09-16), the last change to this page's
        // actual content (17 -> 18 years of experience), not to the
        // unrelated 2026-09-17 email-address commit that also touched
        // this template's markup.
        'senior-tech.html'                                        => '2026-09-16',
        'mentions-legales.html'                                   => '2026-05-21',
        'en/legal-notice.html'                                    => '2026-05-21',
        'contact.html'                                             => '2026-09-16',
        'en/contact.html'                                          => '2026-09-16',
        'audit/index.html'                                        => '2026-05-13',
        'audit/application-vibe-coding-production/index.html'     => '2026-05-13',
        'audit/integration-wetransform-saas/index.html'           => '2026-06-26',
        'audit/dette-technique-application-saas/index.html'       => '2026-05-13',
        'audit/tests-automatises-application/index.html'          => '2026-05-13',
        'audit/cicd-pipeline-application/index.html'               => '2026-05-13',
        'audit/freelance-audit-technique-startup/index.html'      => '2026-05-13',
        'audit/application-solo-founder-clients/index.html'       => '2026-05-13',
        'audit/faq/index.html'                                     => '2026-05-13',
        'en/audit/index.html'                                      => '2026-05-13',
        'en/audit/application-vibe-coding-production/index.html' => '2026-05-13',
        'en/audit/wetransform-integration-saas/index.html'         => '2026-06-26',
        'en/audit/technical-debt-saas-application/index.html'     => '2026-05-13',
        'en/audit/automated-tests-application/index.html'          => '2026-05-13',
        'en/audit/cicd-pipeline-application/index.html'             => '2026-05-13',
        'en/audit/freelance-technical-audit-startup/index.html'    => '2026-05-13',
        'en/audit/application-solo-founder-clients/index.html'      => '2026-05-13',
        'en/audit/faq/index.html'                                   => '2026-05-13',
    ];
}
