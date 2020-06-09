<?php

require_once '../config/db_connection.php';
require_once './users.php';


if(isset($_POST['id'])){
    $user = getUser($_POST['id']);
    if($user){
        echo json_encode($user);
    }
}