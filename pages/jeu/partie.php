<div id="quizzContent">
    <div class="card m-4 d-flex justify-content-center align-items-center">
        <div class="card-body">
            <button class="btn btn-sm my-btn-primary" id="play">Commencez un partie</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#play').on('click', function(){
            $('#quizzContent').load('./questions.php');
        })
    })
</script>