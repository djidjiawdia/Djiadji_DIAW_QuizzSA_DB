<?php

require_once '../config/db_connection.php';
global $db;

$role = $_POST['role'];
$limit = $_POST['limit'];
$offset = $_POST['offset'];

$queryAll = "SELECT * FROM user WHERE id_role = ?";

$query = "
    SELECT *
    FROM user
    WHERE id_role = :id_role
    LIMIT {$limit} 
    OFFSET {$offset}
";

if($role == 'admin'){
    $id_role = 1;
}else{
    $id_role = 2;
}

$stmtAll = $db->prepare($queryAll);
$stmtAll->execute([$id_role]);
$total_rows = $stmtAll->rowCount();

$stmt = $db->prepare($query);
$stmt->execute(["id_role" => $id_role]);
$result = $stmt->fetchAll(2);

echo json_encode([$result, $total_rows]);