<!-- Views/Client/DetailsClient.php -->
<div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
    <div>
        <h1 style="color: var(--text-light); font-family: 'Tenor Sans', sans-serif; margin: 0;">
            <?= htmlspecialchars($client->getPrenom() . ' ' . $client->getNom(), ENT_QUOTES, 'UTF-8') ?>
        </h1>
        <p style="color: gray; margin: 5px 0 0 0;">
            <?= htmlspecialchars($client->getEmail(), ENT_QUOTES, 'UTF-8') ?>
            <?php if ($client->getTelephone() !== ''): ?>
                — <?= htmlspecialchars($client->getTelephone(), ENT_QUOTES, 'UTF-8') ?>
            <?php endif; ?>
        </p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="/Cafthe_Dashboard/Public/clients/editer?id=<?= (int)$client->getId() ?>" style="background-color: var(--gold); color: #1A1A1A; padding: 8px 14px; border-radius: 4px; text-decoration: none; font-weight: bold; font-size: 0.9em;">
            Modifier la fiche
        </a>
        <a href="/Cafthe_Dashboard/Public/clients" style="color: var(--text-light); padding: 8px 14px; border: 1px solid #555; border-radius: 4px; text-decoration: none; font-size: 0.9em;">
            Retour à la liste
        </a>
    </div>
</div>

<!-- Statistiques personnalisées -->
<div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 25px;">
    <div style="flex: 1; min-width: 200px; background-color: var(--bg-sidebar); padding: 18px; border-radius: 8px; border-left: 4px solid var(--gold);">
        <p style="color: gray; margin: 0 0 6px 0; font-size: 0.85em; text-transform: uppercase;">Commandes passées</p>
        <h2 style="color: var(--text-light); margin: 0; font-size: 1.8em;"><?= (int)($stats['nb_commandes'] ?? 0) ?></h2>
    </div>

    <div style="flex: 1; min-width: 200px; background-color: var(--bg-sidebar); padding: 18px; border-radius: 8px; border-left: 4px solid var(--gold);">
        <p style="color: gray; margin: 0 0 6px 0; font-size: 0.85em; text-transform: uppercase;">Panier moyen</p>
        <h2 style="color: var(--gold); margin: 0; font-size: 1.8em;"><?= number_format((float)($stats['panier_moyen'] ?? 0), 2, ',', ' ') ?> €</h2>
    </div>

    <div style="flex: 2; min-width: 260px; background-color: var(--bg-sidebar); padding: 18px; border-radius: 8px;">
        <h3 style="color: var(--gold); margin: 0 0 10px 0; font-size: 1em;">PRODUITS FAVORIS</h3>
        <?php if (empty($produitsFavoris)): ?>
            <p style="color: gray; margin: 0; font-size: 0.9em;">Aucun produit acheté pour ce client.</p>
        <?php else: ?>
            <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.9em;">
                <?php foreach ($produitsFavoris as $fav): ?>
                    <li style="padding: 4px 0; border-bottom: 1px solid #333; display: flex; justify-content: space-between;">
                        <span><?= htmlspecialchars((string)$fav['NOM_PRODUIT'], ENT_QUOTES, 'UTF-8') ?></span>
                        <strong><?= (int)$fav['qte_totale'] ?></strong>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<!-- Historique unifié des commandes -->
<div style="background-color: var(--bg-sidebar); padding: 22px; border-radius: 8px;">
    <h3 style="color: var(--gold); margin-top: 0;">HISTORIQUE DES ACHATS</h3>
    <table style="width: 100%; border-collapse: collapse; text-align: left; color: var(--text-light); font-size: 0.9em;">
        <thead style="border-bottom: 1px solid var(--gold);">
            <tr>
                <th style="padding: 10px;">N° COMMANDE</th>
                <th style="padding: 10px;">DATE</th>
                <th style="padding: 10px;">CANAL</th>
                <th style="padding: 10px;">MONTANT</th>
                <th style="padding: 10px;">STATUT</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($commandes)): ?>
                <tr><td colspan="5" style="padding: 12px; color: gray;">Aucune commande enregistrée.</td></tr>
            <?php else: ?>
                <?php foreach ($commandes as $cmd): ?>
                    <tr style="border-bottom: 1px solid #333;">
                        <td style="padding: 10px;">CMD-<?= (int)$cmd['ID_COMMANDE'] ?></td>
                        <td style="padding: 10px;"><?= htmlspecialchars((string)($cmd['DATE_COMMANDE'] ?? '-'), ENT_QUOTES, 'UTF-8') ?></td>
                        <td style="padding: 10px;"><?= htmlspecialchars((string)($cmd['MODE_COMMANDE'] ?? 'Standard'), ENT_QUOTES, 'UTF-8') ?></td>
                        <td style="padding: 10px;"><?= number_format((float)$cmd['MONTANT_TOTAL'], 2, ',', ' ') ?> €</td>
                        <td style="padding: 10px;"><?= htmlspecialchars((string)($cmd['STATUT_COMMANDE'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>