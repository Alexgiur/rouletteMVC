<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?? 'Jeu de Roulette' ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<header id="head">
    <h2 class="alert alert-warning"><?= $pageTitle ?? 'Jeu de Roulette' ?></h2>
</header>
<br>
<?php 
if(isset($message_erreur) && $message_erreur != '') {
    echo "<div class=\"alert alert-danger errorMessage\">$message_erreur</div>";
}
if(isset($message_info) && $message_info != '') {
    echo "<div class=\"alert alert-info infoMessage\">$message_info</div>";
    if(isset($gagne) && $gagne) {
        echo "<div class=\"alert alert-success resultMessage\">$message_resultat</div>";
    } else if(isset($message_resultat)) {
        echo "<div class=\"alert alert-danger resultMessage\">$message_resultat</div>";
    }
}
?>