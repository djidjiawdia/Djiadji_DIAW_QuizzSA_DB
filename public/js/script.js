let allQuestions;
let questions;
let score;
let check;
let trouve = [];
let limit;
let offset;
let page;
let current = 0;
$(function(){
    const adminContainer = $('#adminContainer');
    const jeuContainer = $('#jeuContainer');
    const accueilContainer = $('#accueilContainer');



    $('#accueil').on('click', function(){navigation($(this), './pages/accueil.php', adminContainer)});
    $('#dashboard').on('click', function(){navigation($(this), './dashboard.php', adminContainer)});
    $('#listeQuestions').on('click', function(){navigation($(this), './questions.php', adminContainer)});
    $('#listeJoueurs').on('click', function(){navigation($(this), './joueurs.php', adminContainer)});
    $('#listeAdmins').on('click', function(){navigation($(this), './admins.php', adminContainer)});
    $('#questions').on('click', function(){navigation($(this), './partie.php', jeuContainer)});
    $('#reponses').on('click', function(){navigation($(this), './reponses.php', jeuContainer)});
    $('#scores').on('click', function(){navigation($(this), './scores.php', jeuContainer)});
    
    $('.nav-link:first').addClass('active');

    fileContentLoader(accueilContainer, './pages/accueil.php')
    fileContentLoader(adminContainer, './dashboard.php')
    fileContentLoader(jeuContainer, './partie.php')

})

function navigation(field, file, container){
    $('.nav-link').each((i, el) => {
        el.classList.remove('active')
    })
    field.addClass('active');
    fileContentLoader(container, file)
}

$(document).on('input', '#slider', function() {
    if($(this).val() >= 5){
        $('#slider_value').html($(this).val());
        $.ajax({
            url: '../../controllers/questionCtrl.php',
            data: {slider: $(this).val()},
            type: 'POST',
            success: function() {
                loadNumQuest()
            }
        });
    }
});

// Déconnexion
$(document).on('click', '#deconnexion', (e) => {
    if(!confirm('Voulez vous se deconnecter ?')){
        e.preventDefault();
    }
})

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

// Functions Load Element
function fileContentLoader(field, fileName, data={}){
    field.load(`${fileName}`,data,function(response, status,detail){        
         if(status === 'error'){
            $("#table").html(`<p class="text-center alert alert-danger col">Le contenu demandé est introuvable!</p>`);
        }
    });
}

