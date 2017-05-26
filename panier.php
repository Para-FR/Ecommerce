<!--A Design by W3layouts 
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php require_once ('config.php') ?>
<?php require_once ('navbar.php') ?>
<!--banner-->
<div class="banner-top">
	<div class="container">
		<h1>Checkout</h1>
		<em></em>
		<h2><a href="index.php">Home</a><label>/</label>Checkout</h2>
	</div>
</div>
<!--login-->
	<script>$(document).ready(function(c) {
					$('.close1').on('click', function(c){
						$('.cart-header').fadeOut('slow', function(c){
							$('.cart-header').remove();
						});
						});	  
					});
			   </script>
<script>$(document).ready(function(c) {
					$('.close2').on('click', function(c){
						$('.cart-header1').fadeOut('slow', function(c){
							$('.cart-header1').remove();
						});
						});	  
					});
			   </script>
			   <script>$(document).ready(function(c) {
					$('.close3').on('click', function(c){
						$('.cart-header2').fadeOut('slow', function(c){
							$('.cart-header2').remove();
						});
						});	  
					});
			   </script>
<div class="check-out">
<div class="container">
	
	<div class="bs-example4" data-example-id="simple-responsive-table">
    <div class="table-responsive">
    	    <table class="table-heading simpleCart_shelfItem">
		  <tr>
			<th class="table-grid">Produit</th>
					
			<th>Prix</th>
			<th >Frais de livraison </th>
			<th>Total</th>
		  </tr>
				<?php
				$idmembre = $_SESSION['membre']['id_membre'];

				$prepa_commande_client =executeRequete("SELECT id_commande FROM commande WHERE id_membre=$idmembre AND etat='commande en cours de traitement'");
				$commande_client = $prepa_commande_client->fetch_assoc();

				$prepa_panier_client = executeRequete("select p.id_produit, p.photo, p.titre, p.description, d.quantite, d.prix  from details_commande d INNER JOIN produit p on d.id_produit = p.id_produit  WHERE id_commande=$commande_client[id_commande]");
				$panier_client = $prepa_panier_client->fetch_assoc();
				var_dump($panier_client);
				?>
				<?php
				foreach ($panier_client as $produit => $value){
					echo '<tr class="cart-header">
			  <td class="ring-in"><a href="single.html" class="at-in"><img src="<?php echo $panier_client[\'photo\']?>" class="img-responsive" alt=""></a>
			<div class="sed">
				<h5><a href="single.html">'. $panier_client['titre']. '</a></h5>
				<p>'.$panier_client['description'].'</p>
			
			</div>
			<div class="clearfix"> </div>
			<div class="close1"> </div></td>
			<td>'.$panier_client['prix'].'€</td>
			<td>GRATUIT</td>
			<td class="item_price">'.$panier_client['prix'].' €</td>
		  </tr>';
				}
				?>
		  <tr class="cart-header">
			  <td class="ring-in"><a href="single.html" class="at-in"><img src="<?php echo $panier_client['photo']?>" class="img-responsive" alt=""></a>
			<div class="sed">
				<h5><a href="single.html"><?php echo $panier_client['titre']?></a></h5>
				<p><?php echo $panier_client['description']?></p>
			
			</div>
			<div class="clearfix"> </div>
			<div class="close1"> </div></td>
			<td><?php echo $panier_client['prix']?>€</td>
			<td>GRATUIT</td>
			<td class="item_price"><?php echo $panier_client['prix']?> €</td>
		  </tr>
		  <tr class="cart-header1">
		  <td class="ring-in"><a href="single.html" class="at-in"><img src="images/ch2.jpg" class="img-responsive" alt=""></a>
			<div class="sed">
				<h5><a href="single.html">Sed ut perspiciatis unde</a></h5>
				<p>(At vero eos et accusamus et iusto odio dignissimos ducimus ) </p>
			</div>
			<div class="clearfix"> </div>
			<div class="close2"> </div></td>
			<td>$100.00</td>
			<td>FREE SHIPPING</td>
			<td class="item_price">$100.00</td>
			<td class="add-check"><a class="item_add hvr-skew-backward" href="#">Add To Cart</a></td>
		  </tr>
		  <tr class="cart-header2">
		  <td class="ring-in"><a href="single.html" class="at-in"><img src="images/ch1.jpg" class="img-responsive" alt=""></a>
			<div class="sed">
				<h5><a href="single.html">Sed ut perspiciatis unde</a></h5>
				<p>(At vero eos et accusamus et iusto odio dignissimos ducimus ) </p>
			</div>
			<div class="clearfix"> </div>
			<div class="close3"> </div></td>
			<td>$100.00</td>
			<td>FREE SHIPPING</td>
			<td class="item_price">$100.00</td>
			<td class="add-check"><a class="item_add hvr-skew-backward" href="#">Add To Cart</a></td>
		  </tr>
		  
	</table>
	</div>
	</div>
	<div class="produced">
	<a href="single.html" class="hvr-skew-backward">Produced To Buy</a>
	 </div>
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
	<!--//footer-->
<?php require_once ('footer.php');