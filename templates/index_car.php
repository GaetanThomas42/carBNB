<?php
// Template de la route index
// URL : index.php?action=index

$title = "Bienvenue dans le Garage";
require_once("block/header.php");
?>

<h1 class="text-center text-primary my-4">🚗 Liste des Voitures</h1>

<div class="container">
    <div class="row">
        <?php foreach ($cars as $car): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-lg">
                    <img src="images/<?= $car->getImage() ?>"
                        alt="<?= $car->getModel() ?>"
                        class="card-img-top"
                        style="height: 200px; object-fit: cover;">

                    <div class="card-body">
                        <h5 class="card-title"><?= $car->getModel() ?></h5>

                        <a href="index.php?action=detail_car&id=<?= $car->getId() ?>" class="btn btn-primary">
                            Voir détails
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once("block/footer.php"); ?>