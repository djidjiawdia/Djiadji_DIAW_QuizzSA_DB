<?php
    require_once '../../data/getQuestGame.php';
?>

<div class="d-flex justify-content-center align-items-center">
    <div class="card m-3 h-100 w-100">
        <form method="post" id="quizzForm">
            <div class="card-body interface-jeu d-flex flex-column justify-content-center align-items-center" id="gameReady">
                <?php foreach($result as $k => $q): ?>
                    <div class="quizzContent d-none flex-column justify-content-center align-items-center w-100">
                        <div class="question-score d-flex justify-content-center align-items-center">
                            <div class="question">
                                <p><?= ($k+1).'. '.htmlentities($q['question'], ENT_QUOTES) ?></p>
                            </div>
                            <div class="score d-flex justify-content-center align-items-center">
                                <span><?= $q['point'].' points' ?></span>
                            </div>
                        </div>
                        <div class="responses row mb-3">
                            <?php foreach(getResponses($q['id_question']) as $i => $res): ?>
                                <?php if($q['type'] === 'text'): ?>
                                    <input type="hidden" name="<?= 'answer'.($k+1) ?>" value="<?= htmlentities($res['reponse'], ENT_QUOTES) ?>">
                                    <input id="repText" class="form-control" name="<?= 'resp'.($k+1) ?>" type="text">
                                <?php else: ?>
                                    <div class="resp-item col-md-5">
                                        <label>
                                            <input type="<?= $q['type'] ?>" name="<?= 'resp'.($k+1).'[]' ?>" id="resp" value="<?= $res['correct'] ?>">
                                            <?= htmlentities($res['reponse'], ENT_QUOTES) ?>
                                        </label>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="prev-next d-flex align-items-center justify-content-between w-100">
                    <button type="button" class="btn btn-small btn-warning" id="prev">Précedent</button>
                    <div class="steps">
                        <?php for($i=0; $i<sizeof($result); $i++){ ?>
                            <span class="step"></span>
                        <?php } ?>
                    </div>
                    <button type="button" class="btn btn-small my-btn-primary" id="next">Suivant</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    allQuestions = <?= json_encode($result) ?>
</script>
<script>
    questions = $('.quizzContent');
    score = 0;
    check = true;
    trouve = [];
    $(document).ready(function(){        
        $('#quizzForm').on('submit', function(e){
            e.preventDefault();
            const my_id = $('#my_id').attr('data-id');
            if(current >= questions.length){
                if(trouve.length > 0){
                    $.ajax({
                        url: '../../data/saveCorrectQuestions.php',
                        type: 'POST',
                        data: {id_user: my_id, id_questions: trouve, score: score},
                        dataType: 'JSON',
                        success: function(res){
                            let div = '';
                            $('#gameReady').empty();
                            if(res.type === 'newScore'){
                                div = `<h5>${res.message}:</h5>`;
                            }else{
                                div = `<h5>Mon score:</h5>`;
                            }
                            div += `
                            <h2 class="my-text-primary">${score}</h2>
                            <button id="replay" class="btn btn-sm my-btn-primary">Rejouer</button>
                            `;
                            $('#gameReady').html(div);
                            $('#replay').on('click', () => {
                                location.reload();
                            })
                        }
                    })
                }else{
                    let div = '';
                    $('#gameReady').empty();
                    div = `
                    <h5>OUPS!! Vous n'avez trouvé aucune bonne réponse</h5>
                    <h2 class="my-text-primary">${score}</h2>
                    <button id="replay" class="btn btn-sm my-btn-primary">Rejouer</button>
                    `;
                    $('#gameReady').html(div);
                    $('#replay').on('click', () => {
                        location.reload();
                    })
                }
            }
        })
        showCurrent(questions, current)
    })
    
    $('#next').on('click', function(){
        const currentEl = questions[current];
        currentEl.classList.remove('d-flex');
        currentEl.classList.add('d-none');
        if(allQuestions[current].type === 'text'){
            disabled = currentEl.querySelector('input[id="repText"]').disabled;
        }else{
            disabled = currentEl.querySelector(`input[id="resp"]`).disabled;
        }
        if(check && !disabled){
            if(verifyResp(currentEl)){
                $(".step")[current].classList.add('true');
                trouve.push(allQuestions[current].id_question);
                score += parseInt(allQuestions[current].point);
            }else{
                $(".step")[current].classList.add('false');
            }
        }
        updateForm(currentEl, current);
        check = true;
        current++;
        showCurrent(questions, current);
    });

    $('#prev').on('click', function(){
        check = false;
        questions[current].classList.remove('d-flex');
        questions[current].classList.add('d-none');
        current--;
        showCurrent(questions, current);
    });

    function verifyResp(currentEl){
        if(allQuestions[current].type === 'text'){
            const resp = currentEl.querySelector('input[type="text"]');
            const answer = currentEl.querySelector('input[type="hidden"]');
            return resp.value.trim().toLowerCase() == answer.value.trim().toLowerCase();
        }else{
            const resp = currentEl.querySelectorAll(`input[id="resp"]:checked`);
            if(resp.length > 0){
                for(let i = 0; i < resp.length; i++){
                    if(resp[i].value == 0){
                        return false;
                    }
                }
                return true;
            }
            return false;
        }
    }

    function updateForm(currentEl ,n){
        if(allQuestions[n].type === 'text'){
            const resp = currentEl.querySelector('input[type="text"]');
            resp.setAttribute('disabled', 'disabled');
        }else{
            const resp = currentEl.querySelectorAll(`input[id="resp"]`);
            for(let i = 0; i < resp.length; i++){
                resp[i].setAttribute('disabled', 'disabled');
            }
        }
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
</script>