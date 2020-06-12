<div id="addNewUser" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h4 class="modal-title"><?= $title ?></h4>
                    <p><?= $desc ?></p>
                </div>
                <button type="button" id="addNewUser" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="inscForm">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="prenom">Prénom</label>
                                <input type="text" name="prenom" id="prenom" class="form-control" placeholder="Ex: Abdoulaye">
                                <small class="error-text"></small>
                            </div>
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" name="nom" id="nom" class="form-control"  placeholder="Ex: Diaw">
                                <small class="error-text"></small>
                            </div>
                            <div class="form-group">
                                <label for="login_i">Login</label>
                                <input type="text" name="login_i" id="login_i" class="form-control" placeholder="Ex: jahji ">
                                <small class="error-text"></small>
                            </div>
                            <div class="form-group">
                                <label for="password_i">Password</label>
                                <input type="password" name="password_i" id="password_i" class="form-control" placeholder="Mot de passe">
                                <small class="error-text"></small>
                            </div>
                            <div class="form-group">
                                <label for="password">Confirm password</label>
                                <input type="password" name="passConfirm" id="passConfirm" class="form-control" placeholder="Confirmer votre mot de passe">
                                <small class="error-text"></small>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <div class="avatar_i">
                                    <img id="profil" src="/public/images/avatar.png">
                                </div>
                                <label for="avatar" class="btn my-btn-primary btn-sm">
                                    <span>Add photo</span>
                                    <input type="file" name="avatar" id="avatar">
                                </label>
                                <small class="error-text"></small>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="role" id="role" value="<?= $role ?>">
                    <div class="d-flex justify-content-center">
                        <button type="submit" name="creerCompte" id="createAccount" class="btn my-btn-primary">Créer compte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Image avatar
    $(document).on('change', '#avatar', function(){
        if(validateAvatar(this)){
            $('#profil')[0].src = URL.createObjectURL(avatar.files[0]);
        }
    });

    // Enregistrer un utilisateur
    $('#inscForm').on('submit', function(e){
        e.preventDefault();
        let url;
        const role = $('#role').val();
        const prenom = $('#prenom');
        const nom = $('#nom');
        const login_i = $('#login_i');
        const password_i = $('#password_i');
        const passConfirm = $('#passConfirm');
        const avatar = $('#avatar')[0];
        if(
            checkRequired([prenom, nom, login_i, password_i, passConfirm]) && 
            checkLength(login_i, 5, 36) && 
            checkIfOnlyLetters(login_i) && 
            checkLength(password_i, 6, 25) && 
            validatePassword(password_i) &&
            validateConfirmPassword(password_i, passConfirm) &&
            validateAvatar(avatar)
        ){
            if(role === 'admin'){
                url = '../../controllers/userCtrl.php';
            }else if(role === 'player'){
                url = 'controllers/userCtrl.php'
            }
            $.ajax({
                url: url,
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                dataType: 'JSON',
                success: function(res){
                    console.log(res);
                    if(res.type === 'errorLog'){
                        setInvalid($('#login_i')[0], res.message);
                    }else if(res.type === 'errorPass'){
                        setInvalid($('#passConfirm')[0], res.message);
                    }else if(res.type === 'required' || res.type === 'errorInser'){
                        alert(res.message);
                    }else if(res.type === 'succes'){
                        $('#addNewUser').modal('hide'),
                        $('#inscForm')[0].reset();
                        if(res.role === "admin"){
                            $('#table-admin').empty();
                            fileContentLoader($('#table-admin'), './../table.php', {role: 'admin'});
                        }
                    }
                }
            });
        }
    });
</script>