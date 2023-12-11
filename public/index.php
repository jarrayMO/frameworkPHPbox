<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Utilisation de PHP-DI pour la gestion de l'injection de dépendances
use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();
$container = $containerBuilder->build();

// Configuration de l'environnement Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../src/Views');
$twig = new \Twig\Environment($loader);

// Enregistrement de l'instance Twig dans le conteneur
$container->set(\Twig\Environment::class, $twig);

$router = $container->get(\App\Router::class);

// Exécute l'application
$router->run();
