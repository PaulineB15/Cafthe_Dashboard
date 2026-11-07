<?php


class Database
{
    // Cette propriété stockera la connexion PDO une fois établie
    private PDO $connection;

    // Le constructeur est appelé automatiquement quand on fait "new Database($config)"
    public function __construct(array $config)
    {
        // 1. On prépare la phrase de connexion (le DSN - Data Source Name)
        $dsn = "mysql:host=" . $config['host'] . ";dbname=" . $config['dbname'] . ";charset=" . $config['charset'];

        // 2. On configure quelques options de sécurité et de confort pour PDO
        $options = [
            // Si une erreur SQL survient, PDO va déclencher une vraie "Exception" (erreur fatale propre)
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            // Quand on fait un SELECT, PDO renverra un tableau associatif (ex: $produit['NOM_PRODUIT'])
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // On désactive l'émulation des requêtes préparées pour plus de sécurité
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        // 3. On tente de se connecter à la base de données
        try {
            $this->connection = new PDO($dsn, $config['user'], $config['password'], $options);
        } catch (PDOException $e) {
            // S'il y a une erreur (ex: mauvais mot de passe), on arrête tout et on affiche le message
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    // Cette méthode permet aux autres classes (les Repositories) de récupérer la connexion active
    public function getConnection(): PDO
    {
        return $this->connection;
    }
}