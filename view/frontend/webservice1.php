<?php
    $title = 'Webservice1';
    $cssFile = 'style-webservice1.css';
    $jsFile = "";
?>

<?php ob_start(); ?>

<button type="submit" class="bubbly-button" id="district-button">Spots wifi de l'arrondissement</button>

<button type="submit" class="bubbly-button" id="paris-button">Spots wifi de Paris</button>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>