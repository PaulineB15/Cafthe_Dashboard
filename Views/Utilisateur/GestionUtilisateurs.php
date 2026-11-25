<!-- Views/Utilisateur/GestionUtilisateurs.php -->
<div style="margin-bottom: 20px;">
    <h1 style="color: var(--text-light); font-family: 'Tenor Sans', sans-serif;">GESTION DES UTILISATEURS</h1>
    <p style="color: gray; margin: 5px 0 0 0;">Administration des comptes vendeurs et administrateurs</p>
</div>

<?php if (!empty($messageSucces)): ?>
    <div style="background-color: #2a5a2a; color: #99ff99; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; max-width: 1100px;">
        <i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($messageSucces, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<?php if (!empty($messageErreur)): ?>
    <div style="background-color: #5a2a2a; color: #ff9999; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; max-width: 1100px;">
        <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($messageErreur, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<div style="display: flex; gap: 25px; flex-wrap: wrap; align-items: flex-start;">

    <!-- Formulaire Création / Modification -->
    <?php $estEdition = ($employeAEditer !== null); ?>
    <form action="<?= $estEdition ? '/Cafthe_Dashboard/Public/utilisateurs/modifier?id=' . (int)$employeAEditer->getId() : '/Cafthe_Dashboard/Public/utilisateurs/creer' ?>" method="POST" style="flex: 1; min-width: 320px; max-width: 420px; background-color: var(--bg-sidebar); padding: 25px; border-radius: 8px; box-sizing: border-box;">
        <h2 style="color: var(--gold); margin-top: 0; font-size: 1.1em;">
            <?= $estEdition ? 'MODIFIER UN COMPTE' : 'CRÉER UN COMPTE EMPLOYÉ' ?>
        </h2>

        <div style="margin-bottom: 14px;">
            <label for="prenom" style="display: block; margin-bottom: 5px; font-size: 0.9em;">Prénom *</label>
            <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($estEdition ? $employeAEditer->getPrenom() : '', ENT_QUOTES, 'UTF-8') ?>" required style="width: 100%; padding: 8px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 14px;">
            <label for="nom" style="display: block; margin-bottom: 5px; font-size: 0.9em;">Nom *</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($estEdition ? $employeAEditer->getNom() : '', ENT_QUOTES, 'UTF-8') ?>" required style="width: 100%; padding: 8px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 14px;">
            <label for="email" style="display: block; margin-bottom: 5px; font-size: 0.9em;">Adresse email *</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($estEdition ? $employeAEditer->getEmail() : '', ENT_QUOTES, 'UTF-8') ?>" required style="width: 100%; padding: 8px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 14px;">
            <label for="role" style="display: block; margin-bottom: 5px; font-size: 0.9em;">Rôle *</label>
            <?php $roleCourant = $estEdition ? $employeAEditer->getRole() : 'Vendeur'; ?>
            <select id="role" name="role" required style="width: 100%; padding: 8px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
                <option value="Vendeur" <?= $roleCourant === 'Vendeur' ? 'selected' : '' ?>>Vendeur</option>
                <option value="Administrateur" <?= $roleCourant === 'Administrateur' ? 'selected' : '' ?>>Administrateur</option>
            </select>
        </div>

        <?php if (!$estEdition): ?>
            <div style="margin-bottom: 20px;">
                <label for="mot_de_passe" style="display: block; margin-bottom: 5px; font-size: 0.9em;">Mot de passe (16 car. min. + caractères spéciaux) *</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required style="width: 100%; padding: 8px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
            </div>
        <?php else: ?>
            <div style="margin-bottom: 20px;">
                <label for="nouveau_mot_de_passe" style="display: block; margin-bottom: 5px; font-size: 0.9em;">Nouveau mot de passe (optionnel)</label>
                <input type="password" id="nouveau_mot_de_passe" name="nouveau_mot_de_passe" style="width: 100%; padding: 8px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
                <small style="color: gray;">Laisser vide pour conserver le mot de passe actuel.</small>
            </div>
        <?php endif; ?>

        <button type="submit" style="background-color: var(--gold); color: #1A1A1A; padding: 10px 16px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%;">
            <?= $estEdition ? 'ENREGISTRER LES MODIFICATIONS' : 'CRÉER LE COMPTE' ?>
        </button>

        <?php if ($estEdition): ?>
            <a href="/Cafthe_Dashboard/Public/utilisateurs" style="display: block; text-align: center; margin-top: 10px; color: gray; text-decoration: none; font-size: 0.9em;">Annuler la modification</a>
        <?php endif; ?>
    </form>

    <!-- Tableau des employés -->
    <div style="flex: 2; min-width: 400px; background-color: var(--bg-sidebar); padding: 25px; border-radius: 8px; box-sizing: border-box;">
        <h2 style="color: var(--gold); margin-top: 0; font-size: 1.1em;">COMPTES EXISTANTS</h2>

        <table style="width: 100%; border-collapse: collapse; text-align: left; color: var(--text-light); font-size: 0.9em;">
            <thead style="border-bottom: 1px solid var(--gold);">
                <tr>
                    <th style="padding: 10px;">NOM COMPLET</th>
                    <th style="padding: 10px;">EMAIL</th>
                    <th style="padding: 10px;">RÔLE</th>
                    <th style="padding: 10px;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employes as $emp): ?>
                    <tr style="border-bottom: 1px solid #333;">
                        <td style="padding: 10px;"><?= htmlspecialchars($emp->getPrenom() . ' ' . $emp->getNom(), ENT_QUOTES, 'UTF-8') ?></td>
                        <td style="padding: 10px;"><?= htmlspecialchars($emp->getEmail(), ENT_QUOTES, 'UTF-8') ?></td>
                        <td style="padding: 10px;"><?= htmlspecialchars($emp->getRole(), ENT_QUOTES, 'UTF-8') ?></td>
                        <td style="padding: 10px; white-space: nowrap;">
                            <a href="/Cafthe_Dashboard/Public/utilisateurs/editer?id=<?= (int)$emp->getId() ?>" style="color: var(--gold); text-decoration: none; margin-right: 12px;">
                                <i class="fa-solid fa-pen"></i> Modifier
                            </a>
                            <?php if ((int)$emp->getId() !== (int)($_SESSION['employe']['id'] ?? 0)): ?>
                                <a href="/Cafthe_Dashboard/Public/utilisateurs/supprimer?id=<?= (int)$emp->getId() ?>" onclick="return confirm('Supprimer ce compte employé ?');" style="color: #ff6b6b; text-decoration: none;">
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