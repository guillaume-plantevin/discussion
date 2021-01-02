<?php
	session_start();
	/*
		Une page contenant un formulaire de connexion (connexion.php) :
		Le formulaire doit avoir deux inputs : “login” et “password”. 
		Lorsque le formulaire est validé, s’il existe un utilisateur en bdd correspondant à ces informations, 
		alors l’utilisateur devient connecté et une (ou plusieurs) variables de session sont créées. 
	*/

	require_once('pdo.php');
	require_once('functions/functions.php');

	$title = 'connexion';

	// CANCEL
	if (isset($_POST['cancel'])) {
		// Redirect the browser to deconnexion.php
		header("Location: deconnexion.php");
		return;
	}

	// SEND POST
	if (isset($_POST['submit'])) {
		// DEBUG 
		// print_r_pre($_POST, '$_POST');

		// NO LOGIN
		if (empty($_POST['login'])) {
			$_SESSION['error'] = 'Vous devez rentrer votre login pour vous connecter.';
			header('Location: connexion.php');
			return;
		}
		// NO PASSWORD
		elseif (empty($_POST['password'])) {
			$_SESSION['error'] = 'Vous devez rentrer votre mot de passe pour vous connecter.';
			header('Location: connexion.php');
			return;
		}
		// OK, CONTINUE
		else {
			$sql = "SELECT * FROM utilisateurs WHERE login = :login";

			$stmt = $pdo->prepare($sql);
			$stmt->execute([':login' => htmlentities($_POST['login'])]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			// DEBUG
			// print_r_pre($row, '49: $row');

			// NO RETURN => NO USER IN DB
			if (empty($row)) {
				$_SESSION['error'] = 'Ce Login n\'existe pas dans notre base de donnée.';
				header('Location: connexion.php');
				return;
			} 
			// OK, CONTINUE
			else {
				// NOT THE SAME PASSWORD
				if (!password_verify(htmlentities($_POST['password']), $row['password'])) {
					$_SESSION['error'] = 'Votre mot de passe ne correspond pas à celui enregistré lors de votre inscription.';
					header('Location: connexion.php');
					return;
				}
				// OK, CONTINUE
				// COPY FROM DB TO $_SESSION
				foreach ($row as $k => $v) {
					$_SESSION[$k] = $v;
				}
				// CREATE BOOL LOGGED
				$_SESSION['logged'] = TRUE;
				// CHARGING PASSWORD, NOT THE HASH
				$_SESSION['password'] = htmlentities($_POST['password']);

				// DEBUG
				// print_r_pre($_SESSION, '75: $_SESSION');

				// GOTO
				header('location: profil.php');
				return;
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="fr">
	<?php require_once("templates/head.php"); ?>

	<!-- <head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
		<link rel="stylesheet" href="styles/styles.css">
		
		<title>Connexion</title>
	</head> -->

	<body>
		<?php require_once('templates/header.php'); ?>
		<main class="container">
			<h1>connexion</h1>
			<p>Pour vous connecter, merci de renseigner les champs suivants:</p>
			<?php
			if (isset($_SESSION['error'])) {
				echo '<p class="error">' . $_SESSION['error'] . '</p>';
				unset($_SESSION['error']);
			} elseif (isset($_SESSION['success'])) {
				echo '<p class="success" >' .  $_SESSION['success'] . "</p>";
				unset($_SESSION['success']);
			}
			?>

			<form action="connexion.php" method="POST">
				<label for="login">Login:</label>
				<input type="text" name="login" id="login"> <br />

				<label for="pass">password:</label>
				<input type="password" name="password" id="pass"> <br />

				<input type="submit" name='submit' value="connexion">
				<input type="submit" name='cancel' value="annuler">
			</form>
		</main>
		<?php require_once('templates/footer.php'); ?>
	</body>
</html>