<?php  
	require_once('../includes/config.inc.php');
	// require_once(INCLUDE_PATH.'inc.session.php');
	header('Content-Type: application/json');

	$method = $_SERVER['REQUEST_METHOD'];

	if(!$as->isAuthenticated() && $method != 'GET') {
	  http_response_code(403);
	  die();
	}

	$table = $_GET['table'] ?? false;
	if($table !== 'actividadesUbicacion' && $table !== 'equipamientoUbicacion' && $table !== 'dirigidoUbicacion' && $table !== 'tiposUbicaciones') {
		http_response_code(400);
		echo json_encode(["error" => "Tabla no válida"]);
		die();
	}

	if($table) {
		switch ($method) {
			case 'GET':
				if(isset($_GET['idUbicacion'])) {
					if(!is_numeric($_GET['idUbicacion'])) {
						http_response_code(400);
						die();
					}

					if(isset($_GET['editar'])) {
						echo json_encode(Catalogo::getAllInfoByIdUbicacion($_GET['idUbicacion'], $table));
					}
					else {
						echo json_encode(Catalogo::getAllByIdUbicacion($_GET['idUbicacion'], $table));
					}
					die();
				} 
				else {
					echo json_encode(Catalogo::getAll($table));
					die();	
				}
				break;
			case 'POST':
				$input = json_decode(file_get_contents('php://input'));
				if(count($input) > 1) {
					$result = array();
					foreach ($input as $value) {
						try {
							$instance = Catalogo::getCatalogoCreate($value->idEnCatalogo, $value->idUbicacion, $table);					
							$res = $instance->save();

							if($res)	
								array_push($result, $res);
							else
								array_push($result, "Error al guardar: ".$value->idUbicacion);
						} catch (Exception $ex) {
							$result = null;
							$result->err = $ex->getMessage();
							echo json_encode($result);
							http_response_code($ex->getCode());
							die();
						}
					}

					//Save into LOG
					try { 
						$idUser = Usuario::getIdByCorreo($_SESSION['uCorreo'], $_SESSION['idSitio']);
						$ip = Log::getRealIp();
						Log::saveAction($idUser->id, $_SESSION['uCorreo'], $input[0]->idUbicacion, 'Catálogo a ubicación: '.$table, 'Agregar al catálogo', $ip);
					} catch(Exception $ex) {
						error_log('Error al guardar en el log: '.$ex->getMessage());
					}

					echo json_encode($result);
					die();
				}
				else {
					try {
						if(is_array($input))
							$input = $input[0];
						$instance = Catalogo::getCatalogoCreate($input->idEnCatalogo, $input->idUbicacion, $table);					
						$result = $instance->save();

						if($result) {
							//Save into LOG
							try { 
								$idUser = Usuario::getIdByCorreo($_SESSION['uCorreo'], $_SESSION['idSitio']);
								$ip = Log::getRealIp();
								Log::saveAction($idUser->id, $_SESSION['uCorreo'], $input->idUbicacion, 'Catálogo a ubicación: '.$table, 'Agregar al catálogo', $ip);
							} catch(Exception $ex) {
								error_log('Error al guardar en el log: '.$ex->getMessage());
							}

							echo json_encode($instance);
						}
						else
							http_response_code(500);
						die();
					}
					catch(Exception $ex) {
						$result->err = $ex->getMessage();
						echo json_encode($result);
						http_response_code($ex->getCode());
					}
					break;
				}
			case 'DELETE':
				if(isset($_GET['id'])) {
					if(!is_numeric($_GET['id'])) {
						http_response_code(400);
						die();
					}

					$result = Catalogo::deleteById($_GET['id'], $table);

					if($result) {
						//Save into LOG
						try { 
							$idUser = Usuario::getIdByCorreo($_SESSION['uCorreo'], $_SESSION['idSitio']);
							$ip = Log::getRealIp();
							Log::saveAction($idUser->id, $_SESSION['uCorreo'], $_GET['id'], 'Catálogo de ubicación: '.$table, 'Eliminar del catálogo', $ip);
						} catch(Exception $ex) {
							error_log('Error al guardar en el log: '.$ex->getMessage());
						}

						echo $_GET['id'];
					}
					else
						http_response_code(500);
					die();
				} 
				else if(isset($_GET['idUbicacion'])) {
					if(!is_numeric($_GET['idUbicacion'])) {
						http_response_code(400);
						die();
					}
					//ids de los que se van a eliminar
					$result = Catalogo::deleteByIdUbicacion($_GET['idUbicacion'], $table);

					if($result) {
						//Save into LOG
						try { 
							$idUser = Usuario::getIdByCorreo($_SESSION['uCorreo'], $_SESSION['idSitio']);
							$ip = Log::getRealIp();
							Log::saveAction($idUser->id, $_SESSION['uCorreo'], $_GET['idUbicacion'], 'Catálogo de ubicación: '.$table, 'Eliminar todo del catálogo por idUbicacion', $ip);
						} catch(Exception $ex) {
							error_log('Error al guardar en el log: '.$ex->getMessage());
						}

						echo json_encode($result);
					}
					else
						http_response_code(400);
					die();
				}
				break;
			default:
				http_response_code(405); //Method not allowed
				break;
		}
	}
	else
		http_response_code(400); //Bad request
		die();
?>