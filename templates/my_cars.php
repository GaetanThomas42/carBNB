<?php
$title = "Mes Locations";
require_once("block/header.php");
?>

<div class="container">
    <h2 class="text-center text-primary my-4"><?= $title ?></h2>

    <div class="row m-5">
        <?php if (empty($rentals)) : ?>
            <p class="text-center text-muted">Vous n'avez aucune location en cours.</p>
        <?php else : ?>
            <?php foreach ($rentals as $rental) : ?>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card shadow-lg mb-4 rounded overflow-hidden">
                        <img src="images/<?= $rental->getCar()->getImage() ?>"
                            alt="<?= $rental->getCar()->getModel() ?>"
                            class="card-img-top"
                            style="height: 200px; object-fit: cover;">

                        <div class="card-body">
                            <h5 class="card-title"><?= $rental->getCar()->getModel() ?></h5>
                            <p class="card-text">
                                <strong>Marque :</strong> <?= $rental->getCar()->getBrand() ?><br>
                                <strong>Type :</strong> <?= $rental->getCar()->getCarType()->getName() ?><br>
                                <strong>Puissance :</strong> <?= $rental->getCar()->getHorsePower() ?> chevaux
                            </p>

                            <p class="card-text">
                                <strong>Date de début :</strong> <?= $rental->getStartDate()->format("d/m/Y") ?><br>
                                <strong>Date de fin :</strong> <?= $rental->getEndDate()->format("d/m/Y") ?>
                            </p>

                            <p class="card-text">
                                <strong>Statut :</strong>
                                <span class="badge <?= $rental->getStatus() === 'Pending' ? 'bg-warning' : 'bg-success' ?>">
                                    <?= $rental->getStatus() ?>
                                </span>
                            </p>

                            <?php if ($rental->getStatus() === 'Pending') : ?>
                                <form action="index.php?action=confirm_rental" method="POST">
                                    <input type="hidden" name="rentalId" value="<?= $rental->getId() ?>">
                                    <button type="submit" class="btn btn-success w-100">✅ Confirmer</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<div class="container mt-5">
    <h2 class="text-center text-primary mb-4">🚗 Mes voitures</h2>

    <div class="text-center mb-4">
        <a class="btn btn-success" href="index.php?action=add_car">➕ Ajouter une Voiture</a>
    </div>

    <div class="row">
        <?php foreach ($cars as $car): ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card shadow-lg mb-4 rounded overflow-hidden">
                    <img src="images/<?= $car->getImage() ?>"
                        alt="<?= $car->getModel() ?>"
                        class="card-img-top img-fluid"
                        style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $car->getModel() ?></h5>
                        <p class="card-text">
                            <strong>Marque :</strong> <?= $car->getBrand() ?><br>
                            <strong>Type :</strong> <?= $car->getCarType()->getName() ?><br>
                            <strong>Puissance :</strong> <?= $car->getHorsePower() ?> chevaux
                        </p>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-primary w-50 me-2" href="index.php?action=edit_car&id=<?= $car->getId() ?>">✏️ Modifier</a>
                            <a class="btn btn-danger w-50" href="index.php?action=delete_car&id=<?= $car->getId() ?>">🗑️ Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once("block/footer.php"); ?>