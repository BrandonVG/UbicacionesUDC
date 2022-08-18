<?php 
	class Log {
		public static function saveAction($idUsuario, $correo, $idObjeto, $tipoObjeto, $accion, $ip) {
			if(isset($idUsuario) 
				&& isset($correo) 
				&& isset($idObjeto) 
				&& isset($tipoObjeto) 
				&& isset($accion)
				&& preg_match('/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$/', $ip)) {

				$sql = "INSERT INTO log (idUsuario, correo, idObjeto, tipoObjeto, accion, ip) values (?, ?, ?, ?, ?, ?)";
				$database = new Database();
				$statement = $database->stmt_init();
				$affected_rows = false;      

				if($statement->prepare($sql)) {
				  $statement->bind_param('isisss', $idUsuario, $correo, $idObjeto, $tipoObjeto, $accion, $ip);
				  $statement->execute();
				  $affected_rows = $database->affected_rows;
				  $statement->close();
				}
				$database->close();

				return $affected_rows;
			}
			else
				throw new Exception("Parámetros inconsistentes al guardar log", 400);
		}

		public static function getCorreoOfLastRecordByIdObjeto($idObjeto) {
			$sql = 'SELECT correo FROM log WHERE idObjeto = '.$idObjeto.' order by id desc limit 1';

			$database = new Database();
			$result = $database->query($sql);
			$object = $result->fetch_object();
			$database->close();
			return $object;	
		}

		public static function getRealIp() {
	    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	      $ip=$_SERVER['HTTP_CLIENT_IP'];
	    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	    else
	      $ip=$_SERVER['REMOTE_ADDR'];
	    return $ip;
		}
	}
?>