<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/png" href="../../public/assets/icon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/<?= $cssFile ?>">
    <title><?= $title ?></title>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>

    <script src="public/js/index.js" defer></script>
    <?php if (isset($jsFile)): ?>
        <script src="public/js/<?= $jsFile ?>" defer></script>
    <?php endif; ?>
    <?php if (isset($errors)): ?>
        <script src="public/js/<?= $errors ?>" defer></script>
    <?php endif; ?>

</head>

<body>
    <nav>
        <a href="#" class="toggle-menu">
            <div class="toggle-icon-line first"></div>
            <div class="toggle-icon-line second"></div>
            <div class="toggle-icon-line third"></div>
        </a>
        <ul id="main-nav">
            <?php if (isset($_SESSION['idUser'])) { ?>
                <!-- Si l'utilisateur est connecté afficher ce menu -->
                <li><a href="index.php?action=redirect&amp;page=profil.php">Mon profil</a></li>
                <li><a href="index.php?action=redirect&amp;page=../rest/getDataDistrict16.php">Trouver les spots wifi</a></li>
                <li><a href="index.php?action=redirect&amp;page=contact.php">Contact</a></li>
                <li><a href="index.php?action=disconnect">Se déconnecter</a></li>
            <?php } else { ?>
                <!-- Sinon afficher ce menu -->
                <li><a href="index.php?action=redirect&amp;page=login.php">Se connecter</a></li>
                <li><a href="index.php?action=redirect&amp;page=ajout-total.php">Créer un compte</a></li>
                <li><a href="index.php?action=redirect&amp;page=contact.php">Contact</a></li>
            <?php } ?>
        </ul>

        <h1>Wifi Spots Paris</h1>

        <a href="index.php?action=redirect&amp;page=accueil.php" class="logo-link">
            <img src="public/assets/icon.svg" width="100px" height="100px" alt="icon" id="icon">
            <div class="wifi-symbol">
                <div class="wifi-circle first"></div>
                <div class="wifi-circle second"></div>
                <div class="wifi-circle third"></div>
            </div>
        </a>
    </nav>

    <div id="placeholder">
        <?= $content ?>
    </div>

    <div id="footer">
        <p id="contact">

        </p>
    </div>
</body>
</html>