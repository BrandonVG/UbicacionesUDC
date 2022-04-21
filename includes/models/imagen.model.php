<?php
  class Imagen extends General {
    public $id;
    public $idUbicacion;
    public $url;
    public $titulo;

    public function getImagenCreate ($object) {
      if (isset($object->idUbicacion) &&
        isset($object->url) &&
        isset($object->titulo)) {
          $instance = new self();

          $instance->url = $object->url;
          $instance->titulo = $object->titulo;
          $instance->idUbicacion = $object->idUbicacion;

          return $instance;
      } else 
        throw new Exception("Error al crear objecto Imagen", 400);
    }

    public function getImagenUpdate ($object) {
      if (isset($object->idUbicacion) && isset($object->url) && isset($object->titulo) && isset($object->id)) {
        $instance = new self();
        $instance->id = $object->id;
        $instance->url = $object->url;
        $instance->titulo = $object->titulo;
        $instance->idUbicacion = $object->idUbicacion;

        return $instance;
      } else
        throw new Exception("Error al crear objecto update Imagen", 400);
    }

    public function create() {
      $sql = 'INSERT INTO imagenes (idUbicacion, url, titulo) VALUES (?,?,?)';

      $database = new Database();
      $statement = $database->stmt_init();
      $result = false;

      if ($statement->prepare($sql)) {
  			$statement->bind_param('iss', $this->idUbicacion, $this->url, $this->titulo);
  			$statement->execute();
  			$result = $database->affected_rows;
        $this->id = $database->insert_id;
  			$statement->close();
  		}
  		$database->close();

  		return $result;
    }

    public function update() {
      $sql = "UPDATE imagenes SET idUbicacion = ?, url = ?, titulo = ? where id = ?;";
  		$database = new Database();
  		$statement = $database->stmt_init();
  		$result = false;
  		if ($statement->prepare($sql)) {
  			$statement->bind_param('issi', $this->idUbicacion, $this->url, $this->titulo, $this->id);
  			$statement->execute();
  			$result = $database->affected_rows;
  			$statement->close();
  		}
  		$database->close();
        
  		return $result;
    }

    public static function getAllByUbicacion($idUbicacion) {
      $sql = "SELECT * FROM imagenes WHERE idUbicacion = ". $idUbicacion;

      return self::getArrayBySql($sql);
    }
  }
?>