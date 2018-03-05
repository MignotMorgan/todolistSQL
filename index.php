<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css"/>
    <title>Chat</title>
  </head>
  <body>
    <?php
      include("./contenu.php");
      include("./mysql.php");
      include("./formulaire.php");
    ?>
    <section class="section--tache">
      <fieldset class="afaire">
        <legend><strong>A FAIRE</strong> </legend>
        <form class="" action="index.php" method="post">
        <?php
          // afficheJSON(false);
          afficheMySQL(false);
         ?>
         <input class="btn_submit" type="submit" name="submit" value="Enregistrer">
        </form>
      </fieldset>
      <fieldset class="archive">
        <legend><strong>ARCHIVE</strong></legend>
        <?php
          // afficheJSON(true);
          afficheMySQL(true);
         ?>
      </fieldset>
      <fieldset class="nouveau">
        <legend><strong>AJOUTER UNE TÂCHE</strong></legend>
        <main>
          <form class="" action="index.php" method="post">
            <label for="tache">la tâche à effectuer</label>
            <input type="text" name="tache" value="">
            <input type="date" name="date" value="">
            <input type="time" name="time" value="">
            <input type="submit" name="ajouter" value="Ajouter">
          </form>
        </main>
      </fieldset>
    </section>
  </body>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js"></script>
  <script type="text/javascript" src="./script.js"></script>
</html>
