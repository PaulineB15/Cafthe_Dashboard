<!-- Views/Client/DetailsClient.php -->
<div class="entete-page-actions">
    <div>
        <h1 class="titre-page">
            <?= htmlspecialchars($client->getPrenom() . ' ' . $client->getNom(), ENT_QUOTES, 'UTF-8') ?>
        </h1>
        <p class="sous-titre-page">
            <?= htmlspecialchars($client->getEmail(), ENT_QUOTES, 'UTF-8') ?>
            <?php if ($client->getTelephone() !== ''): ?>
                — <?= htmlspecialchars($client->getTelephone(), ENT_QUOTES, 'UTF-8') ?>
            <?php endif; ?>
        </p>
    </div>
    <div class="groupe-boutons">
        <a href="/Cafthe_Dashboard/Public/clients/editer?id=<?= (int)$client->getId() ?>" class="bouton-or">
            Modifier la fiche
        </a>
        <a href="/Cafthe_Dashboard/Public/clients" class="bouton-contour">
            Retour à la liste
        </a>
    </div>
</div>

<!-- Statistiques personnalisées -->
<div class="ligne-cartes">
    <div class="carte-kpi">
        <p class="kpi-label">Commandes passées</p>
        <h2 class="kpi-valeur"><?= (int)($stats['nb_commandes'] ?? 0) ?></h2>
    </div>

    <div class="carte-kpi">
        <p class="kpi-label">Panier moyen</p>
        <h2 class="kpi-valeur-or"><?= number_format((float)($stats['panier_moyen'] ?? 0), 2, ',', ' ') ?> €</h2>
    </div>

    <div class="carte carte-large">
        <h3 class="titre-carte">PRODUITS FAVORIS</h3>
        <?php if (empty($produitsFavoris)): ?>
            <p class="texte-gris">Aucun produit acheté pour ce client.</p>
        <?php else: ?>
            <ul class="liste-simple liste-espacee">
                <?php foreach ($produitsFavoris as $fav): ?>
                    <li>
                        <span><?= htmlspecialchars((string)$fav['NOM_PRODUIT'], ENT_QUOTES, 'UTF-8') ?></span>
                        <strong><?= (int)$fav['qte_totale'] ?></strong>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<!-- Historique unifié des commandes -->
<div class="carte">
    <h3 class="titre-carte">HISTORIQUE DES ACHATS</h3>
    <table class="tableau">
        <thead>
            <tr>
                <th>N° COMMANDE</th>
                <th>DATE</th>
                <th>CANAL</th>
                <th>MONTANT</th>
                <th>STATUT</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($commandes)): ?>
                <tr><td colspan="5" class="tableau-vide">Aucune commande enregistrée.</td></tr>
            <?php else: ?>
                <?php foreach ($commandes as $cmd): ?>
                    <tr>
                        <td>CMD-<?= (int)$cmd['ID_COMMANDE'] ?></td>
                        <td><?= htmlspecialchars((string)($cmd['DATE_COMMANDE'] ?? '-'), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string)($cmd['MODE_COMMANDE'] ?? 'Standard'), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= number_format((float)$cmd['MONTANT_TOTAL'], 2, ',', ' ') ?> €</td>
                        <td><?= htmlspecialchars((string)($cmd['STATUT_COMMANDE'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>