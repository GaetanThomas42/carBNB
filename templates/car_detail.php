<?php
// Template de la route detail
// URL : index.php?action=detail&id=1

$title = $car->getModel() . " détails";
require_once("block/header.php");
?>

<h1 class="text-center"><?= $car->getModel() ?></h1>
        <div class="col-4 d-flex p-3 justify-content-center">
            <img src="images/<?= $car->getImage() ?>" alt="<?= $car->getModel() ?>" style="height: 200px; width: auto;">
            <div class="p-2">
                <h2><?= $car->getModel() ?></h2>
                <p><?= $car->getBrand() ?>, <?= $car->getHorsePower() ?> chevaux</p>
            </div>
        </div>
<?php
require_once("block/footer.php");