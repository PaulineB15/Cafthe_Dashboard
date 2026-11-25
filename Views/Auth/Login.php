<!-- Views/Auth/Login.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Dashboard CafThé</title>
    <!-- Liaison du fichier CSS externe -->
    <link rel="stylesheet" href="/Cafthe_Dashboard/Public/Assets/Css/Style.css">
    <!-- Police d'icônes FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="display: flex; align-items: center; justify-content: center; min-height: 100vh;">

    <div style="background-color: var(--bg-sidebar); padding: 35px; border-radius: 8px; width: 100%; max-width: 400px; border: 1px solid #333; box-sizing: border-box;">
        
        <!-- Logo et titre -->
        <div style="text-align: center; margin-bottom: 25px;">
            <img src="/Cafthe_Dashboard/Public/Assets/Images/logo.webp" alt="Logo CafThé" style="max-width: 160px; height: auto;">
            <h1 style="color: var(--gold); font-family: 'Tenor Sans', sans-serif; font-size: 1.5em; margin-top: 15px;">CONNEXION</h1>
            <p style="color: gray; font-size: 0.9em; margin: 5px 0 0 0;">Accès réservé à l'équipe CafThé</p>
        </div>

        <!-- Message d'erreur éventuel -->
        <?php if (!empty($erreur)): ?>
            <div style="background-color: #5a2a2a; color: #ff9999; padding: 10px 12px; border-radius: 5px; margin-bottom: 20px; font-size: 0.9em;">
                <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($erreur) ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire de connexion -->
        <form action="/Cafthe_Dashboard/Public/login" method="POST">
            
            <div style="margin-bottom: 15px;">
                <label for="email" style="display: block; margin-bottom: 6px; font-size: 0.9em;">Adresse email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($emailSaisi ?? '') ?>" required style="width: 100%; padding: 10px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 25px;">
                <label for="mot_de_passe" style="display: block; margin-bottom: 6px; font-size: 0.9em;">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required style="width: 100%; padding: 10px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
            </div>

            <button type="submit" style="background-color: var(--gold); color: #1A1A1A; padding: 11px 20px; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-weight: bold; font-size: 1em;">
                SE CONNECTER
            </button>

        </form>
    </div>

</body>
</html>