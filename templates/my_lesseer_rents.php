<?php
$title = "Mes locations";
require_once("block/header.php");
?>

<h1 class="text-center text-primary my-4">📅 <?= $title ?></h1>

<div class="container">
    <div class="row">
        <?php if (empty($rentals)) : ?>
            <p class="text-center text-muted">Vous n'avez aucune location en cours.</p>
        <?php else : ?>
            <?php foreach ($rentals as $rental) : ?>
                <div class="col-md-4">
                    <div class="card shadow-lg mb-4">
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

<?php require_once("block/footer.php"); ?>