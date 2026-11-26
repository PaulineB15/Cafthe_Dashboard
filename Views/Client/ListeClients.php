<div class="entete-page">
    <h1 class="titre-page">CLIENTS</h1>
    <p class="sous-titre-page">Répertoire des clients</p>
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

<?php $estEdition = ($clientAEditer !== null); ?>

<div class="grille-deux-colonnes">

    <!-- Formulaire Ajout / Modification -->
    <form action="<?= $estEdition ? '/Cafthe_Dashboard/Public/clients/modifier?id=' . (int)$clientAEditer->getId() : '/Cafthe_Dashboard/Public/clients/creer' ?>" method="POST" class="formulaire-carte">
        <h2 class="titre-carte-petit">
            <?= $estEdition ? 'MODIFIER UN CLIENT' : 'NOUVEAU CLIENT' ?>
        </h2>

        <div class="groupe-champ">
            <label for="prenom" class="etiquette">Prénom *</label>
            <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($estEdition ? $clientAEditer->getPrenom() : '', ENT_QUOTES, 'UTF-8') ?>" required class="champ-sombre">
        </div>

        <div class="groupe-champ">
            <label for="nom" class="etiquette">Nom *</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($estEdition ? $clientAEditer->getNom() : '', ENT_QUOTES, 'UTF-8') ?>" required class="champ-sombre">
        </div>

        <div class="groupe-champ">
            <label for="email" class="etiquette">Email *</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($estEdition ? $clientAEditer->getEmail() : '', ENT_QUOTES, 'UTF-8') ?>" required class="champ-sombre">
        </div>

        <div class="groupe-champ">
            <label for="telephone" class="etiquette">Téléphone</label>
            <input type="text" id="telephone" name="telephone" value="<?= htmlspecialchars($estEdition ? $clientAEditer->getTelephone() : '', ENT_QUOTES, 'UTF-8') ?>" class="champ-sombre">
        </div>

        <div class="groupe-champ">
            <label for="adresse_facturation" class="etiquette">Adresse de facturation</label>
            <input type="text" id="adresse_facturation" name="adresse_facturation" value="<?= htmlspecialchars($estEdition ? $clientAEditer->getAdresseFacturation() : '', ENT_QUOTES, 'UTF-8') ?>" class="champ-sombre">
        </div>

        <div class="ligne-champs">
            <div class="col-1">
                <label for="cp_facturation" class="etiquette">CP</label>
                <input type="text" id="cp_facturation" name="cp_facturation" maxlength="5" value="<?= htmlspecialchars($estEdition ? $clientAEditer->getCpFacturation() : '', ENT_QUOTES, 'UTF-8') ?>" class="champ-sombre">
            </div>
            <div class="col-2">
                <label for="ville_facturation" class="etiquette">Ville</label>
                <input type="text" id="ville_facturation" name="ville_facturation" value="<?= htmlspecialchars($estEdition ? $clientAEditer->getVilleFacturation() : '', ENT_QUOTES, 'UTF-8') ?>" class="champ-sombre">
            </div>
        </div>

        <div class="groupe-champ">
            <label for="adresse_livraison" class="etiquette">Adresse de livraison</label>
            <input type="text" id="adresse_livraison" name="adresse_livraison" value="<?= htmlspecialchars($estEdition ? $clientAEditer->getAdresseLivraison() : '', ENT_QUOTES, 'UTF-8') ?>" class="champ-sombre">
        </div>

        <div class="ligne-champs">
            <div class="col-1">
                <label for="cp_livraison" class="etiquette">CP liv.</label>
                <input type="text" id="cp_livraison" name="cp_livraison" maxlength="5" value="<?= htmlspecialchars($estEdition ? $clientAEditer->getCpLivraison() : '', ENT_QUOTES, 'UTF-8') ?>" class="champ-sombre">
            </div>
            <div class="col-2">
                <label for="ville_livraison" class="etiquette">Ville liv.</label>
                <input type="text" id="ville_livraison" name="ville_livraison" value="<?= htmlspecialchars($estEdition ? $clientAEditer->getVilleLivraison() : '', ENT_QUOTES, 'UTF-8') ?>" class="champ-sombre">
            </div>
        </div>

        <button type="submit" class="bouton-or-plein">
            <?= $estEdition ? 'ENREGISTRER LES MODIFICATIONS' : 'AJOUTER LE CLIENT' ?>
        </button>

        <?php if ($estEdition): ?>
            <a href="/Cafthe_Dashboard/Public/clients" class="lien-annuler">Annuler la modification</a>
        <?php endif; ?>
    </form>

    <!-- Liste et recherche des clients -->
    <div class="carte-spacieuse carte-tableau-clients">
        <div class="entete-recherche">
            <h2 class="titre-carte-petit">LISTE DES CLIENTS (<?= count($clients) ?>)</h2>
            <form action="/Cafthe_Dashboard/Public/clients" method="GET" class="formulaire-recherche">
                <input type="text" name="q" value="<?= htmlspecialchars($recherche ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="Nom, prénom, email..." class="champ-sombre">
                <button type="submit" class="bouton-or">Filtrer</button>
            </form>
        </div>

        <table class="tableau">
            <thead>
                <tr>
                    <th>CLIENT</th>
                    <th>EMAIL</th>
                    <th>VILLE</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($clients)): ?>
                    <tr><td colspan="4" class="tableau-vide">Aucun client trouvé.</td></tr>
                <?php else: ?>
                    <?php foreach ($clients as$c): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($c->getPrenom() . ' ' .$c->getNom(), ENT_QUOTES, 'UTF-8') ?>
                                <?php if ($c->getIdEmploye() !== null): ?>
                                    <span class="badge-pro">[Pro]</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($c->getEmail(), ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($c->getVilleFacturation(), ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="colonne-actions">
                                <a href="/Cafthe_Dashboard/Public/clients/details?id=<?= (int)$c->getId() ?>" class="lien-action-clair">
                                    <i class="fa-solid fa-eye"></i> Fiche
                                </a>
                                <a href="/Cafthe_Dashboard/Public/clients/editer?id=<?= (int)$c->getId() ?>" class="lien-action-or">
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