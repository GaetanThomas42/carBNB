<?php
// Template de la route delete
// URL : index.php?action=delete&id=1

$title = "Supprimer " . $car->getModel();
require_once("block/header.php");
?>

<h1>Confirmer la suppression de <?= $car->getBrand() ?> <?= $car->getModel() ?> ?</h1>

<form class="p-3" method="POST" action="index.php?action=delete&id=<?= $car->getId(); ?>">
    <!-- Redirection admin -->
    <input class="btn btn-outline-primary me-3" type="submit" value="Annuler" formaction="index.php?action=admin">
    <!-- Redirection index -->
    <input class="btn btn-outline-danger" type="submit" value="Confirmer">
</form>

<?php
require_once("block/footer.php");