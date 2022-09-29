<?php

class Ubicacion extends General {
  public $id;
  public $etiqueta;
  public $cupo;
  public $titulo;
  public $latitud;
  public $longitud;
  public $resumen;
  public $descripcion;
  public $detalles;
  public $clasificadores; // null, [String]
  public $idSitio;
  public $portada;
  public $idTipo; //Relaci�n 1 a 1 con la tabla tipo de ubicaci�n
  public $visible; // 0 = no visible, 1 = visible
  public $estatus; // 0 = guardada, 1 = enviada, -1 = Elimindada
  public $aceptado; // 0 = rechazado, 1 = aceptado, -1 = indefinido
  public $idPadre; // -1 en padres, ref a padres
  public $idHijo; // -1 en hijos, ref a hijos
  public $fechaEdicion;
  public $idDelegacion;
  public $fechaAprobacion;

  public $agrupador = ''; // Varchar (20), opcional
  // * Primero se enlista el valor por defecto

  public static function getUbicacionCreate ($object) {
    $instance = new self();
    if (isset($object->etiqueta) &&
      isset($object->cupo) &&
      isset($object->titulo) &&
      isset($object->latitud) &&
      isset($object->longitud) &&
      isset($object->resumen) &&
      isset($object->descripcion) &&
      isset($object->idTipo) &&
      isset($object->portada) &&
      isset($object->idDelegacion) &&
      isset($object->idSitio)) {
      $instance->etiqueta = $object->etiqueta;
      $instance->cupo = $object->cupo;
      $instance->titulo = $object->titulo;
      $instance->latitud = $object->latitud;
      $instance->longitud = $object->longitud;
      $instance->idTipo = $object->idTipo;
      $instance->resumen = $object->resumen;
      $instance->descripcion = $object->descripcion;
      $instance->detalles = $object->detalles;
      $instance->clasificadores = isset($object->clasificadores) ? $object->clasificadores : null;
      $instance->idSitio = $object->idSitio;
      $instance->portada = $object->portada;
      $instance->visible = 0;
      $instance->estatus = 0;
      $instance->aceptado = -1;
      $instance->idPadre = -1;
      $instance->idHijo = -1;
      $instance->fechaEdicion = date('Y-m-d h:i:s');
      $instance->fechaAprobacion = date('1970-01-01 00:00:01');
      // $delegacion = self::getIdDelegacionByIdSitio($object->idSitio);
      $instance->idDelegacion = $object->idDelegacion;

      if (isset($object->agrupador))
        $instance->agrupador = $object->agrupador;
      return $instance;
    } else 
      throw new Exception("Error al crear objeto Ubicacion", 400);
  }

  public static function getUbicacionCreateHijo ($object, $idPadre) {
    $instance = new self();
    if (isset($object->etiqueta) &&
      isset($object->cupo) &&
      isset($object->titulo) &&
      isset($object->latitud) &&
      isset($object->longitud) &&
      isset($object->resumen) &&
      isset($object->descripcion) &&
      isset($object->idTipo) &&
      isset($object->portada) &&
      isset($object->idSitio) &&
      isset($object->idDelegacion) &&
      isset($idPadre)) {
      $instance->etiqueta = $object->etiqueta;
      $instance->cupo = $object->cupo;
      $instance->titulo = $object->titulo;
      $instance->latitud = $object->latitud;
      $instance->longitud = $object->longitud;
      $instance->idTipo = $object->idTipo;
      $instance->resumen = $object->resumen;
      $instance->descripcion = $object->descripcion;
      $instance->detalles = $object->detalles;
      $instance->portada = $object->portada;
      
      $instance->visible = 0;
      $instance->estatus = 0;
      $instance->aceptado = -1;

      $instance->clasificadores = isset($object->clasificadores) ? $object->clasificadores : null;
      $instance->idSitio = $object->idSitio;

      $instance->idPadre = $idPadre;
      $instance->idHijo = -1;
      $instance->fechaEdicion = date('Y-m-d h:i:s');
      $instance->fechaAprobacion = $object->fechaAprobacion;
      // $delegacion = self::getIdDelegacionByIdSitio($object->idSitio);
      $instance->idDelegacion = $object->idDelegacion;

      if (isset($object->agrupador))
        $instance->agrupador = $object->agrupador;
      return $instance;
    } else 
      throw new Exception("Error al crear objeto hijo Ubicacion", 400);
  }

