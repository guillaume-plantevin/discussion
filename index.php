<!-- Une page d’accueil qui présente votre site (index.php) -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<?php
$title = "accueil";
require_once("templates/head.php")
?>

<body>

	<?php 
	require_once("templates/header.php")
	?>
	<div class="presentation">
		<article class="article-accueil">
		<h1>Venez rencontrer des passionnés comme vous !</h1>			
			<p>Ici, vous pourrez <strong> partager, échanger, discuter</strong> avec des milliers de personnes à travers le monde.<br> Pour cela, il vous suffilt de vous <strong>enregistrer</strong> puis de vous <strong>connecter</strong> afin d'accéder à notre fil de discution en <strong>illimité</strong>. </p>
		</article>
	</div>
	<?php 
	require_once("templates/footer.php")
	?>
	
</body>
</html>
