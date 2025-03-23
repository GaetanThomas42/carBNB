<?php
// Template de la route login
// URL : index.php?action=login

$title = "Connexion";
require_once("block/header.php");
?>
<h1>Login</h1>
<form method="POST" action="index.php?action=login">
    <label>Username</label>
    <input type="text" name="username">
    <?php if (isset($errors["username"])) { ?>
        <p class="text-danger">
            <?= $errors["username"] ?>
        </p>
    <?php } ?>
    <label>Password</label>
    <input type="password" name="password">
    <?php if (isset($errors["password"])) { ?>
        <p class="text-danger">
            <?= $errors["password"] ?>
        </p>
    <?php } ?>
    <button class="btn btn-outline-success">Se connecter</button>

    <?php if (isset($errors["login"])) { ?>
        <p class="text-danger">
            <?= $errors["login"] ?>
        </p>
    <?php } ?>

</form>

<?php
require_once("block/footer.php");