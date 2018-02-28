<?php
  /*##################################################################*/
  /*fonction qui ouvre le fichier (todo.json) et le transforme en tableau d'objets JSON*/
  /*retourne le tableau d'objets JSON*/
  function tableauJSON()
  {
    /*nom du fichier*/
    $filename = "./todo.json";
    /*récupère la totalité du fichier (todo.json) sous forme de chaîne caractère*/
    $file = file_get_contents($filename);

    /*crée une variable table qui va recevoir les objets JSON*/
    $tabjson;
    if(empty($file))  /*si le fichier est vide : crée une table*/
      $tabjson = json_decode("[]");
    else /*sinon : il decode la chaîne de caractère en objets JSON*/
      $tabjson = json_decode($file);

    return $tabjson;
  }
  /*##################################################################*/
  /*fonction qui sauvegarde un tableau d'objets JSON dans le fichie (todo.json)*/
  /*reçoit comme paramètre un tableau d'objets JSON ($tabjson)*/
  /*retourne false en cas d'erreur ou le nombre de caractères en cas de réussite*/
  function sauvegardeJSON($tabjson)
  {
    /*nom du fichier JSON*/
    $filename = "./todo.json";
    /*encode la table d'objets JSON en format chaîne de caractères*/
    $str_json = json_encode($tabjson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );

    /*inscript la chaîne de caractère dans le fichier (todo.json)*/
    $resultat = file_put_contents($filename, $str_json);
    /*retourne le résultat ($resultat)*/
    return $resultat;
  }

  /*##################################################################*/
  /*fonction qui affiche les Json en format HTML*/
  /*La fonction reçoit comme paramètre ($termin) une valeur de type booléan*/
  function afficheJSON($termin=true)
  {
    /*appel de la fonction "tableauJSON" $tabjson reçoit un tableau d'objet JSON*/
    $tabjson = tableauJSON();

    /*boucle qui parcours le tableau JSON et crée les balises label et checkbox*/
    for($i=0; $i < sizeof($tabjson); $i++)
    {
      /*$obj reçoit l'objet JSON*/
      $obj = $tabjson[$i];
      /*Condition sur la variable "Terminer" de l'objet Json*/
      if($obj->Terminer == $termin)
      {
        /*balise ouvrante <label>*/
        $txt = '<label class="lbl_drag ';
        $txt .= $termin?"tache_terminer":"tache_non_terminer";
        $txt .= '" for="" name="lbl_drag" value="'.$i.'" draggable="true"';
        // $txt .= ' onclick="clicklabel();" ';
        $txt .= ' onmousedown="clicklabel();" ';
        $txt .= '>';
        /*début : balise <input>*/
        $txt .= '<input type="checkbox" name="tache_ligne" value="';
        /*$i représente le numero de la ligne*/
        $txt .= $i.'" ';
        /*si la valeur $termin est vraie ajouter l'attribut "checked" */
        $txt .= $termin?"checked":"";
        $txt .= " onfocus='focuscheck($i);' ";
        // $txt .= ' onclick="clicklabel();" ';
        $txt .= '>';
        /*fin : balise <input>*/
        /*balise fermante <label>*/
        $txt .= $obj->Nom. '</label>';
        // $txt .= "<br/>";

        echo $txt;
      }
    }
  }


  /*##################################################################*/
  /*fonction qui modifie l'objet JSON*/
  /*la fonction reçoit comme paramètre l'index de l'objet qui doit être modifier ($index)*/
  function enregistreJSON($index)
  {
    /*appel de la fonction "tableauJSON" $tabjson reçoit un tableau d'objet JSON*/
    $tabjson = tableauJSON();
    /*casting de la variable $index en INT*/
    $index = (int)$index;
    /*place l'objet JSON à l'index ($index) du tableau ($tabjson) dans la variable ($obj)*/
    $obj = $tabjson[$index];
    /*modifie la valeur "Terminer" de l'objet JSON $obj en son inverse (true <-> false)*/
    $obj->Terminer = !$obj->Terminer;
    /*utilise la fonction "sauvegardeJSON" en lui envoyant un tablreau d'objets JSON ($tabjson)*/
    sauvegardeJSON($tabjson);
  }



 ?>
