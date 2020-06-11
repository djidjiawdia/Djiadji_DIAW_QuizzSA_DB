<?php

require_once '../config/db_connection.php';
global $db;

$sql = 'SELECT nbr_question FROM jeu LIMIT 1';
$req = $db->query($sql);
$result = $req->fetch();

echo json_encode($result);