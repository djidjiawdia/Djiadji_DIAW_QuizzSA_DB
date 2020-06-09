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
            <form method="post" class="d-flex align-items-center">
                <label class="my-text-primary">Nombre de questions :</label>
                <input type="range" min="5" max="10" class="slider">
                <span class="font-weight-bold my-text-primary ml-2">5</span>
            </form>
        </div>
    </div>

    <div class="question-content" id="question-content">
    </div>
</div>