<?php require_once('config.php') ?>
<?php if (!internauteEstConnecte()) {
    header('Location:register.php');
} ?>
<?php
//var_dump($_SESSION['membre']['pseudo']);
if ($_POST) {
    if(!empty($_POST)) {
        $nom_photo = '';
        $avatar = '';
        $photo_bdd = "";
        $taille_maxi = 100000000;
        $taille = filesize($_FILES['avatar']['tmp_name']);
        $extensions = array('.png', '.gif', '.jpg', '.jpeg');
        $extension = strrchr($_FILES['avatar']['name'], '.');
        $echec_ajout_produit = '';

        if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
        {
            $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg';
        }
        if($taille>$taille_maxi)
        {
            $erreur = 'Le fichier est trop gros...';
        }
        if(!empty($_FILES['avatar']['name']) && !isset($erreur)) {
            $nom_photo = $_POST['nom'].'_'.$_FILES['avatar']['name'];
            $photo_bdd = "./avatars/$nom_photo";
            $photo_dossier = "./avatars/$nom_photo";
            !copy($_FILES['avatar']['tmp_name'], "./avatars/$nom_photo");
        } else {
            echo $echec_ajout_produit .= '<strong>Erreur !</strong><br> Image non uploader car trop volumineuse ou n\'est pas une image';
        }
        foreach($_POST as $indice => $valeur) {
            $_POST[$indice] = htmlEntities(addslashes($valeur));
        }
    }
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
        $avatar = $_FILES['avatar']['name'];

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
            executeRequete("UPDATE membre SET mdp='$mdp_crypt',mdp_confirm='$mdp_crypt',nom='$nom', prenom='$prenom', ville='$ville', code_postal='$code_postal', adresse='$adresse', avatar='$photo_bdd' WHERE id_membre='$idmembre'");
            $succes .= '<strong>Effectué !</strong><br> Vos informations ont été mises à jour.';
            $_SESSION['membre']['nom'] = $_POST['nom'];
            $_SESSION['membre']['prenom'] = $_POST['prenom'];
            $_SESSION['membre']['ville'] = $_POST['ville'];
            $_SESSION['membre']['code_postal'] = $_POST['cp'];
            $_SESSION['membre']['adresse'] = $_POST['adresse'];

        }

    }

}
?>
<?php require_once('navbar.php'); ?>



<div class="banner-top">
    <div class="container">
        <h1>Profil</h1>
        <em></em>
        <h2><a href="index.php">Accueil</a><label>/</label>Profil</h2>

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
<?php
        $chemin_avatar = executeRequete("SELECT avatar FROM membre WHERE id_membre=". $_SESSION['membre']['id_membre']);
        foreach ($chemin_avatar as $value => $test) {
            echo '<img src="'. $test['avatar']. '" style="margin-left:45%; width:100px; height:100px;"/>';
        }
        if (empty($test)) {
            
        }

?>
        <form action="#" method="post" enctype="multipart/form-data">
            <div class="col-md-12 header-login ">
                <div class="input-group col-md-6 center center-block">
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
                <div class="login-mail">
                    <label for="avatar">Votre avatar</label>
                    <input name="avatar" type="file">
                </div>
            </div>
            <div class="col-md-12 login-do center">
                <label class="hvr-skew-backward">
                    <input type="submit" value="Mettre à jour">
                </label>
            </div>

            <div class="clearfix"></div>
        </form>
    </div>
    <hr>
</div>

<?php require_once('footer.php') ?>
