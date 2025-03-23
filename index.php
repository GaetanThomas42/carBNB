<?php
require __DIR__ . '/vendor/autoload.php';

use App\Controller\AdminController;
use App\Controller\CarController;
use App\Controller\IndexController;
use App\Controller\SecurityController;
use App\Manager\UserManager;

// Démarrer la session et vérification de la connexion user 
session_start();
// Vérification si l'utilisateur est connecté
$isLoggedIn = false;
if (isset($_SESSION["username"])) {
    $userManager = new UserManager();
    $user = $userManager->selectByUsername($_SESSION["username"]);
    if ($user) {
        $isLoggedIn = true;
    }
}

// Récupérer les paramètres de l'URL et créer des valeurs par défaut
if (isset($_GET['action'])) {

    $action = $_GET['action'];
} else {

    $action = 'homePage';
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
} else {
    $id = null;
}

//Initialisation des controllers
$indexController = new IndexController();
$carController = new CarController();
$securityController = new SecurityController();

// Gérer les routes avec une suite de conditions if


//index.php?action=homePage
if ($action === 'homePage') {

    $indexController->homePage();

    //index.php?action=detail&id=12
} elseif ($action === 'detail' && !is_null($id)) {

    $indexController->detailCar($id);

    //index.php?action=login
} elseif ($action === 'login') {

    $securityController->login();

    //index.php?action=register
} elseif ($action === 'register') {

    $securityController->register();

    //index.php?action=logout + Connecté + CAR_OWNER
} elseif (!$isLoggedIn) {
    //REDIRECTION SI L'UTILISATEUR N'EST PAS CONNECTÉ
    $indexController->homePage();
} elseif ($action === 'myCars' && in_array('CAR_OWNER', $user->getRoles())) {

    $carController->myCars($user);
} elseif ($action === 'rentCar' && in_array('CAR_LESSEE', $user->getRoles())) {

    $carController->rentCar();

    //index.php?action=logout + Connecté
} elseif ($action === 'logout') {

    $securityController->logout();

    //index.php?action=logout + Connecté
} elseif ($action === 'admin' && in_array('ADMIN', $user->getRoles())) {

    $carController->dashboardAdmin();

    //index.php?action=add + Connecté
} elseif ($action === 'add'  && (in_array('ADMIN', $user->getRoles()) || in_array('CAR_OWNER', $user->getRoles()))) {

    $carController->addCar();

    //index.php?action=edit&id=10 + Connecté
} elseif ($action === 'edit' && !is_null($id) && $isLoggedIn && (in_array('ADMIN', $roles) || in_array('CAR_OWNER', $roles))) {

    $carController->editCar($id);

    //index.php?action=delete&id=10 + Connecté
} elseif ($action === 'delete' && !is_null($id) && $isLoggedIn && (in_array('ADMIN', $roles) || in_array('CAR_OWNER', $roles))) {

    $carController->deleteCar($id);

    //Sinon aucune route correspond -> page d'accueil par défaut + Clean url
} else {

    header("Location: index.php");
}
