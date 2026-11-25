<?php
// Fichier = gérer le profil

class ProfilController
{
    private function getEmployeRepository(): EmployeRepository
    {
        $config = require __DIR__ . '/../../Config/Database.php';
        $pdo = (new Database($config))->getConnection();
        return new EmployeRepository($pdo);
    }

    private function chargerEmployeConnecte(EmployeRepository $repo): Employe
    {
        $idEmploye = (int)($_SESSION['employe']['id'] ?? 0);
        $employe = $repo->findById($idEmploye);

        if (!$employe) {
            header('Location: /Cafthe_Dashboard/Public/logout');
            exit;
        }

        return $employe;
    }

    private function afficherVueProfil(
        Employe $employe,
        ?string $messageSucces = null,
        ?string $messageErreur = null
    ): void {
        View::render('Profil/MonProfil', [
            'employe'       => $employe,
            'messageSucces' => $messageSucces,
            'messageErreur' => $messageErreur
        ]);
    }

    // Affiche la page Mon Profil (GET /profil)
    public function index(): void
    {
        $repo = $this->getEmployeRepository();
        $employe = $this->chargerEmployeConnecte($repo);
        $this->afficherVueProfil($employe);
    }

    // Met à jour nom, prénom et email (POST /profil/infos)
    public function updateInfos(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Cafthe_Dashboard/Public/profil');
            exit;
        }

        $repo = $this->getEmployeRepository();
        $employe = $this->chargerEmployeConnecte($repo);
        $idEmploye = (int)$employe->getId();

        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if ($nom === '' || $prenom === '' || $email === '') {
            $this->afficherVueProfil(
                $employe,
                null,
                'Le nom, le prénom et l\'adresse email sont obligatoires.'
            );
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->afficherVueProfil(
                $employe,
                null,
                'Veuillez saisir une adresse email valide.'
            );
            return;
        }

        $employeExistant = $repo->findByEmail($email);
        if ($employeExistant !== null && (int)$employeExistant->getId() !== $idEmploye) {
            $this->afficherVueProfil(
                $employe,
                null,
                'Cette adresse email est déjà utilisée par un autre compte.'
            );
            return;
        }

        $repo->updateProfil($idEmploye, $nom, $prenom, $email);

        // Synchronise les données affichées dans la barre latérale
        $_SESSION['employe']['nom'] = $nom;
        $_SESSION['employe']['prenom'] = $prenom;
        $_SESSION['employe']['email'] = $email;

        $employeMisAJour = $this->chargerEmployeConnecte($repo);
        $this->afficherVueProfil(
            $employeMisAJour,
            'Vos informations personnelles ont bien été mises à jour.',
            null
        );
    }

    // Modifie le mot de passe après vérification de l'ancien (POST /profil/mot-de-passe)
    public function updatePassword(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Cafthe_Dashboard/Public/profil');
            exit;
        }

        $repo = $this->getEmployeRepository();
        $employe = $this->chargerEmployeConnecte($repo);
        $idEmploye = (int)$employe->getId();

        $ancienMotDePasse = $_POST['ancien_mot_de_passe'] ?? '';
        $nouveauMotDePasse = $_POST['nouveau_mot_de_passe'] ?? '';
        $confirmationMotDePasse = $_POST['confirmation_mot_de_passe'] ?? '';

        if ($ancienMotDePasse === '' || $nouveauMotDePasse === '' || $confirmationMotDePasse === '') {
            $this->afficherVueProfil(
                $employe,
                null,
                'Veuillez remplir tous les champs du mot de passe.'
            );
            return;
        }

        $hashActuel = $employe->getMotDePasseHash() ?? '';
        if (!password_verify($ancienMotDePasse, $hashActuel)) {
            $this->afficherVueProfil(
                $employe,
                null,
                'L\'ancien mot de passe est incorrect.'
            );
            return;
        }

        if (strlen($nouveauMotDePasse) < 8) {
            $this->afficherVueProfil(
                $employe,
                null,
                'Le nouveau mot de passe doit contenir au moins 8 caractères.'
            );
            return;
        }

        if ($nouveauMotDePasse !== $confirmationMotDePasse) {
            $this->afficherVueProfil(
                $employe,
                null,
                'La confirmation ne correspond pas au nouveau mot de passe.'
            );
            return;
        }

        $nouveauHash = password_hash($nouveauMotDePasse, PASSWORD_BCRYPT);
        $repo->updateMotDePasse($idEmploye, $nouveauHash);

        $employeMisAJour = $this->chargerEmployeConnecte($repo);
        $this->afficherVueProfil(
            $employeMisAJour,
            'Votre mot de passe a bien été modifié.',
            null
        );
    }
}