<div id="scrollZone" class="col">
    <div id="content">
        <!-- <div class="card mt-2">
            <div class="card-body">
                <h2>Pas encore de questions!</h2>
            </div>
        </div> -->
    </div>
</div>

<script>
    $(document).ready(function(){
        let offset = 0;
        const content = $("#content");
        $.ajax({
            url: '../../data/getQuestion.php',
            type: 'POST',
            data: {limit: 4, offset: offset},
            success: function(res){
                content.html('');
                content.append(res)
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
                        content.append(res)
                        offset += 4;
                    }
                });
            }
        })
    });
    

</script>