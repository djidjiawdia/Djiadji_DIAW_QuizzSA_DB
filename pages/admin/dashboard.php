<div class="stats m-3">
    <div class="row d-flex justify-content-sm-around">
        <div class="col-sm-3 stat p-sm-4 mb-2 d-flex flex-sm-column justify-content-center align-items-center stat-players" id="stat-players">
            <span class="mr-2" id="number"></span>
            <span>Joueurs</span>
        </div>
        <div class="col-sm-3 stat p-sm-4 mb-2 d-flex flex-sm-column justify-content-center align-items-center stat-questions" id="stat-questions">
            <span class="mr-2" id="number"></span>
            <span>Questions</span>
        </div>
        <div class="col-sm-3 stat p-sm-4 mb-2 d-flex flex-sm-column justify-content-center align-items-center stat-admins" id="stat-admins">
            <span class="mr-2" id="number"></span>
            <span>Admins</span>
        </div>
    </div>
</div>

<div class="graphes m-3">
    <div class="row">
        <div class="col-md-7 mb-2">
            <div class="card">
                <div class="card-body">
                    <canvas id="graph1"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-5 mb-2">
            <div class="card">
                <div class="card-body">
                    <canvas id="graph2"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $.ajax({
            url: '../../data/stats.php',
            type: 'POST',
            dataType: 'JSON',
            success: function(res){
                // console.log(graph1);
                const ctx1 = $('#graph1')[0].getContext('2d');
                const ctx2 = $('#graph2')[0].getContext('2d');
                loadStats(res.players, $('#stat-players #number'))
                loadStats(res.questions, $('#stat-questions #number'))
                loadStats(res.admins, $('#stat-admins #number'))
                $.ajax({
                    url: '../../data/fetchDataChart.php',
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(res){
                        console.log(Object.values(res.players));
                        let login = [];
                        let score = [];
                        for(let el of res.players){
                            login.push(el.login);
                            score.push(el.score);
                        }
                        console.log(login, score);
                        const graph1 = new Chart(ctx1, {
                            type: 'bar',
                            data: {
                                labels: login,
                                datasets: [{
                                    label: "score",
                                    backgroundColor: '#F7E6BE',
                                    barThickness: 3,
                                    maxBarThickness: 18,
                                    data: score
                                }]
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                },
                                title: {
                                    display: true,
                                    position: 'bottom',
                                    fontColor: '#51BFD0',
                                    fontSize: 18,
                                    text: "L'evolution du score des joueurs"
                                }
                            }
                        })
                        const graph2 = new Chart(ctx2, {
                            type: 'doughnut',
                            data: {
                                labels: ['Texte', 'Multiple', 'Simple'],
                                datasets: [{
                                    backgroundColor: [
                                        "#36A2EB",
                                        "#FF6384",
                                        "#FFCE56"
                                    ],
                                    data: res.type
                                }]
                            },
                            options: {
                                title: {
                                    display: true,
                                    position: 'bottom',
                                    fontColor: '#51BFD0',
                                    fontSize: 18,
                                    text: 'Les types de questions'
                                }
                            }
                        })
                    }
                })
            }
        })
    })

    function loadStats(n, field){
        let tst;
        for(let i=0; i<=n; i++){
            setTimeout(() => {
                field.text(i);
            }, i*100)
        }
    }
</script>