<?php

require_once __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Bridge\Twig\Extension\TranslationExtension;

function createTwig(string $locale = 'fr'): Environment
{
    $loader = new FilesystemLoader(__DIR__ . '/templates');
    $twig = new Environment($loader, ['cache' => false, 'debug' => true]);

    $translator = new Translator($locale);
    $translator->addLoader('yaml', new YamlFileLoader());
    $translator->addResource('yaml', __DIR__ . '/translations/messages.fr.yaml', 'fr');
    $translator->addResource('yaml', __DIR__ . '/translations/messages.en.yaml', 'en');

    $twig->addExtension(new TranslationExtension($translator));

    return $twig;
}
