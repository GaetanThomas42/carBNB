<?php
$title = "Réserver une voiture";
require_once("block/header.php");

?>

<h1 class="text-center"><?= $title ?></h1>

<div class="container">
    <div class="card">
        <img src="images/<?= $car->getImage() ?>" alt="<?= $car->getModel() ?>" class="card-img-top" style="height: 200px; width: auto;">
        <div class="card-body">
            <h2><?= $car->getModel() ?></h2>
            <p><?= $car->getBrand() ?>, <?= $car->getHorsePower() ?> chevaux</p>

            <form action="index.php?action=rent_form&id=<?= $car->getId() ?>" method="POST">
                <input type="hidden" name="carId" value="<?= $car->getId() ?>">
                <input type="hidden" name="userLesseeId" value="<?= $userLesseeId ?>">
         
                <div class="mb-3">
                    <label for="start_date" class="form-label">Date de début</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="end_date" class="form-label">Date de fin</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Louer</button>
            </form>
        </div>
    </div>
</div>

<?php require_once("block/footer.php"); ?>
