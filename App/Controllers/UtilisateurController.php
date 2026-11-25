<?php
// App/Controllers/UtilisateurController.php

class UtilisateurController
{
    private function verifierAdministrateur(): void
    {
        $role = $_SESSION['employe']['role'] ?? '';
        if ($role !== 'Administrateur') {
            header('Location: /Cafthe_Dashboard/Public/');
            exit;
        }
    }

    private function getEmployeRepository(): EmployeRepository
    {
        $config = require __DIR__ . '/../../Config/Database.php';
        $pdo = (new Database($config))->getConnection();
        return new EmployeRepository($pdo);
    }

    // Liste des comptes + formulaire d'ajout (GET /utilisateurs)
    public function index(): void
    {
        $this->verifierAdministrateur();

        $repo = $this->getEmployeRepository();
        $employes = $repo->findAll();

        View::render('Utilisateur/GestionUtilisateurs', [
            'employes'        => $employes,
            'employeAEditer'  => null,
            'messageSucces'   => null,
            'messageErreur'   => null
        ]);
    }

    // Création d'un compte employé (POST /utilisateurs/creer)
    public function store(): void
    {
        $this->verifierAdministrateur();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Cafthe_Dashboard/Public/utilisateurs');
            exit;
        }

        $prenom = trim($_POST['prenom'] ?? '');
        $nom = trim($_POST['nom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $role = trim($_POST['role'] ?? 'Vendeur');
        $motDePasse = $_POST['mot_de_passe'] ?? '';

        $repo = $this->getEmployeRepository();

        if ($prenom === '' || $nom === '' || $email === '' || $motDePasse === '') {
            View::render('Utilisateur/GestionUtilisateurs', [
                'employes'       => $repo->findAll(),
                'employeAEditer' => null,
                'messageSucces'  => null,
                'messageErreur'  => 'Tous les champs obligatoires doivent être remplis.'
            ]);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            View::render('Utilisateur/GestionUtilisateurs', [
                'employes'       => $repo->findAll(),
                'employeAEditer' => null,
                'messageSucces'  => null,
                'messageErreur'  => 'Adresse email invalide.'
            ]);
            return;
        }

        if (!in_array($role, ['Administrateur', 'Vendeur'], true)) {
            $role = 'Vendeur';
        }

        $erreurMdp = $this->validerMotDePasse($motDePasse);
        if ($erreurMdp !== null) {
            View::render('Utilisateur/GestionUtilisateurs', [
                'employes'       => $repo->findAll(),
                'employeAEditer' => null,
                'messageSucces'  => null,
                'messageErreur'  => $erreurMdp
            ]);
            return;
        }

        if ($repo->findByEmail($email) !== null) {
            View::render('Utilisateur/GestionUtilisateurs', [
                'employes'       => $repo->findAll(),
                'employeAEditer' => null,
                'messageSucces'  => null,
                'messageErreur'  => 'Cet email est déjà utilisé par un employé.'
            ]);
            return;
        }

        $hash = password_hash($motDePasse, PASSWORD_BCRYPT);
        $repo->create($nom, $prenom, $email, $role, $hash);

        View::render('Utilisateur/GestionUtilisateurs', [
            'employes'       => $repo->findAll(),
            'employeAEditer' => null,
            'messageSucces'  => 'Le compte employé a bien été créé.',
            'messageErreur'  => null
        ]);
    }

    // Affiche le formulaire de modification d'un employé (GET /utilisateurs/editer?id=X)
    public function edit(): void
    {
        $this->verifierAdministrateur();

        $id = (int)($_GET['id'] ?? 0);
        $repo = $this->getEmployeRepository();
        $employe = $repo->findById($id);

        if (!$employe) {
            header('Location: /Cafthe_Dashboard/Public/utilisateurs');
            exit;
        }

        View::render('Utilisateur/GestionUtilisateurs', [
            'employes'       => $repo->findAll(),
            'employeAEditer' => $employe,
            'messageSucces'  => null,
            'messageErreur'  => null
        ]);
    }

    // Met à jour un compte employé (POST /utilisateurs/modifier?id=X)
    public function update(): void
    {
        $this->verifierAdministrateur();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Cafthe_Dashboard/Public/utilisateurs');
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);
        $repo = $this->getEmployeRepository();
        $employe = $repo->findById($id);

        if (!$employe) {
            header('Location: /Cafthe_Dashboard/Public/utilisateurs');
            exit;
        }

        $prenom = trim($_POST['prenom'] ?? '');
        $nom = trim($_POST['nom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $role = trim($_POST['role'] ?? 'Vendeur');
        $nouveauMotDePasse = $_POST['nouveau_mot_de_passe'] ?? '';

        if ($prenom === '' || $nom === '' || $email === '') {
            View::render('Utilisateur/GestionUtilisateurs', [
                'employes'       => $repo->findAll(),
                'employeAEditer' => $employe,
                'messageSucces'  => null,
                'messageErreur'  => 'Le prénom, le nom et l\'email sont obligatoires.'
            ]);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            View::render('Utilisateur/GestionUtilisateurs', [
                'employes'       => $repo->findAll(),
                'employeAEditer' => $employe,
                'messageSucces'  => null,
                'messageErreur'  => 'Adresse email invalide.'
            ]);
            return;
        }

        $existant = $repo->findByEmail($email);
        if ($existant !== null && (int)$existant->getId() !== $id) {
            View::render('Utilisateur/GestionUtilisateurs', [
                'employes'       => $repo->findAll(),
                'employeAEditer' => $employe,
                'messageSucces'  => null,
                'messageErreur'  => 'Cette adresse email appartient déjà à un autre compte.'
            ]);
            return;
        }

        if (!in_array($role, ['Administrateur', 'Vendeur'], true)) {
            $role = 'Vendeur';
        }

        $nouveauHash = null;
        if ($nouveauMotDePasse !== '') {
            $erreurMdp = $this->validerMotDePasse($nouveauMotDePasse);
            if ($erreurMdp !== null) {
                View::render('Utilisateur/GestionUtilisateurs', [
                    'employes'       => $repo->findAll(),
                    'employeAEditer' => $employe,
                    'messageSucces'  => null,
                    'messageErreur'  => $erreurMdp
                ]);
                return;
            }
            $nouveauHash = password_hash($nouveauMotDePasse, PASSWORD_BCRYPT);
        }

        $repo->updateCompte($id, $nom, $prenom, $email, $role, $nouveauHash);

        if ($id === (int)($_SESSION['employe']['id'] ?? 0)) {
            $_SESSION['employe']['nom'] = $nom;
            $_SESSION['employe']['prenom'] = $prenom;
            $_SESSION['employe']['email'] = $email;
            $_SESSION['employe']['role'] = $role;
        }

        View::render('Utilisateur/GestionUtilisateurs', [
            'employes'       => $repo->findAll(),
            'employeAEditer' => null,
            'messageSucces'  => 'Le compte employé a bien été mis à jour.',
            'messageErreur'  => null
        ]);
    }

    // Supprime un compte employé (GET /utilisateurs/supprimer?id=X)
    public function delete(): void
    {
        $this->verifierAdministrateur();

        $id = (int)($_GET['id'] ?? 0);
        $idConnecte = (int)($_SESSION['employe']['id'] ?? 0);

        $repo = $this->getEmployeRepository();

        if ($id > 0 && $id !== $idConnecte) {
            $repo->deleteById($id);
            $messageSucces = 'Le compte employé a bien été supprimé.';
            $messageErreur = null;
        } else {
            $messageSucces = null;
            $messageErreur = 'Vous ne pouvez pas supprimer votre propre compte connecté.';
        }

        View::render('Utilisateur/GestionUtilisateurs', [
            'employes'       => $repo->findAll(),
            'employeAEditer' => null,
            'messageSucces'  => $messageSucces,
            'messageErreur'  => $messageErreur
        ]);
    }

    private function validerMotDePasse(string $motDePasse): ?string
    {
        if (mb_strlen($motDePasse) < 16) {
            return 'Le mot de passe doit contenir au moins 16 caractères.';
        }

        if (!preg_match('/[^a-zA-Z0-9]/', $motDePasse)) {
            return 'Le mot de passe doit contenir au moins un caractère spécial.';
        }

        return null;
    }
}