<?php
// App/Repositories/ProduitRepository.php

class ProduitRepository
{
    private PDO $db;

    // Initialisation: Pour se connecter à la BDD
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    // CRUD : READ - Lire tous les produits 
    public function findAll(): array
    {
        // Sélectionne que les produits dont EST_ACTIF = 1 dans BDD
        $stmt = $this->db->query("SELECT * FROM produit WHERE EST_ACTIF = 1 ORDER BY NOM_PRODUIT ASC");
        
        $produitsData = $stmt->fetchAll();
        $produits = []; // Tableau de produits vide
        
        foreach ($produitsData as $data) {
            $produits[] = new Produit(
                $data['ID_PRODUIT'],
                $data['NOM_PRODUIT'],
                $data['CATEGORIE'],
                $data['TYPE_VENTE'],
                $data['DESCRIPTION'],
                (int)$data['STOCK'],
                $data['PRIX_HT'] !== null ? (float)$data['PRIX_HT'] : null,
                $data['TVA'] !== null ? (float)$data['TVA'] : null,
                (float)$data['PRIX_TTC'],
                $data['IMAGES'],
                (int)$data['EST_ACTIF']
            );
        }
        
        return $produits;
    }


    // CRUD : CREATE - Ajouter nouveau produit 
    public function create(array $donnees): void
    {   
        // Protection contre injections SQL
        // Prépare la requête SQL avec des "marqueurs" (:nom, :categorie...)
        $sql = "INSERT INTO produit (NOM_PRODUIT, CATEGORIE, TYPE_VENTE, DESCRIPTION, STOCK, PRIX_HT, TVA, PRIX_TTC, IMAGES, EST_ACTIF) 
                VALUES (:nom, :categorie, :typeVente, :description, :stock, :prixHt, :tva, :prixTtc, :images, 1)";

        // prepare() - Méthode prend en paramètre la requête SQL avec les marqueurs (préfixés par : ), identifiant les données dynamiques.
        $stmt = $this->db->prepare($sql);
        
        // execute() - Méthode qui remplace les marqueurs par les vraies données tapées dans le formulaire
        $stmt->execute([
            'nom'         => $donnees['nom'],
            'categorie'   => $donnees['categorie'],
            'typeVente'   => $donnees['typeVente'],
            'description' => $donnees['description'],
            'stock'       => $donnees['stock'],
            'prixHt'      => $donnees['prixHt'],
            'tva'         => $donnees['tva'],
            'prixTtc'     => $donnees['prixTtc'],
            'images'      => $donnees['images'] // Peut être null
        ]);
    }



    //CRUD : UPDATE - Mettre à jour un produit

    //Trouver un produit spécifique par son ID
    public function findById(int $id): ?Produit
    {
        $stmt = $this->db->prepare("SELECT * FROM produit WHERE ID_PRODUIT = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch();
        
        // Si le produit n'existe pas, on retourne null
        if (!$data) {
            return null; 
        }
        
        // On retourne un VRAI objet Produit (ce que ton formateur attendait !)
        return new Produit(
            $data['ID_PRODUIT'],
            $data['NOM_PRODUIT'],
            $data['CATEGORIE'],
            $data['TYPE_VENTE'],
            $data['DESCRIPTION'],
            (int)$data['STOCK'],
            $data['PRIX_HT'] !== null ? (float)$data['PRIX_HT'] : null,
            $data['TVA'] !== null ? (float)$data['TVA'] : null,
            (float)$data['PRIX_TTC'],
            $data['IMAGES'],
            (int)$data['EST_ACTIF']
        );
    }

    // CRUD : UPDATE - Mettre à jour un produit 
    public function update(int $id, array $donnees): void
    {
        $sql = "UPDATE produit 
                SET NOM_PRODUIT = :nom, CATEGORIE = :categorie, TYPE_VENTE = :typeVente, 
                    DESCRIPTION = :description, STOCK = :stock, PRIX_HT = :prixHt, 
                    TVA = :tva, PRIX_TTC = :prixTtc, IMAGES = :images
                WHERE ID_PRODUIT = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'nom'         => $donnees['nom'],
            'categorie'   => $donnees['categorie'],
            'typeVente'   => $donnees['typeVente'],
            'description' => $donnees['description'],
            'stock'       => $donnees['stock'],
            'prixHt'      => $donnees['prixHt'],
            'tva'         => $donnees['tva'],
            'prixTtc'     => $donnees['prixTtc'],
            'images'      => $donnees['images'], // Peut être null
            'id'          => $id
        ]);
    }

    // CRUD : DELETE - Supprimer un produit (Désactive le produit, ne le supprime pas de la BDD)
    public function delete(int $id): void
    {
        // Ne fait PAS un DELETE, on met juste à jour le statut EST_ACTIF à 0
        $sql = "UPDATE produit SET EST_ACTIF = 0 WHERE ID_PRODUIT = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
}