  public static function getUbicacionUpdate ($object, $id) {
    $instance = new self();
    if (isset($object->etiqueta) &&
      isset($object->cupo) &&
      isset($object->titulo) &&
      isset($object->latitud) &&
      isset($object->idTipo) &&
      isset($object->longitud) &&
      isset($object->portada) &&
      isset($object->descripcion) &&
      isset($object->resumen) &&
      isset($object->idSitio) &&
      isset($object->idDelegacion) &&
      isset($id)) {
      // Requerido
      $instance->etiqueta = $object->etiqueta;
      $instance->cupo = $object->cupo;
      $instance->titulo = $object->titulo;
      $instance->latitud = $object->latitud;
      $instance->longitud = $object->longitud;
      $instance->portada = $object->portada;
      $instance->idTipo = $object->idTipo;
      $instance->resumen = $object->resumen;
      $instance->detalles = $object->detalles;
      $instance->descripcion = $object->descripcion;
      $instance->idSitio = $object->idSitio;
      $instance->id = $id;
      // Opcional
      $instance->clasificadores = isset($object->clasificadores) ? $object->clasificadores : null;

      $instance->visible = isset($object->visible) ? $object->visible : 0;
      $instance->estatus = isset($object->estatus) ? $object->estatus : 0;
      $instance->aceptado = -1;
              
      $instance->idPadre = isset($object->idPadre) ? $object->idPadre : -1;
      $instance->idHijo = isset($object->idHijo) ? $object->idHijo : -1;
      $instance->fechaEdicion = date('Y-m-d h:i:s');
      $instance->fechaAprobacion = $object->fechaAprobacion;
      $instance->idDelegacion = $object->idDelegacion;

      if (isset($object->agrupador))
        $instance->agrupador = $object->agrupador;
      
      return $instance;
    } else 
      throw new Exception("Error al crear objeto Ubicacion", 400);
  }

  public static function getIdDelegacionByIdSitio($idSitio) {
    $sql = 'SELECT s_delegacion FROM v_dependencia_usuarios WHERE id_sitio = '.$idSitio.' LIMIT 1';

    return self::getObjectBySql($sql);
  }

  public static function getAllBySitio ($idSitio) {
    if (is_numeric($idSitio))
      return self::getArrayBySql('SELECT * FROM ubicaciones WHERE estatus < 3 AND idSitio = ' . $idSitio);
    return [ ];
  }

  //Devuelve todas las que est�n pendientes por validar
  public static function getAllPendingByValidador ($idSitio) { // Esto debe de ser idSitio = $idSitio
    if (is_numeric($idSitio)) {
      //Regresa las enviadas (1) e indeterminadas (-1) del sitio
      $sql = 'SELECT * FROM ubicaciones WHERE'
      .' estatus = 1 AND aceptado = -1 AND idSitio = '.$idSitio
      .' ORDER BY estatus DESC';
      return self::getArrayBySql($sql);
    }
    return [ ];
  }

  public static function getAllByValidador($idSitio) { // Esto debe de ser idSitio = $idSitio
    if (is_numeric($idSitio)) {
      //Regresa las enviadas (1) e indeterminadas (-1) del sitio
      //Tambi�n devuelve las que ya fueron aceptadas pero que se cambiaron a guardadas
      $sql = 'SELECT * FROM ubicaciones WHERE'
      .' idPadre = -1 AND idSitio = '.$idSitio.' AND (estatus = 1 OR (estatus = 0 AND aceptado != -1))'
      .' ORDER BY estatus DESC';
      return self::getArrayBySql($sql);
    }
    return [ ];
  }  

  //Devuelve todas las ubicaciones aceptadas y visibles
  public static function getAllForIndex() {
    $sql = 'SELECT ubicaciones.*, v_dependencias.titulo AS nombreSitio'
      .' FROM ubicaciones'
      .' INNER JOIN v_dependencias ON ubicaciones.idSitio = v_dependencias.id_sitio'
      .' WHERE ubicaciones.aceptado = 1 AND ubicaciones.visible = 1';
    return self::getArrayBySql($sql);
  }

  public static function getAllForIndexBySitio($idSitio) {
    $sql = 'SELECT ubicaciones.*, v_dependencias.titulo AS nombreSitio'
      .' FROM ubicaciones'
      .' INNER JOIN v_dependencias ON ubicaciones.idSitio = v_dependencias.id_sitio'
      .' WHERE ubicaciones.aceptado = 1 AND ubicaciones.visible = 1 AND idSitio ='.$idSitio;

    return self::getArrayBySql($sql);
  }

  public static function getAllInfoById($id) {
    $sql = 'SELECT ubicaciones.*, v_dependencias.titulo AS nombreSitio, tiposUbicaciones.nombre AS tipo 
      FROM ubicaciones
      INNER JOIN v_dependencias ON ubicaciones.idSitio = v_dependencias.id_sitio 
      INNER JOIN tiposUbicaciones ON ubicaciones.idTipo = tiposUbicaciones.id 
      WHERE ubicaciones.id = '.$id;
      return self::getObjectBySql($sql);
  }

