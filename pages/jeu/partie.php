<div id="quizzContent">
    <div class="card m-4 d-flex justify-content-center align-items-center">
        <div class="card-body">
            <button class="btn btn-sm my-btn-primary" id="play">Commencez un partie</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $.ajax({
            url: '../../data/partie.php',
            type: 'POST',
            dataType: 'JSON',
            success: function(res){
                if(res.nbrParJeu > res.allQuest){
                    $('#play').prop("disabled", true);
                    $('#play').parent().append('<h5>Question indisponible pour le moment</h5>');
                }else{
                    $('#play').prop("disabled", false);
                    $('#play').on('click', function(){
                        $('#quizzContent').load('./questions.php');
                    })
                }
            }
        })
    })
</script>