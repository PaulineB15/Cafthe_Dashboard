<!-- Views/Dashboard/Accueil.php -->
<h1>Bienvenue sur le Tableau de Bord !</h1>
<p>Voici la liste de l'équipe :</p>

<ul>
    <?php foreach ($employes as $employe): ?>
        <li>
            <!-- On utilise les "getters" de notre Modèle -->
            <strong><?= htmlspecialchars($employe->getPrenom() . ' ' . $employe->getNom()) ?></strong> 
            (<?= htmlspecialchars($employe->getRole()) ?>)
        </li>
    <?php endforeach; ?>
</ul>