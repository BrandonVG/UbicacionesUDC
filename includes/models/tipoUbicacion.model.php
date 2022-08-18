<?php  
	class TipoUbicacion extends General {
		public $id;
		public $nombre; //Requerido
		public $estatus;

		public static function getTipoCreate($object) {
			if(isset($object->nombre)) {
				$instance = new self();
				$instance->nombre = $object->nombre;

				return $instance;
			}
			else 
				throw new Exception("Parámetros inconsistentes al crear tipoUbicacion", 400);
		}

		public static function getTipoUpdate($object) {
			if(isset($object->nombre) && is_numeric($object->estatus) && is_numeric($object->id)) {
				$instance = new self();
				$instance->id = $object->id;
				$instance->nombre = $object->nombre;
				$instance->estatus = $object->estatus;

				return $instance;
			}
			else 
				throw new Exception("Parámetros inconsistentes al crear tipoUbicacion", 400);
		}

		public function create() {
			$sql = "INSERT INTO tiposUbicaciones (nombre) values (?)";

			$database = new Database();
			$statement = $database->stmt_init();
			$affected_rows = false;      

			if($statement->prepare($sql)) {
			  $statement->bind_param('s', $this->nombre);
			  $statement->execute();
			  $affected_rows = $database->affected_rows;
			  $this->id = (string)$database->insert_id;
			  $this->estatus = "1";
			  $statement->close();
			}
			$database->close();

			return $affected_rows;
		}

		public function update() {
				$sql = "UPDATE tiposUbicaciones SET nombre = ?, estatus = ? WHERE id = ?";

				$database = new Database();
				$statement = $database->stmt_init();
				$affected_rows = false;
				
				if ($statement->prepare($sql)) {
				  $statement->bind_param('sii', $this->nombre, $this->estatus, $this->id);
				  $statement->execute();
				  $affected_rows = $database->affected_rows;
				  $statement->close();
				}
				$database->close();
				return $affected_rows;
		}

		public static function getAllActivos() {
			$sql = "SELECT * FROM tiposUbicaciones WHERE estatus = 1";

			return self::getArrayBySql($sql);
		}
	}
?>