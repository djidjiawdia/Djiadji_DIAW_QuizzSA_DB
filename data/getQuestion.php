<?php

require_once '../config/db_connection.php';
global $db;

$limit = $_POST['limit'];
$offset = $_POST['offset'];

$output = '';

$query = "
    SELECT *
    FROM question
    ORDER BY id_question
    LIMIT {$limit} 
    OFFSET {$offset}
";
$stmt = $db->prepare($query);
$stmt->execute();

$result = $stmt->fetchAll();
$total_row = $stmt->rowCount();

if($total_row > 0){

    foreach($result as $row){
        $div = '
            <div class="card mt-2">
                <div class="card-body">
                    <h2>'.$row['id_question'].'. '. $row['question'] .'</h2>
                    <div>
        ';
        
        $query_rep = "SELECT * FROM response WHERE id_question = ?";
        $stmt_rep = $db->prepare($query_rep);
        $stmt_rep->execute([$row['id_question']]);
        $responses = $stmt_rep->fetchAll(2);
        
        foreach($responses as $res){
            if($row['type'] == 'text'){
                $div .= '<input class="form-control" type="text" value="'. $res['reponse'] .'" readonly>';
            }else{
                $checked = ($res['correct'] == 1) ? "checked" : "";
                $div .= '
                <div class="custom-control custom-radio">
                    <input class="" type="'. $row['type'] .'" '. $checked .' disabled>
                    <label>'. htmlentities($res['reponse'], ENT_QUOTES) .'</label>
                </div>
                ';
            }
        }

        $div .= '
                      </div>
                </div>
            </div>
        ';
        $output .= $div;
    }
    // echo json_encode($result);

}

echo $output;

?>
