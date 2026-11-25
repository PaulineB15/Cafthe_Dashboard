<?php

// Fichier = charge le HTML et affiche le design

class View
{
    // Méthode pour afficher une vue avec ses données + layout optiooneel
    public static function render(string $viewPath, array $data = [], ?string $layout = 'Main'): void
    {
        // 1. extract() transforme un tableau ['titre' => 'Accueil'] en une variable $titre
        extract($data, EXTR_SKIP);

        // 2. ob_start() allume l'enregistreur : on "capture" le HTML au lieu de l'afficher tout de suite
        ob_start();
        
        // 3. On charge le fichier de la vue spécifique (ex: le tableau de bord ou le login)
        require __DIR__ . '/../../Views/' . $viewPath . '.php';
        
        // 4. ob_get_clean() coupe l'enregistreur et stocke tout le HTML capturé dans $content
        $content = ob_get_clean();
        
        // 5. Si un layout est demandé (ex: 'Main'), on l'inclut ; sinon on affiche la vue seule
        if ($layout !== null) {
            require __DIR__ . '/../../Views/Layouts/' . $layout . '.php';
        } else {
            echo $content;
        }
    }
}