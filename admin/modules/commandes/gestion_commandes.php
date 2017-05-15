<?php require_once('../../includes/config.php') ?>

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
            <!-- Default box 2 -->
            <div class="box boxblue">
                <div class="box-header with-border">
                    <h3 class="box-title">Vue d'ensemble des Commandes</h3>
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
                    $tableau = executeRequete("SELECT id_commande, id_membre, montant, date_enregistrement, etat FROM commande");
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
                            echo '<td class="centered">' . $information . '</td>';
                        }
                        echo "<td class='center'><i class='fa fa-trash' aria-hidden='true'><a name=\'action\' href=gestion_membre.php?action=modifier&element=" . $ligne['id_commande'] . "></i> Modification</td>";
                        echo "<td class='center'><i class='fa fa-trash' aria-hidden='true'><a name=\'action\' href=gestion_membre.php?action=supprimer&element=" . $ligne['id_commande'] . "></i> Suppression</td>";
                        echo '</tr>';
                    }
                    echo '</table>';
                    ?>
                </div>
                <!-- /.box-body 2 -->
                <div class="box-footer">
                    <?php echo "<b>Total de commande(s) : </b> " . $tableau->num_rows; ?>
                </div>
                <!-- /.box-footer 2-->
            </div>
            <!-- /.box 2 -->

        </section>
    </div>
    <!-- /.content-wrapper -->

<?php require_once('../../includes/footer.php'); ?>