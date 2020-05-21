<?php
    $title = 'Ajout total';
    $cssFile = 'ajout-total.css';
    $jsFile = 'ajout-total-js.php';
	$errors = 'error_handler.js';
?>

<?php ob_start(); ?>

<h1>Création de votre compte !</h1>

<div id="total">
    <div class="slideAjout">

        <div class="content">
            <!-- <div id="image">
                <img src="public/assets/avatar.png" width="40px" height="40px" alt="icon" id="icon">
            </div> -->
                <input type="text" name="mainNom" placeholder="Nom" id="mainNom" required><br>
                <input type="text" name="mainPrenom" placeholder="Prénom" id="mainPrenom" required><br>
                <input type="number" name="mainDistrict" placeholder="Arrondissement" id="mainDistrict" min="1" max="20" required><br>
                <input type="text" name="mainEmail" placeholder="Adresse mail" id="mainEmail" required><br>
                <input type="password" name="password" placeholder="Mot de passe" id="mdp" required><br>
                <input type="password" name="pswVerify" placeholder="Confirmer le mot de passe" id="mdp2" required>
                <p class="error"></p>
        </div>
        <!-- <div id="bouton-avatar">
            <button type="button" class="avatar-button">Ajouter un avatar</button>
        </div> -->

    </div>

    <button type="button" name="button" class="bubbly-button" onclick="confirm()">Confirmer</button>

</div>


<?php $content = ob_get_clean(); ?>

<?php require('template.php') ?>