<?php require_once('config.php') ?>
<?php if (!internauteEstConnecte()) {
    header('Location:register.php');
} ?>
<?php
function do_action_client($action)
{
    if ($action == 'consulter') {
        $element = $_GET['element'];
        if (!empty($element)) {
            $consult = executeRequete("select id_commande,montant,date_enregistrement,etat,nom,prenom,email,ville,code_postal,adresse
from commande INNER JOIN membre on commande.id_membre = membre.id_membre WHERE id_commande='" . $_GET['element'] . "'");
            $consulter = $consult->fetch_assoc();
            return $consulter;

        }
    }
}
?>
<?php
//var_dump($_SESSION['membre']['pseudo']);
if (isset($_POST['modif_infos'])) {
    if (isset($_POST['nom'])) {
        if (is_numeric($_POST['nom']) || empty($_POST['nom'])) {
            $error .= '<br> Le champ nom est incorrect.';
            $succes = '';
        }
    }
    if (isset($_POST['prenom'])) {
        if (is_numeric($_POST['prenom']) || empty($_POST['prenom'])) {
            $error .= '<br> Le champ prenom est incorrect.';
            $succes = '';
        }
    }
    if (isset($_POST['ville'])) {
        if (is_numeric($_POST['ville']) || empty($_POST['ville'])) {
            $error .= '<br> Le champ ville est incorrect.';
            $succes = '';
        }
    }
    if (isset($_POST['cp'])) {
        if (!is_numeric($_POST['cp']) || empty($_POST['cp'])) {
            $error .= '<br> Le champ code postal est incorrect.';
            $succes = '';
        }
    }
    if (isset($_POST['adresse'])) {
        if (is_numeric($_POST['adresse']) || empty($_POST['adresse'])) {
            $error .= '<br> Le champ adresse est incorrect.';
            $succes = '';
        }
    }
    if (empty($error)) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $ville = $_POST['ville'];
        $code_postal = $_POST['cp'];
        $adresse = $_POST['adresse'];
        $idmembre = $_SESSION['membre']['id_membre'];
        $pass = $_POST['mdp'];
        $pass_confirm = $_POST['mdp_confirm'];

        //$mdp_crypt = sha1($_POST['mdp']);
        $membre = executeRequete("SELECT * FROM membre WHERE id_membre='$idmembre'");
        $motdp = $membre->fetch_assoc();
        if (empty($pass)) {
            $mdp_crypt = $motdp['mdp'];
        } else {
            if ($pass == $pass_confirm) {
                $mdp_crypt = sha1($pass);
            } else {
                $error .= '<strong>Erreur !</strong><br> Les mots de passe ne correspondent pas';
            }
        }
        if (isset($error) && empty($error)){
            executeRequete("UPDATE membre SET mdp='$mdp_crypt',mdp_confirm='$mdp_crypt',nom='$nom', prenom='$prenom', ville='$ville', code_postal='$code_postal', adresse='$adresse' WHERE id_membre='$idmembre'");
            $succes .= '<strong>Effectué !</strong><br> Vos informations ont été mises à jour.';
            $_SESSION['membre']['nom'] = $_POST['nom'];
            $_SESSION['membre']['prenom'] = $_POST['prenom'];
            $_SESSION['membre']['ville'] = $_POST['ville'];
            $_SESSION['membre']['code_postal'] = $_POST['cp'];
            $_SESSION['membre']['adresse'] = $_POST['adresse'];
        }

    }

}
$suppression_def = '';
if (isset($_POST['suppression_compte'])){
    executeRequete("DELETE FROM membre WHERE id_membre=" . $_SESSION['membre']['id_membre']);
    $suppression_def = 'Suppression du compte';
}
if (isset($suppression_def) && !empty($suppression_def)){
    session_destroy();
    header('Location:index.php');
}
?>

<?php if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'consulter') {
    $consulter = do_action_client($_GET['action']);
} ?>
<?php require_once('navbar.php') ?>

<div class="banner-top">
    <div class="container">
        <h1>Profil</h1>
        <em></em>
        <h2><a href="index.php">Accueil</a><label>/</label>Profil</h2>

    </div>
