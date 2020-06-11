<?php 
    $root = '/quizz';
    // $root = '../..';
    require_once '../header.php';
    if(empty($_SESSION['user'])){
        header("location:/$root/");
    }else if($_SESSION['user']['role'] === "Joueur"){
        header("location:/quizz/pages/jeu/index.php");
    }
?>
<?php require_once '../menu.php'; ?>

<div class="container-fluid" id="adminContainer">

</div>

<?php require_once '../footer.php'; ?>