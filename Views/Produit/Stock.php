<!-- Views/Produit/Stock.php -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1 style="color: var(--text-light); font-family: 'Tenor Sans', sans-serif;">STOCK</h1>
    <a href="/Cafthe_Dashboard/Public/produits/creer" style="background-color: var(--green); color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; font-weight: bold;">+ AJOUTER UN PRODUIT</a>
</div>

<table style="width: 100%; border-collapse: collapse; text-align: left; color: var(--text-light); font-size: 0.8em;">
    <thead style="border-bottom: 1px solid var(--gold); color: var(--gold);">
        <tr>
            <th style="padding: 8px;">IMAGE</th>
            <th style="padding: 8px;">SKU</th>
            <th style="padding: 8px;">NOM</th>
            <th style="padding: 8px;">CATÉGORIE</th>
            <th style="padding: 8px;">TYPE</th> <!-- NOUVELLE COLONNE -->
            <th style="padding: 8px;">DESCRIPTION</th>
            <th style="padding: 8px;">TYPE VENTE</th>
            <th style="padding: 8px;">PRIX HT</th>
            <th style="padding: 8px;">TVA</th>
            <th style="padding: 8px;">PRIX TTC</th>
            <th style="padding: 8px;">STOCK</th>
            <th style="padding: 8px;">ACTIONS</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($produits as $produit): ?>
        <tr style="border-bottom: 1px solid #333;">
            <!-- IMAGE -->
            <td style="padding: 8px;">
                <?php if ($produit->getImages()): ?>
                    <img src="/Cafthe_Dashboard/Public/Assets/Images/<?= htmlspecialchars($produit->getImages()) ?>" alt="<?= htmlspecialchars($produit->getNom()) ?>" style="width: 45px; height: 45px; object-fit: cover; border-radius: 4px;">
                <?php else: ?>
                    <div style="width: 45px; height: 45px; background-color: #333; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 9px; color: #888;">N/A</div>
                <?php endif; ?>
            </td>
            
            <!-- SKU -->
            <td style="padding: 8px;">REF-<?= htmlspecialchars((string)$produit->getId()) ?></td>
            
            <!-- NOM -->
            <td style="padding: 8px; font-weight: bold;"><?= htmlspecialchars($produit->getNom()) ?></td>

            <!-- CATÉGORIE -->
            <td style="padding: 8px;"><?= htmlspecialchars($produit->getCategorie()) ?></td>

            <!-- TYPE (Grains, Moulu, etc.) -->
            <td style="padding: 8px;"><?= htmlspecialchars((string)$produit->getType()) ?></td>

            <!-- DESCRIPTION -->
            <td style="padding: 8px; color: #aaa;"><?= htmlspecialchars(substr((string)$produit->getDescription(), 0, 30)) ?>...</td>
            
            <!-- TYPE DE VENTE -->
            <td style="padding: 8px;"><?= htmlspecialchars((string)$produit->getTypeVente()) ?></td>
            
            <!-- PRIX HT -->
            <td style="padding: 8px;"><?= number_format((float)$produit->getPrixHt(), 2, ',', ' ') ?> €</td>
            
            <!-- TVA -->
            <td style="padding: 8px;"><?= number_format((float)$produit->getTva(), 1, ',', ' ') ?> %</td>
            
            <!-- PRIX TTC -->
            <td style="padding: 8px;"><?= number_format((float)$produit->getPrixTtc(), 2, ',', ' ') ?> €</td>
            
            <!-- STOCK -->
            <td style="padding: 8px;">
                <span style="padding: 4px 6px; border-radius: 4px; <?= $produit->getStock() < 15 ? 'background-color: #5a2a2a; color: #ff9999;' : 'background-color: #2a5a2a; color: #99ff99;' ?>">
                    <?= htmlspecialchars((string)$produit->getStock()) ?>
                </span>
            </td>
            
            <!-- ACTIONS -->
            <td style="padding: 8px;">
                <a href="/Cafthe_Dashboard/Public/produits/editer?id=<?= $produit->getId() ?>" style="color: var(--gold); text-decoration: none; margin-right: 8px;">Modifier</a>
                <a href="/Cafthe_Dashboard/Public/produits/supprimer?id=<?= $produit->getId() ?>" onclick="return confirm('Êtes-vous sûr ?');" style="color: red; text-decoration: none;">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>