<?php
// On récupère l'URL actuelle pour savoir quelle page est active dans le menu
$currentUri = $_SERVER['REQUEST_URI'];
$isAccueil = ($currentUri === '/Cafthe_Dashboard/Public/' || $currentUri === '/Cafthe_Dashboard/Public/index.php');
$isStocks = (strpos($currentUri, '/produits') !== false);
?>
<!-- Views/Layouts/Main.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard CafThé</title>
    <!-- LIAISON DU FICHIER CSS EXTERNE -->
    <link rel="stylesheet" href="/Cafthe_Dashboard/Public/Assets/Css/Style.css">
    <!-- Police d'icônes FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    
    <!-- Menu latéral -->
    <aside class="sidebar" style="display: flex; flex-direction: column; position: relative; padding: 20px;">
        
        <!-- En-tête du menu (Logo + Rôle) -->
        <div class="logo-container" style="text-align: center; margin-bottom: 40px;">
            <img src="/Cafthe_Dashboard/Public/Assets/Images/logo.webp" alt="Logo CafThé" style="max-width: 180px; height: auto;">
            <p style="color: gray; font-size: 0.9em; margin-top: 10px;">Espace Vendeur</p>
        </div>

        <!-- Navigation principale -->
        <nav class="nav-menu">
            <ul style="list-style: none; padding: 0; margin: 0;">
                
                <!-- Lien vers l'Accueil -->
                <li style="margin-bottom: 15px;">
                    <a href="/Cafthe_Dashboard/Public/" class="nav-link <?= $isAccueil ? 'active' : '' ?>">
                        <i class="fa-solid fa-chart-pie"></i> Tableau de bord
                    </a>
                </li>

                <!-- Lien vers la Caisse -->
                <li style="margin-bottom: 15px;">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-cash-register"></i> Caisse (POS)
                    </a>
                </li>

                <!-- Lien vers les Commandes -->
                <li style="margin-bottom: 15px;">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-box-open"></i> Commandes
                    </a>
                </li>

                <!-- Lien vers les Stocks -->
                <li style="margin-bottom: 15px;">
                    <a href="/Cafthe_Dashboard/Public/produits" class="nav-link <?= $isStocks ? 'active' : '' ?>">
                        <i class="fa-solid fa-mug-hot"></i> Stocks
                    </a>
                </li>

                <!-- Lien vers les Clients -->
                <li style="margin-bottom: 15px;">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-users"></i> Clients
                    </a>
                </li>

                <!-- Lien vers les Utilisateurs -->
                <li style="margin-bottom: 15px;">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-user-shield"></i> Utilisateurs
                    </a>
                </li>

            </ul>
        </nav>

        <!-- Bas du menu (Profil & Déconnexion) -->
        <div style="margin-top: auto; padding-top: 20px; border-top: 1px solid #333;">
            
            <a href="#" class="nav-link" style="margin-bottom: 10px;">
                <i class="fa-solid fa-user"></i> Mon Profil
            </a>

            <a href="#" class="logout-link">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Déconnexion
            </a>
        </div>

    </aside>

    <!-- Zone principale où tes vues s'injectent -->
    <main class="main-content">
        <?= $content ?> 
    </main>

</body>
</html>