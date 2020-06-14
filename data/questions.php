<?php

require_once '../config/db_connection.php';

function saveQuestion($question, $point, $type){
    global $db;
    $query = "INSERT INTO question (type, question, point) VALUES (:type, :question, :point)";
    $stmt = $db->prepare($query);
    $stmt->execute([
        "type" => $type,
        "question" => $question,
        "point" => $point
    ]);
    return $db->lastInsertId();
}

function get_all_questions(){
    global $db;
    $stmt = $db->prepare("SELECT * FROM question");
    $stmt->execute();
    return $stmt->fetchAll();
}

function saveResponse($response, $correct, $id_question){
    global $db;
    $query = "INSERT INTO response (reponse, correct, id_question) VALUES (:response, :correct, :id_question)";
    $stmt = $db->prepare($query);
    return $stmt->execute([
        "response" => $response,
        "correct" => $correct,
        "id_question" => $id_question
    ]);
}

function updateJeu($nbr){
    global $db;
    $query = "
        UPDATE jeu
        SET nbr_question = :nbr
        WHERE id_jeu = :id_jeu
    ";
    $stmt = $db->prepare($query);
    return $stmt->execute([
        "nbr" => $nbr,
        "id_jeu" => 1
    ]);
}

function getResponses($id_q){
    global $db;
    $query_rep = "SELECT * FROM response WHERE id_question = ?";
    $stmt_rep = $db->prepare($query_rep);
    $stmt_rep->execute([$id_q]);
    return $stmt_rep->fetchAll(2);
}

function deleteQuestion($id){
    global $db;
    $stmt = $db->prepare("DELETE FROM response WHERE id_question = ?");
    if($stmt->execute([$id])){
        $stmt1 = $db->prepare("DELETE FROM trouver WHERE id_question = ?");
        if($stmt1->execute([$id])){
            $stmt2 = $db->prepare("DELETE FROM question WHERE id_question = ?");
            $stmt2->execute([$id]);
            return true;
        }
    }
    return false;
}