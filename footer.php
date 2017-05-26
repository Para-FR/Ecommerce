<!--//footer-->
<?php
    if (isset($_POST['sub_newsletter'])){
    if (isset($_POST['input_adresse_mail']) && !empty($_POST['input_adresse_mail'])){
        $new_mail = $_POST['input_adresse_mail'];
        $inscrit ='';
        if (isset($new_mail) && !empty($new_mail)){
            $req_mail_existant = executeRequete("SELECT * FROM newsletter WHERE email_newsletter='$new_mail'");
            if ($req_mail_existant->num_rows >0){
                $inscrit .= '<p>Vous êtes déjà inscrit à notre Newsletter</p>';
            }else{
                executeRequete("INSERT INTO newsletter(email_newsletter) VALUES ('$new_mail') ");
                $inscrit .= '<p>Vous êtes désormais inscrit</p>';
            }
        }

    }
    }
?>
<div class="footer">
    <div class="footer-middle">
        <div class="container">
            <div class="col-md-3 footer-middle-in">
                <a href="index.php"><img src="images/log.png" alt=""></a>
                <p>Un Site Web E-Commerce</p>
            </div>

            <div class="col-md-3 footer-middle-in">
                <h6>Information</h6>
                <ul class=" in">
                    <li><a href="index">Accueil</a></li>
                    <li><a href="produits_femme">Femmes</a></li>
                    <li><a href="produits_hommes">Hommes</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-3 footer-middle-in">
                <h6>Tags</h6>
                <ul class="tag-in">
                    <?php $req_last_searchs = executeRequete("SELECT recherche_client FROM recherche ORDER BY recherche_client asc limit 10");

                    while ($last_recherche = $req_last_searchs->fetch_assoc()){
                        foreach ($last_recherche as $recherches => $recherche){
                            echo '<li><a href="#">'.ucfirst($recherche).'</a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="col-md-3 footer-middle-in">
                <h6>Newsletter</h6>
                <span>Inscrivez vous à notre Newsletter</span>
                <form action="#" method="post">
                    <input name="input_adresse_mail" type="email" placeholder="Entrez votre Adresse Mail" required>
                    <input name="sub_newsletter" type="submit" value="S'inscrire">
                </form>
                <?php
                    if (isset($inscrit) && !empty($inscrit)) echo $inscrit;
                ?>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <ul class="footer-bottom-top">
                <li><a href="#"><img src="images/f1.png" class="img-responsive" alt=""></a></li>
                <li><a href="#"><img src="images/f2.png" class="img-responsive" alt=""></a></li>
                <li><a href="#"><img src="images/f3.png" class="img-responsive" alt=""></a></li>
            </ul>
            <p class="footer-class">&copy; 2017 Shopin. All Rights Reserved | Design by  <a href="http://w3layouts.com/" target="_blank">W3layouts</a> </p>
            <div class="clearfix"> </div>
        </div>
    </div>
</div>
<!--//footer-->
<script src="js/imagezoom.js"></script>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script defer src="js/jquery.flexslider.js"></script>
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />

<script>
    // Can also be used with $(document).ready()
    $(window).load(function() {
        $('.flexslider').flexslider({
            animation: "slide",
            controlNav: "thumbnails"
        });
    });
</script>

<script src="js/simpleCart.min.js"> </script>
<!-- slide -->
<script src="js/bootstrap.min.js"></script>

</body>
</html>