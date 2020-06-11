<?php 
$root = './';
require_once './pages/header.php';
if(!empty($_SESSION['user'])){
    if($_SESSION['user']['role'] === "Admin"){
        var_dump($_SESSION['user']['role']);
        header('location:'.$root.'/pages/admin/index.php');
    }else{
        header('location:'.$root.'/pages/jeu/index.php');
    }
}
?>
<?php require_once './pages/menu.php'; ?>

<div class="container-fluid" id="accueilContainer">
    
</div>

<?php require_once './pages/footer.php'; ?>