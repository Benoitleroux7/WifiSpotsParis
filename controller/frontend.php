<?php
require_once('model/frontend.php');
require_once('vendor/autoload.php');

function login($id, $password, $isChecked)
{
    $connected = false;
    //Connecter l'utilisateur
    $idFound = verifyUser($id, $password);
    if ($idFound)
    {   
        $_SESSION['idUser'] = $idFound['ID'];
        if ($isChecked)
        {
            setcookie('idUser', $id, time()+3600*24*30, null, null, false, true);
            setcookie('pswUser', $password, time()+3600*24*30, null, null, false, true);
            setcookie('remember', true, time()+3600*24*30);
        }
        $connected = true;
    }
    else
    {
        setcookie('remember', false, time()+3600*24*30);
		header("Refresh:0; url=index.php?action=redirect&page=login.php&updated&failed_login=true");
    }
    return $connected;
}

function disconnect()
{
    //Déconnecter l'utilisateur
    session_destroy();
    setcookie('remember', false, time()+3600*24*30);
}

function createUser()
{
    //Creation d'un utilisateur puis connection au site
    if (!verifyUser(htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password'])))
    {
        addUser(htmlspecialchars($_POST['nom']), htmlspecialchars($_POST['prenom']), htmlspecialchars($_POST['district']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password']));
    }
    else {
        throw new Exception("User already existing");
    }
}

function createTotal($infos) {
    $mainHouseUser = $infos['mainUser'];
    
    //Adding the main account
    $idMainUser = addUser($mainHouseUser[0], $mainHouseUser[1], $mainHouseUser[2], $mainHouseUser[3], $mainHouseUser[4]);
}

function profil()
{
    //Appel des infos utilisateur pour la page profil
    $user = getInfoUser($_SESSION['idUser']);
    $nomUser = $user['nom'];
    $prenomUser = $user['prenom'];
    $arrondissementUser = $user['district'];
    $emailUser = $user['email'];
    if ($user['image_profil'] == null) {
        $image = 'photo.svg';
    }
    else {
        $image = $user['image_profil'];
    }
    require('view/frontend/profil.php');
}

function saveUser() {
    setUser($_SESSION['idUser'], htmlspecialchars($_POST['nom']), htmlspecialchars($_POST['prenom']), htmlspecialchars($_POST['district']), htmlspecialchars($_POST['email']));
}

function saveImage() {
    if ($_FILES['file']['size'] <= 1000000)
    {
        $infosfichier = pathinfo($_FILES['file']['name']);
        $extension_upload = $infosfichier['extension'];
        $extensions_autorisees = array('jpg', 'jpeg', 'png');
        if (in_array(strtolower($extension_upload), $extensions_autorisees))
        {
            move_uploaded_file($_FILES['file']['tmp_name'], "public/assets/imageProfil/".$_SESSION['idUser'].".jpg");
            setProfileImage($_SESSION['idUser']);
            header("Refresh:0; url=index.php?action=redirect&page=profil.php");
        }
        else {
            echo "Choisissez une image";
        }
    }
    else {
        echo "Fichier trop gros";
    }
}

function resetPassword($email) {
    $newPassword = generatePassword(10);
    updatePassword($email, hash("sha256", $newPassword));
    sendPassword($email, $newPassword);
}

function generatePassword($length) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = '';
    for ($i=0; $i < $length; $i++) {
        $password .= $chars[rand(0, strlen($chars)-1)];
    }
    return $password;
}

function sendPassword($email, $password) {
    $body = 'Cliquez sur ce lien : <a href="deltadomus/index.php">deltadomus/index.php</a> </br>Connectez vous avec le mot de passe suivant : '.$password;

    // Create the Transport
    $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465,'ssl'))
    ->setUsername('deltadomusapp@gmail.com')
    ->setPassword('tvkjnhpftonkmqye');


    // Create the Mailer using your created Transport
    $mailer = new Swift_Mailer($transport);

    // Create a message
    $message = (new Swift_Message('Mot de passe oublié'))
      ->setFrom(['deltadomusapp@gmail.com' => 'DeltaDomus'])
      ->setTo([$email])
      ->setBody($body, 'text/html')
      ;

    // Send the message
    $result = $mailer->send($message);
}

function verifyPassword($id, $oldPassword, $newPassword) {
  if (verifyUserFromId($id, $oldPassword)) {
    updatePasswordFromId($id, hash("sha256", $newPassword));
    header("Refresh:0; url=index.php?action=redirect&page=profil.php&updated=1");
  }
  else {
    header("Refresh:0; url=index.php?action=redirect&page=profil.php&updated=0");
  }
}

function sendMail($nom, $prenom, $email, $contenu) {
  // Create the Transport
  $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465,'ssl'))
  ->setUsername('deltadomusapp@gmail.com')
  ->setPassword('tvkjnhpftonkmqye');


  // Create the Mailer using your created Transport
  $mailer = new Swift_Mailer($transport);

  // Create a message
  $message = (new Swift_Message('Nouveau message'))
    ->setFrom([$email => $nom." ".$prenom])
    ->setTo(["deltadomusapp@gmail.com"])
    ->setBody($contenu, 'text/html')
    ;

  // Send the message
  $result = $mailer->send($message);
}

function test() {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
}