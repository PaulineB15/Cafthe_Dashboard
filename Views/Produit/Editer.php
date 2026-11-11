<!-- Views/Produit/Editer.php -->
<div style="margin-bottom: 20px;">
    <h1 style="color: var(--gold); font-family: 'Tenor Sans', sans-serif;">MODIFIER LE PRODUIT</h1>
    <a href="/Cafthe_Dashboard/Public/produits" style="color: var(--text-light); text-decoration: none;">← Retour au stock</a>
</div>

<!-- L'URL contient l'ID du produit à modifier -->
<form action="/Cafthe_Dashboard/Public/produits/modifier?id=<?= $produit->getId() ?>" method="POST" style="background-color: var(--bg-sidebar); padding: 30px; border-radius: 8px; max-width: 600px;">
    
    <!-- Nom -->
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px;">Nom du produit *</label>
        <!-- On injecte la valeur avec htmlspecialchars -->
        <input type="text" name="nom" value="<?= htmlspecialchars($produit->getNom()) ?>" required style="width: 100%; padding: 8px; box-sizing: border-box;">
    </div>

    <!-- Catégorie et Type de vente (Côte à côte) -->
    <div style="margin-bottom: 15px; display: flex; gap: 15px;">
        <div style="flex: 1;">
            <label style="display: block; margin-bottom: 5px;">Catégorie *</label>
            <select name="categorie" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                <option value="Café" <?= $produit->getCategorie() === 'Café' ? 'selected' : '' ?>>Café</option>
                <option value="Thé" <?= $produit->getCategorie() === 'Thé' ? 'selected' : '' ?>>Thé</option>
                <option value="Accessoire" <?= $produit->getCategorie() === 'Accessoire' ? 'selected' : '' ?>>Accessoire</option>
                <option value="Coffret" <?= $produit->getCategorie() === 'Coffret' ? 'selected' : '' ?>>Coffret</option>
            </select>
        </div>
        <div style="flex: 1;">
            <label style="display: block; margin-bottom: 5px;">Type de vente *</label>
            <select name="type_vente" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                <option value="Unité" <?= $produit->getTypeVente() === 'Unité' ? 'selected' : '' ?>>Unité</option>
                <option value="Vrac" <?= $produit->getTypeVente() === 'Vrac' ? 'selected' : '' ?>>Vrac (au poids)</option>
            </select>
        </div>
    </div>

    <!-- Description -->
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px;">Description *</label>
        <!-- Pour un textarea, la valeur se met ENTRE les balises (sans espaces avant/après) -->
        <textarea name="description" required rows="3" style="width: 100%; padding: 8px; box-sizing: border-box;"><?= htmlspecialchars((string)$produit->getDescription()) ?></textarea>
    </div>

    <!-- Prix HT, TVA et Stock (Côte à côte) -->
    <div style="margin-bottom: 15px; display: flex; gap: 15px;">
        <div style="flex: 1;">
            <label style="display: block; margin-bottom: 5px;">Prix HT (€) *</label>
            <input type="number" step="0.01" name="prix_ht" value="<?= htmlspecialchars((string)$produit->getPrixHt()) ?>" required style="width: 100%; padding: 8px; box-sizing: border-box;">
        </div>
        <div style="flex: 1;">
            <label style="display: block; margin-bottom: 5px;">TVA (%) *</label>
            <select name="tva" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                <option value="5.5" <?= (float)$produit->getTva() === 5.5 ? 'selected' : '' ?>>5.5 % (Thé/Café)</option>
                <option value="20" <?= (float)$produit->getTva() === 20.0 ? 'selected' : '' ?>>20 % (Accessoires)</option>
            </select>
        </div>
        <div style="flex: 1;">
            <label style="display: block; margin-bottom: 5px;">Stock *</label>
            <input type="number" name="stock" value="<?= htmlspecialchars((string)$produit->getStock()) ?>" required style="width: 100%; padding: 8px; box-sizing: border-box;">
        </div>
    </div>

    <!-- Image -->
    <div style="margin-bottom: 25px;">
        <label style="display: block; margin-bottom: 5px;">Nom de l'image (ex: photo.webp)</label>
        <input type="text" name="images" value="<?= htmlspecialchars((string)$produit->getImages()) ?>" style="width: 100%; padding: 8px; box-sizing: border-box;">
        <small style="color: gray;">Facultatif. L'image doit se trouver dans le dossier Assets/Images/.</small>
    </div>

    <button type="submit" style="background-color: var(--green); color: white; padding: 10px 20px; border: none; cursor: pointer; width: 100%; font-weight: bold;">ENREGISTRER LES MODIFICATIONS</button>
</form>