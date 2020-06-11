const limit = 2;
let offset = 0;
let page = 1;
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
    $('#questions').on('click', function(){navigation($(this), './questions.php', jeuContainer)});
    $('#reponses').on('click', function(){navigation($(this), './reponses.php', jeuContainer)});
    $('#scores').on('click', function(){navigation($(this), './scores.php', jeuContainer)});
    
    $('.nav-link:first').addClass('active');

    fileContentLoader(accueilContainer, './pages/accueil.php')
    fileContentLoader(adminContainer, './dashboard.php')
    fileContentLoader(jeuContainer, './questions.php')

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

function showCurrent(data, n){
    data[n].classList.remove('d-none');
    data[n].classList.add('d-flex');

    if(n <= 0){
        $('#prev').prop('disabled', true)
    }else{
        $('#prev').prop('disabled', false)
    }

    if(n === (data.length)-1){
        $('#next').html('Terminer');
        $('#next').attr('type', 'submit');
    }else{
        $('#next').html('Suivant');
    }

    fixStepIndicator(n)
}

function fixStepIndicator(n){
    // This function removes the "active" class of all steps...
    const x = $(".step");
    for (let i = 0; i < x.length; i++) {
        x[i].classList.remove('active');
    }
    //... and adds the "active" class to the current step:
    x[n].classList.add('active');
}
