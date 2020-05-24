<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie la méthode
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // On inclut les fichiers de configuration et d'accès aux données
    include_once '../config/Database.php';
    include_once '../models/Utilisateur.php';

    // On instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    // On instancie les Utilisateur
    $produit = new Utilisateur($db);

    // On récupère les informations envoyées
    $donnees = json_decode(file_get_contents("php://input"));
    
    if(!empty($donnees->nom) && !empty($donnees->prenom) && !empty($donnees->email) && !empty($donnees->image_profil)){
        // Ici on a reçu les données
        // On hydrate notre objet
        $produit->nom = $donnees->nom;
        $produit->prenom = $donnees->prenom;
        $produit->email = $donnees->email;
        $produit->image_profil = $donnees->image_profil;

        if($produit->creer()){
            // Ici la création a fonctionné
            // On envoie un code 201
            http_response_code(201);
            echo json_encode(["message" => "L'ajout a été effectué"]);
        }else{
            // Ici la création n'a pas fonctionné
            // On envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "L'ajout n'a pas été effectué"]);         
        }
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}