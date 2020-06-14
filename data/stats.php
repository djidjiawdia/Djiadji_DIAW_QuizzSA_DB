<?php

    require_once './questions.php';
    require_once './users.php';

    $players = get_all_users(2);
    $admins = get_all_users(1);
    $questions = get_all_questions();

    $output = [
        "players" => sizeof($players),
        "admins" => sizeof($admins),
        "questions" => sizeof($questions)
    ];

    echo json_encode($output);