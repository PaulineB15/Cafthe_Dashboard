<?php
// Ce fichier est l'outil technique qui va fusionner ton contenu avec le design global

class View
{
    // Méthode pour afficher une vue avec ses données
    public static function render(string $viewPath, array $data = []): void
    {
        // 1. extract() transforme un tableau ['titre' => 'Accueil'] en une variable $titre
        extract($data, EXTR_SKIP);

        // 2. ob_start() allume l'enregistreur : on "capture" le HTML au lieu de l'afficher tout de suite
        ob_start();
        
        // 3. On charge le fichier de la vue spécifique (ex: le tableau de bord)
        require __DIR__ . '/../../Views/' . $viewPath . '.php';
        
        // 4. ob_get_clean() coupe l'enregistreur et stocke tout le HTML capturé dans $content
        $content = ob_get_clean();
        
        // 5. On charge le gabarit global (layout) qui va utiliser la variable $content pour l'afficher au milieu
        require __DIR__ . '/../../Views/Layouts/Main.php';
    }
}