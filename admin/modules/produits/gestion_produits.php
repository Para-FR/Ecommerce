<?php require_once('../../includes/config.php') ?>
<?php
function do_action_produit($action)
{

    if ($action == 'supprimer') {
        $element = $_GET['element'];

        if (!empty($element)) {
            executeRequete("DELETE FROM produit WHERE id_produit=$element");
            $suppression = '<strong>Supprimé !</strong><br> Produit Supprimé';
            return $suppression;
        }
    }
    if ($action == 'modifier') {
        $element = $_GET['element'];

        if (!empty($element)) {
            executeRequete("SELECT * FROM membre WHERE id_membre = $element");
            $caca = executeRequete("SELECT * FROM membre WHERE id_membre = $element");
            $test = $caca->fetch_assoc();
            var_dump($test['pseudo']);
            $resultat_modifier = '';
            return $resultat_modifier;
        }
    } else {
        $resultat_modifier = '';
        return $resultat_modifier;
    }
}

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
            executeRequete("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse, statut) 
            VALUES('$_POST[pseudo_admin]', '$mdp_crypt', '$_POST[first_name_admin]', '$_POST[last_name_admin]', '$_POST[email_admin]', '$_POST[civilite]', '$_POST[ville_admin]', '$_POST[cp_admin]', '$_POST[adresse_admin]', '$statut')");
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
            executeRequete("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse, statut) 
            VALUES('$_POST[pseudo_user]', '$mdp_crypt', '$_POST[first_name_user]', '$_POST[last_name_user]', '$_POST[email_user]', '$_POST[civilite]', '$_POST[ville_user]', '$_POST[cp_user]', '$_POST[adresse_user]', '$statut')");
            $succes .= '<strong>Validé !</strong><br> L\'utilisateur ' . $_POST['first_name_user'] . '&nbsp;' . $_POST['last_name_user'] . ' a bien été ajouté';
        }
    }
}
if (isset($_POST['sub_add_produit'])) {
    $echec_ajout_produit = '';
    $stock_produit = $_POST['stock_produit'];
    $taille_produit = $_POST['size_produit'];
    $prix_produit = $_POST['prix_produit'];
    if (isset($stock_produit) && !is_numeric($stock_produit)) {
        $echec_ajout_produit .= '<strong>Erreur !</strong><br> Le champ Stock est incorrect (Numérique)';
    }
    if (isset($taille_produit) && is_numeric($taille_produit)) {
        $echec_ajout_produit .= '<strong>Erreur !</strong><br> Le champ Taille est incorrect (Numérique)';
    }
    if (isset($prix_produit) && !is_numeric($prix_produit)) {
        $echec_ajout_produit .= '<strong>Erreur !</strong><br> Le champ Prix est incorrect (Numérique)';
    }
    if (isset($echec_ajout_produit) && empty($echec_ajout_produit)) {
        executeRequete("INSERT INTO produit (reference, categorie, titre, taille, description, couleur, prix, stock )
      VALUES ('$_POST[reference_produit]', '$_POST[categorie_produit]', '$_POST[titre_produit]', '$_POST[size_produit]', '$_POST[description_produit]', '$_POST[couleur_produit]', '$_POST[prix_produit]', '$_POST[stock_produit]')");
        $produitajouté = '<strong>Validé !</strong><br> Le produit ' . $_POST['titre_produit'] . '&nbsp;' . 'a bien été ajouté';
    }
    else{
        $echec_ajout_produit .= '';
    }

}
?>
<?php require_once('../../includes/navbar.php'); ?>
    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Gestion des Produits
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
            <div class="box boxgreen">
                <div class="box-header with-border">
                    <h3 class="box-title">Ajouter</h3>
                    <?php var_dump($_POST) ?>
                    <?php if (isset($produitajouté) && !empty($produitajouté)) { ?>
                        <div class="alert alert-success center" role="alert">
                            <?php echo $produitajouté ?>
                        </div>
                    <?php } ?>

                    <?php if (isset($echec_ajout_produit) && !empty($echec_ajout_produit)) { ?>
                        <div class="alert alert-danger center" role="alert">
                            <?php echo $echec_ajout_produit ?>
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
                                            <a href="#tab_insert_1" data-toggle="tab" aria-expanded="true"><i
                                                    class="fa fa-plus"></i> Produit</a>
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

                                                <br>
                                                <div class="col-md-8 col-md-offset-2">
                                                    <label for="sel1">Informations générales :</label>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-shopping-bag"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputtitre_produit" name="titre_produit"
                                                                   placeholder="Entrez le nom du produit" value="" required>
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                   id="inputprix_produit" name="prix_produit"
                                                                   placeholder="Prix" value="" required>
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-euro"></i></span>
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-align-justify"></i></span>
                                                            <textarea type="text" class="form-control"
                                                                      id="inputdescription_produit"
                                                                      name="description_produit"
                                                                      placeholder="Entrez une Description ..."
                                                                      value="" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-barcode"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputreference_produit"
                                                                   name="reference_produit"
                                                                   placeholder="Référence Produit" value="" required>
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 col-md-offset-2">
                                                    <label for="sel1">Informations secondaires :</label>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <select name="genre_produit" class="form-control" required>
                                                            <option value="h">Homme</option>
                                                            <option value="f">Femme</option>
                                                            <option value="mixte">Mixte</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select name="categorie_produit" class="form-control" required>
                                                            <option value="h">T-Shirt</option>
                                                            <option value="f">Pantalon</option>
                                                            <option value="mixte">Veste</option>
                                                        </select>

                                                    </div>

                                                </div>
                                                <br/>

                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-tags"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="input_size_produit"
                                                                   name="size_produit"
                                                                   placeholder="Taille Disponibles ex : S, M ..."
                                                                   value="" required>
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-cubes"></i></span>
                                                            <input type="number" class="form-control"
                                                                   id="input_stock_produit" name="stock_produit"
                                                                   placeholder="Stock" value="" required>
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <div class="form-group">
                                                            <label for="exampleInputFile">Image du Produit</label>
                                                            <input name="photo_produit" type="file" id="photo_produit">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select name="couleur_produit" class="form-control">
                                                            <option value="rouge">Rouge</option>
                                                            <option value="noir">Noir</option>
                                                            <option value="blanc">Blanc</option>
                                                        </select>

                                                    </div>

                                                </div>

                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-11">

                                                        <button name="sub_add_produit" type="submit"
                                                                class="btn btn-success  pull-right">
                                                            <i class="fa fa-check"></i> Ajouter
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
            <?php if (isset($_GET['action']) && !empty($_GET['action'] && $_GET['action'] != 'modifier')) {
                $suppression = do_action_produit($_GET['action']);
            }
            ?>
            <!-- Default box 2 -->
            <div class="box boxblue">
                <div class="box-header with-border">
                    <h3 class="box-title">Ensemble des produits</h3>
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
                    $tableau = executeRequete("SELECT * FROM produit");
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
                        echo "<td class='center'><i class='fa fa-pencil' aria-hidden='true'><a name=\'action\' href=gestion_produits.php?action=modifier&element=" . $ligne['id_produit'] . "></i> Modification</td>";
                        echo "<td class='center'><i class='fa fa-trash' aria-hidden='true'><a name=\'action\' href=gestion_produits.php?action=supprimer&element=" . $ligne['id_produit'] . "></i> Suppression</td>";
                        echo '</tr>';
                    }
                    echo '</table>';
                    ?>
                </div>
                <!-- /.box-body 2 -->
                <div class="box-footer">
                    <?php echo "<b>Total de produits : </b> " . $tableau->num_rows; ?>
                </div>
                <!-- /.box-footer 2-->
            </div>
            <!-- /.box 2 -->

        </section>
    </div>
    <!-- /.content-wrapper -->

<?php require_once('../../includes/footer.php'); ?>