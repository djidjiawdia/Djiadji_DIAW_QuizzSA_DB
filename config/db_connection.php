<?php
    $serveur = 'localhost';
    $dbname = 'sa_quizz';
    $user = 'root';
    $mdp = '';

    // $serveur = 'mysql-djiadjidiaw.alwaysdata.net';
    // $dbname = 'djiadjidiaw_sa_quizz';
    // $user = '203151';
    // $mdp = 'Avoirdes15et16';

    try {
        $db = new PDO('mysql:host='.$serveur.';dbname='.$dbname, $user, $mdp, [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
        ]);
    } catch (PDOException $e) {
        echo "Erreur lors de la connexion à la BD ".$e->getMessage();
    }
?>