<!-- Affichage de la ma page " Mon Profil" -->
<div class="entete-page">
    <h1 class="titre-page">MON PROFIL</h1>
    <p class="sous-titre-page">Rôle actuel : <strong class="texte-or"><?= htmlspecialchars($employe->getRole(), ENT_QUOTES, 'UTF-8') ?></strong></p>
</div>

<?php if (!empty($messageSucces)): ?>
    <div class="alerte-succes">
        <i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($messageSucces, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<?php if (!empty($messageErreur)): ?>
    <div class="alerte-erreur">
        <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($messageErreur, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<div class="grille-profil">

    <!-- Bloc 1 : Informations personnelles -->
    <form action="/Cafthe_Dashboard/Public/profil/infos" method="POST" class="formulaire-profil">
        <h2 class="titre-carte-petit">INFORMATIONS PERSONNELLES</h2>

        <div class="groupe-champ">
            <label for="prenom" class="etiquette">Prénom *</label>
            <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($employe->getPrenom(), ENT_QUOTES, 'UTF-8') ?>" required class="champ-sombre">
        </div>

        <div class="groupe-champ">
            <label for="nom" class="etiquette">Nom *</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($employe->getNom(), ENT_QUOTES, 'UTF-8') ?>" required class="champ-sombre">
        </div>

        <div class="groupe-champ-large">
            <label for="email" class="etiquette">Adresse email *</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($employe->getEmail(), ENT_QUOTES, 'UTF-8') ?>" required class="champ-sombre">
        </div>

        <button type="submit" class="bouton-or-plein">
            ENREGISTRER LES INFOS
        </button>
    </form>

    <!-- Bloc 2 : Modification du mot de passe -->
    <form action="/Cafthe_Dashboard/Public/profil/mot-de-passe" method="POST" class="formulaire-profil">
        <h2 class="titre-carte-petit">MODIFIER LE MOT DE PASSE</h2>

        <div class="groupe-champ">
            <label for="ancien_mot_de_passe" class="etiquette">Ancien mot de passe *</label>
            <input type="password" id="ancien_mot_de_passe" name="ancien_mot_de_passe" required class="champ-sombre">
        </div>

        <div class="groupe-champ">
            <label for="nouveau_mot_de_passe" class="etiquette">Nouveau mot de passe (16 car. min. + caractères spéciaux) *</label>
            <input type="password" id="nouveau_mot_de_passe" name="nouveau_mot_de_passe" required class="champ-sombre">
        </div>

        <div class="groupe-champ-large">
            <label for="confirmation_mot_de_passe" class="etiquette">Confirmer le nouveau mot de passe *</label>
            <input type="password" id="confirmation_mot_de_passe" name="confirmation_mot_de_passe" required class="champ-sombre">
        </div>

        <button type="submit" class="bouton-vert-plein">
            METTRE À JOUR LE MOT DE PASSE
        </button>
    </form>

</div>