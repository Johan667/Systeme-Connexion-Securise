<?php

class Controller
{
    private $_connexion;
    private $_user;
    private $_security;

    public function __construct($connexion)
    {
        $this->_connexion = $connexion;
    }

    public function getUser($form_username)
    {
        try {
            // Faire la requete SQL
            $sql = 'SELECT username, password FROM user WHERE username = LOWER(:uname);';

            // Requete préparer
            $statement = $this->_connexion->prepare($sql);

            // Injection de paramètres permet d'eviter les injections de requetes SQL
            $statement->bindParam('uname', $form_username);

            // Execution de la requete
            $statement->execute();

            // On récupère l'objet utilisateur de la base de données
            $this->_user = $statement->fetch();

            return $this->_user;
        } catch (Exception $error) {
            return $error->getMessage();
        }
    }

    // On va vérifier si l'empreinte numérique correspond à ce qui à été hashé lors de la création du mot de passe
    // Quand on compare un mot de passe on compare deux chaines de caractere hashé

    public function addUser($uname, $pass)
    {
        try {
            // Faire la requete SQL
            $sql = 'INSERT INTO user (username,password) VALUES (:name, :pwd)';

            // Requete préparer
            $statement = $this->_connexion->prepare($sql);

            // Injection de paramètres pour envoyer au serveur des requêtes qui sont autoriser
            $statement->bindParam('name', $uname);
            $statement->bindParam('pwd', $pass);

            // Return l'execution de la requete
            return $statement->execute();
        } catch (Exception $error) {
            echo $error->getMessage();
        }
    }

    public function verify_password($upwd)
    {
        return password_verify($upwd, $this->_user['password']);
    }

    public function modifyUsername($uname)
    {
        try {
            // Faire la requete SQL pour UPDATE LE PSEUDO
            $sql = 'UPDATE INTO user (username) VALUES (:name)';

            // Requete préparer
            $statement = $this->_connexion->prepare($sql);

            // Injection de paramètres pour envoyer au serveur des requêtes qui sont autoriser
            $statement->bindParam('name', $uname);

            // Return l'execution de la requete
            return $statement->execute();
        } catch (Exception $error) {
            echo $error->getMessage();
        }
    }
}
// Failles CSRF = envoie un lien qui ressemble a mon site sauf que c'est un lien pirate
