<?php
$title = "Mes locations";
require_once("block/header.php");
?>

<h1 class="text-center"><?= $title ?></h1>

<div class="container">
    <div class="row">
        <?php if (empty($rentals)) : ?>
            <p class="text-center">Vous n'avez aucune location en cours.</p>
        <?php else : ?>
            <?php foreach ($rentals as $rental) : ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="images/<?= htmlspecialchars($rental->getCar()->getImage()) ?>" 
                             alt="<?= htmlspecialchars($rental->getCar()->getModel()) ?>" 
                             class="card-img-top" 
                             style="height: 200px; object-fit: cover;">

                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($rental->getCar()->getModel()) ?></h5>
                            <p class="card-text">
                                <strong>Marque :</strong> <?= htmlspecialchars($rental->getCar()->getBrand()) ?><br>
                                <strong>Type :</strong> <?= htmlspecialchars($rental->getCar()->getCarType()->getName()) ?><br>
                                <strong>Puissance :</strong> <?= htmlspecialchars($rental->getCar()->getHorsePower()) ?> chevaux
                            </p>

                            <p class="card-text">
                                <strong>Date de début :</strong> <?= $rental->getStartDate()->format("d/m/Y") ?><br>
                                <strong>Date de fin :</strong> <?= $rental->getEndDate()->format("d/m/Y") ?>
                            </p>

                            <p class="card-text">
                                <strong>Statut :</strong> 
                                <span class="badge 
                                    <?= $rental->getStatus() === 'Pending' ? 'bg-warning' : 'bg-success' ?>">
                                    <?= htmlspecialchars($rental->getStatus()) ?>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once("block/footer.php"); ?>
