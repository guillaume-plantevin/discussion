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
			<h1>Accueil</h1>
			<div class="video1">
				<video class="video_soccer" width="1200" autoplay="" >
					<source src="videos/foot.mp4" type="video/mp4">
				</video>
			</div>
		</main>
		<?php require_once('templates/footer.php'); ?>
	</body>
</html>
