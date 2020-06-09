// Events
const limit = 2;
let offset = 0;
let page = 1;
$(document).ready(function(){
    const questionContainer = $("#question-content");
    const tableJoueurs = $('#table-joueurs')
    const tableAdmin = $('#table-admin')

    fileContentLoader(questionContainer, './loadQuestion.php');
    fileContentLoader(tableJoueurs, './../table.php', {role: 'player'});
    fileContentLoader(tableAdmin, './../table.php', {role: 'admin'});
})


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
                }else if(res.type === 'succes'){
                    if(res.role === "Admin"){
                        window.location = './pages/admin/';
                    }else{
                        window.location = './pages/jeu/';
                    }
                }
            }
        });
    }
})

// Functions Load Element
function fileContentLoader(field, fileName, data={role: ''}){
    field.load(`${fileName}`,data,function(response, status,detail){        
         if(status === 'error'){
            $("#table").html(`<p class="text-center alert alert-danger col">Le contenu demandé est introuvable!</p>`);
        }
    });
}

// Bloquer un joueur
$(document).on('click', '.bloquer', function(){
    const id = $(this).attr('id');
    const type = $(this).attr('name');
    if(confirm('Voulez vous bloquer le joueur?')){
        $.ajax({
            url: '../../controllers/userCtrl.php',
            method: 'POST',
            data: {id: id, type: type},
            success: function(res){
                alert(res)
                $('#table-joueurs').html('');
                fileContentLoader($('#table-joueurs'), './../table.php', {role: 'player'});
            }
        });
    }
});

// Débloquer un joueur
$(document).on('click', '.debloquer', function(){
    const id = $(this).attr('id');
    const type = $(this).attr('name');
    if(confirm('Voulez vous bloquer le joueur?')){
        $.ajax({
            url: '../../controllers/userCtrl.php',
            method: 'POST',
            data: {id: id, type: type},
            success: function(res){
                alert(res)
                $('#table-joueurs').empty();
                fileContentLoader($('#table-joueurs'), './../table.php', {role: 'player'});
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

// Type de réponse
$(document).on('change', '#type', function(e) {
    $('#responses').empty();
    $('#respError').empty();
    if(e.target.value === 'text'){
        $('#responses').append(generateRep(1, 'text'));
        $('#addInput').prop('disabled', true);
    }else{
        $('#addInput').prop('disabled', false);
    }
});

// Supprimer un champ de réponse
$(document).on('click', '#deleteInput', function(){
    $(this).parents('.form-group').remove();
    const numRep = $('#responses')[0].children.length+1;
    const type = $('#type').val();
    $('#responses').empty();
    for(let i = 1; i < numRep; i++){
        $('#responses').append(generateRep(i, type));
    }
});

// Ajouter un champ de réponse
$('#addInput').on('click', function(){
    $('#respError').empty();
    const numRep = $('#responses').children().length+1;
    const type = $('#type');
    if(checkRequired([type])){
        if(numRep <= 4){
            $(this).prop('disabled', false);
            $('#responses').append(generateRep(numRep, type.val()))
        }else{
            $(this).prop('disabled', true);
        }
    }
});

// Enregistrer une question
$('#enregistrer').on('click', function(e){
    $('#respError').empty();
    e.preventDefault();
    const numRep = $('#responses')[0].children.length+1;
    const question = $('#question');
    const point = $('#point');
    const type = $('#type');

    if(checkRequired([question, point, type])){
        const responsesEl = ($('#responses').children('.form-group'));
        if(type.val() === 'radio' || type.val() === 'checkbox'){
            if(responsesEl.length < 2){
                $('#respError').html('Ajouter au moins deux champs de réponses');
                return;
            }
        }
        for(el of responsesEl){
            const respText = el.querySelector('.form-control');
            if(!validateResponse(respText)) return;
        }
        
        const selectEl = $('#formAddQuest')[0].querySelectorAll(`input[type="${type.val()}"]:checked`);
        if(type.val() === 'radio' && selectEl.length < 1){
            $('#respError').html('Veuillez cocher la bonne réponse');
            return;
        }
        
        if(type.val() === 'checkbox' && selectEl.length < 2){
            $('#respError').html('Veuillez cocher au moins deux réponses');
            return;
        }

        $.ajax({
            url: '../../controllers/questionCtrl.php',
            method: 'POST',
            data: $('#formAddQuest').serialize(),
            success: function(res){
                $('#addNewQuest').modal('hide'),
                $('#formAddQuest')[0].reset();
                $('#question-content').load('./loadQuestion')
            }
        });
    }
});

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

// Enregistrer Admin
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

function generateRep(value, type = ''){
    html = `
        <div class="form-group">
            <label for="resp${value}">Réponse ${value}</label>
            <div class="d-flex align-items-center">
                <div class="w-100">
                    <input type="text" name="response[]" id="resp${value}" class="form-control my-border mr-2" placeholder="Entrer la réponse ${value}">
                    <small class="error-text"></small>
                </div>
    `;

    if(type !== "text"){
        html += `
                <input class="ml-2" type="${type}" name="goodResp[]" id="goodResp${value}" value="${value-1}">
                <button type="button" class="btn-icon" id="deleteInput">
                    <span><i class="fa fa-trash"></i></span>
                </button>
        `;
    }
    
    html += `
            </div>
        </div>
    `;
    return html;
}
