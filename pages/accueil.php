<div class="accueil row p-3">
    <div class="col-12 col-md-6 d-flex flex-row flex-md-column justify-content-center">
        <div class="">
            <h1 class="font-weight-bold mb-2">Le plaisir de jouer</h1>
            <p>Bienvenue sur la plateforme de Quizz...</p>
            <p>Jouer et tester votre niveau de culture générale.</p>
            <button data-toggle="modal" data-target="#addNewUser" class="btn btn-outline-warning waves-effect">S'inscrire</button>
        </div>
    </div>
    <div class="col-12 col-md-6">
    <div class="card">
        <div class="card-body d-flex align-items-center justify-content-center flex-row">
            <div class="w-75">
                <h3 class="card-title text-center font-weight-bold mb-4">Se Connecter</h3>
                <form method="POST" id="formConnexion">
                    <div class="form-group mb-5">
                        <label class="h5" for="login">Login</label>
                        <input type="text" name="login" id="login" placeholder="Entrer votre login" class="form-control">
                        <small class="error-text"></small>
                    </div>
                    <div class="form-group mb-5">
                        <label class="h5" for="password">Mot de passe</label>
                        <input type="password" name="password" id="password" placeholder="Entrer votre mot de passe" class="form-control">
                        <small class="error-text"></small>
                    </div>
                    <button class="btn my-btn-primary btn-block my-4" type="submit" id="connexion">Connexion</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    $title = "S'inscrire";
    $desc = 'Pour tester votre niveau de culture générale';
    $role = 'player';
    require_once './account.php';
?>

<script>
    $(document).ready(function(){
        // Connexion Form
        $('#connexion').on('click', function(e){
            e.preventDefault();
            const login = $('#login');
            const password = $('#password');
            if(checkRequired([login, password]) && checkLength(login, 5, 36) && checkLength(password, 6, 25) && validatePassword(password)){
                $.ajax({
                    url: './controllers/userCtrl.php',
                    type: 'POST',
                    data: {login: login.val(), password: password.val()},
                    dataType: 'JSON',
                    success: function(res){
                        if(res.type === 'errorLog'){
                            showError(login, res.message);
                        }else if(res.type === 'errorPass'){
                            showError(password, res.message);
                        }else if(res.type === 'bloque'){
                            alert(res.message);
                        }else if(res.type === "succes"){
                            if(res.role === "Admin"){
                                window.location = "./pages/admin/";
                            }else{
                                window.location = "./pages/jeu/";
                            }
                        }
                    }
                });
            }
        })
    })
</script>