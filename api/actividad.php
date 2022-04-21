<?php  
	require_once('../includes/config.inc.php');
	require_once(LIB_PATH.'gump.class.php');
	// require_once(INCLUDE_PATH.'inc.session.php');
	header('Content-Type: application/json');

	$method = $_SERVER['REQUEST_METHOD'];
	//Cualquier puede pedir la información, sólo los admin pueden editar, crear y borrar
	if(!$as->isAuthenticated() && $method != 'GET' && $_SESSION['rol'] != 1) {
	  http_response_code(403);
	  die();
	}
	
	switch ($method) {
		case 'GET':
			if(count($_GET) == 0) {
				$actividades = Actividad::getAll('actividades');
				echo json_encode($actividades);
				die();
			}
			else {
				if(isset($_GET['activa']))
					echo json_encode(Actividad::getAllActive());
				die();
			}
			break;

		//Sólo los administradores podrán agregar, eliminar y editar del catálogo
		case 'POST':
			$input = json_decode(file_get_contents('php://input'));
			try {
				$actividad = Actividad::getActividadCreate($input);
				$result = $actividad->save();

				if($result){
					//Save into LOG
					try { 
					  $idUser = Usuario::getIdByCorreo($_SESSION['uCorreo'], $_SESSION['idSitio']);
					  $ip = Log::getRealIp();
					  Log::saveAction($idUser->id, $_SESSION['uCorreo'], $actividad->id, 'Actividad', 'Crear actividad', $ip);
					} catch(Exception $ex) {
					  error_log('Error al guardar en el log: '.$ex->getMessage());
					}

					echo json_encode($actividad);
				}
				else
					http_response_code(500);
			}
			catch(Exception $ex) {
				$result->err = $ex->getMessage();
				echo json_encode($result);
				http_response_code($ex->getCode());
			}
			die();
			break;
		case 'PUT':
			$input = json_decode(file_get_contents('php://input'));
			try {
				$actividad = Actividad::getActividadUpdate($input);
				$result = $actividad->save();

				if($result) {
					//Save into LOG
					try { 
					  $idUser = Usuario::getIdByCorreo($_SESSION['uCorreo'], $_SESSION['idSitio']);
					  $ip = Log::getRealIp();
					  Log::saveAction($idUser->id, $_SESSION['uCorreo'], $actividad->id, 'Actividad', 'Actualizar actividad', $ip);
					} catch(Exception $ex) {
					  error_log('Error al guardar en el log: '.$ex->getMessage());
					}

					echo json_encode($actividad);
				}
				else
					http_response_code(500);
			}
			catch(Exception $ex) {
				$result->err = $ex->getMessage();
				echo json_encode($result);
				http_response_code($ex->getCode());
			}
			die();
			break;
		case 'DELETE'://Lo mismo que en PUT (borrado lógico, sólo se cambia el estatus a 0 (inactivo))
			$input = json_decode(file_get_contents('php://input'));
			try {
				$actividad = Actividad::getActividadUpdate($input);
				$result = $actividad->save();

				if($result) {
					//Save into LOG
					try { 
					  $idUser = Usuario::getIdByCorreo($_SESSION['uCorreo'], $_SESSION['idSitio']);
					  $ip = Log::getRealIp();
					  Log::saveAction($idUser->id, $_SESSION['uCorreo'], $actividad->id, 'Actividad', 'Eliminar actividad', $ip);
					} catch(Exception $ex) {
					  error_log('Error al guardar en el log: '.$ex->getMessage());
					}

					echo json_encode($actividad);
				}
				else
					http_response_code(500);
			}
			catch(Exception $ex) {
				$result->err = $ex->getMessage();
				echo json_encode($result);
				http_response_code($ex->getCode());
			}
			die();
			break;
		default:
			http_response_code(405); //Bad request
	}
?>