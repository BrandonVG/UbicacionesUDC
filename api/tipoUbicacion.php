<?php
require_once('../includes/config.inc.php');
// require_once(INCLUDE_PATH.'inc.session.php');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

//Cualquier puede pedir la información, sólo los admin pueden editar, crear y borrar
if(!$as->isAuthenticated() && $method != 'GET') {
  http_response_code(403);
  die();
}

switch ($method) {
  case 'GET':
    if (count($_GET) == 0)
      echo json_encode(TipoUbicacion::getAll('tiposUbicaciones'));
    else if(isset($_GET['activo']))
      echo json_encode(TipoUbicacion::getAllActivos());
    break;
    
  case 'POST':
    if (count($_GET) == 0) {
      $json = json_decode(file_get_contents('php://input'));
      try {
        $equipo = TipoUbicacion::getTipoCreate($json);
      } catch (Exception $ex) {
        http_response_code(400);
        echo json_encode(array('err' => utf8_encode($ex->getMessage())));
        die();
      }
      $result = $equipo->save();
      if ($result) {
        //Save into LOG
        try { 
          $idUser = Usuario::getIdByCorreo($_SESSION['uCorreo'], $_SESSION['idSitio']);
          $ip = Log::getRealIp();
          Log::saveAction($idUser->id, $_SESSION['uCorreo'], $equipo->id, 'Tipo Ubicación', 'Crear tipo de ubicación', $ip);
        } catch(Exception $ex) {
          error_log('Error al guardar en el log: '.$ex->getMessage());
        }

        echo json_encode($equipo);
      }
      else {
        http_response_code(500);
        echo json_encode(array('err' => 'Error al Insertar'));
        die();
      }
    }
    break;

  case 'PUT':
    $id = $_GET['id'] ?? false;
    if ($id) {
      if(!is_numeric($id)) {
        http_response_code(400);
        die();
      }

      $json = json_decode(file_get_contents('php://input'));
      try {
        $equipo = TipoUbicacion::getTipoUpdate($json);
      } catch (Exception $ex) {
        http_response_code(400);
        echo json_encode(array('err' => utf8_encode($ex->getMessage())));
        die();
      }
      $result = $equipo->update();
      if ($result) {
        //Save into LOG
        try { 
          $idUser = Usuario::getIdByCorreo($_SESSION['uCorreo'], $_SESSION['idSitio']);
          $ip = Log::getRealIp();
          Log::saveAction($idUser->id, $_SESSION['uCorreo'], $id, 'Tipo Ubicación', 'Actualizar tipo de ubicación', $ip);
        } catch(Exception $ex) {
          error_log('Error al guardar en el log: '.$ex->getMessage());
        }

        echo json_encode($equipo);
      }
      else {
        http_response_code(500);
        echo json_encode(array('err' => 'Error al Actualizar'));
        die();
      }
    }
    break;

  case 'DELETE':
    $id = $_GET['id'] ?? false;
    if ($id) {
      if(!is_numeric($id)) {
        http_response_code(400);
        die();
      }

      $json = json_decode(file_get_contents('php://input'));
      try {
        $equipo = TipoUbicacion::getTipoUpdate($json);
      } catch (Exception $ex) {
        http_response_code(400);
        echo json_encode(array('err' => utf8_encode($ex->getMessage())));
        die();
      }
      $result = $equipo->update();
      if ($result) {
        //Save into LOG
        try { 
          $idUser = Usuario::getIdByCorreo($_SESSION['uCorreo'], $_SESSION['idSitio']);
          $ip = Log::getRealIp();
          Log::saveAction($idUser->id, $_SESSION['uCorreo'], $id, 'Tipo Ubicación', 'Eliminar tipo de ubicación', $ip);
        } catch(Exception $ex) {
          error_log('Error al guardar en el log: '.$ex->getMessage());
        }

        echo json_encode($equipo);
      }
      else {
        http_response_code(500);
        echo json_encode(array('err' => 'Error al Actualizar'));
        die();
      }
    }
    break;
  
  default:
    http_response_code(405);
    echo json_encode(array('err' => 'Bad Request'));
}

?>