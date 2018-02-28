


<?php
/*Sanitisation*/
$options = array(
  'tache'         => FILTER_SANITIZE_STRING,
  'ajouter'       => FILTER_SANITIZE_STRING,
  'submit'        => FILTER_SANITIZE_STRING,
  'tache_ligne'   => FILTER_SANITIZE_STRING,
  'dragdrop'      => FILTER_SANITIZE_STRING,
  'src_index'     => FILTER_SANITIZE_STRING,
  'dest_index'    => FILTER_SANITIZE_STRING
);
$result = filter_input_array(INPUT_POST, $options);

$_Post["tache"] = filter_input(INPUT_POST, "tache", FILTER_SANITIZE_SPECIAL_CHARS );
$_Post["tache"] = filter_input(INPUT_POST, "tache", FILTER_SANITIZE_ENCODED );

$_POST["tache"] = filter_var($_POST["tache"], FILTER_SANITIZE_STRING);
$_POST["ajouter"] = filter_var($_POST["ajouter"], FILTER_SANITIZE_STRING);
$_POST["submit"] = filter_var($_POST["submit"], FILTER_SANITIZE_STRING);
$_POST["tache_ligne"] = filter_var($_POST["tache_ligne"], FILTER_SANITIZE_STRING);
$_POST["dragdrop"] = filter_var($_POST["dragdrop"], FILTER_SANITIZE_STRING);
$_POST["src_index"] = filter_var($_POST["src_index"], FILTER_SANITIZE_STRING);
$_POST["dest_index"] = filter_var($_POST["dest_index"], FILTER_SANITIZE_STRING);
$_POST["date"] = filter_var($_POST["date"], FILTER_SANITIZE_STRING);
$_POST["time"] = filter_var($_POST["time"], FILTER_SANITIZE_STRING);

$_Post["tache"] = htmlentities($_POST["tache"]);
$_Post["ajouter"] = htmlentities($_POST["ajouter"]);
$_Post["submit"] = htmlentities($_POST["submit"]);
$_Post["tache_ligne"] = htmlentities($_POST["tache_ligne"]);
$_Post["dragdrop"] = htmlentities($_POST["dragdrop"]);
$_Post["src_index"] = htmlentities($_POST["src_index"]);
$_Post["dest_index"] = htmlentities($_POST["dest_index"]);
$_Post["date"] = htmlentities($_POST["date"]);
$_Post["time"] = htmlentities($_POST["time"]);

/*fin Sanitisation*/


//Requête POST:
//vérification des valeurs après la Sanitisation
if($result != null && $result != FALSE && $_SERVER['REQUEST_METHOD']=='POST')
{
  /*vérifie si on a cliqué sur le bouton "ajouter".*/
  if(isset($_POST["ajouter"]) && $_POST["ajouter"] == "Ajouter")
  {
    /*nom de la tache contenu dans le "TextBox"*/
    $tache=$_POST["tache"];
    /*date et time*/
    $date = empty($_POST["date"]) ? date("Y-m-d") : $_POST["date"] ;
    $time = empty($_POST["time"]) ? date("H:i:s") : $_POST["time"].":00";
    $datetime = $date ." ". $time;

    // $date = $_POST["date"];
    // $time = $_POST["time"];
    // $datetime = (empty($date) || empty($time)) ? date("Y-m-d H:i:s") :  $date ." ". $time .":00";
 // empty($_POST["date"]) ? date("Y-m-d H:i:s") :


    // echo $datetime;
    /*utilisation de la fonction ecrireJSON*/
    // ecrireJSON($tache, false);
    InsertMySQL($tache, false, $datetime);
  }
  /*vérifie si on a cliqué sur le bouton "Enregistrer".*/
  if(isset($_POST["submit"]) && $_POST["submit"] == "Enregistrer")
  {
    /*$tache_ligne est un tableau*/
    $tache_ligne = $_POST["tache_ligne"];
    /*boucle sur le tableau $tache_ligne*/
    // for($i = 0; $i < sizeof($tache_ligne); $i++)
    //   enregistreJSON($tache_ligne[$i]);
    // enregistreJSON($tache_ligne);
    updateMySQL($tache_ligne);
  }
  /*Requete POST provenant de la fonction "post_dragdrop" du fichier javascript (script.js)*/
  if(isset($_POST["dragdrop"]) && $_POST["dragdrop"] == "true")
  {
    /*récupère l'index source*/
    $src_index = $_POST["src_index"];
    /* récupère l'index destination*/
    $dest_index = $_POST["dest_index"];
    /*utilise la fonction dragdropJSON*/
    // dragDropJSON($src_index, $dest_index);
    dragDropMySQL($src_index, $dest_index);
  }
}

/*fonction qui transforme les variable en format JSON*/
function ecrireJSON($tache, $terminer)
{
  /*appel de la fonction "tableauJSON", $tabjson reçoit un tableau d'objet JSON*/
  $tabjson = tableauJSON();

  /*CREATION JSON*/
  /*Création d'une table ($tab) qui deviendra un objet JSON*/
  $tab = array("Nom" => $tache, "Terminer" => $terminer );
  /*ajout de l'objet JSON dans  la table qui reçois les objets JSON*/
  $tabjson[] = $tab;

  /*utilise la fonction "sauvegardeJSON" en lui envoyant un tablreau d'objets JSON ($tabjson)*/
  sauvegardeJSON($tabjson);
}

/*fonction qui reçoit l'index source et l'index destination et qui les échange*/
function dragDropJSON($src_index, $dest_index)
{
  /*appel de la fonction "tableauJSON", $tabjson reçoit un tableau d'objet JSON*/
  $tabjson = tableauJSON();
  /*vérifie que les index sont des entiers*/
  $src_index = (int)$src_index;
  $dest_index = (int)$dest_index;
  /*échange les valeur dans le tableau*/
  $obj = $tabjson[$src_index];
  $tabjson[$src_index] = $tabjson[$dest_index];
  $tabjson[$dest_index] = $obj;

  /*utilise la fonction "sauvegardeJSON" en lui envoyant un tablreau d'objets JSON ($tabjson)*/
  sauvegardeJSON($tabjson);

}



 ?>
