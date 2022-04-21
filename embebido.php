<?php 
  // echo file_get_contents("https://www.ucol.mx/cms/headerapp2.php?TITULO=".urlencode("Ubicaciones"));
  require_once('includes/config.inc.php');
  if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $ubicacion = Ubicacion::getAllInfoById($_GET['id']);
    if($ubicacion) {
      if($ubicacion->aceptado == 1) {
        require_once(VIEW_PATH.'embebido.view.php');
      }
      else{
        http_response_code(403);
        echo '<h1>403 FORBIDDEN</h1>';
      }
    }
    else {
      http_response_code(404);
      echo '<h1>404 NOT FOUND</h1>';
    }
  }
  else {
    http_response_code(400);
    echo '<h1>400 BAD REQUEST</h1>';
  }
?>
