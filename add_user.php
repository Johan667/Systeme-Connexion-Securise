<?php

require_once 'config/dbconnect.php';
require_once 'config/MyError.php';
require_once 'Controller.php';

// Pour utiliser la class Controller il faut l'instancier
$controller = new Controller($connexion);

// On recupere le contenu de nos variable
$form_username = $_POST['username'];
$form_password = $_POST['password'];

// On filtre l'input 'username' pour evitez les failles XSS*
//$form_username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_VALIDATE_REGEXP,
//[
//    'options' => [
//        'regexp' => '/^([0-9a-zA-Z_]){6,20}$/',
//    ],
//]);

if (is_string($form_username)) {
    $form_password = filter_input(INPUT_POST, 'password',FILTER_VALIDATE_REGEXP,
    [
        'options' => [
            'regexp' => '/^([0-9a-zA-Z_]){6,20}$/',
        ],
    ]);

    if (is_string($form_password)) {
        $user = $controller->getUser($form_username);
    }
}
    // On verifie si le pseudo de l'utilisateur n'existe pas en BDD
    if (is_array($user)) {
        $_SESSION['error']->setError(-2, 'Ce pseudo est déja choisi, écrivez un autre');
        header('Location:sign-in.php?error');
    } else {
        // On refiltre le mot de passe
        $password2 = filter_input(INPUT_POST, 'passwordconf', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // Si les deux mot de passe sont STRICTEMENT EGALE (type,syntaxe etc)
        if ($password2 === $form_password) {
            // Si c'est ok on ajoute un utilisateur, on hache la mot de passe avec le protocole BCRYPT
            $status = $controller->addUser(strtolower($form_username), password_hash($form_password, PASSWORD_BCRYPT));
            if ($status) {
                // Si l'utilisateur à été ajouté en renvoie vers index
                header('Location:index.php');
            }
        }
    }
