<?php
  require_once('includes/config.inc.php');

  function responseError($code, $message = false) {
    global $as;
    global $url;

    $titulo = 'Error '.$code;
    $ruta = array('<li>Error</li>');

    require_once(VIEW_PATH.'header.view.php');
    require_once(VIEW_PATH.'error.view.php');
    require_once(VIEW_PATH.'footer.view.php');

    die();
  }
?>