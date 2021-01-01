<!-- Une page d’accueil qui présente votre site (index.php) -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<?php
$title = "accueil";
require_once("templates/head.php")
?>

<body class="body-accueil">

	<?php 
	require_once("templates/header.php")
	?>
	<div class="video1">
<video class="video_soccer" width="1200" autoplay="" >
  <source src="videos/foot.mp4" type="video/mp4">
</video>
</div>
	
</body>
</html>
