<!-- Views/Produit/Editer.php -->
<div class="entete-page">
    <h1 class="titre-page-or">MODIFIER LE PRODUIT</h1>
    <a href="/Cafthe_Dashboard/Public/produits" class="lien-retour">← Retour au stock</a>
</div>

<!-- L'URL contient l'ID du produit à modifier -->
<form action="/Cafthe_Dashboard/Public/produits/modifier?id=<?= $produit->getId() ?>" method="POST" class="formulaire-produit">
    
    <!-- Nom -->
    <div class="groupe-champ">
        <label class="etiquette">Nom du produit *</label>
        <!-- On injecte la valeur avec htmlspecialchars -->
        <input type="text" name="nom" value="<?= htmlspecialchars($produit->getNom()) ?>" required class="champ-natif">
    </div>

    <!-- Catégorie et Type de vente (Côte à côte) -->
    <!-- Catégorie, Type de produit et Type de vente (Côte à côte) -->
    <div class="ligne-champs">
        <div class="col-1">
            <label class="etiquette">Catégorie *</label>
            <select name="categorie" required class="champ-natif">
                <option value="Café" <?= $produit->getCategorie() === 'Café' ? 'selected' : '' ?>>Café</option>
                <option value="Thé" <?= $produit->getCategorie() === 'Thé' ? 'selected' : '' ?>>Thé</option>
                <option value="Accessoire" <?= $produit->getCategorie() === 'Accessoire' ? 'selected' : '' ?>>Accessoire</option>
                <option value="Coffret" <?= $produit->getCategorie() === 'Coffret' ? 'selected' : '' ?>>Coffret</option>
            </select>
        </div>
        <div class="col-1">
            <label class="etiquette">Type *</label>
            <select name="type" required class="champ-natif">
                <option value="Grains" <?= $produit->getType() === 'Grains' ? 'selected' : '' ?>>Grains</option>
                <option value="Moulu" <?= $produit->getType() === 'Moulu' ? 'selected' : '' ?>>Moulu</option>
                <option value="Noir" <?= $produit->getType() === 'Noir' ? 'selected' : '' ?>>Thé Noir</option>
                <option value="Vert" <?= $produit->getType() === 'Vert' ? 'selected' : '' ?>>Thé Vert</option>
                <option value="Infusion" <?= $produit->getType() === 'Infusion' ? 'selected' : '' ?>>Infusion</option>
                <option value="N/A" <?= $produit->getType() === 'N/A' || $produit->getType() === null || $produit->getType() === '' ? 'selected' : '' ?>>Autre / N/A</option>
            </select>
        </div>
        <div class="col-1">
            <label class="etiquette">Type de vente *</label>
            <select name="type_vente" required class="champ-natif">
                <option value="Unité" <?= $produit->getTypeVente() === 'Unité' ? 'selected' : '' ?>>Unité</option>
                <option value="Vrac" <?= $produit->getTypeVente() === 'Vrac' ? 'selected' : '' ?>>Vrac (au poids)</option>
            </select>
        </div>
    </div>

    <!-- Description -->
    <div class="groupe-champ">
        <label class="etiquette">Description *</label>
        <!-- Pour un textarea, la valeur se met ENTRE les balises (sans espaces avant/après) -->
        <textarea name="description" required rows="3" class="champ-natif"><?= htmlspecialchars((string)$produit->getDescription()) ?></textarea>
    </div>

    <!-- Prix HT, TVA et Stock (Côte à côte) -->
    <div class="ligne-champs">
        <div class="col-1">
            <label class="etiquette">Prix HT (€) *</label>
            <input type="number" step="0.01" name="prix_ht" value="<?= htmlspecialchars((string)$produit->getPrixHt()) ?>" required class="champ-natif">
        </div>
        <div class="col-1">
            <label class="etiquette">TVA (%) *</label>
            <select name="tva" required class="champ-natif">
                <option value="5.5" <?= (float)$produit->getTva() === 5.5 ? 'selected' : '' ?>>5.5 % (Thé/Café)</option>
                <option value="20" <?= (float)$produit->getTva() === 20.0 ? 'selected' : '' ?>>20 % (Accessoires)</option>
            </select>
        </div>
        <div class="col-1">
            <label class="etiquette">Stock *</label>
            <input type="number" name="stock" value="<?= htmlspecialchars((string)$produit->getStock()) ?>" required class="champ-natif">
        </div>
    </div>

    <!-- Image -->
    <div class="groupe-champ-large">
        <label class="etiquette">Nom de l'image (ex: photo.webp)</label>
        <input type="text" name="images" value="<?= htmlspecialchars((string)$produit->getImages()) ?>" class="champ-natif">
        <small class="texte-gris">Facultatif. L'image doit se trouver dans le dossier Assets/Images/.</small>
    </div>

    <button type="submit" class="bouton-vert-plein">ENREGISTRER LES MODIFICATIONS</button>
</form>