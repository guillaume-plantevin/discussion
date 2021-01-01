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
  <main>
    <h1>Page de Profil</h1>

  
  
  </main>
    <?php require_once('templates/footer.php');?>
  </body>
</html>