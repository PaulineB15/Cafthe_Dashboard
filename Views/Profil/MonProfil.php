<!-- Views/Profil/Index.php -->
<div style="margin-bottom: 20px;">
    <h1 style="color: var(--text-light); font-family: 'Tenor Sans', sans-serif;">MON PROFIL</h1>
    <p style="color: gray; margin: 5px 0 0 0;">Rôle actuel : <strong style="color: var(--gold);"><?= htmlspecialchars($employe->getRole(), ENT_QUOTES, 'UTF-8') ?></strong></p>
</div>

<?php if (!empty($messageSucces)): ?>
    <div style="background-color: #2a5a2a; color: #99ff99; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; max-width: 900px;">
        <i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($messageSucces, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<?php if (!empty($messageErreur)): ?>
    <div style="background-color: #5a2a2a; color: #ff9999; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; max-width: 900px;">
        <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($messageErreur, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<div style="display: flex; gap: 25px; flex-wrap: wrap; max-width: 950px;">

    <!-- Bloc 1 : Informations personnelles -->
    <form action="/Cafthe_Dashboard/Public/profil/infos" method="POST" style="flex: 1; min-width: 320px; background-color: var(--bg-sidebar); padding: 25px; border-radius: 8px; box-sizing: border-box;">
        <h2 style="color: var(--gold); margin-top: 0; font-size: 1.15em;">INFORMATIONS PERSONNELLES</h2>

        <div style="margin-bottom: 15px;">
            <label for="prenom" style="display: block; margin-bottom: 6px; font-size: 0.9em;">Prénom *</label>
            <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($employe->getPrenom(), ENT_QUOTES, 'UTF-8') ?>" required style="width: 100%; padding: 9px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="nom" style="display: block; margin-bottom: 6px; font-size: 0.9em;">Nom *</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($employe->getNom(), ENT_QUOTES, 'UTF-8') ?>" required style="width: 100%; padding: 9px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="email" style="display: block; margin-bottom: 6px; font-size: 0.9em;">Adresse email *</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($employe->getEmail(), ENT_QUOTES, 'UTF-8') ?>" required style="width: 100%; padding: 9px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
        </div>

        <button type="submit" style="background-color: var(--gold); color: #1A1A1A; padding: 10px 18px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%;">
            ENREGISTRER LES INFOS
        </button>
    </form>

    <!-- Bloc 2 : Modification du mot de passe -->
    <form action="/Cafthe_Dashboard/Public/profil/mot-de-passe" method="POST" style="flex: 1; min-width: 320px; background-color: var(--bg-sidebar); padding: 25px; border-radius: 8px; box-sizing: border-box;">
        <h2 style="color: var(--gold); margin-top: 0; font-size: 1.15em;">MODIFIER LE MOT DE PASSE</h2>

        <div style="margin-bottom: 15px;">
            <label for="ancien_mot_de_passe" style="display: block; margin-bottom: 6px; font-size: 0.9em;">Ancien mot de passe *</label>
            <input type="password" id="ancien_mot_de_passe" name="ancien_mot_de_passe" required style="width: 100%; padding: 9px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="nouveau_mot_de_passe" style="display: block; margin-bottom: 6px; font-size: 0.9em;">Nouveau mot de passe (8 caractères min.) *</label>
            <input type="password" id="nouveau_mot_de_passe" name="nouveau_mot_de_passe" required style="width: 100%; padding: 9px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="confirmation_mot_de_passe" style="display: block; margin-bottom: 6px; font-size: 0.9em;">Confirmer le nouveau mot de passe *</label>
            <input type="password" id="confirmation_mot_de_passe" name="confirmation_mot_de_passe" required style="width: 100%; padding: 9px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
        </div>

        <button type="submit" style="background-color: var(--green); color: white; padding: 10px 18px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%;">
            METTRE À JOUR LE MOT DE PASSE
        </button>
    </form>

</div>