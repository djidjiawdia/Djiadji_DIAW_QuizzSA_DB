<?php

require_once '../config/db_connection.php';
global $db;

function countTypeQuest($type){
    global $db;
    $query = "SELECT * FROM question WHERE type = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$type]);
    return $stmt->rowCount();
}

$req = $db->prepare("SELECT login, score FROM user WHERE id_role = ?");
$req->execute([2]);
$result = $req->fetchAll(2);

echo json_encode(["type" => [countTypeQuest('text'), countTypeQuest('checkbox'), countTypeQuest('radio')], "players" => $result]);
