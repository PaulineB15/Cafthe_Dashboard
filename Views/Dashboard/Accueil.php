<!-- AFFICHAGE DU DASHBOARD -->

<div class="entete-page">
    <h1 class="titre-page">ACCUEIL</h1>
</div>

<!-- SECTION 1 : Les 4 KPI principaux (Cartes) -->
<div class="ligne-kpi">
    
    <!-- CHIFFRE D'AFFAIRES -->
    <div class="carte-kpi">
        <p class="kpi-label">Chiffre d'affaires</p>
        <h2 class="kpi-valeur-or"><?= number_format((float)$caTotal, 2, ',', ' ') ?> €</h2>
        <small class="texte-vert-clair">Global à ce jour</small>
    </div>

    <!-- COMMANDES À TRAITER -->
    <div class="carte-kpi">
        <p class="kpi-label">Commandes</p>
        <h2 class="kpi-valeur"><?= $nbCommandes ?></h2>
        <small class="<?= $nbCommandes > 0 ? 'texte-jaune' : 'texte-gris' ?>">À traiter</small>
    </div>

    <!-- PANIER MOYEN -->
    <div class="carte-kpi">
        <p class="kpi-label">Panier Moyen</p>
        <h2 class="kpi-valeur"><?= number_format((float)$panierMoyen, 2, ',', ' ') ?> €</h2>
        <small class="texte-gris">Sur toutes les commandes</small>
    </div>

    <!-- CLIENTS -->
    <div class="carte-kpi">
        <p class="kpi-label">Total Clients</p>
        <h2 class="kpi-valeur"><?= $nbClients ?></h2>
        <small class="texte-gris">Inscrits en base</small>
    </div>

</div>

<!-- SECTION 2 : Graphiques et Listes -->
<div class="ligne-cartes">
    
    <!-- Colonne Principale (Graphiques & Dernières commandes) -->
    <div class="colonne-principale">
        
        <!-- Espace Graphique factice (En attente de JS) -->
        <div class="zone-graphique">
            <p class="texte-gris">[ Emplacement Graphique : Évolution du Chiffre d'Affaires ]</p>
        </div>

        <!-- Dernières Commandes (Dynamique) -->
        <div class="carte">
            <h3 class="titre-carte">DERNIÈRES COMMANDES</h3>
            <table class="tableau">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>CLIENT</th>
                        <th>MONTANT</th>
                        <th>STATUT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($dernieresCommandes)): ?>
                        <tr><td colspan="4" class="tableau-vide">Aucune commande pour le moment.</td></tr>
                    <?php else: ?>
                        <?php foreach ($dernieresCommandes as $cmd): ?>
                        <tr>
                            <td data-label="N°">CMD-<?= htmlspecialchars((string)$cmd['ID_COMMANDE']) ?></td>
                            <td data-label="Client"><?= htmlspecialchars($cmd['NOM_CLIENT'] . ' ' . $cmd['PRENOM_CLIENT']) ?></td>
                            <td data-label="Montant"><?= number_format((float)$cmd['MONTANT_TOTAL'], 2, ',', ' ') ?> €</td>
                            <td data-label="Statut">
                                <!-- Changement de couleur selon le statut -->
                                <?php 
                                    $classeStatut = 'badge-defaut';
                                    if ($cmd['STATUT_COMMANDE'] === 'En attente') { $classeStatut = 'badge-attente'; }
                                    elseif ($cmd['STATUT_COMMANDE'] === 'Livrée') { $classeStatut = 'badge-succes'; }
                                ?>
                                <span class="badge <?= $classeStatut ?>">
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

    <!-- Top Produits (Dynamique) -->
        <div class="carte">
            <h3 class="titre-carte">TOP PRODUITS</h3>
            <ul class="liste-simple liste-espacee">
                <?php if (empty($topProduits)): ?>
                    <li class="texte-gris">Aucune vente enregistrée pour le moment.</li>
                <?php else: ?>
                    <?php foreach ($topProduits as $top): ?>
                        <?php $qte = (int)($top['total_ventes'] ?? 0); ?>
                        <li>
                            <span><?= htmlspecialchars((string)$top['NOM_PRODUIT'], ENT_QUOTES, 'UTF-8') ?></span>
                            <strong><?= $qte ?> <?= $qte > 1 ? 'Ventes' : 'Vente' ?></strong>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Alertes Stocks (Dynamique) -->
        <div class="carte-alerte-stock">
            <h3 class="titre-alerte-stock"><i class="fa-solid fa-triangle-exclamation"></i> ALERTES STOCK (&lt; 15)</h3>
            <ul class="liste-simple">
                <?php if (empty($alertesStock)): ?>
                    <li class="texte-gris">Aucune alerte, les stocks sont bons !</li>
                <?php else: ?>
                    <?php foreach ($alertesStock as $alerte): ?>
                    <li>
                        <strong><?= htmlspecialchars((string)$alerte['NOM_PRODUIT']) ?></strong> <br>
                        <span class="texte-gris">Stock actuel : </span> 
                        <span class="texte-rouge texte-gras"><?= htmlspecialchars((string)$alerte['STOCK']) ?></span>
                    </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>

    </div>
</div>