  public static function getIdSitio($nombreSitio) {
    $sql = "SELECT id_sitio FROM v_dependencias WHERE url = '".$nombreSitio."'";

    return self::getObjectBySql($sql);
  }

  public static function getAllDependencias() {
    $sql = 'SELECT * FROM v_dependencias';

    return self::getArrayBySql($sql);
  }

  public static function getNombreSitio($idSitio) {
    $sql = "SELECT titulo AS nombreSitio FROM v_dependencias WHERE id_sitio = ".$idSitio;
    return self::getObjectBySql($sql);
  }

  //Para los filtros por tags en el index, el tag string en forma 'sadfsdfa|sdfds|sadfasd|sadf'
  public static function getAllByTagsAndDelegacion($tagString, $delegacion = false) {
    $sql = 'SELECT id FROM ubicaciones'
      .' WHERE aceptado = 1 AND visible = 1 AND clasificadores LIKE \''.$tagString->tags."'";
    if($delegacion)
      $sql .= ' AND idDelegacion = '.$delegacion;
    // $tagString = str_replace(",",'%',$tagString);
    /*$database = new Database();
    $statement = $database->stmt_init();

    if($statement->prepare($sql)) {
      $statement->bind_param('s', $tagString->tags);
      $statement->execute();
      // $statement->bind_result($result);
    }
    $result = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    
    $statement->close();
    $database->close();
    return $result;*/
    return self::getArrayBySql($sql);
  }

  public static function getAllByEditor ($idSitio) { // Esto debe de ser idSitio = $idSitio
    if (is_numeric($idSitio))
      return self::getArrayBySql('SELECT * FROM ubicaciones WHERE idSitio = '. $idSitio .' AND estatus >= 0 AND (idPadre != -1 OR idHijo = -1) ORDER BY estatus DESC');
    return [ ];
  }

  public function create () {
    $sql = 'INSERT INTO ubicaciones (etiqueta, cupo, titulo, latitud, longitud, resumen, descripcion, detalles, clasificadores, portada, idTipo, idSitio, idPadre, idHijo, fechaEdicion, fechaAprobacion, idDelegacion, agrupador) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
    $id = self::executeInsert($sql,$this->etiqueta, $this->cupo, $this->titulo, $this->latitud, $this->longitud, $this->resumen, $this->descripcion, $this->detalles, $this->clasificadores, $this->portada, $this->idTipo, $this->idSitio, $this->idPadre, $this->idHijo,$this->fechaEdicion, $this->fechaAprobacion, $this->idDelegacion, $this->agrupador);
    if ($id) {
      $this->id = $id;
      return true;
    }
    return false;
  }
  
  public function update () {
    $sql = 'UPDATE ubicaciones SET etiqueta = ?, cupo = ?, titulo = ?, latitud = ?, longitud = ?, resumen = ?, descripcion = ?, detalles = ?, clasificadores = ?, portada = ?, idTipo = ?, idSitio = ?, visible = ?, estatus = ?, aceptado = ?, fechaEdicion = ?, fechaAprobacion = ?, idDelegacion = ?, agrupador = ? WHERE id = ?';
    return self::executeQuery($sql, $this->etiqueta, $this->cupo, $this->titulo, $this->latitud, $this->longitud, $this->resumen, $this->descripcion, $this->detalles, $this->clasificadores, $this->portada, $this->idTipo, $this->idSitio, $this->visible, $this->estatus, $this->aceptado, $this->fechaEdicion, $this->fechaAprobacion, $this->idDelegacion, $this->agrupador, $this->id);
  }

  public static function updateEstatus ($id, $estatus) {
    $sql = 'UPDATE ubicaciones SET estatus = ? WHERE id = ?';
    return self::executeQuery($sql, $estatus, $id);
  }

  public static function updateVisible ($id, $visible) {
    $sql = 'UPDATE ubicaciones SET visible = ? WHERE id = ?';
    return self::executeQuery($sql, $visible, $id);
  }

