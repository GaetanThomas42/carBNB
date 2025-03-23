<?php

namespace App\Manager;

use App\Model\CarType;
use PDO;

class CarTypeManager extends DatabaseManager
{
    /**
     * Récupère tous les types de voitures
     * @return array Tableau d'instances CarType.
     */
    public function selectAll(): array
    {
        $requete = self::getConnexion()->prepare("SELECT * FROM CarType;");
        $requete->execute();

        $types = [];
        foreach ($requete->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $types[] = new CarType($row["id"], $row["name"]);
        }

        return $types;
    }

    /**
     * Récupère un type de voiture par ID
     * @param int $id
     * @return CarType|false
     */
    public function selectByID(int $id): CarType|false
    {
        $requete = self::getConnexion()->prepare("SELECT * FROM CarType WHERE id = :id;");
        $requete->execute([":id" => $id]);

        $row = $requete->fetch(PDO::FETCH_ASSOC);
        return $row ? new CarType($row["id"], $row["name"]) : false;
    }
}
