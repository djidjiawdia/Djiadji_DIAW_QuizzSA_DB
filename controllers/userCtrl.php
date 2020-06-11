<?php
session_start();
require_once '../data/users.php';
require_once '../utils/validators.php';

if(isset($_POST['login']) && isset($_POST['password'])){
    $login = trim($_POST['login']);
    $password = $_POST['password'];
    if(!empty($login) && !empty($password)){
        $user = searchLogin($login);
        if(!$user){
            echo json_encode(["type" => "errorLog", "message" => "L'utilisateur est inconnue"]);
        }else if($user['password'] !== $password){
            echo json_encode(["type" => "errorPass", "message" => "Mot de passe incorrect"]);
        }else{
            $_SESSION["user"] = [
                "id" => $user[0],
                "prenom" => $user["prenom"],
                "nom" => $user["nom"],
                "login" => $user["login"],
                "avatar" => $user["avatar"],
                "score" => $user["score"],
                "statut" => $user["statut"],
                "role" => $user["libelle"],
            ];
            echo json_encode(["type" => "succes", "role" => $user["libelle"]]);
        }
    }
}

if(
    isset($_FILES['avatar']) && 
    isset($_POST["prenom"]) && 
    isset($_POST["nom"]) && 
    isset($_POST["login_i"]) && 
    isset($_POST["password_i"]) && 
    isset($_POST["passConfirm"]) && 
    isset($_POST["role"])
){
    $nom = trim($_POST["nom"]);
    $prenom = trim($_POST["prenom"]);
    $login = trim($_POST["login_i"]);
    $password = $_POST["password_i"];
    $passConfirm = $_POST["passConfirm"];
    $role = $_POST["role"];
    
    $fileName = $_FILES["avatar"]["name"];
    $fileExt = explode(".", $fileName);
    $fileActExt = strtolower(end($fileExt));

    if(!empty($nom) && !empty($prenom) && !empty($login) && !empty($password) && !empty($passConfirm) && !empty($role)){
        if(searchLogin($login)){
            echo json_encode(["type" => "errorLog", "message" => "Le login est déjà pris"]);
        }else{
            if(confirmPassword($password, $passConfirm)){
                $newFileName = $login.".".$fileActExt;
                $fileDest = "../uploads/".$newFileName;
                $path = '/uploads/'.$newFileName;
                if(saveUser($prenom, $nom, $login, $password, $path, $role)){
                    move_uploaded_file($_FILES["avatar"]["tmp_name"], $fileDest);
                    echo json_encode(["type" => "succes", "role" => $role, "message" => "User créé avec succès!!"]);
                }else{
                    echo json_encode(["type" => "errorInser", "message" => "Impossible d'enregistrer l'utilisateur"]);
                }
            }else{
                echo json_encode(["type" => "errorPass", "message" => "Les mots de passe ne sont pas identiques"]);
            }
        }
    }else{
        echo json_encode(["type" => "required", "message" => "Les champs sont obligatoires"]);
    }
}

if(isset($_POST["new_prenom"]) && isset($_POST["new_nom"]) && isset($_POST["new_login"]) && isset($_POST["id_user"])){
    $nom = trim($_POST["new_nom"]);
    $prenom = trim($_POST["new_prenom"]);
    $login = trim($_POST["new_login"]);
    $id = $_POST["id_user"];

    if(!empty($nom) && !empty($prenom) && !empty($login) && !empty($id)){
        if(updateUser($nom, $prenom, $login, $id)){
            echo json_encode(["type" => "succes", "message" => "Amdin mis à jour!!!"]);
        }else{
            echo json_encode(["type" => "error", "message" => "Impossible de mettre à jour!!"]);
        }
    }else{
        echo json_encode(["type" => "error", "message" => "Les champs sont obligatoires"]);
    }
}

if(isset($_POST["id_admin"]) && $_POST["operation"] == "delete"){
    if(deleteUser($_POST['id_admin'])){
        echo "Admin supprimé";
    }else{
        echo "Impossible de supprimer l'admin";
    }
}

if(isset($_POST["id"]) && isset($_POST["type"])){
    if($_POST["type"] === "bloquer"){
        if(update_player($_POST["id"], 1)){
            echo "Joueur bloqué avec success";
        }else{
            echo "Impossible de bloquer le joueur";
        }
    }elseif($_POST["type"] === "debloquer"){
            if(update_player($_POST["id"], 0)){
                echo "Joueur débloqué avec success";
            }else{
                echo "Impossible de débloquer le joueur";
            }
    }
}

if(isset($_GET["deconnexion"])){
    $_SESSION["user"] = [];
    unset($_SESSION["user"]);
    header("location: /quizz");
    // header("location: /");
}