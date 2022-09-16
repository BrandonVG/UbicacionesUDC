<?php 
  class Usuario extends General {
    public $id; 
    public $correo;
    // 1: admin, 2: editor y 3: validador
    public $rol;

    //Crear instancia
    public static function getUsuarioInstance($object) {
      if(isset($object->correo) && intval($object->rol) >= 1 && intval($object->rol) <= 3) {
        $instance = new self();
        $instance->correo = $object->correo;
        $instance->rol = $object->rol;
        return $instance;
      }
      else
        throw new Exception("Inconsistencia en los datos al inicializar la instancia de Usuario", 400);
    }

    //Actualizar instancia
    public static function getUsuarioUpdate($object) {
      if(isset($object->correo) && intval($object->rol) >= 1 && intval($object->rol) <= 3 && is_numeric($object->id)) {
        $instance = new self();
        $instance->id = $object->id;
        $instance->correo = $object->correo;
        $instance->rol = $object->rol;
        return $instance;
      }
      else
        throw new Exception("Inconsistencia en los datos al inicializar la instancia de Usuario", 400);
    }

    public function create() {
      $sql = "INSERT INTO usuarios (correo, rol) values (?, ?)";

      $database = new Database();
      $statement = $database->stmt_init();
      $affected_rows = false;      

      if($statement->prepare($sql)) {
        $statement->bind_param('si', $this->correo, $this->rol);
        $statement->execute();
        $affected_rows = $database->affected_rows;
        $this->id = $database->insert_id;
        $statement->close();
      }
      $database->close();

      return $affected_rows;
    }

    public function update() {
      $sql = "UPDATE usuarios SET correo = ?, rol = ? WHERE id = ?";

      $database = new Database();
      $statement = $database->stmt_init();
      $affected_rows = false;
      
      if ($statement->prepare($sql)) {
        $statement->bind_param('sii', $this->correo, $this->rol, $this->id);
        $statement->execute();
        $affected_rows = $database->affected_rows;
        $statement->close();
      }
      $database->close();
      return $affected_rows;
    }

    public static  function getInfoFromFederada($correo, $sitio) {
      $sql = "SELECT * FROM v_dependencia_usuarios WHERE correo = '".$correo."'AND url = '".$sitio."'";

      return self::getObjectBySql($sql);
    }

    public function getByCorreo($correo) {
      $sql = "SELECT * FROM usuarios WHERE correo = '".$correo."'";

      return self::getObjectBySql($sql);
    }

    public function getDelegacionByCorreoAndSitio($correo, $sitio) {
      $sql = "SELECT s_delegacion FROM v_dependencia_usuarios WHERE correo = '".$correo."' AND url = '".$sitio."'";
      
      return self::getObjectBySql($sql);
    }

    //Método usado para obtener el id de un usuario cuando se va a guardar una acción en el log
    public static function getIdByCorreo($correo, $id_sitio) {
      $sql = "SELECT id FROM v_dependencia_usuarios WHERE correo = '".$correo."' AND id_sitio = ".$id_sitio;

      return self::getObjectBySql($sql);
    }
  }
?>