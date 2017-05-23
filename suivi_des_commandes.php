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
<?php if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'consulter') {
    $consulter = do_action_client($_GET['action']);
} ?>
<?php require_once('navbar.php') ?>

<div class="banner-top">
    <div class="container">
        <h1>Suivi des Commandes</h1>
        <em></em>
        <h2><a href="index.php">Accueil</a><label>/</label>Suivi des Commandes</h2>

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
    <div class="login">
        <div class="form-group">

            <div class="box-body">
                <?php
                $return = '';
                $tableau_suivi_commandes = executeRequete("SELECT id_commande, montant, date_enregistrement, etat FROM commande WHERE id_membre=".$_SESSION['membre']['id_membre']." AND etat='commande en cours de traitement' OR id_membre=".$_SESSION['membre']['id_membre']." AND  etat='commande en cours de livraison'");
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

            <a name=\'action\' href=suivi_des_commandes.php?action=consulter&element=" . $ligne['id_commande'] . " class=\"btn btn-azur btn-xs\">
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
            <div class="box boxpink">
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
                </div>
                <?php } ?>
                <div class="box-footer">
                    <label class="hvr-skew-backward center">
                        <a href="profil">Retour</a>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <hr>
</div>

<?php require_once('footer.php') ?>
