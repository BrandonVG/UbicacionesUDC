<?php 
  class Actividad extends General {
    public $id; 
    public $nombre;
    public $estatus;

    //Crear instancia
    public static function getActividadCreate($object) {
      if(isset($object->nombre)) {
        if(strlen($object->nombre) <= 60){
          $instance = new self();
          $instance->nombre = $object->nombre;
          return $instance;
        }
        else {
          throw new Exception("Nombre demasiado largo en Actividad", 422);
        }
      }
      else {
        throw new Exception("Nombre no definido en Actividad", 400);
      }
    }

    public static function getActividadUpdate($object) {
      if(isset($object->nombre) && is_numeric($object->id) && is_numeric($object->estatus)) {
        if(strlen($object->nombre) <= 60){
          $instance = new self();
          
          $instance->id = $object->id;
          $instance->nombre = $object->nombre;
          $instance->estatus = $object->estatus;

          return $instance;
        }
        else {
          throw new Exception("Nombre demasiado largo en Actividad", 422);
        }
      }
      else {
        throw new Exception("Nombre no definido en Actividad", 400);
      }
    }

    public function create() {
      $sql = "INSERT INTO actividades (nombre) values (?)";

      $database = new Database();
      $statement = $database->stmt_init();
      $affected_rows = false;      

      if($statement->prepare($sql)) {
        $statement->bind_param('s', $this->nombre);
        $statement->execute();
        $affected_rows = $database->affected_rows;

        $this->id = $database->insert_id;
        $this->estatus = 1;

        $statement->close();
      }
      $database->close();

      return $affected_rows;
    }

    public function getAllActive() {
      $sql = "SELECT * FROM actividades WHERE estatus = 1";

      return self::getArrayBySql($sql); 
    }

    public function update() {
      $sql = "UPDATE actividades SET nombre = ?, estatus = ? WHERE id = ?";

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
  }
?>