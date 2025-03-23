<?php
// Template de la route edit
// URL : index.php?action=edit&id=1

$title = "Modifier " . $car->getModel();
require_once("block/header.php");
?>

<div class="container">
    <h1 class="text-primary text-center my-4">Modifier <?= $car->getBrand() ?> <?= $car->getModel() ?></h1>

    <div class="text-center mb-4">
        <img id="preview" src="images/<?= $car->getImage() ?>" alt="<?= $car->getModel() ?>" class="img-fluid rounded shadow" style="height: 200px;">
    </div>

    <form method="POST" action="index.php?action=edit_car&id=<?= $car->getId() ?>" class="w-50 mx-auto" enctype="multipart/form-data">

        <div class="mb-3">
            <label for="model" class="form-label">Modèle</label>
            <input id="model" type="text" name="model" class="form-control" value="<?= $_POST['model'] ?? $car->getModel()  ?>">
            <?php if (isset($errors['model'])): ?>
                <p class="text-danger"><?= $errors['model'] ?></p>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="brand" class="form-label">Marque</label>
            <input type="text" name="brand" class="form-control" value="<?= $_POST['brand'] ?? $car->getBrand()  ?>">
            <?php if (isset($errors['brand'])): ?>
                <p class="text-danger"><?= $errors['brand'] ?></p>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="horsePower" class="form-label">Puissance (chevaux)</label>
            <input id="horsePower" type="number" name="horsePower" class="form-control" value="<?= $_POST['horsePower'] ?? $car->getHorsePower()  ?>">
            <?php if (isset($errors['horsePower'])): ?>
                <p class="text-danger"><?= $errors['horsePower'] ?></p>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="carType" class="form-label">Type de voiture</label>
            <select id="carType" name="carType" class="form-select">
                <?php foreach ($carTypes as $carType): ?>
                    <option value="<?= $carType->getId() ?>"
                        <?= $car->getCarType()->getId() == $carType->getId() ? 'selected' : '' ?>>
                        <?= $carType->getName() ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['carType'])): ?>
                <p class="text-danger"><?= $errors['carType'] ?></p>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input id="image" type="file" name="image" class="form-control" accept="image/*">

            <?php if (isset($errors['file'])): ?>
                <p class="text-danger"><?= $errors['image'] ?></p>
            <?php endif; ?>
            <?php if (isset($errors['file'])): ?>
                <p class="text-danger"><?= $errors['image'] ?></p>
            <?php endif; ?>
        </div>


        <div class="text-center">
            <button type="submit" class="btn btn-success w-100">✅ Valider</button>
        </div>
    </form>
</div>

<?php require_once("block/footer.php"); ?>