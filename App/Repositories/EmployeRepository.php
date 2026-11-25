
// Fichier = lien entre l'objet Employe.php et la BDD

<?php

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



}