<!-- Views/Layouts/Main.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard CafThé</title>
    <!-- LIAISON DU FICHIER CSS EXTERNE (Avec tes Majuscules) -->
    <link rel="stylesheet" href="/Cafthe_Dashboard/Public/Assets/Css/Style.css">
</head>
<body>
    
    <!-- Menu latéral -->
    <aside class="sidebar">
        <h2>CafThé</h2>
        <p style="color: gray; font-size: 0.9em; text-align: center;">Espace Vendeur</p>
        <!-- On ajoutera la liste de tes liens de navigation ici plus tard -->
    </aside>

    <!-- Zone principale où tes vues (Accueil, Produits, etc.) s'injectent -->
    <main class="main-content">
        <?= $content ?> 
    </main>

</body>
</html>