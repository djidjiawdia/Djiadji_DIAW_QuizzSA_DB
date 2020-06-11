<?php

require_once '../config/db_connection.php';

function searchLogin($login){
    global $db;
    $stmt = $db->prepare("SELECT * FROM user INNER JOIN role ON user.id_role = role.id WHERE login = ?");
    $stmt->execute([$login]);
    return $stmt->fetch();
}

function get_all_users($role){
    global $db;
    $stmt = $db->prepare('SELECT * FROM user WHERE id_role = :id ORDER BY id DESC');
    $stmt->execute(["id" => $role]);
    return $stmt->fetchAll();
}

function deleteUser($id){
    global $db;
    $stmt = $db->prepare('DELETE FROM user WHERE id = ?');
    return $stmt->execute([$id]);
}

function updateUser($nom, $prenom, $login, $id){
    global $db;
    $stmt = $db->prepare('UPDATE user SET prenom = :prenom, nom = :nom, login = :login WHERE id = :id');
    return $stmt->execute([
        "prenom" => $prenom,
        "nom" => $nom,
        "login" => $login,
        "id" => $id
    ]);
}

function getUser($id){
    global $db;
    $stmt = $db->prepare('SELECT * FROM user WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function update_player($id, $val){
    global $db;
    $stmt = $db->prepare('UPDATE user SET statut = :statut WHERE id = :id');
    return $stmt->execute([
        "statut" => $val,
        "id" => $id
    ]);
}

function saveUser($prenom, $nom, $login, $password, $avatar, $role){
    global $db;
    $score = NULL;
    if($role == 'admin'){
        $id_role = 1;
    }else{
        $id_role = 2;
        $score = 0;
    }
    $query = 'INSERT INTO user (prenom, nom, login, password, avatar, score, id_role) VALUES (:prenom, :nom, :login, :password, :avatar, :score, :id_role)';
    $stmt = $db->prepare($query);
    return $stmt->execute([
        "prenom" => $prenom,
        "nom" => $nom,
        "login" => $login,
        "password" => $password,
        "avatar" => $avatar,
        "score" => $score,
        "id_role" => $id_role
    ]);
}
