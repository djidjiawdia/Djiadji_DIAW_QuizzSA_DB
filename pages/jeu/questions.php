<?php
    require_once '../../data/getQuestGame.php';
?>

<div class="d-flex justify-content-center align-items-center">
    <div class="card m-3 w-100">
        <form method="post" id="quizzForm">
            <div class="card-body interface-jeu d-flex flex-column justify-content-center align-items-center">
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
                                    <input id="repText" class="form-control" name="<?= 'resp'.($i+1) ?>" type="text">
                                <?php else: ?>
                                    <div class="resp-item col-md-5">
                                        <label for="">
                                            <input type="<?= $q['type'] ?>" name="<?= 'resp'.($i+1).'[]' ?>" id="">
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
    const questions = $('.quizzContent');
    $(document).ready(function(){        
        $('#quizzForm').on('submit', function(e){
            e.preventDefault();
            if(current >= questions.length){
                alert('kdns')
            }
        })
        showCurrent(questions, current)
    })
    
    $('#next').on('click', function(){
        questions[current].classList.remove('d-flex');
        questions[current].classList.add('d-none');
        console.log(questions[current]);
        current++;
        showCurrent(questions, current);
    });

    $('#prev').on('click', function(){
        questions[current].classList.remove('d-flex');
        questions[current].classList.add('d-none');
        current--;
        showCurrent(questions, current);
    });
</script>