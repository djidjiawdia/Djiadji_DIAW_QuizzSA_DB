<?php
require_once '../data/questions.php';

$question = trim($_POST['question']);
$point = $_POST['point'];
$type = $_POST['type'];
$reponse = $_POST['response'];
if(isset($_POST['goodResp'])){
    $goodResp = $_POST['goodResp'];
}

if(!empty($question) && !empty($type) && !empty($point) && !empty($reponse)){
    
    $id_question = saveQuestion($question, $point, $type);

    if($type === 'text'){
        if(saveResponse($reponse[0], 1, $id_question)){
            echo '<p>Question ajoutée</p>';
        }else{
            echo '<p>Impossible d\'ajouter une question</p>';
        }
    }else{
        foreach($reponse as $k => $val){
            if(in_array($k, $goodResp)){
                $correct = 1;
            }else{
                $correct = 0;
            }
            if(saveResponse($val, $correct, $id_question)){
                echo '<p>Question ajoutée</p>';
            }else{
                echo '<p>Impossible d\'ajouter une question</p>';
            }
        }
    }
}

if(isset($_POST['slider'])){
    $nbr = $_POST['slider'];
    if($nbr >= 5){
        if(updateJeu($nbr)){
            echo "success";
        }else{
            echo "error";
        }
    }
}