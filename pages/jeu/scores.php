<div class="card m-3">
    <div class="card-body">
        <h2>Meilleurs scores</h2>
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>Rang</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody id="tbody">
                <tr>
                    <td colspan="4">Pas encore de données</td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">
            <ol id="numbers"></ol>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        const body = $('#tbody');
        $.ajax({
            url: '../../data/getScores.php',
            type: 'POST',
            data: {limit: limit, offset: offset},
            dataType: 'JSON',
            success: function(res){
                // console.log(res);
                body.html('');
                printScore(res, body);
            }
        });
    });

    function printScore(data, body){
        const totalPage = Math.ceil(data[1] / limit);
        $.each(data[0], function(indice, user){
            let tr = `
                <tr>
                    <td>${indice+1}</td>
                    <td>${user.prenom}</td>
                    <td>${user.nom}</td>
                    <td>${user.score}</td>
                </tr>;
            `
            body.append(tr);
        });
        for(let i = 0; i < totalPage; i++){
            const li = `<li><a href="#" data-page="${i+1}">${i+1}</a></li>`;
            $('#numbers').append(li);
        }
        $('#numbers li a').on('click', function(e){
            e.preventDefault();
            page = parseInt($(this).attr('data-page'));
            offset = (page-1)*limit;
            $.ajax({
                url: '../../data/getScores.php',
                type: 'POST',
                data: {limit: limit, offset: offset},
                dataType: 'JSON',
                success: function(res){
                    // console.log(res);
                    body.html('');
                    $('#numbers').html('');
                    printScore(res, body);
                }
            })
        });
        
        $.each($('#numbers li a'), function(i, res){
            // console.log();
            if(page === i+1){
                $(this).parent().addClass('pagination_active');
            }
        })
    }
</script>