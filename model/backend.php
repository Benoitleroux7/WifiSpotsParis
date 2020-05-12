<?php

function getUserArray() {
    $db = dbConnect();
    $query = $db->prepare("SELECT ID, nom, prenom, email, district FROM table_utilisateur");
    $query->execute();

    while ($user = $query->fetch()) {
        $userArray[] = $user;
    }
    $query->closeCursor();

    return $userArray;
}