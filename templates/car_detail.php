<?php
// Template de la route detail
// URL : index.php?action=detail&id=1

$title = $car->getModel() . " - Détails";
require_once("block/header.php");
?>

<div class="container my-5">
    <div class="card shadow-lg">
        <div class="row g-0">
            <div class="col-md-6">
                <img src="images/<?= $car->getImage() ?>" 
                     alt="<?= $car->getModel() ?>" 
                     class="img-fluid rounded-start" 
                     style="height: 100%; object-fit: cover;">
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <div class="card-body">
                    <h1 class="card-title text-primary"><?= $car->getModel() ?></h1>
                    <p class="card-text">
                        <strong>Marque :</strong> <?= $car->getBrand() ?><br>
                        <strong>Type :</strong> <?= $car->getCarType()->getName() ?><br>
                        <strong>Puissance :</strong> <?= $car->getHorsePower() ?> chevaux
                    </p>
                    <a href="index.php?action=index" class="btn btn-outline-secondary">Retour à la liste</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once("block/footer.php"); ?>
