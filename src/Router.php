<?php

namespace App;

use FastRoute\RouteCollector;
use Psr\Container\ContainerInterface;

class Router
{
    protected $dispatcher;
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->dispatcher = \FastRoute\simpleDispatcher(function (RouteCollector $r) {
            $r->addRoute('GET', '/', ['App\Controllers\AirQualityController', 'index']);
            $r->addRoute('GET', '/getAirQuality', ['App\Controllers\AirQualityController', 'index']);

            // Ajoutez d'autres routes au besoin
        });
        

    }

    public function run()
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = strtok($_SERVER['REQUEST_URI'], '?'); // Récupération de l'URI sans les paramètres de requête
        // Récupération de la chaîne de requête avec les paramètres
        // Dispatch de la route
        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri );

        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                // Gestion de la page non trouvée (404)
                echo 'Page non trouvée (Erreur 404)';
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                // Gestion de la méthode non autorisée (405)
                $allowedMethods = $routeInfo[1];
                echo 'Méthode non autorisée (Erreur 405)';
                break;
            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                // Résolution des dépendances et appel du contrôleur
                $container = $this->container;
                $controller = $container->get($handler[0]);
                $method = $handler[1];

                // Appel du contrôleur et de l'action correspondante avec les éventuelles variables
                $controller->$method(...$vars);
                break;
        }
    }
}
