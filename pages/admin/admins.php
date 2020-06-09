<div class="card m-3">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h2>Liste des admins</h2>
            <button class="btn-icon" data-toggle="modal" data-target="#addNewUser">
                Ajouter un admin 
                <span><i class="fas fa-plus-circle"></i></span>
            </button>
        </div>
        <div id="table-admin"></div>
    </div>
</div>

<?php
    $title = "Créer un admin";
    $desc = 'Pour proposer des quizz';
    $role = 'admin';
    require_once '../account.php';
?>
<div id="editUser" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h4 class="modal-title">Modier mes informations</h4>
                </div>
                <button type="button" id="editUser" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="editForm">
                    <div class="form-group">
                        <label for="new_prenom">Prénom</label>
                        <input type="text" name="new_prenom" id="new_prenom" class="form-control" placeholder="Ex: Abdoulaye">
                        <small class="error-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="new_nom">Nom</label>
                        <input type="text" name="new_nom" id="new_nom" class="form-control" placeholder="Ex: Diaw">
                        <small class="error-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="new_login">Login</label>
                        <input type="text" name="new_login" id="new_login" class="form-control" placeholder="Ex: jahji ">
                        <small class="error-text"></small>
                    </div>
                    <input type="hidden" name="id_user" id="id_user">
                    <div class="d-flex justify-content-center">
                        <button type="submit" name="modifierUser" class="btn my-btn-primary">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
