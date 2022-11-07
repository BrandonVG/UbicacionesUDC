<?php
  require_once('includes/config.inc.php');
  require_once('includes/inc.session.php');
  require_once(LIB_PATH.'responseError.php');

  if (!isset($_GET['sitio']) || $_GET['sitio'] != $_SESSION['url'] || $_SESSION['rol'] == 3) 
    responseError(403);

  $ruta = array('<li>Editor</li>');
  $titulo = 'EDITOR';
  require_once(VIEW_PATH . 'header.view.php');

  //URL
  echo "<script>var url = 'https://".$_SERVER['SERVER_NAME']."/ubicaciones/'</script>";

  require_once(VIEW_PATH . 'editar.view.php');
  require_once(VIEW_PATH . 'footer.view.php');
?>