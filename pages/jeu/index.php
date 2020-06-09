<?php 
    $root = '/sa_quizz_db';
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
                case 'questions' :
                    include_once './questions.php';
                break;
                case 'reponses' :
                    include_once './reponses.php';
                break;
                case 'scores' :
                    include_once './scores.php';
                break;
                default :
                    include_once './../accueil.php';
                break;
            }
        }else{
            include_once './questions.php';
        }
    ?>

</div>

<?php require_once '../footer.php'; ?>