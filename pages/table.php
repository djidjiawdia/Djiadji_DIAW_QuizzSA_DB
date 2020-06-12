<input type="hidden" name="role" id="role" value="<?= @$_POST['role'] ?>">
<table class="table table-striped text-center">
    <thead>
        <tr>
            <th>Prénom</th>
            <th>Nom</th>
            <?php if(isset($_POST['role']) && $_POST['role'] === 'player'): ?>
                <th>Score</th>
            <?php elseif(isset($_POST['role']) && $_POST['role'] === 'admin'): ?>
                <th>Login</th>
            <?php endif; ?>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="tbody">
        <tr>
            <td colspan="4">Pas de joueurs</td>
        </tr>
    </tbody>
</table>
<div class="pagination">
    <ol id="numbers"></ol>
</div>

<script>
    $(document).ready(function(){
        limit = 3;
        offset = 0;
        page = 1;
        const body = $('#tbody');
        const role = $('#role').val();
        $.ajax({
            url: '../../data/getUsers.php',
            type: 'POST',
            data: {limit: limit, offset: offset, role: role},
            dataType: 'JSON',
            success: function(res){
                // console.log(res);
                body.html('');
                printData(res, body, role);
            }
        });
    });

    function printData(data, body, role){
        const totalPage = Math.ceil(data[1] / limit);
        $.each(data[0], function(indice, user){
            let tr = `
                <tr>
                    <td>${user.prenom}</td>
                    <td>${user.nom}</td>
            `;
            if(role === 'player'){
                tr += `
                    <td>${user.score}</td>
                `;
                
                if(user.statut == 0){
                    tr += `<td><button class="btn btn-danger btn-sm bloquer" name="bloquer" id="${user.id}">Bloquer</button></td>`;
                }else{
                    tr += `<td><button class="btn btn-success btn-sm debloquer" name="debloquer" id="${user.id}">Débloquer</button></td>`;
                }
            }else if(role === 'admin'){
                tr += `
                    <td>${user.login}</td>
                    <td>
                        <button class="btn btn-warning btn-sm edit" id="${user.id}">Editer</button>
                        <button class="btn btn-danger btn-sm delete" id="${user.id}">Supprimer</button>
                    </td>
                `;
            }
            
            tr += '</tr>';
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
                url: '../../data/getUsers.php',
                type: 'POST',
                data: {limit: limit, offset: offset, role: role},
                dataType: 'JSON',
                success: function(res){
                    // console.log(res);
                    body.html('');
                    $('#numbers').html('');
                    printData(res, body, role);
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