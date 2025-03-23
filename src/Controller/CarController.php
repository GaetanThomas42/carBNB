<?php

namespace App\Controller;

use App\Manager\CarManager;
use App\Manager\CarTypeManager;
use App\Manager\RentalManager;
use App\Model\Car;
use App\Model\User;
use App\Service\FileUploader;

//
/**
 * AdminController
 * Contient les routes pour gérer les voitures en tant qu'admin
 */
class CarController
{

    private CarManager $carManager;
    private RentalManager $rentalManager;
    private CarTypeManager $carTypeManager;


    public function __construct()
    {
        $this->carManager = new CarManager();
        $this->rentalManager = new RentalManager();
        $this->carTypeManager = new CarTypeManager();
    }
    // Route MyCars  
    // URL : index.php?action=myCars
    public function myCars(User $user)
    {
        //Récuperer les voitures
        $cars = $this->carManager->selectByOwnerID($user->getId());
        $rentals = $this->rentalManager->selectByOwnerID($user->getId());

        //Afficher les voitures dans la template
        require_once("./templates/my_cars.php");
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
    public function addCar(User $user)
    {
        $errors = [];
        $carTypes = $this->carTypeManager->selectAll();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {


            if (!empty($_POST["carType"])) {
                $carType = $this->carTypeManager->selectByID($_POST["carType"]);
                if (!$carType) {
                    $errors["carType"] = "Le type de voiture n'existe pas";
                }
            }

            $errors = $this->validateCarForm($errors, $_POST);

            $fileUploader = new FileUploader();
            $fileUploadResult = [];

            // Si un fichier est sélectionné, on essaie de l'uploader
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $fileUploadResult = $fileUploader->upload($_FILES['image']); // Appel du service d'upload
            } else {
                $errors["image"] = "L'image est manquante";
            }

            // Si le résultat est un tableau d'erreurs, on les fusionne avec les autres erreurs
            if (is_array($fileUploadResult)) {
                $errors = array_merge($errors, $fileUploadResult);
            }

            if (empty($errors)) {
                $car = new Car(null, $_POST["brand"], $_POST["model"], $_POST["horsePower"], $fileUploadResult, $carType,  $user);
                $carManager = new CarManager();
                $carManager->insert($car);
                header("Location: index.php?action=my_cars");
                exit();
            }
        }
        require_once("./templates/car_insert.php");
    }

    // Route EditCar ( ancien update.php ) 
    // URL : index.php?action=edit&id=1
    public function editCar(int $id, User $user)
    {
        $car = $this->carManager->selectByID($id); // Un seul connect DB par page

        //Vérifier si la voiture avec l'ID existe en  ou si l'utilisateur est le propriétaire
        if (!$car || $car->getOwner()->getId() !== $user->getId()) {

            header("Location: index.php?action=admin");
            exit();
        }


        $carTypes = $this->carTypeManager->selectAll();

        $errors = [];
        //Si le formulaire est validé
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $errors = $this->validateCarForm($errors, $_POST);
            if (empty($errors) && !empty($_FILES['image']['name'])) {

                $fileUploader = new FileUploader();
                $fileUploadResult = [];

                if ($_FILES['image']['error'] == 0) {
                    $fileUploadResult = $fileUploader->upload($_FILES['image']); // Appel du service d'upload
                    // Si le résultat est un tableau d'erreurs, on les fusionne avec les autres erreurs
                    if (is_array($fileUploadResult)) {
                        $errors = $fileUploadResult;
                    } else {
                        $fileUploader->delete($car->getImage());
                        $car->setImage($fileUploadResult);
                    }
                } else {
                    $errors["image"] = "L'image est manquante";
                }
            }

            if (!empty($_POST["carType"])) {
                $carType = $this->carTypeManager->selectByID($_POST["carType"]);
                if (!$carType) {
                    $errors["carType"] = "Le type de voiture n'existe pas";
                }
            }


            if (empty($errors)) {

                $car->setModel($_POST["model"]);
                $car->setBrand($_POST["brand"]);
                $car->setHorsePower($_POST["horsePower"]);
                $car->setCarType($carType);
                $this->carManager->update($car);

                header("Location: index.php?action=my_cars");
                exit();
            }
        }
        require_once("./templates/car_update.php");
    }
    // Route Delete ( ancien delete.php ) 
    // URL : index.php?action=delete&id=1
    public function deleteCar(int $id, User $user)
    {
        $car = $this->carManager->selectByID($id);

        //Vérifier si la voiture avec l'ID existe en BDD
        if (!$car) {
            header("Location: index.php?action=my_cars");
            exit();
        }
        if ($car->getOwner()->getId() !== $user->getId()) {
            header("Location: index.php?action=my_cars");
            exit();
        }

        //Si le form est validé
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //Possible relation avec les locations à gérer ici
            $this->carManager->deleteByID($car->getId());
            header("Location: index.php?action=my_cars");
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

        if (empty($carForm["carType"])) {
            $errors["image"] = "Le type est manquant";
        }

        return $errors;
    }
}
