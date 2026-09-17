<?php

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/routes.php';

$distDir = dirname(__DIR__) . '/dist';

/**
 * Stop the export as soon as a write fails. PHP only raises a warning on
 * a failed write, so without this the run keeps going and still reports
 * success, leaving stale files in dist/ that then ship to production.
 */
function orFail(bool $ok, string $message): void
{
    if ($ok) {
        return;
    }

    fwrite(STDERR, "\n✗ Export aborted: {$message}\n");
    exit(1);
}

foreach (getPages() as $page) {
    $ctx = pageContext($page);

    $twig = createTwig($ctx['locale']);
    $html = $twig->render($ctx['template'], $ctx);

    $outPath = $distDir . '/' . $ctx['output'];
    $outDir  = dirname($outPath);

    if (!is_dir($outDir)) {
        orFail(mkdir($outDir, 0755, true), "cannot create {$outDir}");
    }

    orFail(file_put_contents($outPath, $html) !== false, "cannot write {$outPath}");
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
            orFail(mkdir($dest, 0755, true), "cannot create {$dest}");
        }
    } else {
        orFail(copy($item->getPathname(), $dest), "cannot copy asset to {$dest}");
    }
}

echo "✓ assets/\n";

// Copy root-level server files (.htaccess, robots.txt, sitemap.xml) into
// dist/ so they are picked up by the FTP deploy step, which only uploads dist/.
$rootDir = dirname(__DIR__);
foreach (['.htaccess', 'robots.txt', 'sitemap.xml'] as $file) {
    orFail(copy($rootDir . '/' . $file, $distDir . '/' . $file), "cannot copy {$file} into dist/");
    echo "✓ {$file}\n";
}

// dist/en/ needs its own ErrorDocument: Apache only allows one per
// directory, and the root .htaccess above already claims it for French.
orFail(copy($rootDir . '/en/.htaccess', $distDir . '/en/.htaccess'), "cannot copy en/.htaccess into dist/en/");
echo "✓ en/.htaccess\n";

echo "\nExport complete. Files written to dist/\n";
