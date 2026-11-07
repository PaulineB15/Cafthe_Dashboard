<?php
// App/Repositories/EmployeRepository.php

class EmployeRepository
{
    private PDO $db;

    // Quand on crée le bibliothécaire, on lui donne la connexion à la base de données
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Méthode pour récupérer tous les employés
    public function findAll(): array
    {
        // Requête SQL pour récupérer les employés (" employe" - nom de table dans la BDD)
        $stmt = $this->db->query("SELECT * FROM employe");
        
        // 2. On récupère toutes les lignes de la base de données
        $employesData = $stmt->fetchAll();
        
        $employes = [];
        
        // 3. On transforme chaque ligne de tableau en véritable "Objet Employe"
        foreach ($employesData as $data) {
            $employes[] = new Employe(
                $data['ID_EMPLOYE'],
                $data['NOM_EMPLOYE'],
                $data['PRENOM_EMPLOYE'],
                $data['ROLE']
            );
        }
        
        // 4. On renvoie la liste d'objets
        return $employes;
    }
}