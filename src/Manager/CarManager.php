<?php

namespace App\Manager;

use App\Model\Car;
use App\Model\CarType;
use App\Model\User;
use App\Service\FileUploader;
use PDO;

/**
 * CarManager
 * Gestion de la table Car
 */
class CarManager extends DatabaseManager
{
    /**
     * Récupère toutes les lignes de la table Car avec leurs relations
     * @return array Tableau d'instances Car.
     */
    public function selectAll(): array
    {
        $requete = self::getConnexion()->prepare("
            SELECT c.*, ct.id AS carTypeId, ct.name AS carTypeName, 
                   u.id AS ownerId, u.username AS ownerName, u.role AS ownerRole
            FROM car c
            JOIN CarType ct ON c.car_type_id = ct.id
            JOIN User u ON c.owner_id = u.id;
        ");
        $requete->execute();

        $arrayCars = $requete->fetchAll(PDO::FETCH_ASSOC);
        $cars = [];

        foreach ($arrayCars as $arrayCar) {


            $carType = new CarType($arrayCar["carTypeId"], $arrayCar["carTypeName"]);
            $owner = new User($arrayCar["ownerId"], $arrayCar["ownerName"], "", json_decode($arrayCar["ownerRole"], true));

            $cars[] = new Car(
                $arrayCar["id"],
                $arrayCar["brand"],
                $arrayCar["model"],
                (int) $arrayCar["horsePower"],
                $arrayCar["image"],
                $carType,
                $owner
            );
        }
        return $cars;
    }

    /**
     * Récupère une voiture par ID avec ses relations
     * @param int $id
     * @return Car|false
     */
    public function selectByID(int $id): Car|false
    {
        $requete = self::getConnexion()->prepare("
            SELECT c.*, ct.id AS carTypeId, ct.name AS carTypeName, 
                   u.id AS ownerId, u.username AS ownerName, u.role AS ownerRole
            FROM car c
            JOIN CarType ct ON c.car_type_id = ct.id
            JOIN User u ON c.owner_id = u.id
            WHERE c.id = :id;
        ");
        $requete->execute([":id" => $id]);

        $arrayCar = $requete->fetch(PDO::FETCH_ASSOC);

        if (!$arrayCar) {
            return false;
        }

        $carType = new CarType($arrayCar["carTypeId"], $arrayCar["carTypeName"]);
        $owner = new User($arrayCar["ownerId"], $arrayCar["ownerName"], "", json_decode($arrayCar["ownerRole"], true));

        return new Car(
            $arrayCar["id"],
            $arrayCar["brand"],
            $arrayCar["model"],
            (int) $arrayCar["horsePower"],
            $arrayCar["image"],
            $carType,
            $owner
        );
    }

    public function selectByOwnerID(int $ownerId): array
    {
        $requete = self::getConnexion()->prepare("
        SELECT c.*, ct.id AS carTypeId, ct.name AS carTypeName, 
               u.id AS ownerId, u.username AS ownerName, u.role AS ownerRole
        FROM car c
        JOIN CarType ct ON c.car_type_id = ct.id
        JOIN User u ON c.owner_id = u.id
        WHERE c.owner_id = :ownerId;
    ");
        $requete->execute([":ownerId" => $ownerId]);

        $arrayCars = $requete->fetchAll();
        $cars = [];

        foreach ($arrayCars as $arrayCar) {

            $carType = new CarType($arrayCar["carTypeId"], $arrayCar["carTypeName"]);
            $owner = new User($arrayCar["ownerId"], $arrayCar["ownerName"], "", json_decode($arrayCar["ownerRole"], true));

            $cars[] = new Car(
                $arrayCar["id"],
                $arrayCar["brand"],
                $arrayCar["model"],
                (int) $arrayCar["horsePower"],
                $arrayCar["image"],
                $carType,
                $owner
            );
        }

        return $cars;
    }
    /**
     * Insère une nouvelle voiture dans la base de données
     * @param Car $car
     * @return bool
     */
    public function insert(Car $car): bool
    {
        $requete = self::getConnexion()->prepare("
            INSERT INTO car (model, brand, horsePower, image, car_type_id, owner_id) 
            VALUES (:model, :brand, :horsePower, :image, :carTypeId, :ownerId);
        ");

        $requete->execute([
            ":model" => $car->getModel(),
            ":brand" => $car->getBrand(),
            ":horsePower" => $car->getHorsePower(),
            ":image" => $car->getImage(),
            ":carTypeId" => $car->getCarType()->getId(),
            ":ownerId" => $car->getOwner()->getId()
        ]);

        return $requete->rowCount() > 0;
    }

    /**
     * Met à jour une voiture dans la base de données
     * @param Car $car
     * @return bool
     */
    public function update(Car $car): bool
    {
        $requete = self::getConnexion()->prepare("
            UPDATE car 
            SET model = :model, brand = :brand, horsePower = :horsePower, 
                image = :image, car_type_id = :carTypeId, owner_id = :ownerId
            WHERE id = :id;
        ");

        $requete->execute([
            ":model" => $car->getModel(),
            ":brand" => $car->getBrand(),
            ":horsePower" => $car->getHorsePower(),
            ":image" => $car->getImage(),
            ":carTypeId" => $car->getCarType()->getId(),
            ":ownerId" => $car->getOwner()->getId(),
            ":id" => $car->getId()
        ]);

        return $requete->rowCount() > 0;
    }

    /**
     * Supprime une voiture par ID
     * @param int $id
     * @return bool
     */
    public function deleteByID(int $id): bool
    {
        $car = $this->selectByID($id);
        if (!$car) {
            return false;
        } else {
            try {
                $requete = self::getConnexion()->prepare("DELETE FROM car WHERE id = :id;");
                $requete->execute([":id" => $id]);
                if ($requete->rowCount() > 0) {
                    $fileUploader = new FileUploader();
                    $fileUploader->delete($car->getImage());
                    return true;
                } else {
                    return false;
                }
            } catch (\PDOException $e) {
                return false;
            }
        }
    }
}
