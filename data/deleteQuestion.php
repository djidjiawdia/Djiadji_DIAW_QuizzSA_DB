<?php

require_once './questions.php';

if(isset($_POST['id_question']) && isset($_POST['operation'])){
    if(deleteQuestion($_POST['id_question'])){
        echo json_encode(["status" => "success", "message" => "Question supprimée"]);
    }else{
        echo json_encode(["status" => "error", "message" => "Impossible de supprimer la question"]);
    }
}