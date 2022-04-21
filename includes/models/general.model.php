<?php
	abstract class General {
		public $id;
		
		public static function getArrayBySql($sql) {
			$database = new Database();
			$result = $database->query($sql);
			$array = array();
		
			while ($object = $result->fetch_object()) {
				$array[] = $object;
			}
		
			$database->close();
			return $array;	
		}

		public static function getObjectBySql($sql) {
			$database = new Database();
			$result = $database->query($sql);
			$object = $result->fetch_object();
			$database->close();
			return $object;	
		}

		public static function getAll($db) {
			return self::getArrayBySql("select * from " . $db);
		}

		public static function getById($id, $db) {
			return self::getObjectBySql("SELECT * FROM ".$db." WHERE id = '".$id."'");
		}

		public static function getCountBySql($sql) {
			$database = new Database();
			$result = $database->query($sql);
			$row = $result->fetch_row();
			$database->close();
			return intval($row[0]);	
		}

		abstract public function create();

		abstract public function update();

		protected function executeQuery($sql, ...$params) {
			$types = '';
			$values = '';
			$i = 0;
			foreach ($params as $p) {
				$types .= gettype($p)[0];
				$values .= '$params['.$i++.'], ';
			}
			$database = new Database();
			$statement = $database->stmt_init();
			$result = false;
			if ($statement->prepare($sql)) {
				$func = "statement->bind_param('".$types."', ".rtrim($values,', ').");";
				eval('$'.$func);
        $statement->execute();
        $result = $database->affected_rows;
				$statement->close();
      }
			$database->close();
			return $result;
		}

		protected function executeInsert($sql, ...$params) {
			$types = '';
			$values = '';
			$i = 0;
			foreach ($params as $p) {
				$types .= gettype($p)[0];
				$values .= '$params['.$i++.'], ';
			}
			$database = new Database();
			$statement = $database->stmt_init();
			$result = false;
			
			if ($statement->prepare($sql)) {
				$func = "statement->bind_param('".$types."', ".rtrim($values,', ').");";
				eval('$'.$func);
				$statement->execute();
				$result = $database->insert_id;
				$statement->close();
			}
			$database->close();
			return $result;
		}

		public static function deleteById($id, $db) {
			$sql = "DELETE FROM ".$db." WHERE id = ?";
			
			$database = new Database();
			$statement = $database->stmt_init();
			$affected_rows = false;
			
			if ($statement->prepare($sql)) {
				$statement->bind_param('i', $id);
				$statement->execute();
				$affected_rows = $database->affected_rows;
				$statement->close();
			}
			$database->close();
			return $affected_rows;
		}

		public function save() {
			if (isset($this->id)) {	
				return $this->update();
			} else {
				return $this->create();
			}
		}
	}
?>