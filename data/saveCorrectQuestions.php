<?php
session_start();

require_once '../config/db_connection.php';
require_once './users.php';
global $db;

$id_user = $_POST['id_user'];
$questions = $_POST['id_questions'];
$score = $_POST['score'];

$user = getUser($id_user);

$output = '';

if(($user['score']) < $score){
    if(update_score($id_user, $score)){
        $_SESSION['user']['score'] = $score;
        $output['message'] = 'Félicitation Nouveau meilleur score';
        $output['type'] = 'newScore';
    }
}
if(!empty($questions)){
    foreach($questions as $id_q){
        $sql = 'INSERT INTO trouver VALUES (:id_u, :id_q)';
        $stmt = $db->prepare($sql);
        $stmt->execute([
            "id_u" => $id_user,
            "id_q" => $id_q
        ]);
    }
}

echo json_encode($output);