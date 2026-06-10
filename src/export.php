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
echo "\nExport complete. Files written to dist/\n";
