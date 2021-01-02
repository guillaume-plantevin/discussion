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
	require_once('functions/functions.php');

	$title = "inscription";

	// CANCEL
	if (isset($_POST['cancel'])) {
		header('Location: deconnexion.php');
		return;
	}
	// POST-FORM SUBMIT
	if (isset($_POST['submit'])) {
		// EMPTY LOGIN
		if (empty($_POST['login'])) {
			$_SESSION['error'] = 'Vous devez choisir un login pour pouvoir vous inscrire.';
			header("Location: inscription.php");
			return;
		}
		// EMPTY PASSWORD
		elseif (empty($_POST['password'])) {
			$_SESSION['error'] = 'Vous devez choisir un mot de passe pour pouvoir vous inscrire.';
			header("Location: inscription.php");
			return;
		}
		// EMPTY PASSWORD_CONFIRM
		elseif (empty($_POST['password_confirm'])) {
			$_SESSION['error'] = 'Vous devez choisir répéter votre mot de passe pour pouvoir vous inscrire.';
			header("Location: inscription.php");
			return;
		}
		// WRONG CONFIRM
		elseif ($_POST['password'] !== $_POST['password_confirm']) {
			$_SESSION['error'] = "Le mot de passe et sa confirmation ne correspondent pas.";
			header('location: inscription.php');
			return;
		}
		// OK, CONTINUE
		else {
			$loginLength = strlen($_POST['login']);
			$passwordLength = strlen($_POST['password']);

			// LOGIN TOO LONG
			if ($loginLength > 255) {
				$_SESSION['error'] = "Votre login est trop long: Veuillez en choisir un plus court.";
				header('location: inscription.php');
               	return;
			}
			// PASSWORD TOO LONG
			elseif ($passwordLength > 255) {
				$_SESSION['error'] = "Votre mot de passe est trop long: Veuillez en choisir un plus court.";
				header('location: inscription.php');
               	return;
			}
			// OK, CONTINUE
			else {
				// VERIFY IF LOGIN IS AVAILABLE
				$count = $pdo->prepare("SELECT * FROM `utilisateurs` WHERE login = :login");
				$count->execute(array(':login' => htmlentities($_POST['login'])));
				$result = $count->fetch(PDO::FETCH_ASSOC);

				// LOGIN ALREADY EXISTS
				if (!empty($result)) {
					$_SESSION['error'] = "Ce login exite déjà, veuillez en choisir un autre.";
		            header('location: inscription.php');
                	return;
				}
				// OK, CONTINUE
				else {
					$rgt = "INSERT INTO utilisateurs (login, password) VALUES (:login, :password)";
                	$stmt = $pdo->prepare($rgt);
                	$stmt->execute([
                    				':login'    => htmlentities($_POST['login']), 
                    				':password' => password_hash( htmlentities( $_POST['password']), PASSWORD_DEFAULT)
					]);
					
                	$_SESSION['success'] =  'Votre profil a été créé avec succès!';
                	header('location: connexion.php');
                	return;
				}
			}
		}		
	}

?>
<!DOCTYPE html>
<html lang="fr">
	<?php require_once("templates/head.php") ?>
	<body>
		<?php require_once("templates/header.php") ?>
		<main class="container">
			<h1>Inscription</h1>
			<p>Pour pouvoir voir et participer à notre fil de discussion, 
				vous devez vous inscrire en remplissant le formulaire suivant:
			</p>
			<?php
	        	if (isset($_SESSION['error'])) {
	        		echo '<p class="error" >'.  $_SESSION['error'] . "</p>";
	        		unset($_SESSION['error']);
	        	}
			/*
	        	elseif (isset($_SESSION['success'])) {
	        		echo '<p class="success" >'.  $_SESSION['success'] . "</p>";
	        		unset($_SESSION['success']);
	        	}
			*/
	        ?>
			<form action="inscription.php" method="POST">
	            <label for="login">Login:</label>
	            <input type="text" name="login" id="login" /><br />

	            <label for="password">Mot de passe:</label>
	            <input type="password" name="password" id="password" /><br />

	            <label for="passwordConfirm">Confirmation du mot de passe:</label>
	            <input type="password" name="password_confirm" /><br />

				<input type="submit" id="submitButton" name="submit" value="Inscription" />
				
	            <input type='submit' name='cancel' value='annuler' />          
	        </form>
    	</main>
	
	</body>
</html>
            
