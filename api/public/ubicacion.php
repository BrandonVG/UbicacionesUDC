<?php 
  require_once('../../includes/config.inc.php');
  require_once(LIB_PATH.'responseRequest.php');
  header('Content-Type: application/json');

  $method = $_SERVER['REQUEST_METHOD'];
  $key = '49342000ca291986c11b009b3127356f';  //HolaMundo
  switch ($method) {
    case 'GET':
      if (isset($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['key']) && $_GET['key'] === $key) {
          echo json_encode(Ubicacion::getById($_GET['id'],'ubicaciones'));
      }
      else
        responseRequest(400, 'Bad request');
      break;
    default:
      responseRequest(405, 'Method not allowed');
      break;
  }  
?>