<!-- Views/Produit/Stock.php -->
<div class="entete-page-actions">
    <h1 class="titre-page">STOCK</h1>
    <a href="/Cafthe_Dashboard/Public/produits/creer" class="bouton-vert">+ AJOUTER UN PRODUIT</a>
</div>

<!-- BARRE DE RECHERCHE ET FILTRES AVANCÉS -->
<form method="GET" action="" class="barre-filtres">
    
    <div class="col-2">
        <label class="etiquette-grise">Rechercher (Nom ou Réf)</label>
        <input type="text" name="recherche" value="<?= htmlspecialchars($recherche ?? '') ?>" placeholder="Ex: Café, REF-5..." class="champ-sombre">
    </div>

    <div class="col-1">
        <label class="etiquette-grise">Catégorie</label>
        <select name="categorie" class="champ-sombre">
            <option value="">Toutes les catégories</option>
            <option value="Café" <?= (isset($categorie) && $categorie === 'Café') ? 'selected' : '' ?>>Café</option>
            <option value="Thé" <?= (isset($categorie) && $categorie === 'Thé') ? 'selected' : '' ?>>Thé</option>
            <option value="Accessoire" <?= (isset($categorie) && $categorie === 'Accessoire') ? 'selected' : '' ?>>Accessoire</option>
            <option value="Coffret" <?= (isset($categorie) && $categorie === 'Coffret') ? 'selected' : '' ?>>Coffret</option>
        </select>
    </div>

    <div>
        <button type="submit" class="bouton-or"><i class="fa-solid fa-magnifying-glass"></i> Filtrer</button>
        <a href="/Cafthe_Dashboard/Public/produits" class="lien-reinitialiser">Réinitialiser</a>
    </div>

</form>

<table class="tableau tableau-compact">
    <thead>
        <tr>
            <th>IMAGE</th>
            <th>SKU</th>
            <th>NOM</th>
            <th>CATÉGORIE</th>
            <th>TYPE</th> <!-- NOUVELLE COLONNE -->
            <th>DESCRIPTION</th>
            <th>TYPE VENTE</th>
            <th>PRIX HT</th>
            <th>TVA</th>
            <th>PRIX TTC</th>
            <th>STOCK</th>
            <th>ACTIONS</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($produits as $produit): ?>
        <tr>
            <!-- IMAGE -->
            <td>
                <?php if ($produit->getImages()): ?>
                    <img src="/Cafthe_Dashboard/Public/Assets/Images/<?= htmlspecialchars($produit->getImages()) ?>" alt="<?= htmlspecialchars($produit->getNom()) ?>" class="miniature-produit">
                <?php else: ?>
                    <div class="miniature-vide">N/A</div>
                <?php endif; ?>
            </td>
            
            <!-- SKU -->
            <td>REF-<?= htmlspecialchars((string)$produit->getId()) ?></td>
            
            <!-- NOM -->
            <td class="texte-gras"><?= htmlspecialchars($produit->getNom()) ?></td>

            <!-- CATÉGORIE -->
            <td><?= htmlspecialchars($produit->getCategorie()) ?></td>

            <!-- TYPE (Grains, Moulu, etc.) -->
            <td><?= htmlspecialchars((string)$produit->getType()) ?></td>

            <!-- DESCRIPTION -->
            <td class="description-courte"><?= htmlspecialchars(substr((string)$produit->getDescription(), 0, 30)) ?>...</td>
            
            <!-- TYPE DE VENTE -->
            <td><?= htmlspecialchars((string)$produit->getTypeVente()) ?></td>
            
            <!-- PRIX HT -->
            <td><?= number_format((float)$produit->getPrixHt(), 2, ',', ' ') ?> €</td>
            
            <!-- TVA -->
            <td><?= number_format((float)$produit->getTva(), 1, ',', ' ') ?> %</td>
            
            <!-- PRIX TTC -->
            <td><?= number_format((float)$produit->getPrixTtc(), 2, ',', ' ') ?> €</td>
            
            <!-- STOCK -->
            <td>
                <span class="badge <?= $produit->getStock() < 15 ? 'badge-danger' : 'badge-succes' ?>">
                    <?= htmlspecialchars((string)$produit->getStock()) ?>
                </span>
            </td>
            
            <!-- ACTIONS -->
            <td class="colonne-actions">
                <a href="/Cafthe_Dashboard/Public/produits/editer?id=<?= $produit->getId() ?>" class="lien-action-or">Modifier</a>
                <a href="/Cafthe_Dashboard/Public/produits/supprimer?id=<?= $produit->getId() ?>" onclick="return confirm('Êtes-vous sûr ?');" class="lien-action-rouge">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>