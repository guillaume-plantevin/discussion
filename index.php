<?php 
	session_start(); 
	$title = "accueil";
?>

<!DOCTYPE html>
<html lang="fr">
	<?php require_once("templates/head.php") ?>
	<body class="body-accueil">
		<?php require_once("templates/header.php") ?>
		<main class="'container">
			<!-- <article class="article-accueil presentation"> -->
			<article class="article-accueil presentation">
				<h1>Accueil</h1>
			<!-- changement du h1 initial en h2 -->
				<h2>Venez rencontrer des passionnés comme vous !</h2>			
				<p>Ici, vous pourrez <strong> partager, échanger, discuter</strong> avec des milliers de personnes à travers le monde.<br> 
				Pour cela, il vous suffit de vous <strong>enregistrer</strong> puis de vous <strong>connecter</strong> afin d'accéder à notre fil de discution. 
			</p>
				</article>
		</main>
		<?php require_once('templates/footer.php'); ?>
	</body>
</html>
