<?php
  /*
    Une page contenant le fil de discussion (discussion.php) :
    Sur cette page, les utilisateurs connectés peuvent voir 
    l’ensemble des messages dans un fil de discussion. 
    En dessous du fil de discussion se trouvent un champs contenant 
    le message et un bouton permettant de l’envoyer. 
    Les utilisateurs non connectés souhaitant accéder 
    à cette page sont redirigés vers la page de connexion.
  */
	session_start();

	require_once('pdo.php');
	require_once('functions/functions.php');

	$title = 'discussion';

	// DEBUG
	// print_r_pre($_SESSION, '$_SESSION:');
	// print_r_pre($_POST, '$_POST:');

	// IF NOT LOGGED
	if (! isset($_SESSION['logged'])) {
		$_SESSION['error'] = 'Le fil de discussion n\'est visible que par les utilisateurs qui sont connectés.';
		header('Location: connexion.php');
		return;
	}
	// CANCEL
	if (isset($_POST['cancel'])) {
		header("Location: discussion.php");
		return;
	}
	// POST-FORM SEND
	if (isset($_POST['submit'])) {
		// EMPTY MSG
		if (empty($_POST['message'])) {
			$_SESSION['error'] = 'Vous ne pouvez pas sauvegarder un commentaire vide.';
			header('Location: discussion.php');
			return;
		}
		else {
			$sql = "INSERT INTO messages 
					(message, id_utilisateur, date) 
					VALUES 
					(:message, :id_utilisateur, :date)";
			// DEBUG
			var_dump_pre($sql, '$sql');

			// sanitizing input query
			$stmt = $pdo->prepare($sql);


			// PAS FINI!!!!
			$stmt->execute([
				':message' => htmlentities($_POST['message']), 
				':id_utilisateur' => $_SESSION['id'],
				':date' => $timestamp = date('y-m-d H:i:s')
			]);

			$_SESSION['success'] = 'Votre message a été rajouté avec succès!';
			header('Location: discussion.php');
			return;
		}
	}
	// GET MESSAGES FROM DB
	$stmt = "SELECT messages.message, utilisateurs.login, messages.date
			FROM `messages` JOIN `utilisateurs` 
			WHERE utilisateurs.id = messages.id_utilisateur ORDER BY messages.ID";

	if (! $result = $pdo->query($stmt) ) {
		// DEBUG
		$_SESSION['error'] = 'Les messages enregistrés ne peuvent pas être reecupérés.';
		// echo 'error';
		// echo 'ok';
		// $row = $result->fetch(PDO::FETCH_ASSOC);
		// DEBUG
		// print_r_pre($row, '60: $rows');
	}
?>

<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php');?>
    <body>
    <?php require_once('templates/header.php'); ?>
        <main class='container'>
            <h1>Fil de Discussion</h1>
            <p>Si vous voulez rajouter un commentaire, si vous suffit de l'<a href='#message'>écrire</a> et de le valider:</p>
            

            <?php 
				if (isset($_SESSION['error'])) {
					echo '<p class="error">' . $_SESSION['error'] . '</p>';
					unset($_SESSION['error']);
				}
				elseif ( isset($_SESSION['success']) ) 
				{
					echo '<p class="success">' . $_SESSION['success'] . '</p>';
					unset($_SESSION['success']);
				}
				echo '<table>';
				while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
					$orgDate = $row['date'];  
					$newDate = date("d-m-Y", strtotime($orgDate));  
					// echo "New date format is: ".$newDate. " (MM-DD-YYYY)"; 
					// print_r_pre($row, '109:$row');
					echo '<article class="commentaires">';
						echo '<h6>Posté par ' . $row['login'] . ', le ' . $newDate . '</h6>';
						echo '<p>' . $row['message'] . '</p>';
					echo '</article>';
				}
				
			?>
			<div>
				<formfield id='message'>
					<legend>Ajouter un message:</legend>
					<form action="" method="POST">
						<label for="message" class='block'>Votre message:</label>
						<textarea name="message" id="message" cols="40" rows="6"></textarea>
						<br />
						
						<input class='button' type='submit' name='cancel' value='annuler'>
						<input class='button' type="submit" name='submit' value="enregistrer">
					</form>
				</formfield>
			</div>
        </main>
        <?php require_once('templates/footer.php'); ?>
    </body>
</html>