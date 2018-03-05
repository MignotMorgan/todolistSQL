<?php



function ConnectMySQL()
{
  try
  {
    // $bdd = new PDO('mysql:host=localhost;dbname=todolist;charset=utf8', 'root', 'user');
    $bdd = new PDO('mysql:host=localhost;dbname=id4734921_todolist;charset=utf8', 'id4734921_root', 'webhost1974');
  }
  catch (Exception $e)
  {
    die('Erreur : ' . $e->getMessage());
  }

  return $bdd;
}
/*renvoi true/false : compte le nombre de tache qui possède déja le même nom*/
function IsTask($name)
{
  $bdd = ConnectMySQL();
  $req = $bdd->prepare('SELECT count(*) FROM taches WHERE Nom = :nom');
  $req->execute(array(
    'nom' => $name
  ));
  $number =  $req->fetchColumn();
  return $number == 0;
}

function afficheMySQL($termin=false)
{
  $bdd = ConnectMySQL();
  $reponse = $bdd->query('SELECT * FROM taches ORDER BY Sort ASC');

  while ($donnees = $reponse->fetch())
  {
    if($donnees["Terminer"] == $termin)
    {
      $i = $donnees["ID"];
      $index = $donnees["Sort"];
      $echeance = $donnees["echeance"];
      $date = strtotime($echeance);

      /*permet de verifier les dates*/
      // echo date("Y-m-d H:i:s", $date-(2*60*60));
      // echo "<br/>";
      // echo date("Y-m-d H:i:s",time("Y-m-d H:i:s"));
      // echo "<br/>";
      // echo date("Y-m-d H:i:s", $date);
      // echo "<br/>";

      $txt = '<label class="lbl_drag ';
      $txt .= $termin?"tache_terminer":"tache_non_terminer";

      if( $date-(2*60*60) < time("Y-m-d H:i:s") && $date > time("Y-m-d H:i:s"))
        $txt .= " timeover";

      $txt .= '" for="" name="lbl_drag" value="'.$index.'" draggable="true"';
      $txt .= '>';
      /*début : balise <input>*/
      $txt .= '<input type="checkbox" name="tache_ligne" value="';
      $txt .= $i.'" ';
      /*si la valeur $termin est vraie ajouter l'attribut "checked" */
      $txt .= $termin?"checked":"";
      $txt .= " onfocus='focuscheck($i);' ";
      $txt .= '>';
      /*fin : balise <input>*/
      /*balise fermante <label>*/
      $txt .= $donnees["Nom"] ." "  . '</label>';

      echo $txt;
    }
  }
}

function InsertMySQL($tache, $terminer, $datetime)
{
  $bdd = ConnectMySQL();

  $reponse = $bdd->query('SELECT Sort FROM `taches` ORDER BY Sort DESC LIMIT 0,1');
  $donnees = $reponse->fetch();
  $index = $donnees["Sort"];


  $req = $bdd->prepare('INSERT INTO taches(Nom, Terminer, Sort, echeance) VALUES(:nom, :terminer, :sort, :echeance)');
  $req->execute(array(
      'nom'       => $tache,
      'terminer'  => 0,
      'sort'      => $index+1,
      'echeance'  => $datetime
      ));
}

function updateMySQL($id)
{
  $bdd = ConnectMySQL();

  $reponse = $bdd->prepare('SELECT * FROM `taches` WHERE ID = :id LIMIT 0,1 ');
  $reponse->execute(array(
    'id' => $id
    ));

  $donnée = $reponse->fetch();
  $terminer = $donnée["Terminer"] == 0 ? 1 : 0;

  $req = $bdd->prepare('UPDATE taches SET Terminer = :terminer WHERE ID = :id');
  $req->execute(array(
      'id'        => $id,
      'terminer'  => $terminer
      ));
}

function dragdropMySQL($src_index, $dest_index)
{
  $bdd = ConnectMySQL();
  /*vérifie que les index sont des entiers*/
  $src_index = (int)$src_index;
  $dest_index = (int)$dest_index;


  $req = $bdd->prepare('UPDATE taches SET Sort =
        CASE sort
          WHEN :src THEN :dest
          WHEN :dest THEN :src
        END
      WHERE Sort IN (:src, :dest)'
    );
  $req->execute(array(
      'src'   => $src_index,
      'dest'  => $dest_index
      ));
}




 ?>
