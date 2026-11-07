<?php
// App/bootstrap.php

// On charge nos outils principaux
require_once __DIR__ . '/Core/Database.php';
require_once __DIR__ . '/Core/Router.php';

// On charge notre premier contrôleur (qu'on va créer juste après)
require_once __DIR__ . '/Controllers/DashboardController.php';