<?php
// App/Controllers/ClientController.php

class ClientController
{
    private function getRepository(): ClientRepository
    {
        $config = require __DIR__ . '/../../Config/Database.php';
        $pdo = (new Database($config))->getConnection();
        return new ClientRepository($pdo);
    }

    private function recupererFormulaire(): array
    {
        return [
            'prenom'              => trim($_POST['prenom'] ?? ''),
            'nom'                 => trim($_POST['nom'] ?? ''),
            'email'               => trim($_POST['email'] ?? ''),
            'telephone'           => trim($_POST['telephone'] ?? ''),
            'adresse_facturation' => trim($_POST['adresse_facturation'] ?? ''),
            'cp_facturation'      => trim($_POST['cp_facturation'] ?? ''),
            'ville_facturation'   => trim($_POST['ville_facturation'] ?? ''),
            'adresse_livraison'   => trim($_POST['adresse_livraison'] ?? ''),
            'cp_livraison'        => trim($_POST['cp_livraison'] ?? ''),
            'ville_livraison'     => trim($_POST['ville_livraison'] ?? '')
        ];
    }

    private function validerFormulaire(array $data): ?string
    {
        if ($data['prenom'] === '' || $data['nom'] === '' || $data['email'] === '') {
            return 'Le prénom, le nom et l\'adresse email sont obligatoires.';
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Veuillez saisir une adresse email valide.';
        }
        return null;
    }

    public function index(): void
    {
        $recherche = trim($_GET['q'] ?? '');
        $repo = $this->getRepository();

        View::render('Client/ListeClients', [
            'clients'       => $repo->findAll($recherche),
            'clientAEditer' => null,
            'recherche'     => $recherche,
            'messageSucces' => null,
            'messageErreur' => null
        ]);
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Cafthe_Dashboard/Public/clients');
            exit;
        }

        $repo = $this->getRepository();
        $data = $this->recupererFormulaire();
        $erreur = $this->validerFormulaire($data);

        if ($erreur !== null) {
            View::render('Client/ListeClients', [
                'clients'       => $repo->findAll(),
                'clientAEditer' => null,
                'recherche'     => '',
                'messageSucces' => null,
                'messageErreur' => $erreur
            ]);
            return;
        }

        $data['id_employe'] = isset($_SESSION['employe']['id']) ? (int)$_SESSION['employe']['id'] : null;
        $repo->create($data);

        View::render('Client/ListeClients', [
            'clients'       => $repo->findAll(),
            'clientAEditer' => null,
            'recherche'     => '',
            'messageSucces' => 'Le client a bien été ajouté.',
            'messageErreur' => null
        ]);
    }

    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $repo = $this->getRepository();
        $client = $repo->findById($id);

        if (!$client) {
            header('Location: /Cafthe_Dashboard/Public/clients');
            exit;
        }

        View::render('Client/ListeClients', [
            'clients'       => $repo->findAll(),
            'clientAEditer' => $client,
            'recherche'     => '',
            'messageSucces' => null,
            'messageErreur' => null
        ]);
    }

    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Cafthe_Dashboard/Public/clients');
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);
        $repo = $this->getRepository();
        $client = $repo->findById($id);

        if (!$client) {
            header('Location: /Cafthe_Dashboard/Public/clients');
            exit;
        }

        $data = $this->recupererFormulaire();
        $erreur = $this->validerFormulaire($data);

        if ($erreur !== null) {
            View::render('Client/ListeClients', [
                'clients'       => $repo->findAll(),
                'clientAEditer' => $client,
                'recherche'     => '',
                'messageSucces' => null,
                'messageErreur' => $erreur
            ]);
            return;
        }

        $repo->update($id, $data);

        View::render('Client/ListeClients', [
            'clients'       => $repo->findAll(),
            'clientAEditer' => null,
            'recherche'     => '',
            'messageSucces' => 'La fiche client a bien été mise à jour.',
            'messageErreur' => null
        ]);
    }

    public function details(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $repo = $this->getRepository();
        $client = $repo->findById($id);

        if (!$client) {
            header('Location: /Cafthe_Dashboard/Public/clients');
            exit;
        }

        View::render('Client/DetailsClient', [
            'client'           => $client,
            'stats'            => $repo->getStatistiquesClient($id),
            'produitsFavoris'  => $repo->getProduitsFavorisClient($id, 5),
            'commandes'        => $repo->findCommandesByClient($id)
        ]);
    }
}