<div class="d-flex justify-content-center align-items-center">
    <div class="card m-3 w-100">
        <div class="card-body interface-jeu d-flex flex-column justify-content-center align-items-center" id="respContent">

        </div>
        <div class="d-flex align-items-center justify-content-around w-100">
            <button type="button" class="btn btn-small btn-warning prev">Précedent</button>
            <button type="button" class="btn btn-small my-btn-primary next">Suivant</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){  
        offset = 0;
        const my_id = $('#my_id').attr('data-id');
        loadQuest(my_id);
        $('.prev').on('click', function(){
            offset--;
            loadQuest(my_id);
        })
        $('.next').on('click', function(){
            offset++;
            loadQuest(my_id);
        })
        
    })

    function loadQuest(my_id){
        $.ajax({
            url: '../../data/getCorrectResp.php',
            type: 'POST',
            data: {id: my_id, offset: offset},
            success: function(res){
                $('#respContent').html(res);
                if(offset >= $('#rows').val()-1){
                    $('.next').prop('disabled', true);
                }else{
                    $('.next').prop('disabled', false);
                }

                if(offset <= 0){
                    $('.prev').prop('disabled', true);
                }else{
                    $('.prev').prop('disabled', false);
                }
            }
        })
    }

</script>