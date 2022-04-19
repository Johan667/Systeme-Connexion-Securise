<?php
        require_once 'config/MyError.php';
        // require_once = On l'appelle une seul fois et on libère le fichier pour d'autres éléments

        // On recupère la session de la page login.php
        session_start();

        // On crée un token unique grâce au fonctions ci dessous
        $_SESSION['token'] = bin2hex(random_bytes(24));

        // random_bytes gènere ex:(string(10) "385e33f741")
        // bin2hex convertit des données binaires en représentation hexadécimale

        // Si il n'existe pas d'erreur dans la session crée une nouvelle erreur
        if (!isset($_SESSION['error'])) {
            $_SESSION['error'] = new MyError();
        }

        // Si il n'existe pas de Session user on indique à l'utilisateur de se connecter,
        // Sinon on affiche son nom d'utilisateur et un lien de deconnexion
        if (!isset($_SESSION['user'])) {
            echo '<h3> Veuillez vous connecter<br>',
                 'ou <a href="sign-in.php">Inscrivez vous </a></h3>';
        } else {
            echo '<h3>Bienvenue !<br>'.ucwords($_SESSION['user']['username']).'</h3>';
            echo "<h2><a href='logout.php'><i class='fa-solid fa-arrow-right-from-bracket'>&nbspDeconnexion </i></a></h2>";
        }

        ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/3f1f47ed70.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="65a05433-450c-44ee-8603-29c67224918f";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
    <script src="/tarteaucitron/tarteaucitron.js"></script>
    <script type="text/javascript"> var tarteaucitronForceLanguage = "fr"; </script>
<script type="text/javascript">
tarteaucitron.init({
  "privacyUrl": "mention.php", /* URL page mentions */

  "hashtag": "#tarteaucitron", /* Ouvrir le panneau du hashtag */
  "cookieName": "tarteaucitron", /* Nom du cookie */

  "orientation": "middle", /* Position banniere (top - bottom) */

  "groupServices": false, /* Groupe les services par categories */
                   
  "showAlertSmall": false, /* Petite alerte en bas a droite */
  "cookieslist": false, /* Montre la liste des cookies */
                   
  "closePopup": false, /* Fermer le popup */

  "showIcon": true, /* Montrer l'icone cookie */
  //"iconSrc": "", /* Optionnal: URL or base64 encoded image */
  "iconPosition": "BottomLeft", /* BottomRight, BottomLeft, TopRight and TopLeft */

  "adblocker": false, /* Detecte AD block */
                   
  "DenyAllCta" : true, /* Montre le bouton refuser tout */
  "AcceptAllCta" : true, /* Montre accepter tout */
  "highPrivacy": true, /* Desactive le contenu automatique */
                   
  "handleBrowserDNTRequest": false, /* If Do Not Track == 1, disallow all */

  "removeCredit": true, /* Retire le lien vers tarteaucitron */
  "moreInfoLink": true, /* Lien Plus d'infos */

  "useExternalCss": false, /* Si faut le CSS externe sera charger */
  "useExternalJs": false, /* Si faut le JS externe sera charger */

  //"cookieDomain": ".my-multisite-domaine.fr", /* Partage les cookies sur un multidomaine */
                  
  "readmoreLink": "", /* Changer le lien "lire plus"*/

  "mandatory": true, /* Montre un message a propose des cookies "mandatory" */
});
tarteaucitron.services.mycustomservice = {
  "key": "mycustomservice",
  "type": "ads|analytic|api|comment|other|social|support|video",
  "name": "MyCustomService",
  "needConsent": true,
  "cookies": ['cookie', 'cookie2'],
  "readmoreLink": "/custom_read_more", // If you want to change readmore link
  "js": function () {
    "use strict";
    // When user allow cookie
  },
  "fallback": function () {
    "use strict";
    // when use deny cookie
  }
};
</script>

    <title>Systeme de Connexion</title>
</head>

<body>

    <?php
        // Si il y à dans l'URL un ?error alors on l'affiche en STRONG
        if (!isset($_GET['error'])) {
            echo ' <strong>'.$_SESSION['error'].'</strong>';
        } ?>

    <form action="login.php" method="post">
        <!-- Le formulaire sera traité par la page login.php en methode post -->
        <div class="form-group">
            <p><label for="username">Nom d'utilisateur</label><br>
                <input type="text" placeholder="Entrez votre Login" name="username" required>

            </p>
            <!-- On met un input caché avec un token pour sécurisé la session et eviter une attaque CSRF -->
            <input type="hidden" name="token" value="<?=$_SESSION['token']; ?>">
            <p><label for="password">Mot de passe</label><br>
                <input type="password" placeholder="Entrez votre Mot de Passe" name="password" required>
            </p>
        </div>
        <p>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="cookie" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Se souvenir de moi
                </label><br>
            </div>
            <button type="submit" class="btn btn-success" value="connexion">Connexion</button>
        </p>
    </form>

</body>
<footer class="footer mt-auto py-3">
    <div class="container">
        <span class="text-muted"><a href="mention.php">Mentions Légales</a></span>
    </div>
</footer>

</html>



<!-- Faire en sorte que le form sois responsable face au demandes de la cnil 
consenetement droit a l'oubli droit a l'information
simple rapide efficace
checkbox consentement cgu
cookies bouton se souvenir 13mois
footer mentions légales-->