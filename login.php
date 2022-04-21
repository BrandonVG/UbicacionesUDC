<?php
  require_once('includes/config.inc.php');

  if(!isset($_GET['urlAnterior']))
    die();
  $as->requireAuth();
  $attributes = $as->getAttributes();
  require_once('includes/inc.session.php'); 
  //print_r($attributes);
  header("Location: ".$_GET['urlAnterior']); 
?>
