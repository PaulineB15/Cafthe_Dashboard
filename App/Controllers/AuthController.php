<?php
// Fichier - pour login

class AuthController
{
    // Affiche le formulaire de connexion (GET /login)
    public function login(): void
    {
        // Si l'employé est déjà connecté, on le redirige vers l'accueil
        if (isset($_SESSION['employe'])) {
            header('Location: /Cafthe_Dashboard/Public/');
            exit;
        }

        View::render('Auth/Login', [
            'erreur' => null,
            'emailSaisi' => ''
        ], null);
    }

    // Traite la soumission du formulaire de connexion (POST /login)
    public function authenticate(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Cafthe_Dashboard/Public/login');
            exit;
        }

        // Récupération et nettoyage minimal des champs saisis
        $email = trim($_POST['email'] ?? '');
        $motDePasse = $_POST['mot_de_passe'] ?? '';

        // Vérification côté serveur que les champs ne sont pas vides
        if ($email === '' || $motDePasse === '') {
            View::render('Auth/Login', [
                'erreur' => 'Veuillez renseigner votre adresse email et votre mot de passe.',
                'emailSaisi' => $email
            ], null);
            return;
        }

        // Connexion à la BDD et recherche de l'employé par email
        $config = require __DIR__ . '/../../Config/Database.php';
        $pdo = (new Database($config))->getConnection();
        $employeRepo = new EmployeRepository($pdo);
        $employe = $employeRepo->findByEmail($email);

        // Vérification de l'existence du compte employé et du mot de passe haché
        $hashStocke = $employe?->getMotDePasseHash() ?? '';
        if (!$employe || !password_verify($motDePasse, $hashStocke)) {
            View::render('Auth/Login', [
                'erreur' => 'Identifiants incorrects.',
                'emailSaisi' => $email
            ], null);
            return;
        }

        // Sécurisation de la session et enregistrement de l'employé connecté
        session_regenerate_id(true);
        $_SESSION['employe'] = [
            'id'     => $employe->getId(),
            'nom'    => $employe->getNom(),
            'prenom' => $employe->getPrenom(),
            'email'  => $employe->getEmail(),
            'role'   => $employe->getRole()
        ];
        $_SESSION['dernier_acces'] = time();

        // Redirection vers le tableau de bord
        header('Location: /Cafthe_Dashboard/Public/');
        exit;
    }

    // Déconnecte l'utilisateur et détruit la session (GET /logout)
    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
        header('Location: /Cafthe_Dashboard/Public/login');
        exit;
    }
}