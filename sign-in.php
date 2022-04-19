<?php
require_once 'config/MyError.php';

session_start();

if (!isset($_GET['error'])) {
    echo ' <strong>'.$_SESSION['error'].'</strong>';
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

    <title>Inscrivez Vous</title>
</head>

<body>

    <h1>Inscrivez Vous</h1>
    <?php // Si il y à dans l'URL un ?error alors on l'affiche en STRONG
        if (!isset($_GET['error'])) {
            echo ' <strong>'.$_SESSION['error'].'</strong>';
        } ?>

    <form action="add_user.php" method="post">
        <!-- Le formulaire sera traité par la page add_user.php -->

        <input type="hidden" name="token" value="">
        <p><input type="text" placeholder="Entrez votre Login" name="username" required></p>

        <p><input type="password" placeholder="Entrez votre Mot de Passe" name="password" required></p>

        <p><input type="password" placeholder="Confirmer le Mot de passe" name="passwordconf" required></p>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="mentions" id="flexCheckDefault" required>
            <label class="form-check-label" for="flexCheckDefault">
                J'ai lu et j'accepte les <a href="mention.php">Mentions Légales</a>
            </label><br>

            <p><button type="submit" class="btn btn-success" value="inscription">Inscription</button></p>
    </form>

    <footer class="footer mt-auto py-3">
        <div class="container">
            <a href="index.php"><i class="fa-solid fa-house">&nbspAccueil</i></a><br>
            <span class="text-muted"><a href="mention.php">Mentions Légales</a></span>
        </div>
    </footer>
</body>

</html>