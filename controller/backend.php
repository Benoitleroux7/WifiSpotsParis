<?php
require_once("model/frontend.php");
require_once("model/backend.php");

function getUserList() {
    $userArray = getUserArray();

    foreach ($userArray as &$user) {
        $user['house'] = getHouse($user['ID']);
    }

    return $userArray;
}