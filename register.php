<?php require_once('config.php') ?>
<?php
if (internauteEstConnecte()){
    header('Location:profil.php');
}
if ($_POST){
    $verif_caracters = preg_match('#^[a-zA-Z0-9._-]+$#', $_POST['pseudo']);
    if (!$verif_caracters && (strlen($_POST['pseudo']<1) || strlen($_POST['pseudo']>20))){
        $contenu .= '<strong>Erreur !</strong><br> Le champ Pseudo doit contenir entre 1 et 20 caractères alphanumériques.';
    }else{
        $membre = executeRequete("SELECT * FROM membre WHERE pseudo='$_POST[pseudo]'");
        if ($membre->num_rows>0) {
            $contenu .= '<strong>Erreur !</strong><br> Le Pseudo existe déjà';
        }else{
            $mdp_crypt = sha1($_POST['mdp']);
            foreach ($_POST as $indice => $valeur){
                $_POST[$indice] = htmlentities(addslashes($valeur));
            }
            executeRequete("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse) 
            VALUES('$_POST[pseudo]', '$mdp_crypt', '$_POST[nom]', '$_POST[prenom]', '$_POST[email]', '$_POST[civilite]', '$_POST[ville]', '$_POST[cp]', '$_POST[adresse]')");
            $succes .= '<strong>Validé !</strong><br> Vous êtes désormais inscrit <br> <a href="login.php">Connectez vous</a>';
        }
    }
}?>
<?php require_once('navbar.php');
?>
    <!--banner-->
    <div class="banner-top">
        <div class="container">
            <h1>S'inscrire</h1>
            <em></em>
            <h2><a href="index.php">Accueil</a><label>/</label>S'inscrire</h2>
        </div>
    </div>
    <!--login-->
    <div class="container">
        <div class="login">
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
            <form action="#" method="post">
                <div class="col-md-6 login-do">
                    <hr>
                    <div class="input-group col-md-6">
                        <input type="radio" class="radio-inline" value="m" name="civilite" checked>&nbsp; <i class="fa fa-mars" aria-hidden="true"></i> Monsieur
                        <input type="radio" class="radio-inline" value="f" name="civilite"> &nbsp;<i class="fa fa-venus" aria-hidden="true"></i> Madame
                    </div>
                    <br/>
                    <div class="login-mail">
                        <input name="pseudo" type="text" placeholder="Pseudo" required="">
                        <i class="fa fa-user-circle-o"></i>
                    </div>
                    <div class="login-mail">
                        <input name="mdp" type="password" placeholder="Mot de passe" required="">
                        <i class="fa fa-unlock-alt"></i>
                    </div>
                    <div class="login-mail">
                        <input name="nom" type="text" placeholder="Nom" required="">
                        <i class="fa fa-vcard"></i>
                    </div>
                    <div class="login-mail">
                        <input name="prenom" type="text" placeholder="Prénom" required="">
                        <i class="glyphicon glyphicon-user"></i>
                    </div>
                    <div class="login-mail">
                        <input name="email" type="email" placeholder="Adresse mail" required="">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="login-mail">
                        <input name="ville" type="text" placeholder="Ville" required="">
                        <i class="fa fa-location-arrow"></i>
                    </div>
                    <div class="login-mail">
                        <input name="cp" type="text" placeholder="Code Postal" required="">
                        <i class="fa fa-map-signs"></i>
                    </div>
                    <div class="login-mail">
                        <input name="adresse" type="text" placeholder="Adresse" required="">
                        <i class="fa fa-map-marker"></i>
                    </div>
                    <label class="hvr-skew-backward">
                        <input type="submit" value="S'inscrire">
                    </label>

                </div>
                <div class="col-md-6 login-right">
                    <h3>Vous possedez déjà un compte ?</h3>

                    <p>Pellentesque neque leo, dictum sit amet accumsan non, dignissim ac mauris. Mauris rhoncus, lectus
                        tincidunt tempus aliquam, odio
                        libero tincidunt metus, sed euismod elit enim ut mi. Nulla porttitor et dolor sed condimentum.
                        Praesent porttitor lorem dui, in pulvinar enim rhoncus vitae. Curabitur tincidunt, turpis ac
                        lobortis hendrerit, ex elit vestibulum est, at faucibus erat ligula non neque.</p>
                    <a href="login.php" class="hvr-skew-backward">Se Connecter</a>

                </div>

                <div class="clearfix"></div>
            </form>
        </div>

    </div>

    <!--//login-->

    <!--brand-->
    <div class="container">
        <div class="brand">
            <div class="col-md-3 brand-grid">
                <img src="images/ic.png" class="img-responsive" alt="">
            </div>
            <div class="col-md-3 brand-grid">
                <img src="images/ic1.png" class="img-responsive" alt="">
            </div>
            <div class="col-md-3 brand-grid">
                <img src="images/ic2.png" class="img-responsive" alt="">
            </div>
            <div class="col-md-3 brand-grid">
                <img src="images/ic3.png" class="img-responsive" alt="">
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!--//brand-->

    <!--//content-->
<?php include('footer.php') ?>