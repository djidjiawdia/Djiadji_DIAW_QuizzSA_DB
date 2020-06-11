<div class="card m-3">
    <div class="card-body">
        <h2>Liste des joueurs</h2>
        <div id="table-joueurs">
            
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        const tableJoueurs = $('#table-joueurs');
        fileContentLoader(tableJoueurs, '../table.php', {role: 'player'});
    })

    // Bloquer un joueur
    $(document).on('click', '.bloquer', function(){
        const id = $(this).attr('id');
        const type = $(this).attr('name');
        if(confirm('Voulez vous bloquer le joueur?')){
            $.ajax({
                url: '../../controllers/userCtrl.php',
                method: 'POST',
                data: {id: id, type: type},
                success: function(res){
                    alert(res)
                    $('#table-joueurs').html('');
                    fileContentLoader($('#table-joueurs'), './../table.php', {role: 'player'});
                }
            });
        }
    });

    // Débloquer un joueur
    $(document).on('click', '.debloquer', function(){
        const id = $(this).attr('id');
        const type = $(this).attr('name');
        if(confirm('Voulez vous bloquer le joueur?')){
            $.ajax({
                url: '../../controllers/userCtrl.php',
                method: 'POST',
                data: {id: id, type: type},
                success: function(res){
                    alert(res)
                    $('#table-joueurs').empty();
                    fileContentLoader($('#table-joueurs'), './../table.php', {role: 'player'});
                }
            });
        }
    });
</script>