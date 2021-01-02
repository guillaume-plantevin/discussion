<?php
  /*
    Une page permettant de modifier son profil (profil.php) :
    Cette page possède un formulaire permettant à l’utilisateur de modifier son login et son mot de passe.
  */
  session_start();

  require_once('pdo.php');
  require_once('functions/functions.php');

  $title = "profil";
?>
<!DOCTYPE html>
<html lang="fr">
  <?php
    require_once("templates/head.php");
  ?>
  <body>
  <?php
    require_once("templates/header.php");
  ?>
  <main>

    <h1>Page de Profil</h1>
<?php  
  if(isset($_POST['valider']))
  {
    $new_login = htmlspecialchars($_POST['new_login']); 
    $new_pass = password_hash($_POST['new_pass'], PASSWORD_DEFAULT);
    $new_confirm_pass = htmlspecialchars($_POST['new_confirm_pass']);

    if(!empty($new_login) && !empty($new_pass) && !empty($new_confirm_pass))
    {
      if($_POST['new_pass'] == $new_confirm_pass && preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{10,}$#',$_POST['new_pass']))
      {
        try
        {
          $connexion = new PDO("mysql:host=localhost;dbname=discussion",'root','') ; 
          $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;

          $result = checkLogin($new_login) ;
          if($result == 0)
          {
            $id = $_SESSION['id'] ; 
            $requete = $connexion->prepare(" UPDATE utilisateurs SET  login    = :newlogin, password = :newpass WHERE id = :id ");
                    
            $requete->bindParam(':newlogin', $new_login) ;
            $requete->bindParam(':newpass', $new_pass) ; 
            $requete->bindParam(':id', $id) ; 
                    
            if($requete->execute()) 
            {
              $changements = 'Changements effectués' ; 
            }

              $sql = $connexion->prepare("SELECT * FROM utilisateurs WHERE id = :id") ;
              $sql->bindParam(':id', $id) ; 
              $sql->execute(); 
              $result = $sql->fetch(); 
                   
              $_SESSION['login']    = $result['login'] ;
              $_SESSION['password'] = $result['password'] ;
              $_SESSION['id']       = $result['id'] ; 

          }
          else
          {
            $error_login = '<p class="error">Ce login déjà pris</p>';
          }
                
        }
          catch(PDOExeption $e)
          {
            echo 'Erreur :' .$e->getMessage();
          }

      }
      elseif($_POST['new_pass'] != $new_confirm_pass)
      {
        $error_pass = '<p class="error"> Mots de passe différents </p>' ;
      }
      // else
      // {
      //   $check_pass = '<p class="error">Mot de passe non valide : Il doit contenir au minimum 10 caractères, avec une majuscule, une minuscule, un chiffre et un caractère spécial.</p>' ; 
      // }
    }
    else
    {
      $error_champs = '<p class="error">Veuillez remplir tous les champs</p>' ;
    }
  }
  ?>

                
    <article class="contenu_formulaire">               
      <form action="profil.php" method="POST">
                        
        <label for="login"> Nouveau login</label>
        <input type="text" id="login" name="new_login" required>

        <label for="password">Nouveau mot de passe </label>
        <input type="password" id="password" name="new_pass" required>

        <label for="confirm_password">Confirmation du nouveau mot de passe </label>
        <input type="password" id="confirm_password" name="new_confirm_pass" required>
 
        <input type="submit" value="Envoyer" name="valider">
      </form>
    </article>
  </main>
    <?php require_once('templates/footer.php');?>
  </body>
</html>