<?php

session_start();

unset($_SESSION['user']);
unset($_SESSION['error']);
// unset va seulement supprimer les variables en session

// ou session_destroy() qui detruit completement la session

header('Location:index.php');
