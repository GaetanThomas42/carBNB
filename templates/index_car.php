<?php
// Template de la route index
// URL : index.php?action=index

$title = "Bienvenue dans le Garage";
require_once("block/header.php");
?>

<h1 class="text-center">Listes des Voitures</h1>
<div class="d-flex flex-wrap justify-content-evenly">
    <?php foreach ($cars as $car): ?>
        <div class="col-4 d-flex p-3 justify-content-center">
            <img src="images/<?= $car->getImage() ?>" alt="<?= $car->getModel() ?>" style="height: 200px; width: auto;">
            <div class="p-2">
                <h2><?= $car->getModel() ?></h2>
                <p><?= $car->getBrand() ?>, <?= $car->getHorsePower() ?> chevaux</p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php
require_once("block/footer.php");