<?php 
	/*
		Une page d’accueil qui présente votre site (index.php)
	*/
	session_start(); 

	$title = "accueil";
?>

<!DOCTYPE html>
<html lang="fr">
	<?php
		require_once("templates/head.php")
	?>
	<body class="body-accueil">
		<?php require_once("templates/header.php") ?>
		<main>
			<div class="video1">
				<video class="video_soccer" width="1200" autoplay="" >
					<source src="videos/foot.mp4" type="video/mp4">
				</video>
			</div>
		</main>
	</body>
</html>
