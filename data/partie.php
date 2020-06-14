<?php
session_start();
// echo 'jdfdfksd';die();
require_once '../config/db_connection.php';
global $db;

$sql = "Select nbr_question FROM jeu LIMIT 1";
$req = $db->query($sql);
$nbrQ = $req->fetch();

$query = "
    SELECT *
    FROM question q
    WHERE id_question NOT IN (SELECT id_question
                                FROM trouver
                                WHERE id_user = :id)
    ORDER BY RAND()
";
$stmt = $db->prepare($query);
$stmt->execute(["id" => $_SESSION['user']['id']]);
$result = $stmt->rowCount();


echo json_encode(["nbrParJeu" => (int)$nbrQ[0], "allQuest" => $result]);
