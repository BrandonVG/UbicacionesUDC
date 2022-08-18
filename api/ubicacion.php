<?php
require_once('../includes/config.inc.php');
// require_once(INCLUDE_PATH.'inc.session.php');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$path = EN_PRODUCCION ? '../../../../demo/cms/content/ubicaciones/portadas/' : '../../content/ubicaciones/portadas/';

if(!$as->isAuthenticated() && $method != 'GET' && !($method == 'POST' && isset($_GET['tags']))) {
  http_response_code(403);
  die();
}

switch ($method) {
  case 'GET':
  if (count($_GET) == 0) {
      echo json_encode(Ubicacion::getAllForIndex('ubicaciones'));
    }
    else {  //Para entrar a cualquira de los siguientes métodos es necesario haber iniciado sesión
      if(!$as->isAuthenticated() && (isset($_GET['validador']) || isset($_GET['editor']))) {
        http_response_code(403);
        die();
      }

      if (isset($_GET['sitio'])) {
        $idSitio = $_GET['sitio'];
        if(!is_numeric($idSitio)) {
          http_response_code(400);
          die();
        }

        if (isset($_GET['aprobadas'])) {
          echo json_encode(Ubicacion::getAllAprobadasBySitio($idSitio));
        } else if(isset($_GET['index']))
          echo json_encode(Ubicacion::getAllForIndexBySitio($idSitio));
        else
          echo json_encode(Ubicacion::getAllBySitio($idSitio));
      }
      else if (isset($_GET['validador'])) {
        //Comprobar a qué dependencia pertenece con la variable de sesión no con el parámetro
        if($_SESSION['rol'] == 2) {
          http_response_code(403);
          die();   
        }

        $idSitio = $_SESSION['idSitio'];
        if(!is_numeric($idSitio)) {
          http_response_code(400);
          die();
        }

        if(isset($_GET['admin']) && $_SESSION['rol'] == 1) {
          $idSitio = $_GET['admin'];
        }

        if(isset($_GET['todas']))
          echo json_encode(Ubicacion::getAllByValidador($idSitio));
        else
          echo json_encode(Ubicacion::getAllPendingByValidador($idSitio));
      }
      else if (isset($_GET['editor'])) {
        // if($_SESSION['rol'] == 3) {
          // http_response_code(403);
          // die();   
        // }
        echo json_encode(Ubicacion::getAllByEditor($_SESSION['idSitio']));
      }
      else if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
        echo json_encode(Ubicacion::getById($id,'ubicaciones'));
      }
      else if(isset($_GET['etiqueta'])) {
        echo json_encode(Ubicacion::isEtiquetaAvailable($_GET['etiqueta']));
      }
      else if(isset($_GET['dependencias'])) {
        echo json_encode(Ubicacion::getAllDependencias());
      }
      else
        http_response_code(400);

      die();
    }
    break;
    
  case 'POST':
    if (isset($_GET['urlSitio'])) {
        $infoSitio = false;
        try {
          $infoSitio = Usuario::getInfoFromFederada($_SESSION['uCorreo'], $_GET['urlSitio']);
        }
        catch(Exception $ex) {
          echo "El sitio: ".$_GET['urlSitio']." no existe";
          http_response_code(400);
          die();
        }
      
      $newUbicacion = json_decode(file_get_contents('php://input'));
      $newUbicacion->idSitio = $infoSitio->id_sitio; 
      try {
        $ubicacion = Ubicacion::getUbicacionCreate($newUbicacion);
      } catch (Exception $ex) {
        http_response_code(400);
        echo json_encode(array('err' => utf8_encode($ex->getMessage())));
        die();
      }
      $result = $ubicacion->create();
      if($result) {
        //Save into LOG
        try { 
          $idUser = Usuario::getIdByCorreo($_SESSION['uCorreo'], $infoSitio->id_sitio);
          $ip = Log::getRealIp();
          Log::saveAction($idUser->id, $_SESSION['uCorreo'], $ubicacion->id, 'Ubicación', 'Crear ubicación', $ip);
          Mail::ubicacionEnviada($ubicacion);
        } catch(Exception $ex) {
          error_log('Error al guardar en el log: '.$ex->getMessage());
        }
        echo json_encode($ubicacion);
      }
      else {
        http_response_code(500);
      }
      die();
    } else if(isset($_GET['imagen']) && isset($_GET['idUbicacion']) && isset($_FILES['imagen'])) {
      if(!is_numeric($_GET['idUbicacion'])) {
          http_response_code(400);
          die();
        }

      $result = guardarImagen($_GET['imagen'], $path);      
      if($result) {
        //Save into LOG
        try {
          $idUser = Usuario::getIdByCorreo($_SESSION['uCorreo'], $_SESSION['idSitio']); 
          $ip = Log::getRealIp();
          Log::saveAction($idUser->id, $_SESSION['uCorreo'], $_GET['idUbicacion'], 'Imagen de ubicación', 'Guardar imagen', $ip);
        } catch(Exception $ex) {
          error_log('Error al guardar en el log: '.$ex->getMessage());
        }
        if (isset($_POST['oldPortada'])) {
          unlink($path.$_POST['oldPortada']);
        }

        http_response_code(201);
      }
      else
        http_response_code(400);
    } else if(isset($_GET['tags'])) {
      if (preg_match("/^%([A-Za-z0-9]+?(%' AND clasificadores LIKE '%[A-Za-z0-9]+)*)%$/","%Ubicaciones%")) {
        $tags = json_decode(file_get_contents('php://input'));
        echo json_encode(
          isset($_GET['delegacion']) ? 
          Ubicacion::getAllByTagsAndDelegacion($tags, $_GET['delegacion']) : 
          Ubicacion::getAllByTagsAndDelegacion($tags)
        );
      } else
        http_response_code(400);
    } else {
      if (isset($_GET['padre'])) {
        $idPadre = $_GET['padre'];
        if(!is_numeric($idPadre)) {
          http_response_code(400);
          die();
        }

        $json = json_decode(file_get_contents('php://input'));
        try {
          $padre = Ubicacion::getById($idPadre,'ubicaciones');
          $ubicacion = Ubicacion::getUbicacionCreateHijo($json, $idPadre);
          $ubicacion->visible = 0;
          $ubicacion->estatus = 0;
          $ubicacion->aceptado = -1;
        } catch (Exception $ex) {
          http_response_code(400);
          echo json_encode(array('err' => utf8_encode($ex->getMessage())));
          die();
        }
        Ubicacion::insertToHistorico($padre);
        $result = $ubicacion->create();
        $hasHijo = Ubicacion::updateIdHijo($idPadre, $ubicacion->id);
        if ($result && $hasHijo) {
          //Save into LOG
          try { 
            $idUser = Usuario::getIdByCorreo($_SESSION['uCorreo'], $_SESSION['idSitio']);
            $ip = Log::getRealIp();
            Log::saveAction($idUser->id, $_SESSION['uCorreo'], $ubicacion->id, 'Ubicación', 'Crear ubicación hijo', $ip);
          } catch(Exception $ex) {
            error_log('Error al guardar en el log: '.$ex->getMessage());
          }
          echo json_encode($ubicacion);
        } else {
          http_response_code(500);
          echo json_encode(array('err' => 'Error al Insertar'));
          die();
        }
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

      if (count($_GET) == 1) { // el unico parametro es id
        $json = json_decode(file_get_contents('php://input'));
        try {
          $ubicacion = Ubicacion::getUbicacionUpdate($json, $id);
        } catch (Exception $ex) {
          http_response_code(400);
          echo json_encode(array('err' => utf8_encode($ex->getMessage())));
          die();
        }
        Ubicacion::insertToHistorico(Ubicacion::getById($id,'ubicaciones'));
        $result = $ubicacion->update();
        if ($result) {
          //Save into LOG
          try { 
            $idUser = Usuario::getIdByCorreo($_SESSION['uCorreo'], $_SESSION['idSitio']);
            $ip = Log::getRealIp();
            Log::saveAction($idUser->id, $_SESSION['uCorreo'], $id, 'Ubicación', 'Actualizar ubicación', $ip);
          } catch(Exception $ex) {
            error_log('Error al guardar en el log: '.$ex->getMessage());
          }
          echo json_encode($ubicacion);
        }
        else {
          http_response_code(500);
          echo json_encode(array('err' => 'Error al Actualizar'));
          die();
        }
      } else if (isset($_GET['estatus'])) {
        if(!is_numeric($_GET['estatus'])) {
          http_response_code(400);
          die();
        }

        if (Ubicacion::updateEstatus($id, $_GET['estatus'])) {
          //Save into LOG
          try { 
            $idUser = Usuario::getIdByCorreo($_SESSION['uCorreo'], $_SESSION['idSitio']);
            $ip = Log::getRealIp();
            Log::saveAction($idUser->id, $_SESSION['uCorreo'], $id, 'Ubicación', 'Actualizar estatus ubicación: '.$_GET['estatus'], $ip);
          } catch(Exception $ex) {
            error_log('Error al guardar en el log: '.$ex->getMessage());
          }

          $ubicacion = Ubicacion::getById($id,'ubicaciones');
          if($_GET['estatus'] == 1 && !isset($_SESSION['noCorreo'])) {
            Mail::ubicacionEnviada($ubicacion);
            Mail::ubicacionRecibidaValidadores($ubicacion, $_SESSION['url']);
          }
          echo json_encode($ubicacion);
        }
        else {
          http_response_code(500);
          echo json_encode(array('err' => 'Error al Actualizar'));
          die();
        }
      } else if (isset($_GET['visible'])) {
        if(!is_numeric($_GET['visible'])) {
          http_response_code(400);
          die();
        }

        if (Ubicacion::updateVisible($id, $_GET['visible'])) {
          //Save into LOG
          try { 
            $idUser = Usuario::getIdByCorreo($_SESSION['uCorreo'], $_SESSION['idSitio']);
            $ip = Log::getRealIp();
            Log::saveAction($idUser->id, $_SESSION['uCorreo'], $id, 'Ubicación', 'Actualizar visibilidad ubicación: '.$_GET['visible'], $ip);
          } catch(Exception $ex) {
            error_log('Error al guardar en el log: '.$ex->getMessage());
          }

          echo json_encode(Ubicacion::getById($id,'ubicaciones'));
        }
        else {
          http_response_code(500);
          echo json_encode(array('err' => 'Error al Actualizar'));
          die();
        }
      } else if (isset($_GET['aceptado'])) {
        if(!is_numeric($_GET['aceptado'])) {
          http_response_code(400);
          die();
        }

        if ($_GET['aceptado'] == 0) {
          $motivo = json_decode(file_get_contents('php://input'));
          if($motivo) {
            $res = Ubicacion::updateAceptado($id, $_GET['aceptado'], $motivo);
            if(!isset($_SESSION['noCorreo'])) {
              $correoDelEnviador = Log::getCorreoOfLastRecordByIdObjeto($id);
              Mail::ubicacionRechazadaEditores(Ubicacion::getById($id, 'ubicaciones'), $motivo->motivo, $correoDelEnviador);
            }
          }
          else {
            http_response_code(400);
            echo json_encode(array('err' => 'No hay motivo'));
            die();
          }
        } else {
          $res = Ubicacion::updateAceptado($id, $_GET['aceptado']);
          if ($res && !isset($_SESSION['noCorreo']))
            Mail::ubicacionAceptadaEditores(Ubicacion::getById($res->id, 'ubicaciones'));
        }
        if ($res) {
          try { 
            $idUser = Usuario::getIdByCorreo($_SESSION['uCorreo'], $_SESSION['idSitio']);
            $ip = Log::getRealIp();
            Log::saveAction($idUser->id, $_SESSION['uCorreo'], $id, 'Ubicación', 'Actualizar aceptado ubicación: '.$_GET['aceptado'], $ip);
          } catch(Exception $ex) {
            error_log('Error al guardar en el log: '.$ex->getMessage());
          }

          echo json_encode($res);
        }
        else {
          http_response_code(500);
          echo json_encode(array('err' => 'Error al Actualizar'));
          die();
        }
      }
    }
    break;

  case 'DELETE':
    $id = $_GET['id'] ?? false;
    if(!is_numeric($_GET['id'])) {
      http_response_code(400);
      die();
    }

    if ($id) {
      $ubicacion = Ubicacion::getById($id,'ubicaciones');

      if($ubicacion->idSitio != $_SESSION['idSitio'] && ($_SESSION['rol'] == 2 || $_SESSION['rol'] == 1)) {//Validar los permisos
        http_response_code(403);
        die();
      }

      $resultPadre = true;
      if ($ubicacion->idPadre != -1) {
        Ubicacion::insertToHistorico(Ubicacion::getById($ubicacion->idPadre,'ubicaciones'));
        $result = Ubicacion::deleteById($ubicacion->idPadre);
      }
      Ubicacion::insertToHistorico($ubicacion);
      $result = Ubicacion::deleteById($id);
      if ($result && $resultPadre) {
        //Save into LOG
        try { 
          $idUser = Usuario::getIdByCorreo($_SESSION['uCorreo'], $_SESSION['idSitio']);
          $ip = Log::getRealIp();
          Log::saveAction($idUser->id, $_SESSION['uCorreo'], $id, 'Ubicación', 'Eliminar ubicación', $ip);
        } catch(Exception $ex) {
          error_log('Error al guardar en el log: '.$ex->getMessage());
        }
        echo json_encode($ubicacion);
      }
      else {
        http_response_code(500);
        echo json_encode(array('err' => 'Error al Eliminar'));
        die();
      }
    }
    break;
  default:
    http_response_code(400);
    echo json_encode(array('err' => 'Bad Request'));
}

function guardarImagen ($name, $path) {
  /*$extension = explode('.', $_FILES['imagen']['name']);
  $extension = array_pop($extension);
  $name = $idSitio.'_'.$id.".".$extension;*/
  if (!file_exists($path)) {
    mkdir($path, 0777);
  }
  $imageUpload = move_uploaded_file($_FILES['imagen']['tmp_name'], $path.$name);
  return $imageUpload;
}
?>