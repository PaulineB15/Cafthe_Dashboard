<!-- Views/Auth/Login.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Dashboard CafThé</title>
    <!-- Liaison du fichier CSS externe -->
    <link rel="stylesheet" href="/Cafthe_Dashboard/Public/Assets/Css/Style.css?v=2">
    <!-- Police d'icônes FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="page-connexion">

    <div class="boite-connexion">
        
        <!-- Logo et titre -->
        <div class="connexion-entete">
            <img src="/Cafthe_Dashboard/Public/Assets/Images/logo.webp" alt="Logo CafThé" class="connexion-logo">
            <h1 class="connexion-titre">CONNEXION</h1>
            <p class="connexion-sous-titre">Accès réservé à l'équipe CafThé</p>
        </div>

        <!-- Message d'erreur éventuel -->
        <?php if (!empty($erreur)): ?>
            <div class="alerte-erreur">
                <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($erreur) ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire de connexion -->
        <form action="/Cafthe_Dashboard/Public/login" method="POST">
            
            <div class="groupe-champ">
                <label for="email" class="etiquette">Adresse email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($emailSaisi ?? '') ?>" required class="champ-sombre">
            </div>

            <div class="groupe-champ-large">
                <label for="mot_de_passe" class="etiquette">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required class="champ-sombre">
            </div>

            <button type="submit" class="bouton-or-plein">
                SE CONNECTER
            </button>

        </form>
    </div>

</body>
</html>