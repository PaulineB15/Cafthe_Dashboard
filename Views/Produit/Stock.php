<!-- Views/Produit/Stock.php -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1 style="color: var(--text-light); font-family: 'Tenor Sans', sans-serif;">STOCK</h1>
    <a href="/Cafthe_Dashboard/Public/produits/creer" style="background-color: var(--green); color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; font-weight: bold;">+ AJOUTER UN PRODUIT</a>
</div>

<!-- BARRE DE RECHERCHE ET FILTRES AVANCÉS -->
<form method="GET" action="" style="background-color: var(--bg-sidebar); padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; gap: 15px; align-items: flex-end;">
    
    <div style="flex: 2;">
        <label style="display: block; margin-bottom: 5px; color: gray; font-size: 0.9em;">Rechercher (Nom ou Réf)</label>
        <input type="text" name="recherche" value="<?= htmlspecialchars($recherche ?? '') ?>" placeholder="Ex: Café, REF-5..." style="width: 100%; padding: 8px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
    </div>

    <div style="flex: 1;">
        <label style="display: block; margin-bottom: 5px; color: gray; font-size: 0.9em;">Catégorie</label>
        <select name="categorie" style="width: 100%; padding: 8px; box-sizing: border-box; background-color: #333; color: white; border: 1px solid #555; border-radius: 4px;">
            <option value="">Toutes les catégories</option>
            <option value="Café" <?= (isset($categorie) && $categorie === 'Café') ? 'selected' : '' ?>>Café</option>
            <option value="Thé" <?= (isset($categorie) && $categorie === 'Thé') ? 'selected' : '' ?>>Thé</option>
            <option value="Accessoire" <?= (isset($categorie) && $categorie === 'Accessoire') ? 'selected' : '' ?>>Accessoire</option>
            <option value="Coffret" <?= (isset($categorie) && $categorie === 'Coffret') ? 'selected' : '' ?>>Coffret</option>
        </select>
    </div>

    <div>
        <button type="submit" style="background-color: var(--gold); color: black; padding: 9px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;"><i class="fa-solid fa-magnifying-glass"></i> Filtrer</button>
        <a href="/Cafthe_Dashboard/Public/produits" style="display: inline-block; margin-left: 10px; color: gray; text-decoration: none; font-size: 0.9em;">Réinitialiser</a>
    </div>

</form>

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