<?php
// App/Models/Produit.php

class Produit
{
    private ?int $id;
    private string $nom;
    private string $categorie;
    private ?string $typeVente;
    private ?string $description;
    private int $stock;
    private ?float $prixHt;
    private ?float $tva;
    private float $prixTtc;
    private ?string $images;
    private int $estActif; // Pour gérer la "suppression" du produit (CRUD)
 
    public function __construct(
        ?int $id, 
        string $nom, 
        string $categorie, 
        ?string $typeVente, 
        ?string $description, 
        int $stock, 
        ?float $prixHt, 
        ?float $tva, 
        float $prixTtc, 
        ?string $images, 
        int $estActif
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->categorie = $categorie;
        $this->typeVente = $typeVente;
        $this->description = $description;
        $this->stock = $stock;
        $this->prixHt = $prixHt;
        $this->tva = $tva;
        $this->prixTtc = $prixTtc;
        $this->images = $images;
        $this->estActif = $estActif;
    }

    // Getters pour lire les informations
    public function getId(): ?int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getCategorie(): string { return $this->categorie; }
    public function getTypeVente(): ?string { return $this->typeVente; }
    public function getDescription(): ?string { return $this->description; }
    public function getStock(): int { return $this->stock; }
    public function getPrixHt(): ?float { return $this->prixHt; }
    public function getTva(): ?float { return $this->tva; }
    public function getPrixTtc(): float { return $this->prixTtc; }
    public function getImages(): ?string { return $this->images; }
    public function getEstActif(): int { return $this->estActif; }
}