<?php
session_start();
require_once '../../config/db_connection.php';
global $db;

function getResponses($id_q){
    global $db;
    $query_rep = "SELECT * FROM response WHERE id_question = ?";
    $stmt_rep = $db->prepare($query_rep);
    $stmt_rep->execute([$id_q]);
    return $stmt_rep->fetchAll(2);
}

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
    LIMIT {$nbrQ[0]}
";
$stmt = $db->prepare($query);
$stmt->execute(["id" => $_SESSION['user']['id']]);
$result = $stmt->fetchAll(2);

