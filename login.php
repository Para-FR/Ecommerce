<?php require_once('config.php') ?>
<?php
if (internauteEstConnecte()){
	header('Location:profil.php');
}
if (isset($_POST['connect'])) {
	$resultat = executeRequete("SELECT * FROM membre WHERE pseudo='$_POST[pseudo]'");
	if ($resultat->num_rows != 0) {
		$membre = $resultat->fetch_assoc();
		if ($membre['mdp'] == sha1($_POST['mdp'])) {
			foreach ($membre as $indice => $element) {
				if ($indice != 'mdp') {
					$_SESSION['membre'][$indice] = $element;
				}
			}
			header("location:profil.php");
		} else {
			$contenu = '<strong>Erreur !</strong><br> Combinaison Pseudo et Mot de Passe incorrect.';
		}
	}else{
		$contenu = '<strong>Erreur !</strong><br> Combinaison Pseudo et Mot de Passe incorrect.';
	}
}
if (isset($_POST['send'])){
	$errormdp = '';
	$succes_password = '';
	if(!empty($_POST['email'])){
		$email = $_POST['email'];
		$mdp_reset = executeRequete("SELECT nom, prenom, email, mdp FROM membre WHERE email = '".$email."' ");
		if ($mdp_reset->num_rows !=1){
			$errormdp .= '<strong>Erreur !</strong><br> Votre mail n\'existe pas !';
		}else{
			$newmdp = chaine_aleatoire(8);
			$info = $mdp_reset->fetch_assoc();
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8';
			$msg  =  'Bonjour '.$info['nom']." ".$info['prenom'].'<br />';
			$msg .=  'Votre nouveau Mot de passe est : <strong>'.$newmdp.'</strong><br />';
			$msg .=  "Connectez vous : <a href=\"http://ecommercemai2017:8082/login\"> ICI </a>";
			$objet = 'Récupération de votre mot de passe Shopin';

			$mail_send = mail($info['email'], $objet,$msg , $headers);
			if ($mail_send){
				$succes_password .= '<strong>Succès !</strong><br> Vous recevrez votre nouveau mot de passe d\'ici 5 mins !';
				$mdpcrypt = sha1($newmdp);
				var_dump($mdpcrypt);
				executeRequete("UPDATE membre SET mdp = '".$mdpcrypt."' WHERE email = '".$email."'");
			}else{
				$errormdp .= '<strong>Erreur !</strong><br> Echec de l\'envoi du mail, merci de réessayer.';
			}
		}
	}else{
		$errormdp .= '<strong>Erreur !</strong><br> Adresse mail non valide !';
	}


}

?>
<?php require_once('navbar.php') ?>
<!--banner-->
<div class="banner-top">
	<div class="container">
		<h1>Connexion</h1>
		<em></em>
		<h2><a href="index.php">Accueil</a><label>/</label>Connexion</h2>

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
			<form method="post" action="#">
			<div class="col-md-6 login-do">
				<div class="login-mail">
					<input name="pseudo" type="text" placeholder="Pseudo" required="">
					<i class="fa fa-user-circle-o"></i>
				</div>
				<div class="login-mail">
					<input name="mdp" type="password" placeholder="Mot de passe" required="">
					<i class="fa fa-unlock-alt"></i>
				</div>
				<label class="hvr-skew-backward">
					<input name="connect" type="submit" value="Se connecter">
				</label><br><br>
				<a class="lien-bleu" data-toggle="modal" data-target="#myModal">Mot de Passe Oublié ?</a>
			</div>
			<div class="col-md-6 login-right">
				 <h3>Pas encore inscrit ?</h3>

				 <p>Pellentesque neque leo, dictum sit amet accumsan non, dignissim ac mauris. Mauris rhoncus, lectus tincidunt tempus aliquam, odio
				 libero tincidunt metus, sed euismod elit enim ut mi. Nulla porttitor et dolor sed condimentum. Praesent porttitor lorem dui, in pulvinar enim rhoncus vitae. Curabitur tincidunt, turpis ac lobortis hendrerit, ex elit vestibulum est, at faucibus erat ligula non neque.</p>
				<a href="register.php" class=" hvr-skew-backward">S'inscrire</a>

			</div>

			<div class="clearfix"> </div>
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
	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Récupération de Mot de Passe</h4>
				</div>
				<div class="modal-body">
					<form action="" method="post" >
						<p>Vous avez oublié votre mot de passe ?<br>Pas de soucis, entrez votre adresse mail ci-dessous :</p>

						<label for="email" >E-mail</label>
						<div class="login-mail">
							<input name="email" type="email" placeholder="exemple@test.fr" required="">
							<i class="fa fa-envelope"></i>
						</div>
						<button type="submit" class="btn btn-success" name="send" id="send">Envoyer</button>


					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
				</div>
			</div>

		</div>

	</div>
<?php include('footer.php') ?>