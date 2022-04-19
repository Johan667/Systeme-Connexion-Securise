<?php

require_once 'config/dbconnect.php';
require_once 'config/MyError.php';
require_once 'Controller.php';

// Démarre la session ou la récupere
session_start();

// On recupere le contenu de nos variable
$form_username = htmlentities(trim($_POST['username']));
$form_password = htmlentities(trim($_POST['password']));

// Pour utiliser la class Controller il faut l'instancier et chercher le paramètre de connexion
$controller = new Controller($connexion);

// Récupere la méthode getUser dans le controller pour récuperer l'objet user
$user = $controller->getUser($form_username);

// On filtre l'input 'username' pour evitez les failles XSS*
$form_username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_REGEXP,
[
    'options' => [
        'regexp' => '#^[a-zA-Z-][a-zA-z0-9]{7,29}$#',
    ],
]);

$token = filter_input(INPUT_POST, 'post', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Verifie si on récupère un tableau $user
if (is_array($user)) {
    // On filtre le mot de passe
    $form_password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_ENCODED,FILTER_VALIDATE_REGEXP,
    [
        'options' => [
            'regexp' => '#^[a-zA-Z-][a-zA-z0-9]{7,29}$#',
        ],
    ]);
    // On rajoute l'user en session
    $_SESSION['user'] = $user;
    header('Location:index.php');
} else {
    $_SESSION['error']->setError(-1, 'Identification Echoué, Recommencez.');
    header('Location:index.php?error');
    // Sinon l'identification à échouée
}

// Faille XSS = Cross side scripting Injection de script malveillant généralement du JS
// Dans un formulaire ou URL d'un site; OWASM = organisme de recommandation
// On peux voler des données en session (cookies etc) ou d'installer un Malware ou fuite de données

// REGEX : L'ancre ^ affirme que nous sommes au début de la chaîne
// [a-z]{7} correspond à une lettre minuscule.
// [a-z0-9_]{7,29} correspond à 3 à 13 caractères.
// En mode insensible à la casse, dans de nombreux moteurs, il pourrait être remplacé par \w{3,13}
// L'ancre $ affirme que nous sommes à la fin de la chaîne
