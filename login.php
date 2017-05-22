<?php require_once('config.php') ?>
<?php
if (internauteEstConnecte()){
	header('Location:profil.php');
}
if ($_POST) {
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
				<hr>
				<label class="hvr-skew-backward">
					<input type="submit" value="Se connecter">
				</label>
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
<?php include('footer.php') ?>