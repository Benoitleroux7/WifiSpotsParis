<?php

function dbConnect()
{
    //Connexion a la base de donnée
    $db = new PDO('mysql:host=localhost;dbname=wifispotsparis;charset=utf8;port=3308', 'root', '');
    return $db;
}


function verifyUser($idUser, $password)
{
    //Vérification de l'utilisateur dans la base de donnée
    $db = dbConnect();
    $query = $db->prepare("SELECT ID FROM table_utilisateur WHERE email = ? AND password = ?");
	  $hash = hash("sha256", $password);
    $query->execute(array($idUser, $hash));
    $id = $query->fetch();
    $query->closeCursor();

    return $id;
}

function verifyMail($mail)
{
    //Vérification de l'utilisateur dans la base de donnée
    $db = dbConnect();
    $query = $db->prepare("SELECT ID FROM table_utilisateur WHERE email = ?");
    $query->execute(array($mail));
    $id = $query->fetch();
    $query->closeCursor();

    return $id;
}

function addUser($nom, $prenom, $district, $email, $password) {
    //Ajout d'un utilisateur dans la base de donnée
    $db = dbConnect();
    if (verifyMail($email)) {
        return;
    }
	$hash = hash("sha256", $password);
    $adding = $db->prepare("INSERT INTO table_utilisateur(nom, prenom, district, email, password) VALUES(:nom, :prenom, :district, :email, :password)");
    $adding->execute(array(
        'nom' => $nom,
        'prenom' => $prenom,
        'district' => $district,
        'email' => $email,
        'password' => $hash
    ));

    $max = $db->query("SELECT MAX(ID) FROM table_utilisateur");
    $id = $max->fetch()['MAX(ID)'];
    $max->closeCursor();
    return $id;
}

function getInfoUser($idUser)
{
    //Récupère les infos d'un utilisateur
    $db = dbConnect();
    $query = $db->prepare("SELECT ID, nom, prenom, district, email, image_profil FROM table_utilisateur WHERE ID = ?");
    $query->execute(array($idUser));
    $info = $query->fetch();
    $query->closeCursor();

    //Return ID, nom, prenom, email, image_profil de l'utilisateur et son arrondissement
    return $info;
}

function setUser($idUser, $nom, $prenom, $district, $email) {
    $db = dbConnect();
    $query = $db->prepare("UPDATE table_utilisateur
        SET nom = :nom,
        prenom = :prenom,
        district = :district,
        email = :email
        WHERE ID = :idUser");
    $query->execute(array(
        'nom' => $nom,
        'prenom' => $prenom,
        'district' => $district,
        'email' => $email,
        'idUser' =>$idUser
    ));
}

function setProfileImage($idUser) {
    $db = dbConnect();
    $query = $db->prepare("UPDATE table_utilisateur SET image_profil = :image WHERE ID = :idUser");
    $query->execute(array('image' => $idUser.".jpg", 'idUser' => $idUser));
}

function updatePassword($email, $password) {
    $db = dbConnect();
    $update = $db->prepare("UPDATE table_utilisateur SET password = :password WHERE email = :email");
    $update->execute(array(
      'password' => $password,
      'email' => $email
    ));
}

function updatePasswordFromId($id, $password) {
  $db = dbConnect();
  $update = $db->prepare("UPDATE table_utilisateur SET password = :password WHERE ID = :id");
  $update->execute(array(
    'password' => $password,
    'id' => $id
  ));
}

function verifyUserFromId($id, $password) {
  $db = dbConnect();
  $query = $db->prepare("SELECT ID FROM table_utilisateur WHERE ID = ? AND password = ?");
  $query->execute(array($id, hash("sha256", $password)));
  return $query->fetch();
}