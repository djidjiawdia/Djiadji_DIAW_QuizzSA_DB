<?php

require_once '../config/db_connection.php';
global $db;

$limit = $_POST['limit'];
$offset = $_POST['offset'];

$queryAll = "SELECT * FROM user WHERE id_role = ?";

$query = "
    SELECT *
    FROM user
    WHERE id_role = :id_role
    ORDER BY score DESC
    LIMIT {$limit} 
    OFFSET {$offset}
";

$stmtAll = $db->prepare($queryAll);
$stmtAll->execute([2]);
$total_rows = $stmtAll->rowCount();

$stmt = $db->prepare($query);
$stmt->execute(["id_role" => 2]);
$result = $stmt->fetchAll(2);

echo json_encode([$result, $total_rows]);