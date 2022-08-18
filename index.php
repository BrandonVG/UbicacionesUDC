<?php  
  require_once('includes/config.inc.php');
  require_once(LIB_PATH.'responseError.php');
  
  $ruta = array('<li>Inicio</li>');
  $titulo = "UBICACIONES";

  if($as->isAuthenticated())
    require_once('includes/inc.session.php');
  require_once(VIEW_PATH.'header.view.php');
  if(!count($_GET)){
    $ubicaciones = Ubicacion::getAllForIndex();
    var_dump($ubicaciones);
  } 
  else if(isset($_GET['sitio'])) {
    try {
      $idSitio = Ubicacion::getIdSitio($_GET['sitio']);
      if($idSitio) {  
        echo "<script>var sitio = '".$idSitio->id_sitio."'</script>";
        $ubicaciones = Ubicacion::getAllForIndexBySitio($idSitio->id_sitio);
      } 
      else
        responseError(404, 'El sitio "'.$_GET['sitio'].'" no existe, intenta con otro');
    }
    catch(Exception $ex) {
        responseError(404, 'El sitio "'.$_GET['sitio'].'" no existe, intenta con otro');
    }
  }
  require_once(VIEW_PATH.'index.view.php'); 
	require_once(VIEW_PATH.'footer.view.php');
?>