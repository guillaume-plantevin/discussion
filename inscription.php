<?php
  /*
    Une page contenant un formulaire d’inscription (inscription.php) :
    Le formulaire doit contenir l’ensemble des champs présents dans la table “utilisateurs” 
    (sauf “id”) ainsi qu’une confirmation de mot de passe. 
    Dès qu’un utilisateur remplit ce formulaire, 
    les données sont insérées dans la base de données 
    et l’utilisateur est redirigé vers la page de connexion.
  */

    session_start();
    require_once('pdo.php');

	if (isset($_POST['submit'])) 
	{
		$length_login = strlen($_POST['login']);
    	$length_password = strlen($_POST['password']);

		if ($_POST['password'] == $_POST['password_confirm'])
		{
			if ($length_login <= 255 AND $length_password <=255) 
			{
				$count = $pdo->prepare("SELECT * FROM `utilisateurs` WHERE login = :login");
		        $count->execute(array(':login' => htmlentities($_POST['login'])));
		        $num_rows = $count->fetch(PDO::FETCH_ASSOC);

		        if (!$num_rows)
		        {
		        	$rgt = "INSERT INTO utilisateurs (login, password) VALUES (:login, :password)";
                	$stmt = $pdo->prepare($rgt);
                	$stmt->execute([
                    				':login'    => htmlentities($_POST['login']), 
                    				':password' => password_hash( htmlentities( $_POST['password']), PASSWORD_DEFAULT)
                	]);
                	$_SESSION['success'] =  'Votre profil a été créé avec succès!';
                	header('location: inscription.php');
                	return;

		        }
		        else 
		        {
		            $_SESSION['error'] = "Le login exite déja";
		            header('location: inscription.php');
                	return;
		        }		
			}
			else
			{
				$_SESSION['error'] = "Tout doit faire au max 255 caractères";
				header('location: inscription.php');
               	return;
			}
		}
		else 
		{
			$_SESSION['error'] = "le mot de passe de confirmation dois correspondre au mot de passe";
			header('location: inscription.php');
            return;
		}
}

?>
	<!DOCTYPE html>
	<html lang="fr">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
		<title>Inscription</title>
	</head>
	<body>
		<main class="container">
			<form action="inscription.php" method="POST">

	            <label for="login">Login:</label>
	            <input type="text" name="login" id="login" required /><br />

	            <label for="password">Mot de passe:</label>
	            <input type="password" name="password" id="password" required /><br />

	            <label for="passwordConfirm">Confirmation du mot de passe:</label>
	            <input type="password" name="password_confirm" required /><br />

	            <input type="submit" id="submitButton" name="submit" value="M'inscrire" />
	            <input type='submit' name='cancel' value='annuler' />          
	        </form>
	        <?php  

	        	if (isset($_SESSION['error'])) 
	        	{
	        		echo '<p style = "color : red">'.  $_SESSION['error'] . "</p>";
	        		unset($_SESSION['error']);
	        	}
	        	elseif (isset($_SESSION['success'])) 
	        	{
	        		echo '<p style = "color:green">'.  $_SESSION['success'] . "</p>";
	        		unset($_SESSION['success']);
	        	}

	        ?>
    	</main>
	
	</body>
	</html>
            