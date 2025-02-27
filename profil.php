<?php
	session_start();

	require_once('pdo.php');
	require_once('functions/functions.php');

	$title = "profil";

	// TAKING BACK VALUES
	if (isset($_SESSION['login']))
		$login = $_SESSION['login'];
	if (isset($_SESSION['password']))
		$password = $_SESSION['password'];

	// CANCEL
	if (isset($_POST['cancel'])) {
		header("Location: profil.php");
		return;
	}

	// POST-FORM SEND
	if (isset($_POST['submit'])) {
		if (empty($_POST['login'])) {
			$_SESSION['error'] = 'Vous ne pouvez pas utiliser un login vide.';
			header("Location: profil.php");
			return;
		}
		// EMPTY PASSWORD
		elseif (empty($_POST['password'])) {
			$_SESSION['error'] = 'Vous ne pouvez pas utiliser un mot de passe vide.';
			header("Location: profil.php");
			return;
		}
		// IF USER CHANGING HIS LOGIN: VERIFY AVAILABILITY
		elseif ($_POST['login'] !== $_SESSION['login']) {
			$verify = "SELECT * FROM utilisateurs WHERE login = :login";
			$stmt = $pdo->prepare($verify);
			$stmt->execute([':login' => htmlentities($_POST['login'])]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			// ALREADY EXISTS -> STOP
			if (!empty($row)) {
				if ($_SESSION['id'] !== $row['id']) {
					$_SESSION['error'] = 'Votre nouveau login est déjà utilisée, veuillez en choisir un autre.';
					header('Location: profil.php');
					return;
				}
			}
		}

		// OK => UPDATE PROFIL
		$sql = "UPDATE utilisateurs 
				SET login = :log, password = :pw 
				WHERE id = :id";

		$stmt = $pdo->prepare($sql);

		$stmt->execute([
			':log' => htmlentities($_POST['login']), 
			':pw' => password_hash( htmlentities($_POST['password']), PASSWORD_DEFAULT),
			':id' => $_SESSION['id']
		]);
		
		// CHARGE INPUTS IN $_SESSION
		$_SESSION['login'] = htmlentities($_POST['login']);
		$_SESSION['password'] = htmlentities($_POST['password']);
		$_SESSION['logged'] = TRUE;
		$_SESSION['success'] = 'Votre profil a bien été mis à jour!';

		header('location: profil.php');
		return;
	}
?>
<!DOCTYPE html>
<html lang="fr">
	<?php require_once("templates/head.php"); ?>
	<body>
		<?php require_once("templates/header.php"); ?>
		<main class='container'>
			<h1>Page de Profil</h1>
			<p>Ici, vous pouvez changer votre identifiant - s'il est disponible - et/ou votre mot de passe:</p>
			<?php
				if (isset($_SESSION['error'])) {
					echo '<p class="error">' . $_SESSION['error'] . '</p>';
					unset($_SESSION['error']);
				}
				elseif ( isset($_SESSION['success']) ) {
					echo '<p class="success">' . $_SESSION['success'] . '</p>';
					unset($_SESSION['success']);
				}
				if (!isset($_SESSION['logged']) || !$_SESSION['logged']) :
					echo '<p class="error">Cette partie du site où vous pourrez modifier vos identifiants, ne sera visible qu\'une fois connecté</p>';
				else :
			?>
			<form action="" method="post">
				<label for="login">Login:</label>
				<input type="text" name="login" id="login" 
					value='<?=$login?>' /> <br />
				
				<label for="password">Mot de passe:</label>
				<input type="text" name="password" id="password" 
					value='<?=$password?>'/> <br />

				<input type="submit" name='cancel' value="Annuler">
				<input type="submit" id="submitButton" name='submit' value="Valider">
			</form>
			<?php endif;?>
		</main>
		<?php require_once('templates/footer.php');?>
	</body>
</html>