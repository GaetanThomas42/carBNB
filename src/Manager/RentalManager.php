<?php

namespace App\Manager;

use App\Model\Rental;
use App\Model\Car;
use App\Model\CarType;
use App\Model\User;
use PDO;

class RentalManager extends DatabaseManager
{
    /**
     * Récupère toutes les locations
     * @return array Tableau d'instances Rental.
     */
    public function selectAll(): array
    {
        $requete = self::getConnexion()->prepare("
        SELECT r.*, 
               c.model AS carModel, 
               c.brand AS carBrand, 
               c.horsePower AS carHorsePower, 
               c.image AS carImage, 
               carType.id AS carTypeID, 
               carType.name AS carType, 
               u.username AS renterName, 
               u.role AS renterRole, 
               u.id AS carLesseeID,  -- Le locataire
               owner.username AS ownerName, 
               owner.role AS ownerRole,
               owner.id AS ownerID  -- Le propriétaire
        FROM Rental r
        JOIN Car c ON r.car_id = c.id
        JOIN CarType carType ON c.car_type_id = carType.id
        JOIN User u ON r.renter_id = u.id
        JOIN User owner ON c.owner_id = owner.id;
    ");

        $requete->execute();
        // Pour le débogage, afficher les résultats de la requête

        $rentals = [];
        foreach ($requete->fetchAll() as $row) {
            // Récupération du carType et du owner
            $carType = new CarType($row["carTypeID"], $row["carType"]);
            $owner = new User($row["ownerID"], $row["ownerName"], "", json_decode($row["renterRole"], true));

            // Création de l'objet Car avec les informations récupérées
            $car = new Car($row["car_id"], $row["carBrand"], $row["carModel"], $row["carHorsePower"], $row["carImage"], $carType, $owner);

            // Création de l'objet User pour le locataire (carLesseeID)
            $renter = new User($row["carLesseeID"], $row["renterName"], "", json_decode($row["renterRole"], true));

            // Ajout de la location dans le tableau $rentals
            $rentals[] = new Rental(
                $row["id"], // ID de la location
                $car, // L'objet Car
                $renter, // L'objet User du locataire
                new \DateTime($row["start_date"]), // Date de début
                new \DateTime($row["end_date"]), // Date de fin
                $row["status"] // Statut de la location
            );
        }
        dd($rentals);
        return $rentals;
    }

    /**
     * Récupère une location par ID
     * @param int $id
     * @return Rental|false
     */
    public function selectByID(int $id): Rental|false
    {
        $requete = self::getConnexion()->prepare("
           SELECT r.*, 
               c.model AS carModel, 
               c.brand AS carBrand, 
               c.horsePower AS carHorsePower, 
               c.image AS carImage, 
               carType.id AS carTypeID, 
               carType.name AS carType, 
               u.username AS renterName, 
               u.role AS renterRole, 
               u.id AS carLesseeID,  -- Le locataire
               owner.username AS ownerName, 
               owner.role AS ownerRole,
               owner.id AS ownerID  -- Le propriétaire
        FROM Rental r
        JOIN Car c ON r.car_id = c.id
        JOIN CarType carType ON c.car_type_id = carType.id
        JOIN User u ON r.renter_id = u.id
        JOIN User owner ON c.owner_id = owner.id
            WHERE r.id = :id;
        ");
        $requete->execute([":id" => $id]);

        $row = $requete->fetch();

        if (!$row) {
            return false;
        }
        // Récupération du carType et du owner
        $carType = new CarType($row["carTypeID"], $row["carType"]);
        $owner = new User($row["ownerID"], $row["ownerName"], "", json_decode($row["renterRole"], true));

        // Création de l'objet Car avec les informations récupérées
        $car = new Car($row["car_id"], $row["carBrand"], $row["carModel"], $row["carHorsePower"], $row["carImage"], $carType, $owner);


        $renter = new User($row["renter_id"], $row["renterName"], "", $row["renterRole"]);

        return new Rental(
            $row["id"],
            $car,
            $renter,
            new \DateTime($row["start_date"]),
            new \DateTime($row["end_date"]),
            $row["status"]
        );
    }

    /**
     * Insère une nouvelle location
     * @param Rental $rental
     * @return bool
     */
    public function insert(Rental $rental): bool
    {
        $requete = self::getConnexion()->prepare("
            INSERT INTO Rental (car_id, renter_id, start_date, end_date, status)
            VALUES (:carId, :renterId, :startDate, :endDate, :status);
        ");

        $requete->execute([
            ":carId" => $rental->getCar()->getId(),
            ":renterId" => $rental->getRenter()->getId(),
            ":startDate" => $rental->getStartDate()->format("Y-m-d H:i:s"),
            ":endDate" => $rental->getEndDate()->format("Y-m-d H:i:s"),
            ":status" => $rental->getStatus()
        ]);

        return $requete->rowCount() > 0;
    }

    /**
     * Met à jour une location
     * @param Rental $rental
     * @return bool
     */
    public function update(Rental $rental): bool
    {
        $requete = self::getConnexion()->prepare("
            UPDATE Rental 
            SET car_id = :carId, renter_id = :renterId, start_date = :startDate, 
                end_date = :endDate, status = :status
            WHERE id = :id;
        ");

        $requete->execute([
            ":carId" => $rental->getCar()->getId(),
            ":renterId" => $rental->getRenter()->getId(),
            ":startDate" => $rental->getStartDate()->format("Y-m-d H:i:s"),
            ":endDate" => $rental->getEndDate()->format("Y-m-d H:i:s"),
            ":status" => $rental->getStatus(),
            ":id" => $rental->getId()
        ]);

        return $requete->rowCount() > 0;
    }

    /**
     * Supprime une location par ID
     * @param int $id
     * @return bool
     */
    public function deleteByID(int $id): bool
    {
        $requete = self::getConnexion()->prepare("DELETE FROM Rental WHERE id = :id;");
        $requete->execute([":id" => $id]);

        return $requete->rowCount() > 0;
    }
}
