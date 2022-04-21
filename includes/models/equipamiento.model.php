<?php 
	class Equipamiento extends General {
		public $id;	
		public $nombre;
		public $estatus; //0:Activo e 1:inactivo

		//Crear instancia
		public static function getEquipamientoCreate($object) {
			$instance = new self();

			if(isset($object->nombre)) {
				if(strlen($object->nombre) <= 60){
					$instance->nombre = $object->nombre;
					return $instance;
				}
				else {
					throw new Exception("Nombre demasiado largo en equipamiento", 422);
				}
			}
			else {
				throw new Exception("Nombre no definido en equipamiento", 400);
			}
		}

		//Crear instancia
		public static function getEquipamientoUpdate($object) {
			$instance = new self();

			if(isset($object->nombre) && is_numeric($object->id) && is_numeric($object->estatus)) {
				if(strlen($object->nombre) <= 60){
					$instance->nombre = $object->nombre;
					$instance->estatus = $object->estatus;
					$instance->id = $object->id;
					return $instance;
				}
				else {
					throw new Exception("Nombre demasiado largo en equipamiento", 422);
				}
			}
			else {
				throw new Exception("Nombre no definido en equipamiento", 400);
			}
		}

		public function create() {
			$sql = "INSERT INTO equipamiento (nombre) values (?)";
			$id = self::executeINSERT($sql,$this->nombre);
			if ($id) {
				$this->id = $id;
				$this->estatus = 1;
			}
			return $id;
		}

		public function update() {
			$sql = "UPDATE equipamiento SET nombre = ?, estatus = ? WHERE id = ?";
			return self::executeQuery($sql, $this->nombre, intval($this->estatus), intval($this->id));
		}

		public function getAllActive() {
			$sql = "SELECT * FROM equipamiento WHERE estatus = 1";

			return self::getArrayBySql($sql);
		}
	}
?>