</div>
<div class="container">
    <div class="login">
        <?php $checked = $_SESSION['membre']['civilite'];
        $civilitem = '';
        $civilitef = '';
        if (isset($checked) && !empty($checked)) {
            if ($checked == 'm') {
                $civilitem .= 'checked';
            } else {
                $civilitem .= '';
            }

            if ($checked == 'f') {
                $civilitef .= 'checked';
            } else {
                $civilitef .= '';
            }
        }
        ?>
        <div class="col-md-12">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1primary" data-toggle="tab"><i class="fa fa-user"></i> Mon Profil</a></li>
                        <li><a href="#tab2primary" data-toggle="tab"><i class="fa fa-truck"></i> Suivi des Commandes</a></li>
                        <li><a href="#tab3primary" data-toggle="tab"><i class="fa fa-cubes"></i> Historique des Commandes</a></li>
                        <li><a href="#tab4primary" data-toggle="tab"><i class="fa fa-life-ring"></i> Support</a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1primary">
                            <form action="#" method="post">
                                <div class="col-md-12 header-login ">
                                    <div class="input-group col-md-12 center center-block">
                                        <?php if (isset($error) && !empty($error)) { ?>
                                            <div class="alert alert-danger center" role="alert"><strong>Erreur !</strong>
                                                <?php echo $error ?>
                                            </div>
                                        <?php } ?>
                                        <?php if (isset($succes) && !empty($succes)) { ?>
                                            <div class="alert alert-success center" role="alert">
                                                <?php echo $succes ?>
                                            </div>
                                        <?php } ?>
                                        <input type="radio" class="radio-inline" value="m" name="civilite" <?php echo $civilitem ?>>&nbsp;
                                        <i class="fa fa-mars" aria-hidden="true"></i> Monsieur
                                        <input type="radio" class="radio-inline" value="f" name="civilite" <?php echo $civilitef ?>>
                                        &nbsp;<i class="fa fa-venus"
                                                 aria-hidden="true"></i>Madame
                                    </div>
                                </div>

                                <div class="col-md-6 login-do">
                                    <br/>
                                    <div class="login-mail">
                                        <input class="disabled" name="pseudo" type="text"
                                               value="<?php echo ucfirst($_SESSION['membre']['pseudo']) ?> " required="" disabled>
                                        <i class="fa fa-user-circle-o"></i>
                                    </div>
                                    <div class="login-mail">
                                        <input name="mdp" type="password" placeholder="Entrez votre nouveau Mot de Passe">
                                        <i class="fa fa-unlock-alt"></i>
                                    </div>
                                    <div class="login-mail">
                                        <input name="mdp_confirm" type="password" placeholder="Confrimez votre nouveau Mot de Passe">
                                        <i class="fa fa-lock"></i>
                                    </div>
                                    <div class="login-mail">
                                        <input name="nom" type="text" value="<?php echo ucfirst($_SESSION['membre']['nom']) ?>"
                                               required="">
                                        <i class="fa fa-vcard"></i>
                                    </div>
                                    <div class="login-mail">
                                        <input name="prenom" type="text" value="<?php echo ucfirst($_SESSION['membre']['prenom']) ?>"
                                               required="">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </div>
                                </div>
                                <div class=" col-md-6 login-right">
                                    <br/>
                                    <div class="login-mail">
                                        <input class="disabled" name="email" type="email"
                                               value="<?php echo ucfirst($_SESSION['membre']['email']) ?>"
                                               required="" disabled>
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <div class="login-mail">
                                        <input name="ville" type="text" value="<?php echo ucfirst($_SESSION['membre']['ville']) ?>"
                                               required="">
                                        <i class="fa fa-location-arrow"></i>
                                    </div>
                                    <div class="login-mail">
                                        <input name="cp" type="text" value="<?php echo ucfirst($_SESSION['membre']['code_postal']) ?>"
                                               required="">
                                        <i class="fa fa-map-signs"></i>
                                    </div>
                                    <div class="login-mail">
                                        <input name="adresse" type="text"
                                               value="<?php echo ucfirst($_SESSION['membre']['adresse']) ?>" required="">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 login-do center">
                                    <label class="hvr-skew-backward">
                                        <input name="modif_infos" type="submit" value="Mettre à jour">
                                    </label>
                                </div>

                                <div class="clearfix"></div>
                            </form>
                            <form action="#" method="post">
                                <div class="col-md-6 login-do center">
                                    <label class="hvr-skew-backward">
                                        <input name="suppression_compte" type="submit" value="Suprimer mon Compte">
                                    </label>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="tab2primary">
                            <div class="box boxblue">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Suivi des Commandes</h3>
                                    <?php if (isset($suppression) && !empty($suppression)) { ?>
                                        <div class="alert alert-danger center" role="alert">
                                            <?php echo $suppression ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="box-body">
                                    <?php
                                    $return = '';
                                    $tableau_suivi_commandes = executeRequete("SELECT id_commande, montant, date_enregistrement, etat FROM commande WHERE id_membre=".$_SESSION['membre']['id_membre']." AND etat='commande en cours de traitement' OR etat='commande en cours de livraison'");
                                    echo '<table class="table table-bordered"> <tr class="center">';
                                    while ($colonne = $tableau_suivi_commandes->fetch_field()) {
                                        echo '<th class="center text-center">' . ucfirst($colonne->name) . '</th>';
                                    }
                                    echo '<th class="center">Action</th>';
                                    echo "</tr>";
                                    while ($ligne = $tableau_suivi_commandes->fetch_assoc()) {

                                        echo '<tr>';
                                        foreach ($ligne as $indice => $information) {
                                            echo '<td class="centered">' . $information . '</td>';
                                        }
                                        echo "<td class='center text-center'>
    <div style=\"width:100px;\">

            <a name=\'action\' href=profil-update2.php?action=consulter&element=" . $ligne['id_commande'] . " class=\"btn btn-azur btn-xs\">
            <i class=\"fa fa-eye\"></i>
            </a>
        </div>
    </div>
</td>";
                                        echo '</tr>';
                                    }
                                    echo '</table>';
                                    ?>
                                </div>
                                <?php if (!empty($consulter)) { ?>
                                    <div class="box boxazur">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Commande n° <?php echo $consulter['id_commande'] ?> &nbsp; Enregistrée le
                                                : <?php echo $consulter['date_enregistrement'] ?></h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                                        title="Collapse">
                                                    <i class="fa fa-minus"></i></button>
                                                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                                                        title="Remove">
                                                    <i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-8 col-md-offset-2">
                                                    <label><i class="fa fa-info-circle"></i> Informations:</label><br>
                                                    <div class="col-md-4 bg-bleu_azur2 pad5 borderRadius5 text-center">
                                                        <p><?php echo ucfirst($consulter['nom']) ?> <?php echo ucfirst($consulter['prenom']) ?></p>
                                                        <p><?php echo $consulter['email'] ?></p>
                                                        <p><?php echo ucfirst($consulter['adresse']) ?></p>
                                                        <p><?php echo ucfirst($consulter['code_postal']) ?>
                                                            &nbsp; <?php echo ucfirst($consulter['ville']) ?></p>

                                                    </div>
                                                    <div class="col-md-4 bg-bleu_azur2 pull-right pad5 borderRadius5 text-center">
                                                        <p>Etat : <br><?php echo ucfirst($consulter['etat']) ?></p>
                                                    </div>
                                                    <div class="input-error under-grouped">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <?php
                                            $return = '';
                                            $detail_commande_tableau = executeRequete("select p.id_produit, p.photo, p.titre, p.description, d.quantite, d.prix  from details_commande d INNER JOIN produit p on d.id_produit = p.id_produit WHERE id_commande='" . $_GET['element'] . "'");
                                            echo '<table class="table table-bordered"> <tr class="center">';
                                            if ($detail_commande_tableau->num_rows > 0){
                                                while ($colonne = $detail_commande_tableau->fetch_field()) {
                                                    echo '<th class="center text-center">' . ucfirst($colonne->name) . '</th>';
                                                }
                                            }else{
                                                echo "<div class='center'>Il n'y a aucun produit sur cette commande</div>";
                                            }

                                            echo "</tr>";
                                            while ($ligne = $detail_commande_tableau->fetch_assoc()) {
                                                echo '<tr>';
                                                foreach ($ligne as $item => $value) {
                                                    echo '<td class="center">' . $value . '</td>';
                                                }
                                                echo '</tr>';

                                            }
                                            echo '</table>'
                                            ?>

                                            <br>
                                            <hr>
                                        <!-- /.box-body 2 -->
                                        <div class="box-footer">
                                            <?php echo "<b>Total de produit(s) : </b> " . $detail_commande_tableau->num_rows; ?>
                                        </div>
                                        <!-- /.box-footer 2-->
                                    </div>
                                <?php } ?>
                                </div>
                        </div>
                            </div>
                        <div class="tab-pane fade" id="tab3primary">
                            <div class="box boxblue">
                                <div class="box-header with-border">
                                    <h3 class="box-title"> Historique des Commandes</h3>
                                    <?php if (isset($suppression) && !empty($suppression)) { ?>
                                        <div class="alert alert-danger center" role="alert">
                                            <?php echo $suppression ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="box-body">
                                    <?php
                                    $return = '';
                                    $tableau = executeRequete("SELECT id_commande, montant, date_enregistrement, etat FROM commande WHERE id_membre=".$_SESSION['membre']['id_membre']." AND etat='commande livree'");
                                    echo '<table class="table table-bordered"> <tr class="center">';
                                    while ($colonne = $tableau->fetch_field()) {
                                        echo '<th class="center text-center">' . ucfirst($colonne->name) . '</th>';
                                    }
                                    echo '<th class="center">Action</th>';
                                    echo "</tr>";
                                    while ($ligne = $tableau->fetch_assoc()) {

                                        echo '<tr>';
                                        foreach ($ligne as $indice => $information) {
                                            echo '<td class="centered">' . $information . '</td>';
                                        }
                                        echo "<td class='center text-center'>
    <div style=\"width:100px;\">

            <a name=\'action\' href=profil-update2.php?action=consulter&element=" . $ligne['id_commande'] . " class=\"btn btn-azur btn-xs\">
            <i class=\"fa fa-eye\"></i>
            </a>
        </div>
    </div>
</td>";
                                        echo '</tr>';
                                    }
                                    echo '</table>';
                                    ?>
                                </div>
                                <?php if (!empty($consulter)) { ?>
                                <div class="box boxazur">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Commande n° <?php echo $consulter['id_commande'] ?> &nbsp; Enregistrée le
                                            : <?php echo $consulter['date_enregistrement'] ?></h3>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                                    title="Collapse">
                                                <i class="fa fa-minus"></i></button>
                                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                                                    title="Remove">
                                                <i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-8 col-md-offset-2">
                                                <label><i class="fa fa-info-circle"></i> Informations:</label><br>
                                                <div class="col-md-4 bg-bleu_azur2 pad5 borderRadius5 text-center">
                                                    <p><?php echo ucfirst($consulter['nom']) ?> <?php echo ucfirst($consulter['prenom']) ?></p>
                                                    <p><?php echo $consulter['email'] ?></p>
                                                    <p><?php echo ucfirst($consulter['adresse']) ?></p>
                                                    <p><?php echo ucfirst($consulter['code_postal']) ?>
                                                        &nbsp; <?php echo ucfirst($consulter['ville']) ?></p>

                                                </div>
                                                <div class="col-md-4 bg-bleu_azur2 pull-right pad5 borderRadius5 text-center">
                                                    <p>Etat : <br><?php echo ucfirst($consulter['etat']) ?></p>
                                                </div>
                                                <div class="input-error under-grouped">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <?php
                                        $return = '';
                                        $detail_commande_tableau = executeRequete("select p.id_produit, p.photo, p.titre, p.description, d.quantite, d.prix  from details_commande d INNER JOIN produit p on d.id_produit = p.id_produit WHERE id_commande='" . $_GET['element'] . "'");
                                        echo '<table class="table table-bordered"> <tr class="center">';
                                        if ($detail_commande_tableau->num_rows > 0){
                                            while ($colonne = $detail_commande_tableau->fetch_field()) {
                                                echo '<th class="center text-center">' . ucfirst($colonne->name) . '</th>';
                                            }
                                        }else{
                                            echo "<div class='center'>Il n'y a aucun produit sur cette commande</div>";
                                        }

                                        echo "</tr>";
                                        while ($ligne = $detail_commande_tableau->fetch_assoc()) {
                                            echo '<tr>';
                                            foreach ($ligne as $item => $value) {
                                                echo '<td class="center">' . $value . '</td>';
                                            }
                                            echo '</tr>';

                                        }
                                        echo '</table>'
                                        ?>

                                        <br>
                                        <hr>
                                        <!-- /.box-body 2 -->
                                        <div class="box-footer">
                                            <?php echo "<b>Total de produit(s) : </b> " . $detail_commande_tableau->num_rows; ?>
                                        </div>
                                        <!-- /.box-footer 2-->
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab4primary">Prochainement</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
</div>

<?php require_once('footer.php') ?>
