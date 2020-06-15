<?php

require_once '../config/db_connection.php';
global $db;

function getResponses($id_q){
    global $db;
    $query_rep = "SELECT * FROM response WHERE id_question = ?";
    $stmt_rep = $db->prepare($query_rep);
    $stmt_rep->execute([$id_q]);
    return $stmt_rep->fetchAll(2);
}

$id = $_POST['id'];
$offset = $_POST['offset'];

$req = "
    SELECT *
    FROM trouver t
    INNER JOIN question q ON t.id_question = q.id_question
    WHERE t.id_user = ? 
";

$sql = $db->prepare($req);
$sql->execute([$id]);

$query = "
    SELECT *
    FROM trouver t
    INNER JOIN question q ON t.id_question = q.id_question
    WHERE t.id_user = ? 
    LIMIT 1
    OFFSET {$offset}
";

$stmt = $db->prepare($query);
$stmt->execute([$id]);

$result = $stmt->fetch(2);

if($stmt->rowCount() > 0){
    $output = '
        <input type="hidden" value="'.$sql->rowCount().'" id="rows" >
        <div class="quizzContent d-flex flex-column justify-content-center align-items-center w-100">
            <div class="question-score d-flex justify-content-center align-items-center">
                <div class="question">
                    <p>'.($offset+1).'. '.htmlentities($result['question'], ENT_QUOTES).'</p>
                </div>
                <div class="score d-flex justify-content-center align-items-center">
                    <span>'. $result['point'] .' points </span>
                </div>
            </div>
            <div class="responses row row mb-md-3">';
                foreach(getResponses($result['id_question']) as $i => $res){
                    if($result['type'] === 'text'){
                        $output .= '<input class="form-control" type="text" value="'. $res['reponse'] .'" readonly>';
                    }else{
                        $checked = ($res['correct'] == 1) ? "checked" : "";
                        $output .= '
                            <div class="resp-item col-md-5 mb-2 mb-md-4">
                                <label>
                                    <input type="'. $result['type'] .'" '. $checked .' disabled>'.
                                    htmlentities($res['reponse'], ENT_QUOTES).'
                                </label>
                            </div>
                        ';
                    }
                }
    $output .= '
            </div>
        </div>
    ';
    
    echo $output;
}else{
    echo '<h3>Pas encore de bonnes réponses</h3>';
}
