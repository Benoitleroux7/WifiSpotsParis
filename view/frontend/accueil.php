<?php
    $title = 'Accueil';
    $cssFile = 'style-accueil.css';
    $jsFile = 'accueil.js';
?>

<?php ob_start(); ?>

<div class="slideshow-container">

    <div class="mySlides fade">
        <img src="public/assets/pariswifi.png" style="width:80%;">
    </div>

    <div class="mySlides fade">
        <img src="public/assets/pariswifi2.png" style="width:80%;">
    </div>

    <div class="mySlides fade">
        <img src="public/assets/pariswifi3.png" style="width:80%;">
    </div>

</div>
<br/>

    <div id="review">
        <p>
            Bienvenue sur le site de Wifi Spots Paris !
            Nous vous proposons de trouver tous les spots wifi autour de vous dans Paris.
            Pour ce faire, connectez-vous à l'aide de votre compte ou créez-en un !
            Cliquez sur les barres en haut à gauche de votre écran pour sélectionner les différentes actions que vous souhaitez réaliser.
        </p>
    </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php require('template.php') ?>
