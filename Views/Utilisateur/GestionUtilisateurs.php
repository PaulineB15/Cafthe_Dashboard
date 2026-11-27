<!-- Views/Utilisateur/GestionUtilisateurs.php -->
<div class="entete-page">
    <h1 class="titre-page">GESTION DES UTILISATEURS</h1>
    <p class="sous-titre-page">Administration des comptes vendeurs et administrateurs</p>
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

<div class="grille-deux-colonnes">

    <!-- Formulaire Création / Modification -->
    <?php $estEdition = ($employeAEditer !== null); ?>
    <form action="<?= $estEdition ? '/Cafthe_Dashboard/Public/utilisateurs/modifier?id=' . (int)$employeAEditer->getId() : '/Cafthe_Dashboard/Public/utilisateurs/creer' ?>" method="POST" class="formulaire-carte">
        <h2 class="titre-carte-petit">
            <?= $estEdition ? 'MODIFIER UN COMPTE' : 'CRÉER UN COMPTE EMPLOYÉ' ?>
        </h2>

        <div class="groupe-champ">
            <label for="prenom" class="etiquette">Prénom *</label>
            <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($estEdition ? $employeAEditer->getPrenom() : '', ENT_QUOTES, 'UTF-8') ?>" required class="champ-sombre">
        </div>

        <div class="groupe-champ">
            <label for="nom" class="etiquette">Nom *</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($estEdition ? $employeAEditer->getNom() : '', ENT_QUOTES, 'UTF-8') ?>" required class="champ-sombre">
        </div>

        <div class="groupe-champ">
            <label for="email" class="etiquette">Adresse email *</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($estEdition ? $employeAEditer->getEmail() : '', ENT_QUOTES, 'UTF-8') ?>" required class="champ-sombre">
        </div>

        <div class="groupe-champ">
            <label for="role" class="etiquette">Rôle *</label>
            <?php $roleCourant = $estEdition ? $employeAEditer->getRole() : 'Vendeur'; ?>
            <select id="role" name="role" required class="champ-sombre">
                <option value="Vendeur" <?= $roleCourant === 'Vendeur' ? 'selected' : '' ?>>Vendeur</option>
                <option value="Administrateur" <?= $roleCourant === 'Administrateur' ? 'selected' : '' ?>>Administrateur</option>
            </select>
        </div>

        <?php if (!$estEdition): ?>
            <div class="groupe-champ-large">
                <label for="mot_de_passe" class="etiquette">Mot de passe (16 car. min. + caractères spéciaux) *</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required class="champ-sombre">
            </div>
        <?php else: ?>
            <div class="groupe-champ-large">
                <label for="nouveau_mot_de_passe" class="etiquette">Nouveau mot de passe (optionnel)</label>
                <input type="password" id="nouveau_mot_de_passe" name="nouveau_mot_de_passe" class="champ-sombre">
                <small class="texte-gris">Laisser vide pour conserver le mot de passe actuel.</small>
            </div>
        <?php endif; ?>

        <button type="submit" class="bouton-vert-plein">
            <?= $estEdition ? 'ENREGISTRER LES MODIFICATIONS' : 'CRÉER LE COMPTE' ?>
        </button>

        <?php if ($estEdition): ?>
            <a href="/Cafthe_Dashboard/Public/utilisateurs" class="lien-annuler">Annuler la modification</a>
        <?php endif; ?>
    </form>

    <!-- Tableau des employés -->
    <div class="carte-spacieuse carte-tableau-utilisateurs">
        <h2 class="titre-carte-petit">COMPTES EXISTANTS</h2>

        <table class="tableau">
            <thead>
                <tr>
                    <th>NOM COMPLET</th>
                    <th>EMAIL</th>
                    <th>RÔLE</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employes as $emp): ?>
                    <tr>
                        <td data-label="Nom complet"><?= htmlspecialchars($emp->getPrenom() . ' ' . $emp->getNom(), ENT_QUOTES, 'UTF-8') ?></td>
                        <td data-label="Email"><?= htmlspecialchars($emp->getEmail(), ENT_QUOTES, 'UTF-8') ?></td>
                        <td data-label="Rôle"><?= htmlspecialchars($emp->getRole(), ENT_QUOTES, 'UTF-8') ?></td>
                        <td data-label="Actions" class="colonne-actions">
                            <a href="/Cafthe_Dashboard/Public/utilisateurs/editer?id=<?= (int)$emp->getId() ?>" class="lien-action-or">
                                <i class="fa-solid fa-pen"></i> Modifier
                            </a>
                            <?php if ((int)$emp->getId() !== (int)($_SESSION['employe']['id'] ?? 0)): ?>
                                <a href="/Cafthe_Dashboard/Public/utilisateurs/supprimer?id=<?= (int)$emp->getId() ?>" onclick="return confirm('Supprimer ce compte employé ?');" class="lien-action-rouge">
                                    <i class="fa-solid fa-trash"></i> Supprimer
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>