  public static function updateAceptado ($id, $aceptado, $motivo = false) {
    $ubicacion = self::getById($id,'ubicaciones');
    $date = date('Y-m-d h:i:s');
    $sql = "UPDATE ubicaciones SET aceptado = ?, estatus = 0, visible = 1, fechaEdicion = '" . $date . "', fechaAprobacion = '" . $date . "' WHERE id = ?";
    if ($ubicacion->idPadre == -1 || $motivo) { // acpetando original o rechanzando cualquiera
      if (self::executeQuery($sql, $aceptado, $id)) {
        $ubicacion->aceptado = $aceptado;
        $ubicacion->estatus = 0;
        return $ubicacion;
      }
      return false;
    } else { // aceptando hijo, sustituira al padre
      $padre = self::getById($ubicacion->idPadre,'ubicaciones');
      $nueva = self::getUbicacionUpdate($ubicacion, $padre->id);
      $nueva->idPadre = -1;
      $nueva->estatus = 0;
      $nueva->visible = 1;
      $nueva->aceptado = 1;
      $nueva->fechaAprobacion = $date;
      $nueva->fechaEdicion = $date;
      if ($nueva->update()) {
        self::insertToHistorico($padre);
        self::updateIdHijo($nueva->id, -1);
        Catalogo::deleteByIdUbicacion($nueva->id, 'equipamientoUbicacion');
        Catalogo::deleteByIdUbicacion($nueva->id, 'actividadesUbicacion');
        Catalogo::deleteByIdUbicacion($nueva->id, 'dirigidoUbicacion');
        Catalogo::updateIdUbicacion($ubicacion->id, $nueva->id, 'equipamientoUbicacion');
        Catalogo::updateIdUbicacion($ubicacion->id, $nueva->id, 'actividadesUbicacion');
        Catalogo::updateIdUbicacion($ubicacion->id, $nueva->id, 'dirigidoUbicacion');
        $sql = 'DELETE FROM ubicaciones WHERE id = ?';
        self::executeQuery($sql, $id);
        return $nueva;
      }
      return false;
    }

  }

  public static function updateIdHijo ($id, $idHijo) {
    $sql = 'UPDATE ubicaciones SET idHijo = ? WHERE id = ?';
    return self::executeQuery($sql, $idHijo, $id);
  }
  
  public function insertToHistorico($object) {
    $object->visible = isset($object->visible) ? $object->visible : 0;
    $object->estatus = isset($object->estatus) ? $object->estatus : 0;
    $object->estatus = isset($object->aceptado) ? $object->aceptado : -1;
    $object->idPadre = isset($object->idPadre) ? $object->idPadre : -1;
    $object->idPadre = isset($object->idHijo) ? $object->idHijo : -1;
    $object->idPadre = isset($object->idHijo) ? $object->idHijo : -1;
    $sql = 'INSERT INTO historico (id, etiqueta, cupo, titulo, latitud, longitud, resumen, descripcion, detalles, clasificadores, idSitio, portada, idTipo, visible, estatus, aceptado, idPadre, idHijo, fechaEdicion, fechaAprobacion, agrupador) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
    return self::executeQuery($sql, $object->id, $object->etiqueta, $object->cupo, $object->titulo, $object->latitud, $object->longitud, $object->resumen, $object->descripcion, $object->detalles, $object->clasificadores, $object->idSitio, $object->portada, $object->idTipo, $object->visible, $object->estatus, $object->aceptado, $object->idPadre, $object->idHijo, $object->fechaEdicion, $object->fechaAprobacion, $object->agrupador);
  }

  public static function deleteById($id, $db = 'ubicaciones') {
    $sql = 'UPDATE ubicaciones SET estatus = ? WHERE id = ?';
    $estadoBorrado = -1;
    return self::executeQuery($sql, $estadoBorrado, $id);
  }

  public static function isEtiquetaAvailable($etiqueta) {
    $sql = "SELECT COUNT(*) FROM ubicaciones WHERE etiqueta = '".$etiqueta."'";
    return (object) ['available' => self::getCountBySql($sql) == 0];
  }

  public static function exist($id) {
    return self::getCountBySql("SELECT COUNT(*) FROM ubicaciones WHERE id = ".$id);
  }

  public static function getAllAprobadasBySitio ($idSitio) {
    $sql = "SELECT * FROM ubicaciones WHERE idSitio = ".$idSitio." AND aceptado = 1";

    return self::getArrayBySql($sql);
  }
  public static function getCorreosValidadoresByIdSitio($idSitio) {
    $sql = "SELECT correo FROM v_dependencia_usuarios WHERE id_sitio = ".$idSitio." AND rol ='V'";

    return self::getArrayBySql($sql);
  }

  public static function getCorreosEditoresByIdSitio($idSitio) {
    $sql = "SELECT correo FROM v_dependencia_usuarios WHERE id_sitio = ".$idSitio." AND rol ='E'";

    return self::getArrayBySql($sql);
  }

  public static function getUrlSitio($idSitio){
    $sql ="SELECT url FROM v_dependencias WHERE id_sitio =".$idSitio;
    
    return self::getObjectBySql($sql);
  }
}
?>