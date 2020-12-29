<?php
  /*
    Une page contenant un formulaire d’inscription (inscription.php) :
    Le formulaire doit contenir l’ensemble des champs présents dans la table “utilisateurs” 
    (sauf “id”) ainsi qu’une confirmation de mot de passe. 
    Dès qu’un utilisateur remplit ce formulaire, 
    les données sont insérées dans la base de données 
    et l’utilisateur est redirigé vers la page de connexion.
  */
    // 
    require_once('pdo.php');


        $error = null;

      $lenght_login = strlen($login);
      $lenght_password = strlen($password);
if (isset($_POST['submit'])) 
{
	if ($_POST['password'] == $_POST['password_confirm'])
	{
 		if ($lenght_login <= 255 AND $lenght_password <=255) 
		{
			$count = $bdd->prepare("SELECT COUNT(*) FROM utilisateurs WHERE login = :login");
	        $count->execute(array(':login' => $login));
	        $num_rows = $count->fetchColumn();

	        if (!$num_rows)
	        {
	          $crypted_password = password_hash($password, PASSWORD_BCRYPT);
	          $insert = $bdd->prepare("INSERT INTO utilisateurs(login, password) VALUES(:login, :crypted_password)");
	          $insert->execute(array( ':login' => $login, ':crypted_password' => $crypted_password));
	        }
	        else 
	        {
	          $error = "Le login exite déja";
	        }		
		}
		else
		{
			$error = "Tout doit faire au max 255 caractères";
		}
	}
	else 
	{
		$error = "le mot de passe de confirmation dois correspondre au mot de passe";
	}
}





?>
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

            