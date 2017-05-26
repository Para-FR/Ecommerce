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
		<h1>Homme</h1>
		<em></em>
		<h2><a href="index.php">Accueil</a><label>/</label>Hommes</h2>
	</div>
</div>
	<!--content-->
		<div class="product">
			<div class="container">
			<div class="col-md-10">
				<h1 class="text-center">Collection Homme</h1>
				<hr>
				<?php
				$collec_femme = executeRequete("SELECT * FROM produit WHERE public='h'");
				foreach ($collec_femme as $produit => $value){
					if ($value['public'] == 'h'){
						$public = '<span>Homme</span>';
					}else{
						$public = '<span>Indéfini</span>';
					}
					if (empty($value['photo'])){
						$image = './uploads/default.jpg';
					}else{
						$image = $value['photo'];
					}
					echo '<div class="col-md-4 item-grid1 simpleCart_shelfItem">
					<div class=" mid-pop">
					<div class="pro-img">
						<img src="'.$image.'" class="img-responsive" alt="">
						<div class="zoom-icon ">
						<a class="picture" href="'.$image.'" rel="title" class="b-link-stripe b-animate-go  thickbox"><i class="glyphicon glyphicon-search icon "></i></a>
						<a href="single.html"><i class="glyphicon glyphicon-menu-right icon"></i></a>
						</div>
						</div>
						<div class="mid-1">
						<div class="men">
						<div class="men-top">
							<span>'. $public .'</span>
							<h6><a href="single.html">'. $value['description'] .'</a></h6>
							</div>
							<div class="img item_add">
								<a href="#"><img src="images/ca.png" alt=""></a>
							</div>
							<div class="clearfix"></div>
							</div>
							<div class="mid-2">
								<p><em class="item_price">'. $value['prix'] .' €</em></p>
								  <div class="block">
									<div class="starbox small ghosting"> </div>
								</div>
								
								<div class="clearfix"></div>
							</div>
							
						</div>
					</div>
					</div>';
				}

				?>
				</div>
			</div>
			<div class="clearfix"></div>
			</div>
				<!--products-->
			
			<!--//products-->
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
	<!--//content-->
		<!--//footer-->
<?php require_once ('footer.php');