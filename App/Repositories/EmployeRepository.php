<?php

// Classe = lien entre l'objet Employe.php et la BDD

class EmployeRepository
{
    private PDO $db;

    // Connexion à la BDD
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Méthode pour récupérer tous les employés
    public function findAll(): array
    {
        // Requête SQL pour récupérer les employés (" employe" - nom de table dans la BDD)
        $stmt = $this->db->query("SELECT ID_EMPLOYE, NOM_EMPLOYE, PRENOM_EMPLOYE, EMAIL_EMPLOYE, ROLE FROM employe");
        
        // Récupère toutes les lignes de la base de données
        $employesData = $stmt->fetchAll();
        
        $employes = [];
        
        // Transforme chaque ligne de tableau en véritable "Objet Employe"
        foreach ($employesData as $data) {
            $employes[] = new Employe(
                (int)$data['ID_EMPLOYE'],
                $data['NOM_EMPLOYE'],
                $data['PRENOM_EMPLOYE'],
                $data['EMAIL_EMPLOYE'],
                $data['ROLE']
            );
        }
        
        // Renvoie la liste d'objets
        return $employes;
    }

    // Méthode pour trouver un employé par son adresse email (login))
    public function findByEmail(string $email): ?Employe
    {
        // Requête pour éviter toute injection SQL
        $stmt = $this->db->prepare("SELECT * FROM employe WHERE EMAIL_EMPLOYE = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();

        // Aucun compte trouvé avec cet email
        if (!$data) {
            return null;
        }

        // Retourne l'objet Employe avec son hash de mot de passe pour vérification
        return new Employe(
            (int)$data['ID_EMPLOYE'],
            $data['NOM_EMPLOYE'],
            $data['PRENOM_EMPLOYE'],
            $data['EMAIL_EMPLOYE'],
            $data['ROLE'],
            $data['MDP_EMPLOYE'] ?? null
        );
    }



    // Trouver un employé par son ID (pour la page "Mon Profil")
    public function findById(int $id): ?Employe
    {
        $stmt = $this->db->prepare("SELECT * FROM employe WHERE ID_EMPLOYE = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return new Employe(
            (int)$data['ID_EMPLOYE'],
            $data['NOM_EMPLOYE'],
            $data['PRENOM_EMPLOYE'],
            $data['EMAIL_EMPLOYE'],
            $data['ROLE'],
            $data['MDP_EMPLOYE'] ?? null
        );
    }

    // Mettre à jour les informations personnelles d'un employé
    public function updateProfil(int $id, string $nom, string $prenom, string $email): void
    {
        $sql = "UPDATE employe
                SET NOM_EMPLOYE = :nom, PRENOM_EMPLOYE = :prenom, EMAIL_EMPLOYE = :email
                WHERE ID_EMPLOYE = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'nom'    => $nom,
            'prenom' => $prenom,
            'email'  => $email,
            'id'     => $id
        ]);
    }

    // Mettre à jour le mot de passe haché d'un employé
    public function updateMotDePasse(int $id, string $nouveauHash): void
    {
        $sql = "UPDATE employe
                SET MDP_EMPLOYE = :mdp
                WHERE ID_EMPLOYE = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'mdp' => $nouveauHash,
            'id'  => $id
        ]);
    }

    // Créer un nouvel employé (avec mot de passe déjà haché en bcrypt)
    public function create(string $nom, string $prenom, string $email, string $role, string $motDePasseHash): void
    {
        $sql = "INSERT INTO employe (NOM_EMPLOYE, PRENOM_EMPLOYE, EMAIL_EMPLOYE, ROLE, MDP_EMPLOYE)
                VALUES (:nom, :prenom, :email, :role, :mdp)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'nom'    => $nom,
            'prenom' => $prenom,
            'email'  => $email,
            'role'   => $role,
            'mdp'    => $motDePasseHash
        ]);
    }

    // Mettre à jour les informations (et optionnellement le mot de passe haché) d'un employé
    public function updateCompte(int $id, string $nom, string $prenom, string $email, string $role, ?string $nouveauHash = null): void
    {
        if ($nouveauHash !== null) {
            $sql = "UPDATE employe
                    SET NOM_EMPLOYE = :nom, PRENOM_EMPLOYE = :prenom, EMAIL_EMPLOYE = :email, ROLE = :role, MDP_EMPLOYE = :mdp
                    WHERE ID_EMPLOYE = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'nom'    => $nom,
                'prenom' => $prenom,
                'email'  => $email,
                'role'   => $role,
                'mdp'    => $nouveauHash,
                'id'     => $id
            ]);
            return;
        }

        $sql = "UPDATE employe
                SET NOM_EMPLOYE = :nom, PRENOM_EMPLOYE = :prenom, EMAIL_EMPLOYE = :email, ROLE = :role
                WHERE ID_EMPLOYE = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'nom'    => $nom,
            'prenom' => $prenom,
            'email'  => $email,
            'role'   => $role,
            'id'     => $id
        ]);
    }

    // Supprimer un compte employé par ID
    public function deleteById(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM employe WHERE ID_EMPLOYE = :id");
        $stmt->execute(['id' => $id]);
    }

}