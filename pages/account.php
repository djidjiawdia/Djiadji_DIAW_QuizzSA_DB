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
                                    <img id="profil" src="<?= $root ?>/public/images/avatar.png">
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