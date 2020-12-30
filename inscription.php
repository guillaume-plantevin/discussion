<?php
  /*
    Une page contenant un formulaire d’inscription (inscription.php) :
    Le formulaire doit contenir l’ensemble des champs présents dans la table “utilisateurs” 
    (sauf “id”) ainsi qu’une confirmation de mot de passe. 
    Dès qu’un utilisateur remplit ce formulaire, 
    les données sont insérées dans la base de données 
    et l’utilisateur est redirigé vers la page de connexion.
  */
   
    require_once('pdo.php');


    $error = null;




	if (isset($_POST['submit'])) 
	{
		echo 'inside submit<br>';
		$length_login = strlen($_POST['login']);
    	$length_password = strlen($_POST['password']);

		if ($_POST['password'] == $_POST['password_confirm'])
		{
			// DEBUG
			echo "password OK<br>";
			if ($length_login <= 255 AND $length_password <=255) 
			{
				// DEBUG
				echo '30: length: OK<br>';
				$count = $pdo->prepare("SELECT * FROM `utilisateurs` WHERE login = :login");
		        $count->execute(array(':login' => htmlentities($_POST['login'])));
		        $num_rows = $count->fetch(PDO::FETCH_ASSOC);
		        // echo $num_rows;
		        var_dump($num_rows);

		         if (!$num_rows)
		        {
		        	$rgt = "INSERT INTO utilisateurs (login, password) VALUES (:login, :password)";
                
                // DEBUG
                echo "<pre>\n" . $rgt . "</pre>";
    
                // sanitizing input query
                $stmt = $pdo->prepare($rgt);
    
                $stmt->execute([
                    ':login' => htmlentities($_POST['login']), 
                    ':password' => password_hash( htmlentities( $_POST['password']), PASSWORD_DEFAULT)
                ]);

                $ok =  'Votre profil a été créé avec succès!';

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
            <?php  

            	if (isset($error)) {
            		echo $error;
            		# code...
            	}
            	else echo $ok;

            ?>

            