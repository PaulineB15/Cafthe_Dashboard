<?php


class ClientRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /** @return Client[] */
    public function findAll(string $recherche = ''): array
    {
        if ($recherche !== '') {
            $sql = "SELECT ID_CLIENT, NOM_CLIENT, PRENOM_CLIENT, ADRESSE_FACTURATION, CP_FACTURATION, VILLE_FACTURATION,
                           ADRESSE_LIVRAISON, CP_LIVRAISON, VILLE_LIVRAISON, TEL_CLIENT, EMAIL_CLIENT, ID_EMPLOYE
                    FROM client
                    WHERE NOM_CLIENT LIKE :recherche
                       OR PRENOM_CLIENT LIKE :recherche
                       OR EMAIL_CLIENT LIKE :recherche
                       OR VILLE_FACTURATION LIKE :recherche
                    ORDER BY ID_CLIENT DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['recherche' => '%' . $recherche . '%']);
        } else {
            $sql = "SELECT ID_CLIENT, NOM_CLIENT, PRENOM_CLIENT, ADRESSE_FACTURATION, CP_FACTURATION, VILLE_FACTURATION,
                           ADRESSE_LIVRAISON, CP_LIVRAISON, VILLE_LIVRAISON, TEL_CLIENT, EMAIL_CLIENT, ID_EMPLOYE
                    FROM client
                    ORDER BY ID_CLIENT DESC";
            $stmt = $this->db->query($sql);
        }

        $clients = [];
        foreach ($stmt->fetchAll() as $row) {
            $clients[] = $this->hydrater($row);
        }
        return $clients;
    }

    public function findById(int $id): ?Client
    {
        $stmt = $this->db->prepare("
            SELECT ID_CLIENT, NOM_CLIENT, PRENOM_CLIENT, ADRESSE_FACTURATION, CP_FACTURATION, VILLE_FACTURATION,
                   ADRESSE_LIVRAISON, CP_LIVRAISON, VILLE_LIVRAISON, TEL_CLIENT, EMAIL_CLIENT, ID_EMPLOYE
            FROM client
            WHERE ID_CLIENT = :id
            LIMIT 1
        ");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ? $this->hydrater($row) : null;
    }

    public function create(array $data): void
    {
        $sql = "INSERT INTO client (
                    NOM_CLIENT, PRENOM_CLIENT, ADRESSE_FACTURATION, CP_FACTURATION, VILLE_FACTURATION,
                    ADRESSE_LIVRAISON, CP_LIVRAISON, VILLE_LIVRAISON, TEL_CLIENT, EMAIL_CLIENT, ID_EMPLOYE
                ) VALUES (
                    :nom, :prenom, :adr_fac, :cp_fac, :ville_fac,
                    :adr_liv, :cp_liv, :ville_liv, :tel, :email, :id_employe
                )";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'nom'        => $data['nom'],
            'prenom'     => $data['prenom'],
            'adr_fac'    => $data['adresse_facturation'] ?: null,
            'cp_fac'     => $data['cp_facturation'] ?: null,
            'ville_fac'  => $data['ville_facturation'] ?: null,
            'adr_liv'    => $data['adresse_livraison'] ?: null,
            'cp_liv'     => $data['cp_livraison'] ?: null,
            'ville_liv'  => $data['ville_livraison'] ?: null,
            'tel'        => $data['telephone'] ?: null,
            'email'      => $data['email'],
            'id_employe' => $data['id_employe'] ?? null
        ]);
    }

    public function update(int $id, array $data): void
    {
        $sql = "UPDATE client
                SET NOM_CLIENT = :nom,
                    PRENOM_CLIENT = :prenom,
                    ADRESSE_FACTURATION = :adr_fac,
                    CP_FACTURATION = :cp_fac,
                    VILLE_FACTURATION = :ville_fac,
                    ADRESSE_LIVRAISON = :adr_liv,
                    CP_LIVRAISON = :cp_liv,
                    VILLE_LIVRAISON = :ville_liv,
                    TEL_CLIENT = :tel,
                    EMAIL_CLIENT = :email
                WHERE ID_CLIENT = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'nom'       => $data['nom'],
            'prenom'    => $data['prenom'],
            'adr_fac'   => $data['adresse_facturation'] ?: null,
            'cp_fac'    => $data['cp_facturation'] ?: null,
            'ville_fac' => $data['ville_facturation'] ?: null,
            'adr_liv'   => $data['adresse_livraison'] ?: null,
            'cp_liv'    => $data['cp_livraison'] ?: null,
            'ville_liv' => $data['ville_livraison'] ?: null,
            'tel'       => $data['telephone'] ?: null,
            'email'     => $data['email'],
            'id'        => $id
        ]);
    }

// Historique complet des commandes d'un client (achats unifiés)
    public function findCommandesByClient(int $idClient): array
    {
        $sql = "SELECT ID_COMMANDE, DATE_COMMANDE, STATUT_COMMANDE, MODE_COMMANDE, MODE_PAIEMENT, MONTANT_TOTAL
                FROM commande
                WHERE ID_CLIENT = :id_client
                ORDER BY DATE_COMMANDE DESC, ID_COMMANDE DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id_client' => $idClient]);
        return $stmt->fetchAll();
    }

    // Statistiques client : nombre de commandes et panier moyen
    public function getStatistiquesClient(int $idClient): array
    {
        $sql = "SELECT COUNT(*) AS nb_commandes, COALESCE(AVG(MONTANT_TOTAL), 0) AS panier_moyen
                FROM commande
                WHERE ID_CLIENT = :id_client";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id_client' => $idClient]);
        $row = $stmt->fetch();

        return [
            'nb_commandes' => (int)($row['nb_commandes'] ?? 0),
            'panier_moyen' => (float)($row['panier_moyen'] ?? 0)
        ];
    }

    // Produits favoris d'un client (top 5 par quantité commandée)
    public function getProduitsFavorisClient(int $idClient, int $limite = 5): array
    {
        $sql = "SELECT p.NOM_PRODUIT, COALESCE(SUM(ct.QUANTITE_COMMANDEE), 0) AS qte_totale
                FROM contenir ct
                JOIN commande cmd ON ct.ID_COMMANDE = cmd.ID_COMMANDE
                JOIN produit p ON ct.ID_PRODUIT = p.ID_PRODUIT
                WHERE cmd.ID_CLIENT = :id_client
                GROUP BY p.ID_PRODUIT, p.NOM_PRODUIT
                ORDER BY qte_totale DESC
                LIMIT :limite";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('id_client', $idClient, PDO::PARAM_INT);
        $stmt->bindValue('limite', $limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    private function hydrater(array $row): Client
    {
        return new Client(
            (int)$row['ID_CLIENT'],
            $row['NOM_CLIENT'] ?? null,
            $row['PRENOM_CLIENT'] ?? null,
            $row['ADRESSE_FACTURATION'] ?? null,
            $row['CP_FACTURATION'] ?? null,
            $row['VILLE_FACTURATION'] ?? null,
            $row['ADRESSE_LIVRAISON'] ?? null,
            $row['CP_LIVRAISON'] ?? null,
            $row['VILLE_LIVRAISON'] ?? null,
            $row['TEL_CLIENT'] ?? null,
            $row['EMAIL_CLIENT'] ?? null,
            isset($row['ID_EMPLOYE']) ? (int)$row['ID_EMPLOYE'] : null
        );
    }
}