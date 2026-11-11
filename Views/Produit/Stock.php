<!-- Views/Produit/Stock.php -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1 style="color: var(--text-light); font-family: 'Tenor Sans', sans-serif;">STOCK</h1>
    <a href="/Cafthe_Dashboard/Public/produits/creer" style="background-color: var(--green); color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; font-weight: bold;">+ AJOUTER UN PRODUIT</a>
</div>

<table style="width: 100%; border-collapse: collapse; text-align: left; color: var(--text-light); font-size: 0.9em;">
    <thead style="border-bottom: 1px solid var(--gold); color: var(--gold);">
        <tr>
            <th style="padding: 10px;">IMAGE</th>
            <th style="padding: 10px;">SKU</th>
            <th style="padding: 10px;">NOM</th>
            <th style="padding: 10px;">TYPE VENTE</th>
            <th style="padding: 10px;">PRIX HT</th>
            <th style="padding: 10px;">TVA</th>
            <th style="padding: 10px;">PRIX TTC</th>
            <th style="padding: 10px;">STOCK</th>
            <th style="padding: 10px;">ACTIONS</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($produits as $produit): ?>
        <tr style="border-bottom: 1px solid #333;">
            <!-- IMAGE -->
            <td style="padding: 10px;">
                <?php if ($produit->getImages()): ?>
                    <img src="/Cafthe_Dashboard/Public/Assets/Images/<?= htmlspecialchars($produit->getImages()) ?>" alt="<?= htmlspecialchars($produit->getNom()) ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                <?php else: ?>
                    <div style="width: 50px; height: 50px; background-color: #333; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #888;">N/A</div>
                <?php endif; ?>
            </td>
            
            <!-- SKU -->
            <td style="padding: 10px;">REF-<?= htmlspecialchars((string)$produit->getId()) ?></td>
            
            <!-- NOM + CATEGORIE + DESCRIPTION -->
            <td style="padding: 10px; font-weight: bold;">
                <?= htmlspecialchars($produit->getNom()) ?><br>
                <span style="font-size: 0.8em; color: #aaa; font-weight: normal;">
                    <?= htmlspecialchars($produit->getCategorie()) ?> | 
                    <?= htmlspecialchars(substr((string)$produit->getDescription(), 0, 30)) ?>...
                </span>
            </td>
            
            <!-- TYPE DE VENTE -->
            <td style="padding: 10px;"><?= htmlspecialchars((string)$produit->getTypeVente()) ?></td>
            
            <!-- PRIX HT -->
            <td style="padding: 10px;"><?= number_format((float)$produit->getPrixHt(), 2, ',', ' ') ?> €</td>
            
            <!-- TVA -->
            <td style="padding: 10px;"><?= number_format((float)$produit->getTva(), 1, ',', ' ') ?> %</td>
            
            <!-- PRIX TTC -->
            <td style="padding: 10px;"><?= number_format((float)$produit->getPrixTtc(), 2, ',', ' ') ?> €</td>
            
            <!-- STOCK (avec alerte couleur) -->
            <td style="padding: 10px;">
                <span style="padding: 4px 8px; border-radius: 4px; <?= $produit->getStock() < 15 ? 'background-color: #5a2a2a; color: #ff9999;' : 'background-color: #2a5a2a; color: #99ff99;' ?>">
                    <?= htmlspecialchars((string)$produit->getStock()) ?>
                </span>
            </td>
            
            <!-- ACTIONS -->
            <td style="padding: 10px;">
                <a href="/Cafthe_Dashboard/Public/produits/editer?id=<?= $produit->getId() ?>" style="color: var(--gold); text-decoration: none; margin-right: 10px;">Modifier</a>
                <a href="/Cafthe_Dashboard/Public/produits/supprimer?id=<?= $produit->getId() ?>" onclick="return confirm('Êtes-vous sûr de vouloir désactiver ce produit ?');" style="color: red; text-decoration: none;">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>