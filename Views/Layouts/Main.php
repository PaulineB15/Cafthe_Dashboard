<!-- Views/Layouts/Main.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard CafThé</title>
    <!-- LIAISON DU FICHIER CSS EXTERNE -->
    <link rel="stylesheet" href="/Cafthe_Dashboard/Public/Assets/Css/Style.css">
    <!-- J'ajoute une police d'icônes (FontAwesome) pour avoir les mêmes petits dessins que sur ta maquette -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    
    <!-- Menu latéral -->
    <aside class="sidebar" style="display: flex; flex-direction: column; position: relative; padding: 20px;">
        
        <!-- En-tête du menu (Logo + Rôle) -->
        <div class="logo-container" style="text-align: center; margin-bottom: 40px;">
            <!-- Remplace "logo.png" par le vrai nom de ton fichier image (png ou svg) -->
            <img src="/Cafthe_Dashboard/Public/Assets/Images/logo.webp" alt="Logo CafThé" style="max-width: 180px; height: auto;">
            <p style="color: gray; font-size: 0.9em; margin-top: 10px;">Espace Vendeur</p>
        </div>

        <!-- Navigation principale -->
        <nav class="nav-menu">
            <ul style="list-style: none; padding: 0; margin: 0;">
                
                <!-- Lien vers l'Accueil (DashboardController) -->
                <li style="margin-bottom: 15px;">
                    <a href="/Cafthe_Dashboard/Public/" style="color: var(--text-light); text-decoration: none; display: block; padding: 10px; border-radius: 5px; font-size: 1.1em;">
                        <i class="fa-solid fa-chart-pie" style="width: 25px; color: var(--gold);"></i> Tableau de bord
                    </a>
                </li>

                <!-- Lien vers la future Caisse -->
                <li style="margin-bottom: 15px;">
                    <a href="#" style="color: var(--text-light); text-decoration: none; display: block; padding: 10px; border-radius: 5px; font-size: 1.1em;">
                        <i class="fa-solid fa-cash-register" style="width: 25px; color: var(--gold);"></i> Caisse (POS)
                    </a>
                </li>

                <!-- Lien vers les futures Commandes -->
                <li style="margin-bottom: 15px;">
                    <a href="#" style="color: var(--text-light); text-decoration: none; display: block; padding: 10px; border-radius: 5px; font-size: 1.1em;">
                        <i class="fa-solid fa-box-open" style="width: 25px; color: var(--gold);"></i> Commandes
                    </a>
                </li>

                <!-- Lien vers les Stocks (ProduitController) -->
                <li style="margin-bottom: 15px;">
                    <!-- J'ai mis un fond légèrement gris pour simuler la page "active" -->
                    <a href="/Cafthe_Dashboard/Public/produits" style="color: var(--gold); text-decoration: none; display: block; padding: 10px; border-radius: 5px; background-color: #333; font-weight: bold; font-size: 1.1em;">
                        <i class="fa-solid fa-mug-hot" style="width: 25px;"></i> Stocks
                    </a>
                </li>

                <!-- Lien vers les futurs Clients -->
                <li style="margin-bottom: 15px;">
                    <a href="#" style="color: var(--text-light); text-decoration: none; display: block; padding: 10px; border-radius: 5px; font-size: 1.1em;">
                        <i class="fa-solid fa-users" style="width: 25px; color: var(--gold);"></i> Clients
                    </a>
                </li>

            </ul>
        </nav>

        <!-- Bouton Déconnexion (en bas) -->
        <div style="margin-top: auto; padding-top: 40px;">
            <a href="#" style="color: #ff4c4c; text-decoration: none; display: block; padding: 10px; text-align: center; border: 1px solid #ff4c4c; border-radius: 5px; transition: 0.3s;">
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