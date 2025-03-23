<?php

namespace App\Controller;

use App\Manager\CarManager;

/**
 * IndexController
 * Contient les routes pour gérer les voitures en tant qu'admin
 */
class IndexController
{

    private CarManager $carManager;

    public function __construct()
    {
        // Quand on crée un IndexController
        // Il contiendra automatiquement un CarManager
        // Utilisable avec $this->carManager
        $this->carManager = new CarManager();
    }

    // Route HomePage -> URL : index.php
    public function homePage()
    {
        //Récuperer les voitures
        $cars = $this->carManager->selectAll();
        //Afficher les voitures dans la template
        require_once("./templates/index_car.php");
    }

    // Route DetailCar -> URL: index.php?action=detail&id=10 
    public function detailCar(int $id)
    {
        //Récuperer les voitures
        $car = $this->carManager->selectByID($id);
        if ($car != false) {
            //Afficher les voitures dans la template
            require_once("./templates/car_detail.php");
        } else {
            header("Location: index.php");
            exit();
        }
    }
}
