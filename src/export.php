<?php

require_once __DIR__ . '/bootstrap.php';

$distDir = dirname(__DIR__) . '/dist';

$pages = [
    // [template, locale, current_page, asset_base, lang_fr_url, lang_en_url, output_path]
    ['index.html.twig',               'fr', 'home',     '',     'index.html',               'en/index.html',           'index.html'],
    ['site-web-14-jours.html.twig',   'fr', 'site_14',  '',     'site-web-14-jours.html',   'en/website-14-days.html', 'site-web-14-jours.html'],
    ['portfolio.html.twig',           'fr', 'portfolio', '',    'portfolio.html',            'en/portfolio.html',       'portfolio.html'],
    ['senior-tech.html.twig',         'fr', 'senior',   '',     'senior-tech.html',          'en/index.html',           'senior-tech.html'],
    ['tech.html.twig',                'fr', '',          '',     'tech.html',                 'en/index.html',           'tech.html'],
    ['mentions-legales.html.twig',    'fr', 'legal',    '',     'mentions-legales.html',     'en/legal-notice.html',    'mentions-legales.html'],
    ['quiz.html.twig',                'fr', 'quiz',     '',     'quiz.html',                 'en/index.html',           'quiz.html'],
    ['audit/index.html.twig',         'fr', 'audit',    '../',  'audit/',                    '../en/audit/',            'audit/index.html'],
    ['en/index.html.twig',            'en', 'home',     '../',  '../index.html',             'index.html',              'en/index.html'],
    ['en/website-14-days.html.twig',  'en', 'site_14',  '../',  '../site-web-14-jours.html', 'website-14-days.html',    'en/website-14-days.html'],
    ['en/portfolio.html.twig',        'en', 'portfolio', '../', '../portfolio.html',         'portfolio.html',          'en/portfolio.html'],
    ['en/legal-notice.html.twig',     'en', 'legal',    '../',  '../mentions-legales.html',  'legal-notice.html',       'en/legal-notice.html'],
];

foreach ($pages as [$template, $locale, $current_page, $asset_base, $lang_fr_url, $lang_en_url, $output]) {
    $twig = createTwig($locale);
    $html = $twig->render($template, [
        'locale'       => $locale,
        'current_page' => $current_page,
        'asset_base'   => $asset_base,
        'lang_fr_url'  => $lang_fr_url,
        'lang_en_url'  => $lang_en_url,
    ]);

    $outPath = $distDir . '/' . $output;
    $outDir  = dirname($outPath);

    if (!is_dir($outDir)) {
        mkdir($outDir, 0755, true);
    }

    file_put_contents($outPath, $html);
    echo "✓ $output\n";
}

// Copy assets/ into dist/assets/ so dist/ is self-contained
$srcAssets  = __DIR__ . '/assets';
$destAssets = $distDir . '/assets';

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($srcAssets, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

foreach ($iterator as $item) {
    $dest = $destAssets . '/' . $iterator->getSubPathname();
    if ($item->isDir()) {
        if (!is_dir($dest)) {
            mkdir($dest, 0755, true);
        }
    } else {
        copy($item->getPathname(), $dest);
    }
}

echo "✓ assets/\n";
echo "\nExport complete. Files written to dist/\n";
