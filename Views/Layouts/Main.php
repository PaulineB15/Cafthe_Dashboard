<?php
// Récupère l'URL actuelle pour savoir quelle page est active dans le menu
$currentUri = $_SERVER['REQUEST_URI'];
$isAccueil = ($currentUri === '/Cafthe_Dashboard/Public/' || $currentUri === '/Cafthe_Dashboard/Public/index.php');
$isStocks = (strpos($currentUri, '/produits') !== false);
$isProfil = (strpos($currentUri, '/profil') !== false);
$isUtilisateurs = (strpos($currentUri, '/utilisateurs') !== false);
$isClients = (strpos($currentUri, '/clients') !== false);

// Récupère les informations de l'employé connecté depuis la session
$employeConnecte = $_SESSION['employe'] ?? null;
$prenomEmploye = $employeConnecte['prenom'] ?? '';
$nomEmploye = $employeConnecte['nom'] ?? '';
$roleEmploye = $employeConnecte['role'] ?? 'Vendeur';
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard CafThé</title>
    <!-- LIAISON DU FICHIER CSS EXTERNE -->
    <link rel="stylesheet" href="/Cafthe_Dashboard/Public/Assets/Css/Style.css?v=2">
    <link rel="stylesheet" href="/Cafthe_Dashboard/Public/Assets/Css/responsive.css?v=2">
    <!-- Police d'icônes FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Script du menu burger -->
    <script src="/Cafthe_Dashboard/Public/Assets/Js/menu-burger.js" defer></script>
</head>
<body>
    
    <!-- Menu latéral -->
    <aside class="sidebar">

        <!-- Bouton menu burger (visible uniquement sur mobile) -->
        <button type="button" id="bouton-burger" class="bouton-burger" aria-label="Ouvrir le menu" aria-expanded="false">
            <i class="fa-solid fa-bars"></i>
        </button>
        
        <!-- En-tête du menu (Logo + Employé connecté + Rôle) -->
        <div class="logo-container">
            <img src="/Cafthe_Dashboard/Public/Assets/Images/logo.webp" alt="Logo CafThé" class="logo-sidebar">
            <?php if ($employeConnecte): ?>
                <p class="sidebar-employe">
                    <?= htmlspecialchars($prenomEmploye . ' ' . $nomEmploye) ?>
                </p>
            <?php endif; ?>
            <p class="sidebar-role">
                Espace <?= htmlspecialchars($roleEmploye) ?>
            </p>
        </div>

        <!-- Navigation principale -->
        <nav class="nav-menu">
            <ul>
                
                <!-- Lien vers l'Accueil -->
                <li>
                    <a href="/Cafthe_Dashboard/Public/" class="nav-link <?= $isAccueil ? 'active' : '' ?>">
                        <i class="fa-solid fa-chart-pie"></i> Tableau de bord
                    </a>
                </li>

                <!-- Lien vers la Caisse -->
                <li>
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-cash-register"></i> Caisse (POS)
                    </a>
                </li>

                <!-- Lien vers les Commandes -->
                <li>
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-box-open"></i> Commandes
                    </a>
                </li>

                <!-- Lien vers les Stocks -->
                <li>
                    <a href="/Cafthe_Dashboard/Public/produits" class="nav-link <?= $isStocks ? 'active' : '' ?>">
                        <i class="fa-solid fa-mug-hot"></i> Stocks
                    </a>
                </li>

                <!-- Lien vers les Clients -->
                <li>
                    <a href="/Cafthe_Dashboard/Public/clients" class="nav-link <?= $isClients ? 'active' : '' ?>">
                        <i class="fa-solid fa-users"></i> Clients
                    </a>
                </li>

                <!-- Lien vers les Utilisateurs (Réservé à l'Administrateur) -->
                <?php if ($roleEmploye === 'Administrateur'): ?>
                <li>
                    <a href="/Cafthe_Dashboard/Public/utilisateurs" class="nav-link <?= $isUtilisateurs ? 'active' : '' ?>">
                        <i class="fa-solid fa-user-shield"></i> Utilisateurs
                    </a>
                </li>
                <?php endif; ?>

            </ul>
        </nav>

        <!-- Bas du menu (Profil & Déconnexion) -->
        <div class="sidebar-bas">
            
            <a href="/Cafthe_Dashboard/Public/profil" class="nav-link <?= $isProfil ? 'active' : '' ?>">
                <i class="fa-solid fa-user"></i> Mon Profil
            </a>

            <a href="/Cafthe_Dashboard/Public/logout" class="logout-link">
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