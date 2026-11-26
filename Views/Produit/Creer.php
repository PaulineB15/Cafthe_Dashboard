<!-- Views/Produit/Creer.php -->
<div class="entete-page">
    <h1 class="titre-page-or">AJOUTER UN PRODUIT</h1>
    <a href="/Cafthe_Dashboard/Public/produits" class="lien-retour">← Retour au stock</a>
</div>

<form action="/Cafthe_Dashboard/Public/produits/enregistrer" method="POST" class="formulaire-produit">
    
    <!-- Nom -->
    <div class="groupe-champ">
        <label class="etiquette">Nom du produit *</label>
        <input type="text" name="nom" required class="champ-natif">
    </div>
    
    <!-- Catégorie et Type de vente (Côte à côte) -->
    <!-- Catégorie, Type de produit et Type de vente (Côte à côte) -->
    <div class="ligne-champs">
        <div class="col-1">
            <label class="etiquette">Catégorie *</label>
            <select name="categorie" required class="champ-natif">
                <option value="Café">Café</option>
                <option value="Thé">Thé</option>
                <option value="Accessoire">Accessoire</option>
                <option value="Coffret">Coffret</option>
            </select>
        </div>
        <div class="col-1">
            <label class="etiquette">Type *</label>
            <select name="type" required class="champ-natif">
                <option value="Grains">Grains</option>
                <option value="Moulu">Moulu</option>
                <option value="Noir">Thé Noir</option>
                <option value="Vert">Thé Vert</option>
                <option value="Infusion">Infusion</option>
                <option value="N/A">Autre / N/A</option>
            </select>
        </div>
        <div class="col-1">
            <label class="etiquette">Type de vente *</label>
            <select name="type_vente" required class="champ-natif">
                <option value="Unité">Unité</option>
                <option value="Vrac">Vrac (au poids)</option>
            </select>
        </div>
    </div>

    <!-- Description -->
    <div class="groupe-champ">
        <label class="etiquette">Description *</label>
        <textarea name="description" required rows="3" class="champ-natif"></textarea>
    </div>

    <!-- Prix HT, TVA et Stock (Côte à côte) -->
    <div class="ligne-champs">
        <div class="col-1">
            <label class="etiquette">Prix HT (€) *</label>
            <input type="number" step="0.01" name="prix_ht" required class="champ-natif">
        </div>
        <div class="col-1">
            <label class="etiquette">TVA (%) *</label>
            <select name="tva" required class="champ-natif">
                <option value="5.5">5.5 % (Thé/Café)</option>
                <option value="20">20 % (Accessoires)</option>
            </select>
        </div>
        <div class="col-1">
            <label class="etiquette">Stock *</label>
            <input type="number" name="stock" required class="champ-natif">
        </div>
    </div>

    <!-- Image -->
    <div class="groupe-champ-large">
        <label class="etiquette">Nom de l'image (ex: photo.webp)</label>
        <input type="text" name="images" class="champ-natif">
        <small class="texte-gris">Facultatif. L'image doit se trouver dans le dossier Assets/Images/.</small>
    </div>

    <button type="submit" class="bouton-vert-plein">ENREGISTRER LE PRODUIT</button>
</form>