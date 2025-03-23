<?php

namespace App\Controller;

use App\Manager\CarManager;
use App\Model\Car;
use App\Model\User;

//
/**
 * AdminController
 * Contient les routes pour gérer les voitures en tant qu'admin
 */
class CarController
{

    private CarManager $carManager;

    public function __construct()
    {
        $this->carManager = new CarManager();
    }
    // Route MyCars  
    // URL : index.php?action=myCars
    public function myCars(User $user)
    {
        //Récuperer les voitures
        $cars = $this->carManager->selectByOwnerID($user->getId());
        //Afficher les voitures dans la template
        require_once("./templates/my_cars.php");
    }

    public function indexRent(){
        //Récuperer les voitures
        $cars = $this->carManager->selectAll();
        //Afficher les voitures dans la template
        require_once("./templates/index_car.php");
    }

    
    public function rentCar(int $id){
        //Récuperer les voitures
        $car = $this->carManager->selectByID($id);
        if(!$car){
            header("Location: index.php?action=index_rent");
            exit();
        }
        $errors = [];
        //Afficher les voitures dans la template
        require_once("./templates/rent_car.php");
    }

    // Route DashboardAdmin ( ancien admin.php ) 
    // URL : index.php?action=admin
    public function dashboardAdmin()
    {
        //Récuperer les voitures
        $cars = $this->carManager->selectAll();
        //Afficher les voitures dans la template
        require_once("./templates/index_admin.php");
    }

    // Route DashboardAdmin ( ancien add.php ) 
    // URL : index.php?action=add
    public function addCar()
    {
        $errors = [];
        // Si le formulaire est validé
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $errors = $this->validateCarForm($errors, $_POST);

            if (empty($errors)) {
                //Instancier une objet Car avec le sdonnées du formulaire
                $car = new Car(null, $_POST["brand"], $_POST["model"], $_POST["horsePower"], $_POST["image"]);
                // Ajouter la voiture en BDD  et rediriger
                $carManager = new CarManager();
                $carManager->insert($car);
                $this->dashboardAdmin();
                exit();
            }
        }
        require_once("./templates/car_insert.php");
    }

    // Route EditCar ( ancien update.php ) 
    // URL : index.php?action=edit&id=1
    public function editCar(int $id)
    {
        $car = $this->carManager->selectByID($id); // Un seul connect DB par page

        //Vérifier si la voiture avec l'ID existe en BDD
        if (!$car) {

            header("Location: index.php?action=admin");
            exit();
        }

        $errors = [];
        // Si le formulaire est validé
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Vérifier les champs du formulaire
            $errors = $this->validateCarForm($errors, $_POST);
            // Si le formulaire n'a pas renvoyé d'erreurs
            if (empty($errors)) {

                // Mettre à jour la voiture $car et rediriger
                $car->setModel($_POST["model"]);
                $car->setBrand($_POST["brand"]);
                $car->setImage($_POST["image"]);
                $car->setHorsePower($_POST["horsePower"]);

                $this->carManager->update($car);

                header("Location: index.php?action=admin");
                exit();
            }
        }
        require_once("./templates/car_update.php");
    }
    // Route Delete ( ancien delete.php ) 
    // URL : index.php?action=delete&id=1
    public function deleteCar(int $id)
    {
        $car = $this->carManager->selectByID($id);

        //Vérifier si la voiture avec l'ID existe en BDD
        if (!$car) {

            header("Location: index.php?action=admin");
            exit();
        }

        //Si le form est validé
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //Supprimer la voiture et rediriger
            $this->carManager->deleteByID($car->getId());

            header("Location: index.php?action=admin");
            exit();
        }

        require_once("./templates/car_delete.php");
    }


    public function validateCarForm(array $errors, array $carForm): array
    {
        if (empty($carForm["model"])) {
            $errors["model"] = "le modele de voiture est manquant";
        }
        if (empty($carForm["brand"])) {
            $errors["brand"] = "la marque de la voiture est manquante";
        }
        if (empty($carForm["horsePower"])) {
            $errors["horsePower"] = "la puissance du vehicule est manquante";
        }
        if (empty($carForm["image"])) {
            $errors["image"] = "l'image de la voiture est manquante";
        }
        //Démo class CarFormValidator

        return $errors;
    }
}
