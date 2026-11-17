<!-- Views/Dashboard/Accueil.php -->
<div style="margin-bottom: 20px;">
    <h1 style="color: var(--text-light); font-family: 'Tenor Sans', sans-serif;">ACCUEIL</h1>
</div>

<!-- SECTION 1 : Les 4 KPI principaux (Cartes) -->
<div style="display: flex; gap: 20px; margin-bottom: 30px;">
    
    <!-- CHIFFRE D'AFFAIRES -->
    <div style="flex: 1; background-color: var(--bg-sidebar); padding: 20px; border-radius: 8px; border-left: 4px solid var(--gold);">
        <p style="color: gray; margin: 0 0 10px 0; font-size: 0.9em; text-transform: uppercase;">Chiffre d'affaires</p>
        <h2 style="color: var(--gold); margin: 0; font-size: 2em;"><?= number_format((float)$caTotal, 2, ',', ' ') ?> €</h2>
        <small style="color: #99ff99;">Global à ce jour</small>
    </div>

    <!-- COMMANDES À TRAITER -->
    <div style="flex: 1; background-color: var(--bg-sidebar); padding: 20px; border-radius: 8px; border-left: 4px solid var(--gold);">
        <p style="color: gray; margin: 0 0 10px 0; font-size: 0.9em; text-transform: uppercase;">Commandes</p>
        <h2 style="color: var(--text-light); margin: 0; font-size: 2em;"><?= $nbCommandes ?></h2>
        <small style="color: <?= $nbCommandes > 0 ? '#ffcc00' : 'gray' ?>;">À traiter</small>
    </div>

    <!-- PANIER MOYEN -->
    <div style="flex: 1; background-color: var(--bg-sidebar); padding: 20px; border-radius: 8px; border-left: 4px solid var(--gold);">
        <p style="color: gray; margin: 0 0 10px 0; font-size: 0.9em; text-transform: uppercase;">Panier Moyen</p>
        <h2 style="color: var(--text-light); margin: 0; font-size: 2em;"><?= number_format((float)$panierMoyen, 2, ',', ' ') ?> €</h2>
        <small style="color: gray;">Sur toutes les commandes</small>
    </div>

    <!-- CLIENTS -->
    <div style="flex: 1; background-color: var(--bg-sidebar); padding: 20px; border-radius: 8px; border-left: 4px solid var(--gold);">
        <p style="color: gray; margin: 0 0 10px 0; font-size: 0.9em; text-transform: uppercase;">Total Clients</p>
        <h2 style="color: var(--text-light); margin: 0; font-size: 2em;"><?= $nbClients ?></h2>
        <small style="color: gray;">Inscrits en base</small>
    </div>

</div>

<!-- SECTION 2 : Graphiques et Listes -->
<div style="display: flex; gap: 20px;">
    
    <!-- Colonne Principale (Graphiques & Dernières commandes) -->
    <div style="flex: 2; display: flex; flex-direction: column; gap: 20px;">
        
        <!-- Espace Graphique factice (En attente de JS) -->
        <div style="background-color: var(--bg-sidebar); padding: 20px; border-radius: 8px; min-height: 250px; display: flex; align-items: center; justify-content: center; border: 1px dashed #444;">
            <p style="color: gray;">[ Emplacement Graphique : Évolution du Chiffre d'Affaires ]</p>
        </div>

        <!-- Dernières Commandes (Dynamique) -->
        <div style="background-color: var(--bg-sidebar); padding: 20px; border-radius: 8px;">
            <h3 style="color: var(--gold); margin-top: 0;">DERNIÈRES COMMANDES</h3>
            <table style="width: 100%; border-collapse: collapse; text-align: left; color: var(--text-light); font-size: 0.9em;">
                <thead style="border-bottom: 1px solid var(--gold);">
                    <tr>
                        <th style="padding: 10px;">N°</th>
                        <th style="padding: 10px;">CLIENT</th>
                        <th style="padding: 10px;">MONTANT</th>
                        <th style="padding: 10px;">STATUT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($dernieresCommandes)): ?>
                        <tr><td colspan="4" style="padding: 10px; color: gray;">Aucune commande pour le moment.</td></tr>
                    <?php else: ?>
                        <?php foreach ($dernieresCommandes as $cmd): ?>
                        <tr style="border-bottom: 1px solid #333;">
                            <td style="padding: 10px;">CMD-<?= htmlspecialchars((string)$cmd['ID_COMMANDE']) ?></td>
                            <td style="padding: 10px;"><?= htmlspecialchars($cmd['NOM_CLIENT'] . ' ' . $cmd['PRENOM_CLIENT']) ?></td>
                            <td style="padding: 10px;"><?= number_format((float)$cmd['MONTANT_TOTAL'], 2, ',', ' ') ?> €</td>
                            <td style="padding: 10px;">
                                <!-- Changement de couleur selon le statut -->
                                <?php 
                                    $bgColor = '#333'; $color = 'white';
                                    if ($cmd['STATUT_COMMANDE'] === 'En attente') { $bgColor = '#5a4a2a'; $color = '#ffcc00'; }
                                    elseif ($cmd['STATUT_COMMANDE'] === 'Livrée') { $bgColor = '#2a5a2a'; $color = '#99ff99'; }
                                ?>
                                <span style="background-color: <?= $bgColor ?>; color: <?= $color ?>; padding: 2px 6px; border-radius: 4px; font-size: 0.9em;">
                                    <?= htmlspecialchars((string)$cmd['STATUT_COMMANDE']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Colonne Latérale (Top 10 et Alertes) -->
    <div style="flex: 1; display: flex; flex-direction: column; gap: 20px;">
        
        <!-- Top Produits (Laissé statique pour l'instant) -->
        <div style="background-color: var(--bg-sidebar); padding: 20px; border-radius: 8px;">
            <h3 style="color: var(--gold); margin-top: 0;">TOP PRODUITS</h3>
            <ul style="list-style: none; padding: 0; margin: 0; color: var(--text-light); font-size: 0.9em;">
                <li style="padding: 8px 0; border-bottom: 1px solid #333; display: flex; justify-content: space-between;">
                    <span>Café Éclat Matinal</span> <strong>26 Ventes</strong>
                </li>
                <li style="padding: 8px 0; border-bottom: 1px solid #333; display: flex; justify-content: space-between;">
                    <span>L'éveil du Volcan</span> <strong>18 Ventes</strong>
                </li>
            </ul>
        </div>

        <!-- Alertes Stocks (Dynamique) -->
        <div style="background-color: var(--bg-sidebar); padding: 20px; border-radius: 8px; border: 1px solid #ff4c4c;">
            <h3 style="color: #ff4c4c; margin-top: 0;"><i class="fa-solid fa-triangle-exclamation"></i> ALERTES STOCK (< 15)</h3>
            <ul style="list-style: none; padding: 0; margin: 0; color: var(--text-light); font-size: 0.9em;">
                <?php if (empty($alertesStock)): ?>
                    <li style="padding: 8px 0; color: gray;">Aucune alerte, les stocks sont bons !</li>
                <?php else: ?>
                    <?php foreach ($alertesStock as $alerte): ?>
                    <li style="padding: 8px 0; border-bottom: 1px solid #333;">
                        <strong><?= htmlspecialchars((string)$alerte['NOM_PRODUIT']) ?></strong> <br>
                        <span style="color: gray;">Stock actuel : </span> 
                        <span style="color: #ff4c4c; font-weight: bold;"><?= htmlspecialchars((string)$alerte['STOCK']) ?></span>
                    </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>

    </div>
</div>