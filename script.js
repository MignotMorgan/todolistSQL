

window.onload = init;
function init()
{
      /*sélectionne tous les éléments qui possèdent un attribut draggable = true*/
      var elements = document.querySelectorAll('* [draggable="true"]');
      /*boucle sur tous les éléments*/
      for(var i = 0; i < elements.length; i++)
      {
        /*ajout de l'évènement dragstart*/
        elements[i].addEventListener(
          'dragstart',
          function(e) {
            var elem = e.target || e.srcElement;
            var index = elem.getAttribute("value");
            e.dataTransfer.setData('text/plain', index);
        });

        /*ajout de l'évènement drop*/
        elements[i].addEventListener(
          'drop',
          function(e) {
              e.preventDefault(); // Cette méthode est toujours nécessaire pour éviter une éventuelle redirection inattendue
              var elem = e.target || e.srcElement;
              var src_index = e.dataTransfer.getData('text/plain');
              var dest_index = elem.getAttribute("value");

              post_dragdrop(src_index, dest_index);
          });

          /*ajout de l'évènement dragover*/
          elements[i].addEventListener(
            'dragover', function(e) {
                e.preventDefault(); // Annule l'interdiction de drop

            });

      }
};
/*fonction utilisé lors du drop: envoit une requête POST*/
function post_dragdrop(src_index, dest_index)
{
  $.post(
    'index.php',
    {
      "dragdrop":"true",
      "src_index":src_index,
      "dest_index":dest_index
    },
    function(data)
    {
      document.location.href="index.php";
    },
    'text'
  );
};
/*fonction appelé en utilisant la checkbox: envoit une requête POST*/
function focuscheck(index)
{
  $.post(
    'index.php',
    {
      "tache_ligne":index,
      "submit":"Enregistrer"
    },
    function(data)
    {
      document.location.href="index.php";
    },
    'text'
  );
};
