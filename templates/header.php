<header>
	<div class="div1-accueil">
		<h1 class="h1-accueil"> FOOT-PROJECT </h1>
	</div>
	<nav>
		<ol class="breadcrumb " itemscope itemtype="http://schema.org/BreadcrumbList">
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a itemprop="item" href="index.php"><span itemprop="name">Accueil</span></a>
				<meta itemprop="position" content="1" />
			</li>
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				 <?php 
					if(isset($_SESSION['login']))
						echo "<a itemprop=\"item\" href=\"profil.php\"><span itemprop=\"name\">Profil</span></a><meta itemprop=\"position\" content=\"3\" /></li>";
					else 
						echo  "<a itemprop=\"item\" href=\"inscription.php\"><span itemprop=\"name\">Inscription</span></a><meta itemprop=\"position\" content=\"3\" /></li>" ;
            	?>
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<?php 
					if(isset($_SESSION['login']))
						echo "<a itemprop=\"item\" href=\"deconnexion.php\"><span itemprop=\"name\">Deconnexion</span></a><meta itemprop=\"position\" content=\"3\" /></li>" ;  
					else 
						echo  "<a itemprop=\"item\" href=\"connexion.php\"><span itemprop=\"name\">Connexion</span></a><meta itemprop=\"position\" content=\"3\" /></li>" ;
				?>	
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a itemprop="item" href="discussion.php"> 
					<span itemprop="name">Discussion</span>
				</a>
				<meta itemprop="position" content="4" />

			</li>
		</ol>
	</nav>
</header>