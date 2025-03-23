<?php
// Template de la route add
// URL : index.php?action=add

$title = "Ajouter une voiture";
require_once("block/header.php");
?>
<h1 class="text-success">Ajouter une voiture</h1>

<form method="POST" action="index.php?action=add_car" class="m-5" enctype="multipart/form-data">

    <label for="model">Model</label>
    <input id="model" type="text" name="model" value="<?= $_POST['model'] ?? '' ?>">
    <?php if (isset($errors['model'])): ?>
        <p class="text-danger"><?= $errors['model'] ?></p>
    <?php endif; ?>
    <label for="brand">Brand</label>
    <input type="text" name="brand" value="<?= $_POST['brand'] ?? '' ?>">
    <?php if (isset($errors['brand'])): ?>
        <p class="text-danger"><?= $errors['brand'] ?></p>
    <?php endif; ?>
    <label for="horsePower">HorsePower</label>
    <input id="horsePower" type="number" name="horsePower" value="<?= $_POST['horsePower'] ?? '' ?>">
    <?php if (isset($errors['horsePower'])): ?>
        <p class="text-danger"><?= $errors['horsePower'] ?></p>
    <?php endif; ?>
    <label for="carType">Type de voiture</label>
    <select id="carType" name="carType">
        <option value="">Sélectionnez un type</option>
        <?php foreach ($carTypes as $carType): ?>
            <option value="<?= $carType->getId() ?>" 
                <?= (isset($_POST['carType']) && $_POST['carType'] == $carType->getId()) ? 'selected' : '' ?>>
                <?= $carType->getName() ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php if (isset($errors['carType'])): ?>
        <p class="text-danger"><?= $errors['carType'] ?></p>
    <?php endif; ?>
    <div class="mb-3">
    <label for="image" class="form-label">Image</label>
    <input id="image" type="file" name="image" class="form-control" accept="image/*">
    </div>
    <?php if (isset($errors['file'])): ?>
        <p class="text-danger"><?= $errors['file'] ?></p>
    <?php endif; ?>
    <?php if (isset($errors['image'])): ?>
        <p class="text-danger"><?= $errors['image'] ?></p>
    <?php endif; ?>
</div>

    <button class="btn btn-outline-success">Valider</button>

</form>

<?php
require_once("block/footer.php");