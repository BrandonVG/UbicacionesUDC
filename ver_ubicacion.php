<?php  
  require_once('includes/config.inc.php');
  require_once(LIB_PATH.'responseError.php');
  
  $id = isset($_GET['id']) ? $_GET['id'] : false;
  $preview = false;
  if(is_numeric($id)) {
    $ubicacion = Ubicacion::getAllInfoById($id);
    if($ubicacion !== null) {
      if($ubicacion->aceptado != 1) {
        //para las sesiones es necesario la url del sitio
        $_GET['sitio'] = Ubicacion::getUrlSitio($ubicacion->idSitio)->url;
        require_once('includes/inc.session.php');
        if($ubicacion->idSitio != $_SESSION['idSitio'] || $_SESSION['rol'] !== 1) 
          responseError(403, 'No tienes permiso para ver esta actividad');
      }
      
      $ruta = array('<li class="active">Ver ubicación</li>');
      $titulo = strtoupper($ubicacion->etiqueta);
      if($ubicacion->aceptado != 1)
        $preview = "Previsualización";
      
      require_once(VIEW_PATH.'header.view.php');  
      require_once(VIEW_PATH.'ver-ubicacion.view.php');
      require_once(VIEW_PATH.'footer.view.php');
    }
    else 
      responseError(400, 'No se encontró la ubicación con el id '.$id);
  }
  else 
    responseError(400, 'No se encontró la ubicación');
?>