<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>
        <?= $title ?? "Garage" ?>
    </title>
</head>

<body>

<nav class="mb-5 navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-light" href="index.php">Garage</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">

            

                <?php
                if (!isset($_SESSION["username"])) { ?>

                    <li class="nav-item">
                        <a class="nav-link text-light" href="index.php?action=login">Connexion</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-light" href="index.php?action=register">Inscription</a>
                    </li>

                <?php } else { 
                    //Vérification des rôles de l'utilisateur
                    ?>
                                            <li class="nav-item">

                    <span class="nav-link text-secondary">Hello, <?=$_SESSION["username"] ?></span>
                    </li>

                    <?php if (in_array('CAR_LESSEE', $_SESSION["roles"])) { ?>
      
                        <li class="nav-item">
                            <a class="nav-link text-light" href="index.php?action=rent_cars">Louer une voiture</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="index.php?action=my_lesseer_rents">Mes locations</a>
                        </li>
                    <?php } ?>

                    <?php if (in_array('CAR_OWNER', $_SESSION["roles"])) { ?>
     
                        <li class="nav-item">
                            <a class="nav-link text-light" href="index.php?action=my_cars">Mes voitures</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="index.php?action=my_owner_rents">Les locations de mes voitures</a>
                        </li>
                    <?php } ?>

                    <?php if (in_array('ADMIN', $_SESSION["roles"])) { ?>
 
                        <li class="nav-item">
                            <a class="nav-link text-light" href="index.php?action=admin">Admin</a>
                        </li>
                    <?php } ?>

                    <li class="nav-item">
                        <a class="nav-link text-light" href="index.php?action=logout">Déconnexion</a>
                    </li>
                    
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
