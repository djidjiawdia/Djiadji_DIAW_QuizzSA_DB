<div class="m-3">
    <div id="addNewQuest" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter une nouvelle question</h4>
                    <button type="button" id="addNewQuestion" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="formAddQuest">
                        <div class="form-group">
                            <label for="question">Question</label>
                            <textarea name="question" id="question" class="form-control my-border" rows="3"></textarea>
                            <small class="error-text"></small>
                        </div>
                        <div class="form-group">
                            <label for="point">Point</label>
                            <input type="number" name="point" id="point" class="form-control my-border w-50" placeholder="Entrer le nombre de points">
                            <small class="error-text"></small>
                        </div>
                        <div class="form-group">
                            <label for="type">Type de réponse</label>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="w-100">
                                    <select name="type" id="type" class="form-control my-border mr-2">
                                        <option value="" disabled selected><span class="text-light">Choisir le type de réponse</span></option>
                                        <option value="radio">Choix simple</option>
                                        <option value="checkbox">Choix multiple</option>
                                        <option value="text">Choix texte</option>
                                    </select>
                                    <small class="error-text"></small>
                                </div>
                                <button type="button" class="btn-icon" id="addInput">
                                    <span><i class="fas fa-plus-square"></i></span>
                                </button>
                            </div>
                        </div>
                        <div id="responses">
                        </div>
                        <small class="error-text" id="respError" ></small>
                        <input type="hidden" name="question_id" id="question_id">
                        <input type="hidden" name="operation" id="operation">
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-sm my-btn-primary" name="action" id="enregistrer">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body d-flex align-items-center justify-content-between">
            <button class="btn-icon" data-toggle="modal" data-target="#addNewQuest">
                <span><i class="fas fa-plus-circle"></i></span>
                Ajouter une question
            </button>
            <form method="post" id="nbrQuestion" class="d-flex flex-column align-items-center">
                <label class="my-text-primary">Nombre de questions : <span id="slider_value"></span></label>
                <input type="range" name="slider" id="slider" value="" min="0" max="10">
            </form>
        </div>
    </div>

    <div id="scrollZone" class="col">
        <div id="content">
            <div class="card mt-2">
                <div class="card-body">
                    <h2>Loading...</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    offset = 0;
    $(document).ready(function(){
        loadNumQuest();
        // const content = $("#content");
        $.ajax({
            url: '../../data/getQuestion.php',
            type: 'POST',
            data: {limit: 4, offset: offset},
            success: function(res){
                $("#content").html('');
                $("#content").append(res)
                offset += 4;
            }
        });
        
        const scrollZone = $('#scrollZone')
        scrollZone.scroll(() => {
            const st = scrollZone[0].scrollTop;
            const sh = scrollZone[0].scrollHeight;
            const ch = scrollZone[0].clientHeight;


            if(Math.ceil(sh-st)-1 <= ch){
                $.ajax({
                    url: '../../data/getQuestion.php',
                    type: 'POST',
                    data: {limit: 4, offset: offset},
                    success: function(res){
                        // content.html('');
                        $("#content").append(res)
                        offset += 4;
                    }
                });
            }
        })
    });

    $(document).on('click', '#supp-quest', function(){
        const id_q = $(this).attr('data-id');
        if(confirm("Voulez-vous supprimer la question")){
            $.ajax({
                url: '../../data/deleteQuestion.php',
                type: 'POST',
                data: {id_question: id_q, operation: 'delete'},
                dataType: 'JSON',
                success: function(res){
                    console.log(res);
                    if(res.status == 'success'){
                        alert(res.message);
                        $('#adminContainer').load('./questions.php')
                    }
                }
            })
        }
    })

    // Ajouter un champ de réponse
    $(document).on('click', '#addInput', function(){
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
                    $('#addNewQuest').hide();
                    $('.show').parent().removeClass();
                    $('#formAddQuest')[0].reset();
                    $('body').removeClass('modal-open');
                    $('#adminContainer').load('./questions.php');
                }
            });
        }
    });

    // Load number of questions
    function loadNumQuest(){
        $.ajax({
            url: '../../data/loadNumQuest.php',
            type: 'GET',
            dataType: 'JSON',
            success: function(res){
                $('#slider').val(res[0]);
                $('#slider_value').html(res[0]);
            }
        })
    }
</script>