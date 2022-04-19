<?php

// PDO est une interface qui permet d'acceder à la base de données.
// Elle est orienté objet et constitue une couche d'abstraction qui intervient entre l'appli php et la BDD
// PHP DATA OBJECT = PDO.

// On se connecte à la base de donnée

try {
    // Je me connecte à la base de données
    $connexion = new PDO(
        'mysql:host=localhost:3306;dbname=frameworkpdo', 'root', '');
    // On lui dit que c'est dans un tableau associatif qu'il se connecte
    $connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (Exception $error) {
    echo $error->getMessage();
    // Si la tentative de connexion echou on envoie un message d'erreur
}
