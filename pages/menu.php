<nav class="navbar navbar-expand-sm">
    <a class="navbar-brand" href="#">
        <img src="<?= $root ?>/public/images/logo-QuizzSA.png" class="logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapse_target" aria-controls="collapse_target" aria-expanded="false" aria-label="Toggle navigation">
        <span><i class="fa fa-bars"></i></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="collapse_target">
        <ul class="nav navbar-nav">
            <?php if(isset($_SESSION['user'])): ?>
                <?php if($_SESSION['user']['role'] === 'Admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=questions">Questions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=joueurs">Joueurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=admins">Admins</a>
                    </li>
                <?php elseif($_SESSION['user']['role'] === 'Joueur'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=questions">Questions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=reponses">Réponses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=scores">Scores</a>
                    </li>
                <?php endif; ?>
            <?php else: ?>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= $root ?>">Accueil</a>
                </li>
            <?php endif; ?>
            <li class="navitem">
                <a class="nav-link" href="" data-toggle="modal" data-target="#profil_modal">
                    <span><i class="fa fa-user"></i></span>
                </a>
                <div class="modal fade right" id="profil_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                    <div class="modal-dialog modal-side modal-top-right" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title w-100" id="myModalLabel">Mon Profil</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body profil">
                                <?php if(isset($_SESSION['user'])): ?>
                                    <img class="avatar" src="<?= $root.$_SESSION['user']['avatar'] ?>" alt="Profil">
                                    <h4 id="my_id" data-id="<?= $_SESSION['user']['id'] ?>"><?= ucfirst($_SESSION['user']['prenom']).' '.strtoupper($_SESSION['user']['nom']) ?></h4>
                                    <?php if($_SESSION['user']['role'] === 'Joueur'): ?>
                                        <p>Mon score : <span class="my-text-primary"><?= $_SESSION['user']['score'].' points' ?></span></p>
                                        <?php endif; ?>
                                        <a href="<?= $root ?>/controllers/userCtrl.php?deconnexion" id="deconnexion" class="btn my-btn-primary">Se Deconnecter</a>
                                <?php else: ?>
                                    <img class="avatar" src="<?= $root ?>/public/images/avatar.png" alt="Profil">
                                    <h4>Veuillez-vous connecter</h4>
                                <?php endif; ?>
                            </di>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>