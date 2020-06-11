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

<script>
    $(document).ready(function(){
        const tableAdmin = $('#table-admin');
        fileContentLoader(tableAdmin, '../table.php', {role: 'admin'});
    })
    
    // Modifier Admin
    $('#editForm').on('submit', function(e){
        e.preventDefault();
        const newPrenom = $('#new_prenom');
        const newNom = $('#new_nom');
        const newLogin = $('#new_login');
        if(checkRequired([newPrenom, newNom, newLogin]) && checkLength(newLogin, 5, 36) && checkIfOnlyLetters(newLogin)){
            $.ajax({
                url: '../../controllers/userCtrl.php',
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                dataType: 'JSON',
                success: function(res){
                    if(res.type === 'error'){
                        alert(res.message);
                    }else if(res.type === 'succes'){
                        $('#editUser').modal('hide'),
                        $('#editForm')[0].reset();
                        $('#table-admin').empty();
                        fileContentLoader($('#table-admin'), './../table.php', {role: 'admin'});
                    }
                }
            });
        }
    });
    
    // Editer admin
    $(document).on('click', '.edit', function(){
        const id = $(this).attr('id');
        const my_id = $('#my_id').attr('data-id');
        if(my_id !== id){
            alert("Vous ne pouvez pas modifier d'autres admins");
        }else{
            $.ajax({
                url: '../../data/getAdmin.php',
                type: 'POST',
                data: {id: id},
                dataType: 'JSON',
                success: function(res){
                    $('#editUser').modal('show');
                    $('#new_prenom').val(res.prenom);
                    $('#new_nom').val(res.nom);
                    $('#new_login').val(res.login);
                    $('#id_user').val(res.id);
                }
            })
        }
    });

    // Supprimer admin
    $(document).on('click', '.delete', function(){
        const id = $(this).attr('id');
        const my_id = $('#my_id').attr('data-id');
        if(my_id === id){
            alert("Vous ne pouvez pas supprimer votre compte");
        }else{
            if(confirm('Voulez-vous supprimer le compte?')){
                $.ajax({
                    url: '../../controllers/userCtrl.php',
                    type: 'POST',
                    data: {id_admin: id, operation: 'delete'},
                    success: function(res){
                        alert(res);
                        $('#table-admin').html('');
                        fileContentLoader($('#table-admin'), './../table.php', {role: 'admin'});
                    }
                })
            }
        }
    });
</script>