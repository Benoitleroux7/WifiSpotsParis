<?php

// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie que la méthode utilisée est correcte
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // On veut par exmemple obtenir les spots dans le 16 eme arrondissement
    // On inclut les fichiers de configuration et d'accès aux données
    $parisData = 'https://opendata.paris.fr/api/records/1.0/search/?dataset=sites-disposant-du-service-paris-wi-fi&q=&rows=300&facet=cp&facet=nom_site&facet=arc_adresse&facet=geo_point_2d&facet=etat2&q=cp%3D75016';
    $curlData = curl_init($parisData);

    // On instancie la base de données

    curl_setopt_array($curlData,[
        CURLOPT_SSL_VERIFYPEER => __DIR__.DIRECTORY_SEPARATOR.'C:\wamp64\www\1\WifiSpotsParis\certifParisData',
        CURLOPT_RETURNTRANSFER =>true,
        CURLOPT_TIMEOUT => 1
    ]);


    //Instanciation des spots
    $data= curl_exec($curlData);
    $data = json_decode($data,true);
    $spots = [];
    foreach($data['records'] as $record){
        //Récupération du spot
        $row = [
            "cp" => $record['fields']['cp'],
            "nom_site" => $record['fields']['nom_site'],
            "arc_adresses" => $record['fields']['arc_adresse'],
            "etat2" => $record['fields']['etat2']
        ];
        $spots['Spots WiFi'][] = $row;
    }
    // On envoie le code réponse 200 OK
    http_response_code(200);
    // On encode en json et on envoie
    echo json_encode($spots);




    //Close curl
    curl_close($curlData);

    /*
    // Instanciations des utilisateur à faire
    //TODO
    $produit = new Produits($db);

    $donnees = json_decode(file_get_contents("php://input"));

    if (!empty($donnees->id)) {
        $produit->id = $donnees->id;

        // On récupère le produit
        $produit->lireUn();

        // On vérifie si le produit existe
        if ($produit->nom != null) {

            $prod = [
                "id" => $produit->id,
                "nom" => $produit->nom,
                "description" => $produit->description,
                "prix" => $produit->prix,
                "categories_id" => $produit->categories_id,
                "categories_nom" => $produit->categories_nom
            ];
            // On envoie le code réponse 200 OK
            http_response_code(200);

            // On encode en json et on envoie
            echo json_encode($prod);
        } else {
            // 404 Not found
            http_response_code(404);

            echo json_encode(array("message" => "Le produit n'existe pas."));
        }


    }*/
} else {
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}