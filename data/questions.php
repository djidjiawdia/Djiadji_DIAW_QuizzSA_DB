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