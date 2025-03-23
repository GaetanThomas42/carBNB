<?php
// Template de la route register
// URL : index.php?action=register

$title = "Inscription";
require_once("block/header.php");
?>

<form method="POST" action="index.php?action=register">

    <span class="d-block p-2 text-bg-dark">

        <label for="Username">Username</label>
        <input type="text" name="username">

        <?php if (isset($errors["username"])) {?>
        <p class="text-danger">
            <?=$errors["username"] ?>
        </p>
        <?php } ?>

    </span>

    <span class="d-block p-2 text-bg-dark">

        <label for="password">Mot de passe</label>
        <input type="password" name="password">

        <?php if (isset($errors["password"])) {?>
        <p class="text-danger">
            <?=$errors["password"] ?>
        </p>
        <?php } ?>

    </span>
    <span class="d-block p-2 text-bg-dark">

        <button>Valider</button>
        <button formaction="index.php">Annuler</button>

    </span>

</form>

<a href="login.php">Se connecter</a>

<?php
require_once("block/footer.php");