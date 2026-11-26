<?php
// On récupère l'URL actuelle pour savoir quelle page est active dans le menu
$currentUri = $_SERVER['REQUEST_URI'];
$isAccueil = ($currentUri === '/Cafthe_Dashboard/Public/' || $currentUri === '/Cafthe_Dashboard/Public/index.php');
$isStocks = (strpos($currentUri, '/produits') !== false);
$isProfil = (strpos($currentUri, '/profil') !== false);
$isUtilisateurs = (strpos($currentUri, '/utilisateurs') !== false);
$isClients = (strpos($currentUri, '/clients') !== false);

// On récupère les informations de l'employé connecté depuis la session
$employeConnecte = $_SESSION['employe'] ?? null;
$prenomEmploye = $employeConnecte['prenom'] ?? '';
$nomEmploye = $employeConnecte['nom'] ?? '';
$roleEmploye = $employeConnecte['role'] ?? 'Vendeur';
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
    <aside class="sidebar" style="display: flex; flex-direction: column; position: relative; padding: 20px; box-sizing: border-box;">
        
        <!-- En-tête du menu (Logo + Employé connecté + Rôle) -->
        <div class="logo-container" style="text-align: center; margin-bottom: 30px;">
            <img src="/Cafthe_Dashboard/Public/Assets/Images/logo.webp" alt="Logo CafThé" style="max-width: 160px; height: auto;">
            <?php if ($employeConnecte): ?>
                <p style="color: var(--gold); font-weight: bold; font-size: 0.95em; margin: 10px 0 2px 0;">
                    <?= htmlspecialchars($prenomEmploye . ' ' . $nomEmploye) ?>
                </p>
            <?php endif; ?>
            <p style="color: gray; font-size: 0.85em; margin: 0;">
                Espace <?= htmlspecialchars($roleEmploye) ?>
            </p>
        </div>

        <!-- Navigation principale -->
        <nav class="nav-menu" style="flex-grow: 1;">
            <ul style="list-style: none; padding: 0; margin: 0;">
                
                <!-- Lien vers l'Accueil -->
                <li style="margin-bottom: 12px;">
                    <a href="/Cafthe_Dashboard/Public/" class="nav-link <?= $isAccueil ? 'active' : '' ?>">
                        <i class="fa-solid fa-chart-pie"></i> Tableau de bord
                    </a>
                </li>

                <!-- Lien vers la Caisse -->
                <li style="margin-bottom: 12px;">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-cash-register"></i> Caisse (POS)
                    </a>
                </li>

                <!-- Lien vers les Commandes -->
                <li style="margin-bottom: 12px;">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-box-open"></i> Commandes
                    </a>
                </li>

                <!-- Lien vers les Stocks -->
                <li style="margin-bottom: 12px;">
                    <a href="/Cafthe_Dashboard/Public/produits" class="nav-link <?= $isStocks ? 'active' : '' ?>">
                        <i class="fa-solid fa-mug-hot"></i> Stocks
                    </a>
                </li>

                <!-- Lien vers les Clients -->
                <li style="margin-bottom: 12px;">
                    <a href="/Cafthe_Dashboard/Public/clients" class="nav-link <?= $isClients ? 'active' : '' ?>">
                        <i class="fa-solid fa-users"></i> Clients
                    </a>
                </li>

                <!-- Lien vers les Utilisateurs (Réservé à l'Administrateur) -->
                <?php if ($roleEmploye === 'Administrateur'): ?>
                <li style="margin-bottom: 12px;">
                    <a href="/Cafthe_Dashboard/Public/utilisateurs" class="nav-link <?= $isUtilisateurs ? 'active' : '' ?>">
                        <i class="fa-solid fa-user-shield"></i> Utilisateurs
                    </a>
                </li>
                <?php endif; ?>

            </ul>
        </nav>

    
        <!-- Bas du menu (Profil & Déconnexion) -->
        <div style="margin-top: auto; padding-top: 20px; border-top: 1px solid #333;">
            
            <a href="/Cafthe_Dashboard/Public/profil" class="nav-link <?= $isProfil ? 'active' : '' ?>" style="margin-bottom: 10px;">
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