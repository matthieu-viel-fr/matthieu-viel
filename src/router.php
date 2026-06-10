<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Serve assets from src/assets/
if (str_starts_with($uri, '/assets/')) {
    $file = '/app/src' . $uri;
    if (file_exists($file) && is_file($file)) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $mimeTypes = [
            'css'   => 'text/css',
            'js'    => 'application/javascript',
            'webp'  => 'image/webp',
            'svg'   => 'image/svg+xml',
            'png'   => 'image/png',
            'jpg'   => 'image/jpeg',
            'jpeg'  => 'image/jpeg',
            'ico'   => 'image/x-icon',
            'woff2' => 'font/woff2',
            'woff'  => 'font/woff',
        ];
        header('Content-Type: ' . ($mimeTypes[$ext] ?? mime_content_type($file)));
        readfile($file);
        exit;
    }
    http_response_code(404);
    exit;
}

// Serve other static files directly (audit sub-pages, etc.)
if ($uri !== '/' && file_exists('/app' . $uri) && !is_dir('/app' . $uri)) {
    return false;
}

require_once __DIR__ . '/bootstrap.php';

$routes = [
    // FR pages
    '/'                          => ['index.html.twig',                    'fr', 'home',     '',     'index.html',              'en/index.html'],
    '/index.html'                => ['index.html.twig',                    'fr', 'home',     '',     'index.html',              'en/index.html'],
    '/site-web-14-jours.html'    => ['site-web-14-jours.html.twig',        'fr', 'site_14',  '',     'site-web-14-jours.html',  'en/website-14-days.html'],
    '/portfolio.html'            => ['portfolio.html.twig',                'fr', 'portfolio', '',    'portfolio.html',          'en/portfolio.html'],
    '/senior-tech.html'          => ['senior-tech.html.twig',              'fr', 'senior',   '',     'senior-tech.html',        'en/index.html'],
    '/tech.html'                 => ['tech.html.twig',                     'fr', '',          '',     'tech.html',               'en/index.html'],
    '/mentions-legales.html'     => ['mentions-legales.html.twig',         'fr', 'legal',    '',     'mentions-legales.html',   'en/legal-notice.html'],
    '/quiz.html'                 => ['quiz.html.twig',                     'fr', 'quiz',     '',     'quiz.html',               'en/index.html'],
    '/audit/'                    => ['audit/index.html.twig',              'fr', 'audit',    '../',  'audit/',                  '../en/audit/'],
    '/audit/index.html'          => ['audit/index.html.twig',              'fr', 'audit',    '../',  'audit/',                  '../en/audit/'],
    '/audit/application-vibe-coding-production/'       => ['audit/application-vibe-coding-production.html.twig',      'fr', 'audit', '../../', './', '../../en/audit/application-vibe-coding-production/'],
    '/audit/application-vibe-coding-production/index.html' => ['audit/application-vibe-coding-production.html.twig', 'fr', 'audit', '../../', './', '../../en/audit/application-vibe-coding-production/'],
    '/audit/dette-technique-application-saas/'         => ['audit/dette-technique-application-saas.html.twig',        'fr', 'audit', '../../', './', '../../en/audit/technical-debt-saas-application/'],
    '/audit/dette-technique-application-saas/index.html' => ['audit/dette-technique-application-saas.html.twig',      'fr', 'audit', '../../', './', '../../en/audit/technical-debt-saas-application/'],
    '/audit/tests-automatises-application/'            => ['audit/tests-automatises-application.html.twig',           'fr', 'audit', '../../', './', '../../en/audit/automated-tests-application/'],
    '/audit/tests-automatises-application/index.html'  => ['audit/tests-automatises-application.html.twig',           'fr', 'audit', '../../', './', '../../en/audit/automated-tests-application/'],
    '/audit/cicd-pipeline-application/'                => ['audit/cicd-pipeline-application.html.twig',               'fr', 'audit', '../../', './', '../../en/audit/cicd-pipeline-application/'],
    '/audit/cicd-pipeline-application/index.html'      => ['audit/cicd-pipeline-application.html.twig',               'fr', 'audit', '../../', './', '../../en/audit/cicd-pipeline-application/'],
    '/audit/freelance-audit-technique-startup/'        => ['audit/freelance-audit-technique-startup.html.twig',       'fr', 'audit', '../../', './', '../../en/audit/freelance-technical-audit-startup/'],
    '/audit/freelance-audit-technique-startup/index.html' => ['audit/freelance-audit-technique-startup.html.twig',    'fr', 'audit', '../../', './', '../../en/audit/freelance-technical-audit-startup/'],
    '/audit/application-solo-founder-clients/'         => ['audit/application-solo-founder-clients.html.twig',        'fr', 'audit', '../../', './', '../../en/audit/application-solo-founder-clients/'],
    '/audit/application-solo-founder-clients/index.html' => ['audit/application-solo-founder-clients.html.twig',      'fr', 'audit', '../../', './', '../../en/audit/application-solo-founder-clients/'],
    '/audit/faq/'                                      => ['audit/faq.html.twig',                                     'fr', 'audit', '../../', './', '../../en/audit/faq/'],
    '/audit/faq/index.html'                            => ['audit/faq.html.twig',                                     'fr', 'audit', '../../', './', '../../en/audit/faq/'],
    // EN pages
    '/en/'                       => ['en/index.html.twig',                 'en', 'home',     '../',  '../index.html',           'index.html'],
    '/en/index.html'             => ['en/index.html.twig',                 'en', 'home',     '../',  '../index.html',           'index.html'],
    '/en/website-14-days.html'   => ['en/website-14-days.html.twig',       'en', 'site_14',  '../',  '../site-web-14-jours.html', 'website-14-days.html'],
    '/en/portfolio.html'         => ['en/portfolio.html.twig',             'en', 'portfolio', '../', '../portfolio.html',       'portfolio.html'],
    '/en/legal-notice.html'      => ['en/legal-notice.html.twig',          'en', 'legal',    '../',  '../mentions-legales.html', 'legal-notice.html'],
    '/en/audit/'                                             => ['en/audit/index.html.twig',                              'en', 'audit', '../../',    '../../audit/',                                       './'],
    '/en/audit/index.html'                                   => ['en/audit/index.html.twig',                              'en', 'audit', '../../',    '../../audit/',                                       './'],
    '/en/audit/application-vibe-coding-production/'          => ['en/audit/application-vibe-coding-production.html.twig', 'en', 'audit', '../../../', '../../../audit/application-vibe-coding-production/', './'],
    '/en/audit/application-vibe-coding-production/index.html' => ['en/audit/application-vibe-coding-production.html.twig', 'en', 'audit', '../../../', '../../../audit/application-vibe-coding-production/', './'],
    '/en/audit/technical-debt-saas-application/'             => ['en/audit/technical-debt-saas-application.html.twig',     'en', 'audit', '../../../', '../../../audit/dette-technique-application-saas/',   './'],
    '/en/audit/technical-debt-saas-application/index.html'   => ['en/audit/technical-debt-saas-application.html.twig',     'en', 'audit', '../../../', '../../../audit/dette-technique-application-saas/',   './'],
    '/en/audit/automated-tests-application/'                 => ['en/audit/automated-tests-application.html.twig',         'en', 'audit', '../../../', '../../../audit/tests-automatises-application/',     './'],
    '/en/audit/automated-tests-application/index.html'       => ['en/audit/automated-tests-application.html.twig',         'en', 'audit', '../../../', '../../../audit/tests-automatises-application/',     './'],
    '/en/audit/cicd-pipeline-application/'                   => ['en/audit/cicd-pipeline-application.html.twig',           'en', 'audit', '../../../', '../../../audit/cicd-pipeline-application/',         './'],
    '/en/audit/cicd-pipeline-application/index.html'         => ['en/audit/cicd-pipeline-application.html.twig',           'en', 'audit', '../../../', '../../../audit/cicd-pipeline-application/',         './'],
    '/en/audit/freelance-technical-audit-startup/'           => ['en/audit/freelance-technical-audit-startup.html.twig',   'en', 'audit', '../../../', '../../../audit/freelance-audit-technique-startup/', './'],
    '/en/audit/freelance-technical-audit-startup/index.html' => ['en/audit/freelance-technical-audit-startup.html.twig',   'en', 'audit', '../../../', '../../../audit/freelance-audit-technique-startup/', './'],
    '/en/audit/application-solo-founder-clients/'            => ['en/audit/application-solo-founder-clients.html.twig',    'en', 'audit', '../../../', '../../../audit/application-solo-founder-clients/',  './'],
    '/en/audit/application-solo-founder-clients/index.html'  => ['en/audit/application-solo-founder-clients.html.twig',    'en', 'audit', '../../../', '../../../audit/application-solo-founder-clients/',  './'],
    '/en/audit/faq/'                                         => ['en/audit/faq.html.twig',                                 'en', 'audit', '../../../', '../../../audit/faq/',                               './'],
    '/en/audit/faq/index.html'                               => ['en/audit/faq.html.twig',                                 'en', 'audit', '../../../', '../../../audit/faq/',                               './'],
];

if (!isset($routes[$uri])) {
    http_response_code(404);
    echo '<h1>404 Not found</h1><p>' . htmlspecialchars($uri) . '</p>';
    exit;
}

[$template, $locale, $current_page, $asset_base, $lang_fr_url, $lang_en_url] = $routes[$uri];

$twig = createTwig($locale);

echo $twig->render($template, [
    'locale'       => $locale,
    'current_page' => $current_page,
    'asset_base'   => $asset_base,
    'lang_fr_url'  => $lang_fr_url,
    'lang_en_url'  => $lang_en_url,
]);
