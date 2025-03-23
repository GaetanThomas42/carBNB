<?php
$title = "Louer une voiture";
require_once("block/header.php");
?>

<h1 class="text-center text-primary my-4">🚗 <?= $title ?></h1>

<div class="container">
    <div class="row">
        <?php foreach ($cars as $car): ?>
            <div class="col-md-4 mb-4">
                <a href="index.php?action=rent_form&id=<?= $car->getId() ?>" class="text-decoration-none text-dark">
                    <div class="card shadow-lg h-100">
                        <img src="images/<?= $car->getImage() ?>"
                            alt="<?= $car->getModel() ?>"
                            class="card-img-top"
                            style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= $car->getModel() ?></h5>
                            <p class="card-text">
                                <strong>Marque :</strong> <?= $car->getBrand() ?><br>
                                <strong>Type :</strong> <?= $car->getCarType()->getName() ?><br>
                                <strong>Puissance :</strong> <?= $car->getHorsePower() ?> chevaux
                            </p>
                            <button class="btn btn-primary">Louer cette voiture</button>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once("block/footer.php"); ?>