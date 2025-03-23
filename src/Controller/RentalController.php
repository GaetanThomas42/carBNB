<?php

namespace App\Controller;

use App\Manager\CarManager;
use App\Manager\RentalManager;
use App\Manager\UserManager;
use App\Model\Rental;
use DateTime;

class RentalController
{

    private CarManager $carManager;
    private UserManager $userManager;
    private RentalManager $rentalManager;

    public function __construct()
    {

        $this->carManager = new CarManager();
        $this->userManager = new UserManager();
        $this->rentalManager = new RentalManager();
    }

    // Route HomePage -> URL : index.php?action=rent_car
    public function myLesseerRents($userId)
    {
        //Récuperer les voitures
        $rentals = $this->rentalManager->selectByLesseerID($userId);
        //Afficher les voitures dans la template
        require_once("./templates/my_lesseer_rents.php");
    }

    // Route HomePage -> URL : index.php?action=rent_cars
    public function rentCars()
    {
        //Récuperer les voitures
        $cars = $this->carManager->selectAll();
        //Afficher les voitures dans la template
        require_once("./templates/cars_rent.php");
    }

    // Route HomePage -> URL : index.php?action=rent_form&id=2
    public function rentForm(int $id, int $userLesseeId)
    {

        $car = $this->carManager->selectByID($id);

        if (!$car) {
            header("Location: index.php?action=rent_cars");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $carId = $_POST["carId"];
            $userLesseeId = $_POST["userLesseeId"];
            $startDate = $_POST["start_date"];
            $endDate = $_POST["end_date"];

            $car = $this->carManager->selectByID($carId);
            $renter = $this->userManager->selectByID($userLesseeId);

            if (!$car || !$renter) {
                echo "Erreur : voiture ou utilisateur non trouvé.";
                return;
            }

            $rental = new Rental(null, $car, $renter, new DateTime($startDate), new DateTime($endDate), "Pending");

            $this->rentalManager->insert($rental);

            header("Location: index.php?action=my_lesseer_rents");

            exit;
        }
        require_once("./templates/rent_form.php");
    }
    public function confirmRental(int $userId)
    {
        if (!isset($_POST["rentalId"])) {
            header("Location: index.php?action=my_owner_rents");
            exit;
        }
        $rentalId = (int) $_POST["rentalId"];
        // Vérifier si la location existe
        $rental = $this->rentalManager->selectByID($rentalId);
        // Vérifier si la location est en attente et si l'utilisateur est le propriétaire
        if (!$rental || $rental->getStatus() !== "Pending" || $rental->getCar()->getOwner()->getId() !== $userId) {
            header("Location: index.php?action=my_owner_rents");
            exit;
        }
        // Mettre à jour le statut
        $this->rentalManager->updateStatus($rentalId, "Approved");

        header("Location: index.php?action=my_owner_rents");
        exit;
    }
}
