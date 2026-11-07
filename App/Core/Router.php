<?php
// App/Core/Router.php

class Router
{
    // Ce tableau va stocker toutes les routes qu'on autorise dans l'application
    // Il y a une liste pour les requêtes GET (voir une page) et une pour POST (soumettre un formulaire)
    private array $routes = ['GET' => [], 'POST' => []];

    // Méthode pour ajouter une route GET (ex: afficher la liste des produits)
    public function get(string $path, array $action): void
    {
        $this->routes['GET'][$path] = $action;
    }

    // Méthode pour ajouter une route POST (ex: enregistrer un nouveau produit)
    public function post(string $path, array $action): void
    {
        $this->routes['POST'][$path] = $action;
    }

    // C'est ici que la magie opère : le routeur analyse l'URL demandée
    public function dispatch(string $uri, string $method): void
    {
        // 1. On nettoie l'URL pour enlever les paramètres après le "?" (s'il y en a)
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        
        // 2. IMPORTANT POUR LARAGON : On enlève le chemin de ton dossier local 
        // pour que le routeur ne garde que la fin de l'URL (ex: "/produits")
        $path = str_replace('/Cafthe_Dashboard/Public', '', $path);
        
        // Si le chemin est vide après nettoyage, on le remplace par '/' (l'accueil)
        if ($path === '') {
            $path = '/';
        }

        // 3. On cherche si cette URL existe dans notre annuaire de routes
        $action = $this->routes[$method][$path] ?? null;

        // 4. Si la route n'existe pas, on affiche une page 404
        if (!$action) {
            http_response_code(404);
            echo "Erreur 404 : Cette page n'existe pas sur le Dashboard CafThé.";
            return;
        }

        // 5. Si la route existe, on extrait le Contrôleur et sa méthode, et on les exécute !
        [$controllerClass, $methodName] = $action;
        (new $controllerClass())->$methodName();
    }
}