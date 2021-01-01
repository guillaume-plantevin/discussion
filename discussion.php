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
  print_r_pre($_SESSION, '$_SESSION:');
  print_r_pre($_POST, '$_POST:');

  // CANCEL
  if (isset($_POST['cancel'])) {
    header("Location: discussion.php");
    return;
  }
  
  if (isset($_POST['submit'])) {
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
  // GO GET MESSAGES
  $stmt = "SELECT messages.message, utilisateurs.login, messages.date
            FROM `messages` JOIN `utilisateurs` 
            WHERE utilisateurs.id = messages.id_utilisateur ORDER BY messages.ID";

  if ( $result = $pdo->query($stmt) ) {
      // DEBUG
      echo 'ok';
      // $row = $result->fetch(PDO::FETCH_ASSOC);
      // DEBUG
      // print_r_pre($row, '60: $rows');
  }
  else {
    // DEBUG
      echo 'error';
  }
?>

<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php');?>
    <body>
        <header>
            
        </header>
        <main class='container'>
            <h1>Fil de Discussion</h1>
            <p>Si vous voulez rajouter un commentaire, si vous suffit de l'écrire et de le valider:</p>
            

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
            ?>
            <form action="" method="POST">
                <label for="message" class='block'>Votre message:</label>
                <textarea name="message" id="message" cols="40" rows="6"></textarea>
                <br />

                <input class='button' type='submit' name='cancel' value='annuler'>
                <input class='button' type="submit" name='submit' value="enregistrer">
            </form>
            <?php
              echo '<table>';
              while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                // print_r_pre($row, '109:$row');
                echo '<tr>';
                  echo '<td class="info">';
                  echo $row['date'] . ' par ' . $row['login'];
                  echo '</td>';
                echo '</tr>';

                echo '<tr>';
                  echo '<td>';
                  echo $row['message'];
                  echo '</td>';
                echo '</tr>';
              }
              echo '</table>';
            ?>
        </main>
        
    </body>
</html>