<?php
require_once(__DIR__ . "/vendor/autoload.php");

use App\Manager\RentalManager; 

// Instanciation du manager de Rental
$rentalManager = new RentalManager();

// Récupérer toutes les locations
$rentals = $rentalManager->selectAll();

dump(file_exists("images/67e040b64f247dd.png"));