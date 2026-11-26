
<div style="margin-bottom: 20px;">
    <h1 style="color: var(--text-light); font-family: 'Tenor Sans', sans-serif;">CLIENTS</h1>
    <p style="color: gray; margin: 5px 0 0 0;">Répertoire des clients particuliers et professionnels</p>
</div>

<?php if (!empty($messageSucces)): ?>
    <div style="background-color: #2a5a2a; color: #99ff99; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; max-width: 1200px;">
        <i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($messageSucces, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<?php if (!empty($messageErreur)): ?>
    <div style="background-color: #5a2a2a; color: #ff9999; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; max-width: 1200px;">
        <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($messageErreur, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<?php $estEdition = ($clientAEditer !== null); ?>

<div style="display: flex; gap: 25px; flex-wrap: wrap; align-items: flex-start;">

    <!-- Formulaire Ajout / Modification -->
    <form action="<?= $estEdition ? '/Cafthe_Dashboard/Public/clients/modifier?id=' . (int)$clientAEditer->getId() : '/Cafthe_Dashboard/Public/clients/creer' ?>" method="POST" style="flex: 1; min-width: 320px; max-width: 420px; background-color: var(--bg-sidebar); padding: 25px; border-radius: 8px; box-sizing: border-box;">
        <h2 style="color: var(--gold); margin-top: 0; font-size: 1.1em;">
            <?= $estEdition ? 'MODIFIER UN CLIENT' : 'NOUVEAU CLIENT' ?>
        </h2>

        <div style="margin-bottom: 12px;">
            <label for="prenom" style="display: block; margin-bottom: 4px; font-size: 0.9em;">Prénom *</label>
            <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($estEdition ? $clientAEditer->getPrenom() : '', ENT_QUOTES, 'UTF-8') ?>" required style="width: 100%; padding: 8px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 12px;">
            <label for="nom" style="display: block; margin-bottom: 4px; font-size: 0.9em;">Nom *</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($estEdition ? $clientAEditer->getNom() : '', ENT_QUOTES, 'UTF-8') ?>" required style="width: 100%; padding: 8px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 12px;">
            <label for="email" style="display: block; margin-bottom: 4px; font-size: 0.9em;">Email *</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($estEdition ? $clientAEditer->getEmail() : '', ENT_QUOTES, 'UTF-8') ?>" required style="width: 100%; padding: 8px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 12px;">
            <label for="telephone" style="display: block; margin-bottom: 4px; font-size: 0.9em;">Téléphone</label>
            <input type="text" id="telephone" name="telephone" value="<?= htmlspecialchars($estEdition ? $clientAEditer->getTelephone() : '', ENT_QUOTES, 'UTF-8') ?>" style="width: 100%; padding: 8px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 12px;">
            <label for="adresse_facturation" style="display: block; margin-bottom: 4px; font-size: 0.9em;">Adresse de facturation</label>
            <input type="text" id="adresse_facturation" name="adresse_facturation" value="<?= htmlspecialchars($estEdition ? $clientAEditer->getAdresseFacturation() : '', ENT_QUOTES, 'UTF-8') ?>" style="width: 100%; padding: 8px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
        </div>

        <div style="display: flex; gap: 10px; margin-bottom: 12px;">
            <div style="flex: 1;">
                <label for="cp_facturation" style="display: block; margin-bottom: 4px; font-size: 0.9em;">CP</label>
                <input type="text" id="cp_facturation" name="cp_facturation" maxlength="5" value="<?= htmlspecialchars($estEdition ? $clientAEditer->getCpFacturation() : '', ENT_QUOTES, 'UTF-8') ?>" style="width: 100%; padding: 8px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
            </div>
            <div style="flex: 2;">
                <label for="ville_facturation" style="display: block; margin-bottom: 4px; font-size: 0.9em;">Ville</label>
                <input type="text" id="ville_facturation" name="ville_facturation" value="<?= htmlspecialchars($estEdition ? $clientAEditer->getVilleFacturation() : '', ENT_QUOTES, 'UTF-8') ?>" style="width: 100%; padding: 8px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
            </div>
        </div>

        <div style="margin-bottom: 12px;">
            <label for="adresse_livraison" style="display: block; margin-bottom: 4px; font-size: 0.9em;">Adresse de livraison</label>
            <input type="text" id="adresse_livraison" name="adresse_livraison" value="<?= htmlspecialchars($estEdition ? $clientAEditer->getAdresseLivraison() : '', ENT_QUOTES, 'UTF-8') ?>" style="width: 100%; padding: 8px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
        </div>

        <div style="display: flex; gap: 10px; margin-bottom: 18px;">
            <div style="flex: 1;">
                <label for="cp_livraison" style="display: block; margin-bottom: 4px; font-size: 0.9em;">CP liv.</label>
                <input type="text" id="cp_livraison" name="cp_livraison" maxlength="5" value="<?= htmlspecialchars($estEdition ? $clientAEditer->getCpLivraison() : '', ENT_QUOTES, 'UTF-8') ?>" style="width: 100%; padding: 8px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
            </div>
            <div style="flex: 2;">
                <label for="ville_livraison" style="display: block; margin-bottom: 4px; font-size: 0.9em;">Ville liv.</label>
                <input type="text" id="ville_livraison" name="ville_livraison" value="<?= htmlspecialchars($estEdition ? $clientAEditer->getVilleLivraison() : '', ENT_QUOTES, 'UTF-8') ?>" style="width: 100%; padding: 8px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
            </div>
        </div>

        <button type="submit" style="background-color: var(--gold); color: #1A1A1A; padding: 10px 16px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%;">
            <?= $estEdition ? 'ENREGISTRER LES MODIFICATIONS' : 'AJOUTER LE CLIENT' ?>
        </button>

        <?php if ($estEdition): ?>
            <a href="/Cafthe_Dashboard/Public/clients" style="display: block; text-align: center; margin-top: 10px; color: gray; text-decoration: none; font-size: 0.9em;">Annuler la modification</a>
        <?php endif; ?>
    </form>

    <!-- Liste et recherche des clients -->
    <div style="flex: 2; min-width: 450px; background-color: var(--bg-sidebar); padding: 25px; border-radius: 8px; box-sizing: border-box;">
        <div style="display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 15px;">
            <h2 style="color: var(--gold); margin: 0; font-size: 1.1em;">LISTE DES CLIENTS (<?= count($clients) ?>)</h2>
            <form action="/Cafthe_Dashboard/Public/clients" method="GET" style="display: flex; gap: 8px;">
                <input type="text" name="q" value="<?= htmlspecialchars($recherche ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="Nom, email, ville..." style="padding: 7px 10px; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
                <button type="submit" style="background-color: var(--gold); color: #1A1A1A; padding: 7px 12px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Filtrer</button>
            </form>
        </div>

        <table style="width: 100%; border-collapse: collapse; text-align: left; color: var(--text-light); font-size: 0.9em;">
            <thead style="border-bottom: 1px solid var(--gold);">
                <tr>
                    <th style="padding: 10px;">CLIENT</th>
                    <th style="padding: 10px;">EMAIL</th>
                    <th style="padding: 10px;">VILLE</th>
                    <th style="padding: 10px;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($clients)): ?>
                    <tr><td colspan="4" style="padding: 12px; color: gray;">Aucun client trouvé.</td></tr>
                <?php else: ?>
                    <?php foreach ($clients as $c): ?>
                        <tr style="border-bottom: 1px solid #333;">
                            <td style="padding: 10px;">
                                <?= htmlspecialchars($c->getPrenom() . ' ' . $c->getNom(), ENT_QUOTES, 'UTF-8') ?>
                                <?php if ($c->getIdEmploye() !== null): ?>
                                    <span style="margin-left: 6px; font-size: 0.78em; color: var(--gold);">[Pro]</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 10px;"><?= htmlspecialchars($c->getEmail(), ENT_QUOTES, 'UTF-8') ?></td>
                            <td style="padding: 10px;"><?= htmlspecialchars($c->getVilleFacturation(), ENT_QUOTES, 'UTF-8') ?></td>
                            <td style="padding: 10px; white-space: nowrap;">
                                <a href="/Cafthe_Dashboard/Public/clients/details?id=<?= (int)$c->getId() ?>" style="color: var(--text-light); text-decoration: none; margin-right: 12px;">
                                    <i class="fa-solid fa-eye"></i> Fiche
                                </a>
                                <a href="/Cafthe_Dashboard/Public/clients/editer?id=<?= (int)$c->getId() ?>" style="color: var(--gold); text-decoration: none;">
                                    <i class="fa-solid fa-pen"></i> Modifier
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>