<?php


class Employe
{
    private ?int $id; // ?int signifie que ça peut être un entier (int) ou null
    private string $nom;
    private string $prenom;
    private string $email; // Email pour la connexion
    private string $role;
    private ?string $motDePasseHash; // Hash du mot de passe stocké en BDD

    // Le constructeur pour remplir l'objet
    public function __construct(
        ?int $id,
        string $nom,
        string $prenom,
        string $email,
        string $role,
        ?string $motDePasseHash = null
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->role = $role;
        $this->motDePasseHash = $motDePasseHash;
    }

    // Les "Getters" pour lire les informations (car elles sont "private")
    public function getId(): ?int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getemail(): string { return $this->email; }
    public function getRole(): string { return $this->role; }
    public function getMotDePasseHash(): ?string { return $this->motDePasseHash; }
}