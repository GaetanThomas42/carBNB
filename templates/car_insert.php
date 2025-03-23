<?php
// Template de la route add
// URL : index.php?action=add

$title = "Ajouter une voiture";
require_once("block/header.php");
?>
<h1 class="text-success">Ajouter une voiture</h1>

<form method="POST" action="index.php?action=add" class="m-5">

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
    <label for="image">Image</label>
    <input id="image" type="text" name="image" value="<?= $_POST['image'] ?? '' ?>">
    <?php if (isset($errors['image'])): ?>
        <p class="text-danger"><?= $errors['image'] ?></p>
    <?php endif; ?>
    <button class="btn btn-outline-success">Valider</button>

</form>

<?php
require_once("block/footer.php");