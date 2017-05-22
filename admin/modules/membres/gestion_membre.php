<?php require_once('../../includes/config.php') ?>
<?php
function do_action_membre($action)
{

    if ($action == 'supprimer') {
        $element = $_GET['element'];

        if (!empty($element)) {
            executeRequete("DELETE FROM membre WHERE id_membre=$element");
            $suppression = '<strong>Supprimé !</strong><br> Utilisateur Supprimé';
            return $suppression;
        }
    }
    if ($action == 'modifier') {
        $element = $_GET['element'];

        if (!empty($element)) {
            executeRequete("SELECT * FROM membre WHERE id_membre=$element");
            $caca = executeRequete("SELECT * FROM membre WHERE id_membre=$element");
            $test = $caca->fetch_assoc();
            //var_dump($test);
            return $test;
        }
    } else {
        $resultat_modifier = '';
        return $resultat_modifier;
    }
}

?>
<?php

if (isset($_POST['sub_admin'])) {
    $verif_caracters = preg_match('#^[a-zA-Z0-9._-]+$#', $_POST['pseudo_admin']);
    if (!$verif_caracters && (strlen($_POST['pseudo_admin'] < 1) || strlen($_POST['pseudo_admin'] > 20))) {
        $contenu .= '<strong>Erreur !</strong><br> Le champ Pseudo doit contenir entre 1 et 20 caractères alphanumériques.';
    } else {
        $membre = executeRequete("SELECT * FROM membre WHERE pseudo='$_POST[pseudo_admin]'");
        if ($membre->num_rows > 0) {
            $contenu .= '<strong>Erreur !</strong><br> Le Pseudo existe déjà';
        } else {
            $statut = 1;
            $mdp_crypt = sha1($_POST['password_admin']);
            foreach ($_POST as $indice => $valeur) {
                $_POST[$indice] = htmlentities(addslashes($valeur));
            }
            executeRequete("INSERT INTO membre (pseudo, mdp, mdp_confirm, nom, prenom, email, civilite, ville, code_postal, adresse, statut) 
            VALUES('$_POST[pseudo_admin]', '$mdp_crypt', '$mdp_crypt', '$_POST[first_name_admin]', '$_POST[last_name_admin]', '$_POST[email_admin]', '$_POST[civilite]', '$_POST[ville_admin]', '$_POST[cp_admin]', '$_POST[adresse_admin]', '$statut')");
            $succes .= '<strong>Validé !</strong><br> L\'administrateur ' . $_POST['first_name_admin'] . '&nbsp;' . $_POST['last_name_admin'] . ' a bien été ajouté';
        }
    }
}
if (isset($_POST['sub_user'])) {
    $verif_caracters = preg_match('#^[a-zA-Z0-9._-]+$#', $_POST['pseudo_user']);
    if (!$verif_caracters && (strlen($_POST['pseudo_user'] < 1) || strlen($_POST['pseudo_user'] > 20))) {
        $contenu .= '<strong>Erreur !</strong><br> Le champ Pseudo doit contenir entre 1 et 20 caractères alphanumériques.';
    } else {
        $membre = executeRequete("SELECT * FROM membre WHERE pseudo='$_POST[pseudo_user]'");
        if ($membre->num_rows > 0) {
            $contenu .= '<strong>Erreur !</strong><br> Le Pseudo existe déjà';
        } else {
            $statut = 0;
            $mdp_crypt = sha1($_POST['password_user']);
            foreach ($_POST as $indice => $valeur) {
                $_POST[$indice] = htmlentities(addslashes($valeur));
            }
            executeRequete("INSERT INTO membre (pseudo, mdp, mdp_confirm, nom, prenom, email, civilite, ville, code_postal, adresse, statut) 
            VALUES('$_POST[pseudo_user]', '$mdp_crypt', '$mdp_crypt', '$_POST[first_name_user]', '$_POST[last_name_user]', '$_POST[email_user]', '$_POST[civilite]', '$_POST[ville_user]', '$_POST[cp_user]', '$_POST[adresse_user]', '$statut')");
            $succes .= '<strong>Validé !</strong><br> L\'utilisateur ' . $_POST['first_name_user'] . '&nbsp;' . $_POST['last_name_user'] . ' a bien été ajouté';
        }
    }
}
if (isset($_POST['sub_modifier_membre'])) {
    $echec_modification_membre = '';
    $verif_caracters = preg_match('#^[a-zA-Z0-9._-]+$#', $_POST['pseudo_admin']);
    if (!$verif_caracters && (strlen($_POST['pseudo_admin'] < 1) || strlen($_POST['pseudo_admin'] > 20))) {
        $echec_modification_membre .= '<strong>Erreur !</strong><br> Le champ Pseudo doit contenir entre 1 et 20 caractères alphanumériques.';
    } else {
        $membre = executeRequete("SELECT * FROM membre WHERE pseudo='$_POST[pseudo_admin]'");
        $motdp = $membre->fetch_assoc();
        if ($membre->num_rows > 1) {
            $echec_modification_membre .= '<strong>Erreur !</strong><br> Le Pseudo existe déjà';
        } else {
            if (empty($_POST['password_admin'])) {
                $mdp_crypt = $motdp['mdp'];
            } else {
                if ($_POST['password_admin'] == $_POST['confirmation_admin']) {
                    $mdp_crypt = sha1($_POST['password_admin']);
                } else {
                    $echec_modification_membre .= '<strong>Erreur !</strong><br> Les mots de passe ne correspondent pas';
                }
            }
            if (isset($echec_modification_membre) && empty($echec_modification_membre)) {
                executeRequete("UPDATE membre SET pseudo='" . $_POST['pseudo_admin'] . "', mdp='" . $mdp_crypt . "', mdp_confirm='" . $mdp_crypt ."', nom='" . $_POST['first_name_admin'] . "', prenom='" . $_POST['last_name_admin'] . "', email='" . $_POST['email_admin'] . "', civilite= '" . $_POST['civilite'] . "', ville='" . $_POST['ville_admin'] . "', code_postal='" . $_POST['cp_admin'] . "', adresse='" . $_POST['adresse_admin'] . "', statut='" . $_POST['statut_membre'] . "' WHERE id_membre='" . $_GET['element'] . "'");
                $membremodifie = '<strong>Validé !</strong><br> Le membre ' . ucfirst($_POST['first_name_admin']) . '&nbsp;' . ucfirst($_POST['last_name_admin']) . ' a bien été modifié';
                $test = array(
                    "pseudo" => $_POST['pseudo_admin'],
                    "mdp" => $mdp_crypt,
                    "mdp_confirm" => $mdp_crypt,
                    "nom" => $_POST['first_name_admin'],
                    "prenom" => $_POST['last_name_admin'],
                    "email" => $_POST['email_admin'],
                    "civilite" => $_POST['civilite'],
                    "ville" => $_POST['ville_admin'],
                    "code_postal" => $_POST['cp_admin'],
                    "adresse" => $_POST['adresse_admin'],
                    "statut" => $_POST['statut_membre']
                );
            }
        }
    }
}

?>
<?php if (isset($_GET['action']) && !empty($_GET['action'] && $_GET['action'] != 'modifier')) {
    $suppression = do_action_membre($_GET['action']);
}
if (isset($_GET['action']) && !empty($_GET['action'] && $_GET['action'] != 'supprimer')) {
    $test = do_action_membre($_GET['action']);
}
?>
<?php require_once('../../includes/navbar.php'); ?>
    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Gestion des Membres
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Examples</a></li>
                <li class="active">Blank page</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box boxgreen collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Ajouter</h3>
                    <?php if (isset($contenu) && !empty($contenu)) { ?>
                        <div class="alert alert-danger center" role="alert">
                            <?php echo $contenu ?>
                        </div>
                    <?php } ?>
                    <?php if (isset($succes) && !empty($succes)) { ?>
                        <div class="alert alert-success center" role="alert">
                            <?php echo $succes ?>
                        </div>
                    <?php } ?>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-plus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                                title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Custom Tabs -->
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_insert_1" data-toggle="tab" aria-expanded="true">Administrateur</a>
                                        </li>
                                        <li class="">
                                            <a href="#tab_insert_2" data-toggle="tab"
                                               aria-expanded="false">Utilisateur</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <!-- /.tab-pane ADMINUISTRATEUR -->
                                        <div class="tab-pane active" id="tab_insert_1">

                                            <br>
                                            <form action="#"
                                                  class="myform" method="post" accept-charset="utf-8">
                                                <input type="hidden" name="csrf_sitecom_token"
                                                       value="e9475f8e53f59d2f3b2bbeab3cb56c4e">


                                                <div class="row">
                                                    <div
                                                        class="col-md-10 col-md-offset-1 bg-info paddingTop20 borderRadius5">

                                                        <div class="row">
                                                            <div class="col-md-8 col-md-offset-2">
                                                                <label><i class="fa fa-key"></i> Identifiants :</label>

                                                                <div class="input-group">
                                                                    <span class="input-group-addon" id="basic-addon1"><i
                                                                            class="fa fa-user-circle-o"></i></span>
                                                                    <input type="text" class="form-control"
                                                                           id="inputpseudo_admin" name="pseudo_admin"
                                                                           placeholder="Pseudo" value="">
                                                                </div>
                                                                <div class="input-error under-grouped">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-4 col-md-offset-2">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon" id="basic-addon1"><i
                                                                            class="fa fa-lock"></i></span>
                                                                    <input type="password" class="form-control"
                                                                           id="inputpassword_admin"
                                                                           name="password_admin"
                                                                           placeholder="Mot de passe" value="">
                                                                </div>
                                                                <div class="input-error under-grouped">
                                                                </div>

                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon" id="basic-addon1"><i
                                                                            class="ion ion-lock-combination"></i></span>
                                                                    <input type="password" class="form-control"
                                                                           id="inputconfirmation_admin"
                                                                           name="confirmation_admin"
                                                                           placeholder="Confirmation du mot de passe"
                                                                           value="">
                                                                </div>
                                                                <div class="input-error under-grouped">
                                                                </div>

                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                                <br>
                                                <div class="col-md-8 col-md-offset-2">
                                                    <label for="sel1">Informations générales :</label>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-id-card-o"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputfirst_name_admin" name="first_name_admin"
                                                                   placeholder="Nom" value="">
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-user-circle-o"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputlast_name_admin" name="last_name_admin"
                                                                   placeholder="Prénom" value="">
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-envelope"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputemail_admin" name="email_admin"
                                                                   placeholder="Adresse mail" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <div class="input-group">
                                                            <input type="radio" class="radio-inline" value="m"
                                                                   name="civilite" checked>&nbsp; <i class="fa fa-mars"
                                                                                                     aria-hidden="true"></i>
                                                            Monsieur
                                                            <input type="radio" class="radio-inline" value="f"
                                                                   name="civilite"> &nbsp;<i class="fa fa-venus"
                                                                                             aria-hidden="true"></i>
                                                            Madame
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <label for="sel1">Coordonnées secondaires :</label>

                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-home"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputadresse_admin" name="adresse_admin"
                                                                   placeholder="Adresse" value="">
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-envelope"></i></span>
                                                            <input type="text" class="form-control" id="inputcp_admin"
                                                                   name="cp_admin" placeholder="Code postal" value="">
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-institution"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputville_admin" name="ville_admin"
                                                                   placeholder="Ville" value="">
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-11">

                                                        <button name="sub_admin" type="submit"
                                                                class="btn btn-success  pull-right">
                                                            <i class="fa fa-check"></i> Valider
                                                        </button>
                                                    </div>
                                                </div>


                                            </form>
                                        </div>
                                        <!-- /.tab-pane AEROPORT -->
                                        <div class="tab-pane" id="tab_insert_2">

                                            <br>
                                            <form action="#"
                                                  class="myform" method="post" accept-charset="utf-8">
                                                <input type="hidden" name="csrf_sitecom_token"
                                                       value="e9475f8e53f59d2f3b2bbeab3cb56c4e">


                                                <div class="row">
                                                    <div
                                                        class="col-md-10 col-md-offset-1 bg-info paddingTop20 borderRadius5">

                                                        <div class="row">
                                                            <div class="col-md-8 col-md-offset-2">
                                                                <label><i class="fa fa-key"></i> Identifiants :</label>

                                                                <div class="input-group">
                                                                    <span class="input-group-addon" id="basic-addon1"><i
                                                                            class="fa fa-user-circle-o"></i></span>
                                                                    <input type="text" class="form-control"
                                                                           id="inputpseudo_user" name="pseudo_user"
                                                                           placeholder="Pseudo" value="">
                                                                </div>
                                                                <div class="input-error under-grouped">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-4 col-md-offset-2">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon" id="basic-addon1"><i
                                                                            class="fa fa-lock"></i></span>
                                                                    <input type="password" class="form-control"
                                                                           id="inputpassword_user"
                                                                           name="password_user"
                                                                           placeholder="Mot de passe" value="">
                                                                </div>
                                                                <div class="input-error under-grouped">
                                                                </div>

                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon" id="basic-addon1"><i
                                                                            class="ion ion-lock-combination"></i></span>
                                                                    <input type="password" class="form-control"
                                                                           id="inputconfirmation_user"
                                                                           name="confirmation_user"
                                                                           placeholder="Confirmation du mot de passe"
                                                                           value="">
                                                                </div>
                                                                <div class="input-error under-grouped">
                                                                </div>

                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                                <br>
                                                <div class="col-md-8 col-md-offset-2">
                                                    <label for="sel1">Informations générales :</label>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-id-card-o"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputfirst_name_user" name="first_name_user"
                                                                   placeholder="Nom" value="">
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-user-circle-o"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputlast_name_user" name="last_name_user"
                                                                   placeholder="Prénom" value="">
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-envelope"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputemail_user" name="email_user"
                                                                   placeholder="Adresse mail" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <div class="input-group">
                                                            <input type="radio" class="radio-inline" value="m"
                                                                   name="civilite" checked>&nbsp; <i class="fa fa-mars"
                                                                                                     aria-hidden="true"></i>
                                                            Monsieur
                                                            <input type="radio" class="radio-inline" value="f"
                                                                   name="civilite"> &nbsp;<i class="fa fa-venus"
                                                                                             aria-hidden="true"></i>
                                                            Madame
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <label for="sel1">Coordonnées secondaires :</label>

                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-home"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputadresse_user" name="adresse_user"
                                                                   placeholder="Adresse" value="">
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-envelope"></i></span>
                                                            <input type="text" class="form-control" id="inputcp_user"
                                                                   name="cp_user" placeholder="Code postal" value="">
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-institution"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputville_user" name="ville_user"
                                                                   placeholder="Ville" value="">
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-11">

                                                        <button name="sub_user" type="submit"
                                                                class="btn btn-success  pull-right">
                                                            <i class="fa fa-check"></i> Valider
                                                        </button>
                                                    </div>
                                                </div>


                                            </form>

                                        </div>

                                    </div>
                                    <!-- /.tab-content -->
                                </div>
                                <!-- nav-tabs-custom -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->


                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    Footer
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
            <!-- ./Box Modif -->
            <!-- Box Modification -->
            <?php if (!empty($test)) { ?>
                <div class="box boxorange">
                    <div class="box-header with-border">
                        <h3 class="box-title">Modifier</h3>


                        <?php if (isset($membremodifie) && !empty($membremodifie)) { ?>
                            <div class="alert alert-success center" role="alert">
                                <?php echo $membremodifie ?>
                            </div>
                        <?php } ?>

                        <?php if (isset($echec_modification_membre) && !empty($echec_modification_membre)) { ?>
                            <div class="alert alert-danger center" role="alert">
                                <?php echo $echec_modification_membre ?>
                            </div>
                        <?php } ?>

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
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Custom Tabs -->
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_insert_1" data-toggle="tab" aria-expanded="true"><i
                                                        class="fa fa-plus"></i> Membre : <?php echo $test['pseudo'] ?>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <!-- /.tab-pane Modifier -->
                                            <div class="tab-pane active" id="tab_insert_1">

                                                <br>
                                                <form action="#"
                                                      class="myform" method="post" accept-charset="utf-8">
                                                    <input type="hidden" name="csrf_sitecom_token"
                                                           value="e9475f8e53f59d2f3b2bbeab3cb56c4e">


                                                    <div class="row">
                                                        <div
                                                            class="col-md-10 col-md-offset-1 bg-info paddingTop20 borderRadius5">

                                                            <div class="row">
                                                                <div class="col-md-8 col-md-offset-2">
                                                                    <label><i class="fa fa-key"></i> Identifiants
                                                                        :</label>

                                                                    <div class="input-group">
                                                                    <span class="input-group-addon" id="basic-addon1"><i
                                                                            class="fa fa-user-circle-o"></i></span>
                                                                        <input type="text" class="form-control"
                                                                               id="inputpseudo_admin"
                                                                               name="pseudo_admin"
                                                                               placeholder="Pseudo"
                                                                               value="<?php echo $test['pseudo'] ?>">
                                                                    </div>
                                                                    <div class="input-error under-grouped">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-4 col-md-offset-2">
                                                                    <div class="input-group">
                                                                    <span class="input-group-addon" id="basic-addon1"><i
                                                                            class="fa fa-lock"></i></span>
                                                                        <input type="password" class="form-control"
                                                                               id="inputpassword_admin"
                                                                               name="password_admin"
                                                                               placeholder="Mot de passe" value="">
                                                                    </div>
                                                                    <div class="input-error under-grouped">
                                                                    </div>

                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="input-group">
                                                                    <span class="input-group-addon" id="basic-addon1"><i
                                                                            class="ion ion-lock-combination"></i></span>
                                                                        <input type="password" class="form-control"
                                                                               id="inputconfirmation_admin"
                                                                               name="confirmation_admin"
                                                                               placeholder="Confirmation du mot de passe"
                                                                               value="">
                                                                    </div>
                                                                    <div class="input-error under-grouped">
                                                                    </div>

                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>

                                                    <br>
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <label for="sel1">Informations générales :</label>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4 col-md-offset-2">
                                                            <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-id-card-o"></i></span>
                                                                <input type="text" class="form-control"
                                                                       id="inputfirst_name_admin"
                                                                       name="first_name_admin"
                                                                       placeholder="Nom"
                                                                       value="<?php echo $test['nom'] ?>">
                                                            </div>
                                                            <div class="input-error under-grouped">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-user-circle-o"></i></span>
                                                                <input type="text" class="form-control"
                                                                       id="inputlast_name_admin" name="last_name_admin"
                                                                       placeholder="Prénom"
                                                                       value="<?php echo $test['prenom'] ?>">
                                                            </div>
                                                            <div class="input-error under-grouped">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-8 col-md-offset-2">
                                                            <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-envelope"></i></span>
                                                                <input type="text" class="form-control"
                                                                       id="inputemail_admin" name="email_admin"
                                                                       placeholder="Adresse mail"
                                                                       value="<?php echo $test['email'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-8 col-md-offset-2">
                                                            <div class="input-group">
                                                                <input type="radio" class="radio-inline" value="m"
                                                                       name="civilite" <?php if ($test['civilite'] == 'm') {
                                                                    echo 'checked';
                                                                } ?>>&nbsp; <i class="fa fa-mars"
                                                                               aria-hidden="true"></i>
                                                                Monsieur
                                                                <input type="radio" class="radio-inline" value="f"
                                                                       name="civilite" <?php if ($test['civilite'] == 'f') {
                                                                    echo 'checked';
                                                                } ?>> &nbsp;<i class="fa fa-venus"
                                                                               aria-hidden="true"></i>
                                                                Madame
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-8 col-md-offset-2">
                                                            <label for="sel1">Coordonnées secondaires :</label>

                                                            <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-home"></i></span>
                                                                <input type="text" class="form-control"
                                                                       id="inputadresse_admin" name="adresse_admin"
                                                                       placeholder="Adresse"
                                                                       value="<?php echo $test['adresse'] ?>">
                                                            </div>
                                                            <div class="input-error under-grouped">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4 col-md-offset-2">
                                                            <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-envelope"></i></span>
                                                                <input type="text" class="form-control"
                                                                       id="inputcp_admin"
                                                                       name="cp_admin" placeholder="Code postal"
                                                                       value="<?php echo $test['code_postal'] ?>">
                                                            </div>
                                                            <div class="input-error under-grouped">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-institution"></i></span>
                                                                <input type="text" class="form-control"
                                                                       id="inputville_admin" name="ville_admin"
                                                                       placeholder="Ville"
                                                                       value="<?php echo $test['ville'] ?>">
                                                            </div>
                                                            <div class="input-error under-grouped">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-8 col-md-offset-2">
                                                            <label for="sel1">Statut :</label>

                                                            <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-users"></i></span>

                                                                <select name="statut_membre" class="form-control"
                                                                        required>
                                                                    <option value="1">Administrateur</option>
                                                                    <option value="0" <?php if ($test['statut'] == 0) {
                                                                        echo 'selected';
                                                                    } ?>>Utilisateur
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="input-error under-grouped">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-11">

                                                            <button name="sub_modifier_membre" type="submit"
                                                                    class="btn btn-warning  pull-right">
                                                                <i class="fa fa-cogs"></i> Modifier
                                                            </button>
                                                        </div>
                                                    </div>


                                                </form>
                                            </div>
                                        </div>
                                        <!-- /.tab-content -->
                                    </div>
                                    <!-- nav-tabs-custom -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->


                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        Footer
                    </div>
                    <!-- /.box-footer-->
                </div>

            <?php } ?>
            <!-- ./Box Modification -->
            <!-- Default box 2 -->
            <div class="box boxblue">
                <div class="box-header with-border">
                    <h3 class="box-title">Ensemble des utilisateurs</h3>
                    <?php if (isset($suppression) && !empty($suppression)) { ?>
                        <div class="alert alert-danger center" role="alert">
                            <?php echo $suppression ?>
                        </div>
                    <?php } ?>
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
                    <?php
                    $return = '';
                    $tableau = executeRequete("SELECT id_membre, pseudo, nom, prenom, email, civilite, ville, code_postal, adresse, statut FROM membre");
                    echo '<table class="table table-bordered"> <tr class="center">';
                    while ($colonne = $tableau->fetch_field()) {
                        echo '<th class="center text-center">' . ucfirst($colonne->name) . '</th>';
                    }
                    echo '<th class="center">Modification</th>';
                    echo '<th class="center">Suppression</th>';
                    echo "</tr>";
                    while ($ligne = $tableau->fetch_assoc()) {
                        echo '<tr>';
                        foreach ($ligne as $indice => $information) {
                            echo '<td class="center">' . $information . '</td>';
                        }
                        echo "<td class='center'><i class='fa fa-pencil' aria-hidden='true'><a name=\'action\' href=gestion_membre.php?action=modifier&element=" . $ligne['id_membre'] . "></i> Modification</td>";
                        echo "<td class='center'><i class='fa fa-trash' aria-hidden='true'><a name=\'action\' href=gestion_membre.php?action=supprimer&element=" . $ligne['id_membre'] . "></i> Suppression</td>";
                        echo '</tr>';
                    }
                    echo '</table>';
                    ?>
                </div>
                <!-- /.box-body 2 -->
                <div class="box-footer">
                    <?php echo "<b>Total d'utilisateurs : </b> " . $tableau->num_rows; ?>
                </div>
                <!-- /.box-footer 2-->
            </div>
            <!-- /.box 2 -->

        </section>
    </div>
    <!-- /.content-wrapper -->

<?php require_once('../../includes/footer.php'); ?>