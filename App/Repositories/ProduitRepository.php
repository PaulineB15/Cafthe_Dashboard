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

    // CRUD : READ - Lire tous les produits avec filtres avancés et tri DESC
    public function findAll(string $recherche = '', string $categorie = ''): array
    {
        // Requête de base pour les produits actifs
        $sql = "SELECT * FROM produit WHERE EST_ACTIF = 1";
        $params = [];

        // Filtre par recherche (nom ou ID)
        if ($recherche !== '') {
            $sql .= " AND (NOM_PRODUIT LIKE :recherche OR ID_PRODUIT = :id_recherche)";
            $params['recherche'] = '%' . $recherche . '%';
            // Permet de chercher "REF-5" ou juste "5"
            $params['id_recherche'] = (int) str_replace('REF-', '', $recherche); 
        }

        // Filtre par catégorie
        if ($categorie !== '') {
            $sql .= " AND CATEGORIE = :categorie";
            $params['categorie'] = $categorie;
        }

        // Ajout du tri du plus récent au plus ancien (ID décroissant)
        $sql .= " ORDER BY ID_PRODUIT DESC";
        
        // On utilise prepare() au lieu de query() pour la sécurité
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        $produitsData = $stmt->fetchAll();
        $produits = []; // Tableau de produits vide
        
        foreach ($produitsData as $data) {
            $produits[] = new Produit(
                $data['ID_PRODUIT'],
                $data['NOM_PRODUIT'],
                $data['CATEGORIE'],
                $data['TYPE'],
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
        $sql = "INSERT INTO produit (NOM_PRODUIT, CATEGORIE, TYPE, TYPE_VENTE, DESCRIPTION, STOCK, PRIX_HT, TVA, PRIX_TTC, IMAGES, EST_ACTIF) 
                VALUES (:nom, :categorie, :type, :typeVente, :description, :stock, :prixHt, :tva, :prixTtc, :images, 1)";

        $stmt = $this->db->prepare($sql);
        
        $stmt->execute([
            'nom'         => $donnees['nom'],
            'categorie'   => $donnees['categorie'],
            'type'        => $donnees['type'], 
            'typeVente'   => $donnees['typeVente'],
            'description' => $donnees['description'],
            'stock'       => $donnees['stock'],
            'prixHt'      => $donnees['prixHt'],
            'tva'         => $donnees['tva'],
            'prixTtc'     => $donnees['prixTtc'],
            'images'      => $donnees['images'] 
        ]);
    }


    // CRUD : UPDATE - Trouver un produit spécifique par son ID
    public function findById(int $id): ?Produit
    {
        $stmt = $this->db->prepare("SELECT * FROM produit WHERE ID_PRODUIT = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch();
        
        if (!$data) {
            return null; 
        }
        
        return new Produit(
            $data['ID_PRODUIT'],
            $data['NOM_PRODUIT'],
            $data['CATEGORIE'],
            $data['TYPE'], 
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
                SET NOM_PRODUIT = :nom, CATEGORIE = :categorie, TYPE = :type,  TYPE_VENTE = :typeVente, 
                    DESCRIPTION = :description, STOCK = :stock, PRIX_HT = :prixHt, 
                    TVA = :tva, PRIX_TTC = :prixTtc, IMAGES = :images
                WHERE ID_PRODUIT = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'nom'         => $donnees['nom'],
            'categorie'   => $donnees['categorie'],
            'type'        => $donnees['type'], 
            'typeVente'   => $donnees['typeVente'],
            'description' => $donnees['description'],
            'stock'       => $donnees['stock'],
            'prixHt'      => $donnees['prixHt'],
            'tva'         => $donnees['tva'],
            'prixTtc'     => $donnees['prixTtc'],
            'images'      => $donnees['images'], 
            'id'          => $id
        ]);
    }

    // CRUD : DELETE - Supprimer un produit (Désactive le produit)
    public function delete(int $id): void
    {
        $sql = "UPDATE produit SET EST_ACTIF = 0 WHERE ID_PRODUIT = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
}