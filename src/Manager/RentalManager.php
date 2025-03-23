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
        return $this->fetchRentals();
    }

    /**
     * Récupère une location par ID
     * @param int $id
     * @return Rental|false
     */
    public function selectByID(int $id): Rental|false
    {
        $rentals = $this->fetchRentals("WHERE r.id = :id", [":id" => $id]);
        //fetchAll retourne un tableau, on veut un seul élément ou false
        return $rentals[0] ?? false;
    }

    /**
     * Récupère les locations d'un locataire donné
     * @param int $id
     * @return array|false
     */
    public function selectByLesseerID(int $id): array|false
    {
        return $this->fetchRentals("WHERE r.renter_id = :id", [":id" => $id]);
    }

        /**
     * Récupère les locations d'un owner donné
     * @param int $id
     * @return array|false
     */
    public function selectByOwnerID(int $id): array|false
    {
        return $this->fetchRentals("WHERE owner.id = :id", [":id" => $id]);
    }


    /**
     * Méthode privée pour récupérer les locations en fonction d'un filtre
     * @param string $whereClause Condition WHERE SQL (optionnelle)
     * @param array $params Paramètres de la requête SQL
     * @return array
     */
    private function fetchRentals(string $whereClause = "", array $params = []): array
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
                   u.id AS carLesseeID,  
                   owner.username AS ownerName, 
                   owner.role AS ownerRole,
                   owner.id AS ownerID  
            FROM Rental r
            JOIN Car c ON r.car_id = c.id
            JOIN CarType carType ON c.car_type_id = carType.id
            JOIN User u ON r.renter_id = u.id
            JOIN User owner ON c.owner_id = owner.id
            $whereClause;
        ");

        $requete->execute($params);

        $rentals = [];
        foreach ($requete->fetchAll() as $row) {
            $owner = new User($row["ownerID"], $row["ownerName"], "", json_decode($row["ownerRole"], true));
            $renter = new User($row["carLesseeID"], $row["renterName"], "", json_decode($row["renterRole"], true));
            $carType = new CarType($row["carTypeID"], $row["carType"]);

            $car = new Car(
                $row["car_id"],
                $row["carBrand"],
                $row["carModel"],
                $row["carHorsePower"],
                $row["carImage"],
                $carType,
                $owner
            );

            $rentals[] = new Rental(
                $row["id"],
                $car,
                $renter,
                new \DateTime($row["start_date"]),
                new \DateTime($row["end_date"]),
                $row["status"]
            );
        }
        return $rentals;
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
