<?php


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://localhost/wifi/api-rest-bdd/Utilisateur/lire_un.php",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS =>"{\"id\":65}",
    CURLOPT_HTTPHEADER => array(
        "Content-Type: text/plain"
    ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
