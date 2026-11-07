<?php
// App/Models/Employe.php

class Employe
{
    private ?int $id; // ?int signifie que ça peut être un entier (int) ou null
    private string $nom;
    private string $prenom;
    private string $role;

    // Le constructeur pour remplir l'objet
    public function __construct(?int $id, string $nom, string $prenom, string $role)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->role = $role;
    }

    // Les "Getters" pour lire les informations (car elles sont "private")
    public function getId(): ?int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getRole(): string { return $this->role; }
}