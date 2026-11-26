<?php
// App/Models/Client.php

class Client
{
    private int $id;
    private ?string $nom;
    private ?string $prenom;
    private ?string $adresseFacturation;
    private ?string $cpFacturation;
    private ?string $villeFacturation;
    private ?string $adresseLivraison;
    private ?string $cpLivraison;
    private ?string $villeLivraison;
    private ?string $telephone;
    private ?string $email;
    private ?int $idEmploye;

    public function __construct(
        int $id,
        ?string $nom,
        ?string $prenom,
        ?string $adresseFacturation = null,
        ?string $cpFacturation = null,
        ?string $villeFacturation = null,
        ?string $adresseLivraison = null,
        ?string $cpLivraison = null,
        ?string $villeLivraison = null,
        ?string $telephone = null,
        ?string $email = null,
        ?int $idEmploye = null
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresseFacturation = $adresseFacturation;
        $this->cpFacturation = $cpFacturation;
        $this->villeFacturation = $villeFacturation;
        $this->adresseLivraison = $adresseLivraison;
        $this->cpLivraison = $cpLivraison;
        $this->villeLivraison = $villeLivraison;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->idEmploye = $idEmploye;
    }

    public function getId(): int { return $this->id; }
    public function getNom(): string { return $this->nom ?? ''; }
    public function getPrenom(): string { return $this->prenom ?? ''; }
    public function getAdresseFacturation(): string { return $this->adresseFacturation ?? ''; }
    public function getCpFacturation(): string { return $this->cpFacturation ?? ''; }
    public function getVilleFacturation(): string { return $this->villeFacturation ?? ''; }
    public function getAdresseLivraison(): string { return $this->adresseLivraison ?? ''; }
    public function getCpLivraison(): string { return $this->cpLivraison ?? ''; }
    public function getVilleLivraison(): string { return $this->villeLivraison ?? ''; }
    public function getTelephone(): string { return $this->telephone ?? ''; }
    public function getEmail(): string { return $this->email ?? ''; }
    public function getIdEmploye(): ?int { return $this->idEmploye; }
}