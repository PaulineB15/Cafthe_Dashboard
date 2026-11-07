
<?php
// Pour la connexion à la BDD Cafthé

// Ce fichier retourne un tableau contenant les paramètres de connexion à MySQL
return [
    'host'     => '127.0.0.1', // localhost sous Laragon
    'dbname'   => 'cafthe',    // nom de la BDD
    'user'     => 'root',      // L'utilisateur par défaut sous Laragon
    'password' => '',          // Le mot de passe (vide par défaut sous Laragon)
    'charset'  => 'utf8mb4'    // L'encodage pour gérer tous les caractères (y compris les émojis)
];