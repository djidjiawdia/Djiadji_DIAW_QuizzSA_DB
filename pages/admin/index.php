<?php 
    $root = '/quizz';
    // $root = '../..';
    require_once '../header.php';
    if(empty($_SESSION['user'])){
        header("location:/$root/");
    }else if($_SESSION['user']['role'] === "joueur"){
        header("location:/$root/pages/jeu/index.php");
    }
?>
<?php require_once '../menu.php'; ?>

<div class="container-fluid">

    <?php

        if(isset($_GET['page'])){
            switch($_GET['page']){
                case 'dashboard' :
                    include_once './dashboard.php';
                break;
                case 'questions' :
                    include_once './questions.php';
                break;
                case 'joueurs' :
                    include_once './joueurs.php';
                break;
                case 'admins' :
                    include_once './admins.php';
                break;
                default :
                    include_once './../accueil.php';
                break;
            }
        }else{
            include_once './dashboard.php';
        }
    ?>

</div>

<?php require_once '../footer.php'; ?>