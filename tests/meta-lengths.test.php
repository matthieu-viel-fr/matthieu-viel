<?php

/**
 * QW04 / TODO.md item 7: every indexable page's <title> and meta
 * description must render within the practical SERP limits set by
 * CLAUDE.md rule 2 (title 55-60 characters, description 150-160
 * characters), so a future edit can't silently let 20 descriptions and
 * 6 titles drift out of target again, the way the 2026-09 audit found.
 *
 * Measured on the generated dist/ output, not the Twig source: HTML
 * entities such as &amp; count once in the rendered page but five times
 * in the source, and only the rendered length is what Google truncates
 * on. Run: php src/export.php && php tests/meta-lengths.test.php
 */

require_once __DIR__ . '/../src/routes.php';

const META_TITLE_MIN = 55;
const META_TITLE_MAX = 60;
const META_DESC_MIN = 150;
const META_DESC_MAX = 160;

/**
 * Pages excluded from this check, keyed by output path, with the reason
 * documented. Deliberately NOT the same list as getSitemapExclusions():
 * that one also excludes 404.html/en/404.html as error documents, but
 * QW04 explicitly keeps the two 404 pages in scope here. They are real
 * pages a visitor lands on, their title/description are already within
 * target, and a regression there should still fail this test even
 * though they carry a noindex meta tag.
 */
function getMetaLengthExclusions(): array
{
    return [
        'tech.html' => 'meta-refresh redirect to senior-tech.html, not a page of its own',
        'quiz.html' => 'deliberately noindex/orphaned (see TODO.md item A5), not offered for indexing',
    ];
}

/**
 * Length as a browser/search engine would count it: HTML entities
 * decoded (so "&amp;" is 1 character, not 5) and surrounding whitespace
 * trimmed, counted per Unicode codepoint (not byte) so accented
 * characters (é, ·) count as one character each. Uses PCRE's "u"
 * modifier rather than mbstring, which is not guaranteed to be
 * installed (it isn't, in this project's environment).
 */
function renderedTextLength(string $html): int
{
    $decoded = trim(html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    $count = preg_match_all('/./us', $decoded);

    return $count === false ? strlen($decoded) : $count;
}

$distDir = __DIR__ . '/../dist';
$exclusions = getMetaLengthExclusions();
$failures = 0;
$checked = 0;

foreach (getPages() as $page) {
    $output = $page[0];

    if (isset($exclusions[$output])) {
        continue;
    }

    $path = $distDir . '/' . $output;

    if (!is_file($path)) {
        fwrite(STDERR, "  \xE2\x9C\x97 {$output}: missing from dist/, run php src/export.php first\n");
        $failures++;
        continue;
    }

    $html = file_get_contents($path);

    if (!preg_match('/<title>(.*?)<\/title>/s', $html, $titleMatch)) {
        fwrite(STDERR, "  \xE2\x9C\x97 {$output}: no <title> tag found\n");
        $failures++;
        continue;
    }

    if (!preg_match('/<meta\s+name="description"\s+content="(.*?)"/s', $html, $descMatch)) {
        fwrite(STDERR, "  \xE2\x9C\x97 {$output}: no meta description found\n");
        $failures++;
        continue;
    }

    $checked++;

    $titleLength = renderedTextLength($titleMatch[1]);
    $descLength = renderedTextLength($descMatch[1]);

    $titleOk = $titleLength >= META_TITLE_MIN && $titleLength <= META_TITLE_MAX;
    $descOk = $descLength >= META_DESC_MIN && $descLength <= META_DESC_MAX;

    if (!$titleOk) {
        fwrite(STDERR, "  \xE2\x9C\x97 {$output}: title is {$titleLength} chars, target " . META_TITLE_MIN . '-' . META_TITLE_MAX . "\n");
        $failures++;
    }

    if (!$descOk) {
        fwrite(STDERR, "  \xE2\x9C\x97 {$output}: meta description is {$descLength} chars, target " . META_DESC_MIN . '-' . META_DESC_MAX . "\n");
        $failures++;
    }
}

if ($failures === 0) {
    echo "  \xE2\x9C\x93 {$checked} indexable page(s) have a title (" . META_TITLE_MIN . '-' . META_TITLE_MAX .
        ') and meta description (' . META_DESC_MIN . '-' . META_DESC_MAX . ") within target, measured on dist/\n";
    echo "\n\xE2\x9C\x85 Meta length test passed.\n";

    return;
}

fwrite(STDERR, "\n\xE2\x9D\x8C Meta length test failed.\n");
exit(1);
