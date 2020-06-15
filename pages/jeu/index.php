<?php 
    $root = '/quizz';
    // $root = '../..';
    require_once '../header.php';
    if(empty($_SESSION['user'])){
        header("location:$root/");
    }else if($_SESSION['user']['role'] === "Admin"){
        header("location:/quizz/pages/admin/index.php");
        // header("location:../../pages/admin/index.php");
    }
?>
<?php require_once '../menu.php'; ?>

<div class="container-fluid" id="jeuContainer">

</div>

<?php require_once '../footer.php'; ?>