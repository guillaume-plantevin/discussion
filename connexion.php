<?php
  session_start();
  /*
    Une page contenant un formulaire de connexion (connexion.php) :
    Le formulaire doit avoir deux inputs : “login” et “password”. 
    Lorsque le formulaire est validé, s’il existe un utilisateur en bdd correspondant à ces informations, 
    alors l’utilisateur devient connecté et une (ou plusieurs) variables de session sont créées. 
  */
  
  require_once('pdo.php');

  $rgt = "INSERT INTO utilisateurs (login, password) VALUES (:login, :password)";
                
                // DEBUG
                // echo "<pre>\n" . $rgt . "</pre>";
    
                // sanitizing input query
                $stmt = $pdo->prepare($rgt);
    
                $stmt->execute([
                    ':login' => 'test', 
                    ':password' => password_hash('123', PASSWORD_DEFAULT)
                ]);

                // $_SESSION['success'] = 'Votre profil a été créé avec succès!';
                // GOTO
                // header('Location: connexion.php');
                // return;

  if (isset($_POST['cancel'])) {
    // Redirect the browser to deconnexion.php
    header("Location: deconnexion.php");
    return;
  }
  if (isset($_POST['submit'])) {
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
    if ( isset($_POST['login']) && isset($_POST['password']) ) {

        $sql = "SELECT * FROM utilisateurs WHERE login = :login";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([':login' => $_POST['login']]);
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // DEBUG
        print_r_pre($row, '$row');

        if (empty($row)) {
            $_SESSION['error'] = 'Ce Login n\'existe pas dans notre base de donnée.';
            header('Location: connexion.php');
            return;
        }
        else { 
            // NOT THE SAME PASSWORD
            if (!password_verify($_POST['password'], $row['password'])) {
                $_SESSION['error'] = 'Votre mot de passe n\'est pas similaire à celui enregistré lors de votre inscription.';
                header('Location: connexion.php');
                return;
            }
            // OK
            // faire le tour des infos de l'utilisateur dans la DB et les copier dans $_SESSION
            foreach($row as $k => $v) {
                $_SESSION[$k] = $v;
            }
            // BOOL LOGGED
            $_SESSION['logged'] = TRUE;
            // CHARGING PASSWORD, NOT THE HASH
            $_SESSION['password'] = htmlentities($_POST['password']);

            // GOTO
            // header('location: profil.php');
            return;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/styles.css">

  <title>Connexion</title>
</head>
<body>
  <main class="container">
    <h1>connexion</h1>
    <p>Pour vous connecter, merci de renseigner les champs suivants:</p>
    <?php 
      if (isset($_SESSION['error'])) {
          echo '<p class="error">' . $_SESSION['error'] . '</p>';
          unset($_SESSION['error']);
      }
  ?>
    
    <form action="" method="post">
      <label for="login">Login:</label>
      <input type="text" name="login" id="login"> <br />
      
      <label for="pass">password:</label>
      <input type="password" name="" id="pass"> <br />
      
      <input type="submit" name='submit' value="connexion">
      <input type="submit" name='cancel' value="annuler">
    </form>
  </main>
  
</body>
</html>