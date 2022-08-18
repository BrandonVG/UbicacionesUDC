<?php  
	//Modelo genérico para todas las tablas intermedias que se relacionan con ubicación y que sólo tienen 3 campos
	//actividadesUbicacion, equipamientoUbicacion e imagenesUbicacion
	class Catalogo extends General {
		public $id;
		public $idEnCatalogo;
		public $idUbicacion;
		public $nombreTabla;
		public $nombreCampo;

		public static function getCatalogoCreate($idEnCatalogo, $idUbicacion, $nombreTabla) {
			if(isset($idEnCatalogo) && isset($idUbicacion) && isset($nombreTabla)) {
				$instance = new self();

				$nombreCampo = "idActividad";
				if($nombreTabla == "equipamientoUbicacion")
					$nombreCampo = "idEquipamiento";
				else if ($nombreTabla == "dirigidoUbicacion")
					$nombreCampo = "idDirigido";

				$instance->idEnCatalogo = $idEnCatalogo;
				$instance->idUbicacion = $idUbicacion;
				$instance->nombreCampo = $nombreCampo;
				$instance->nombreTabla = $nombreTabla;

				return $instance;
			}			
			else
				throw new Exception("Inconsistencia en los datos al crear instance generica de Catálogos", 400);
		}

		public function create() {
			$sql = "INSERT INTO ".$this->nombreTabla." (".$this->nombreCampo.", idUbicacion) values (?, ?)";

			$database = new Database();
			$statement = $database->stmt_init();
			$affected_rows = false;      

			if($statement->prepare($sql)) {
			  $statement->bind_param('ii', $this->idEnCatalogo, $this->idUbicacion);
			  $statement->execute();
			  $affected_rows = $database->affected_rows;

			  $this->id = $database->insert_id;

			  $statement->close();
			}
			$database->close();

			return $affected_rows;
		}

		public function update() {
			throw new Exception("Los registros en los catálogos no se pueden actualizar", 400);
		}

		public static function getAllByIdUbicacion($idUbicacion, $nombreTabla) {
			if($nombreTabla == 'equipamientoUbicacion') {
				$columnName = 'idEquipamiento';
				$innerTable = 'equipamiento';
			}
			else if($nombreTabla == 'actividadesUbicacion') {
				$columnName = 'idActividad';
				$innerTable = 'actividades';
			}
			else if ($nombreTabla == 'dirigidoUbicacion') {
				$columnName = 'idDirigido';
				$innerTable = 'dirigido';
			}
			else
				return false;
			
			$sql = 
				"SELECT ".$innerTable.".nombre, ".$innerTable.".id FROM "
				.$nombreTabla." INNER JOIN ".$innerTable." ON "
				.$nombreTabla.".".$columnName." = ".$innerTable.".id"
				." WHERE ".$nombreTabla.".idUbicacion = ".$idUbicacion;

			return self::getArrayBySql($sql);
		}

		public static function getAllInfoByIdUbicacion($idUbicacion, $table) {
			$sql = "SELECT * FROM ".$table." WHERE idUbicacion = ".$idUbicacion;
			// echo $sql;
			return self::getArrayBySql($sql);
		}

		public static function deleteByIdUbicacion($idUbicacion, $table) {
			$sql = "DELETE FROM ".$table.' WHERE idUbicacion = ?';

			return self::executeQuery($sql, $idUbicacion);
		}

		public static function updateIdUbicacion($idToUpdate, $newId, $table) {
			$sql = "UPDATE ".$table." SET idUbicacion = ? WHERE idUbicacion = ?";

			return self::executeQuery($sql, $newId, $idToUpdate);
		}
	}
?>