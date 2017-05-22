<!--A Design by W3layouts 
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php require_once ('config.php')?>
<?php if ($_POST){
            executeRequete("INSERT INTO contact (name_contact, email_contact, sujet_contact, date_contact, message_contact) 
            VALUES('$_POST[nom]', '$_POST[email]', '$_POST[sujet]', NOW(), '$_POST[message]')");
            $succes .= '<strong>Validé !</strong><br> Votre message a bien été envoyé. <br> Il sera traité le plus rapidement possible !';
}?>
<?php require_once ('navbar.php')?>

<!--banner-->
	<div class="banner-top">
	<div class="container">
		<h1>Contact</h1>
		<em></em>
		<h2><a href="index.php">Home</a><label>/</label>Contact</h2>
	</div>
</div>

			<div class="contact">

				<div class="contact-form">
					<div class="container">
					<div class="col-md-6 contact-left">
						<h3>Bienvenue sur Shopin ! </h3>
						<p>C'est ici que vous trouverez tous les moyens de nous contacter ! </p>


					<div class="address">
					<div class=" address-grid">
							<i class="glyphicon glyphicon-map-marker"></i>
							<div class="address1">
								<h3>Addresse</h3>
								<p>2 Rue du Corbusier 13090 Aix en Provence</p>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class=" address-grid ">
							<i class="glyphicon glyphicon-phone"></i>
							<div class="address1">
							<h3>Téléphone :<h3>
								<p>+123456789</p>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class=" address-grid ">
							<i class="glyphicon glyphicon-envelope"></i>
							<div class="address1">
							<h3>Email:</h3>
								<p><a href="mailto:info@example.com"> contact@shopin.fr</a></p>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class=" address-grid ">
							<i class="glyphicon glyphicon-bell"></i>
							<div class="address1">
								<h3>Horaires d'ouverture :</h3>
								<p>Lundi - Vendredi , 9h - 19h</p>
							</div>
							<div class="clearfix"> </div>
						</div>
</div>
				</div>
                            <form action="#" method="post">
                                <div class="col-md-6 login-do">
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
                                    <h1>Besoin d'aide ?</h1>
                                    <hr>
                                    <div class="login-mail">
                                        <input name="nom" type="text" placeholder="Nom Complet" required>
                                        <i class="fa fa-vcard"></i>
                                    </div>
                                    <div class="login-mail">
                                        <input name="email" type="email" placeholder="Adresse mail" required>
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <div class="login-mail">
                                        <input name="sujet" type="text" placeholder="Sujet" required>
                                        <i class="fa fa-commenting-o"></i>
                                    </div>
                                    <div class="login-mail">
                                        <textarea name="message" cols="60" rows="5" placeholder="Votre Message"></textarea>
                                    </div>
                                    <label class="hvr-skew-backward">
                                        <input type="submit" value="Envoyer">
                                    </label>

                                </div>

                                <div class="clearfix"></div>
                            </form>
		<div class="clearfix"></div>
		</div>
		</div>
		<div class="map">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d37494223.23909492!2d103!3d55!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x453c569a896724fb%3A0x1409fdf86611f613!2sRussia!5e0!3m2!1sen!2sin!4v1415776049771"></iframe>
					</div>
	</div>

<!--//contact-->
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
			</div>

		</div>
	<!--//content-->
	<!--//footer-->
<?php require_once ('footer.php')?>