<?php

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/routes.php';

$distDir = dirname(__DIR__) . '/dist';

foreach (getPages() as $page) {
    $ctx = pageContext($page);

    $twig = createTwig($ctx['locale']);
    $html = $twig->render($ctx['template'], $ctx);

    $outPath = $distDir . '/' . $ctx['output'];
    $outDir  = dirname($outPath);

    if (!is_dir($outDir)) {
        mkdir($outDir, 0755, true);
    }

    file_put_contents($outPath, $html);
    echo "✓ {$ctx['output']}\n";
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

// Copy root-level server files (.htaccess, robots.txt, sitemap.xml) into
// dist/ so they are picked up by the FTP deploy step, which only uploads dist/.
$rootDir = dirname(__DIR__);
foreach (['.htaccess', 'robots.txt', 'sitemap.xml'] as $file) {
    copy($rootDir . '/' . $file, $distDir . '/' . $file);
    echo "✓ {$file}\n";
}

echo "\nExport complete. Files written to dist/\n";
