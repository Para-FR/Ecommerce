<?php require_once('config.php') ?>
<?php if (!internauteEstConnecte()) {
    header('Location:register.php');
} ?>
<?php require_once('navbar.php') ?>

<div class="banner-top">
    <div class="container">
        <h1>Support</h1>
        <em></em>
        <h2><a href="index.php">Accueil</a><label>/</label>Support</h2>

    </div>
</div>

<div class="container">
    <div class="row">
        <div class="menu bg-profil center" id="menu">
            <ul class="list-inline">
                <li><a href="profil"><i class="fa fa-user"></i> Profil</a></li>
                <li><a href="suivi_des_commandes"><i class="fa fa-truck"></i> Suivi des Commandes</a></li>
                <li><a href="historique_des_commandes"><i class="fa fa-cubes"></i> Historique des Commandes</a></li>
                <li><a href="support_client"><i class="fa fa-life-ring"></i> Support</a></li>
            </ul>
        </div>
    </div>
    <hr>
        <div class="row form-group">
            <div class="col-xs-12 col-md-offset-2 col-md-8 col-lg-8 col-lg-offset-2">
                <div class="panel panel-profil">
                    <div class="panel-heading">
                        <span class="fa fa-life-ring"></span> Support
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-chevron-down"></span>
                            </button>
                            <ul class="dropdown-menu slidedown">
                                <li><a href="#"><span class="glyphicon glyphicon-refresh">
                            </span>Actualiser</a></li>
                                <li><a href="#"><span class="glyphicon glyphicon-ok-sign">
                            </span>En Ligne</a></li>
                                <li><a href="#"><span class="glyphicon glyphicon-remove">
                            </span>Absent</a></li>
                                <li><a href="#"><span class="glyphicon glyphicon-time"></span>
                                        Hors Ligne</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body body-panel">
                        <ul class="chat">
                            <li class="left clearfix"><span class="chat-img pull-left">
                            <img src="http://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar" class="img-circle" />
                        </span>
                                <div class="chat-body clearfix">
                                    <div class="header">
                                        <strong class="primary-font">Jack Sparrow</strong> <small class="pull-right text-muted">
                                            <span class="glyphicon glyphicon-time"></span>Il y a 12 mins</small>
                                    </div>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                        dolor, quis ullamcorper ligula sodales.
                                    </p>
                                </div>
                            </li>
                            <li class="right clearfix"><span class="chat-img pull-right">
                            <img src="http://placehold.it/50/FA6F57/fff&text=ME" alt="User Avatar" class="img-circle" />
                        </span>
                                <div class="chat-body clearfix">
                                    <div class="header">
                                        <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>Il y a 13 mins</small>
                                        <strong class="pull-right primary-font">Bhaumik Patel</strong>
                                    </div>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                        dolor, quis ullamcorper ligula sodales.
                                    </p>
                                </div>
                            </li>
                            <li class="left clearfix"><span class="chat-img pull-left">
                            <img src="http://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar" class="img-circle" />
                        </span>
                                <div class="chat-body clearfix">
                                    <div class="header">
                                        <strong class="primary-font">Jack Sparrow</strong> <small class="pull-right text-muted">
                                            <span class="glyphicon glyphicon-time"></span>Il y a 14 mins</small>
                                    </div>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                        dolor, quis ullamcorper ligula sodales.
                                    </p>
                                </div>
                            </li>
                            <li class="right clearfix"><span class="chat-img pull-right">
                            <img src="http://placehold.it/50/FA6F57/fff&text=ME" alt="User Avatar" class="img-circle" />
                        </span>
                                <div class="chat-body clearfix">
                                    <div class="header">
                                        <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>Il y a 15 mins</small>
                                        <strong class="pull-right primary-font">Bhaumik Patel</strong>
                                    </div>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                        dolor, quis ullamcorper ligula sodales.
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="panel-footer clearfix">
                        <textarea class="form-control" rows="3"></textarea>
                        <span class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-xs-12" style="margin-top: 10px">
                        <button class="btn hvr-skew-backward btn-lg btn-block" id="btn-chat">Envoyer</button>
                    </span>
                    </div>
                </div>
            </div>
        </div>


</div>

<?php require_once('footer.php') ?>
