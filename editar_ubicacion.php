<?php  
	require_once('includes/config.inc.php');
  require_once('includes/inc.session.php');

  if (!isset($_GET['sitio']) || $_GET['sitio'] != $_SESSION['url'] || $_SESSION['rol'] == 3) {
    http_response_code(403);
    echo "<div style='background-color: #f0ad4e; padding: 15px 20px; text-align: center; color: #fff; font-family: \".Helvetica Neue\",Helvetica,Arial,sans-serif;'><img src='https://wayf.ucol.mx/imglogin/UdClog.png'><br>Correo ".$_SESSION['uCorreo']." NO tiene permiso en sitio<br> <a href='".$url."'>Regresar al inicio</a> </div>";
    die();
  }

  $ruta = array('<li class="active">Editar ubicaci&oacute;n</li>');
  $titulo = "EDITAR UBICACI&Oacute;N";
  $id = $_GET['id'] ?? false;

  $ubicacion = Ubicacion::getById($id,'ubicaciones');
  if ($id) {
    if ($ubicacion) {
      if ($ubicacion->idSitio == $_SESSION['idSitio']) {
        $padre = ($ubicacion->aceptado == 1 && $ubicacion->idHijo == -1) ? 'true' : 'false';
        echo '<script>window.id = '.$id.';window.crearHijo = '.$padre.';window.sitio = "'.$_SESSION['url'].'";</script>';
        $_SESSION["Id_Modulo"] = $_SESSION['idSitio'];
        $_SESSION["fck_folder"] ="ubicaciones/".$_SESSION["Id_Modulo"]."/";
        $_SESSION['pkusr']=$_SESSION['uCorreo']; //Para permitir upload
        require_once(VIEW_PATH.'header.view.php');
        $defaultDelegacion = (int)$ubicacion->idDelegacion;
        //URL
        echo "<script>
              var urlSitio = '".$_SESSION['url']."';
              var delegaciones = ".json_encode($delegaciones).";
              var defaultDelegacionId = ".$defaultDelegacion." 
          </script>";

        require_once(VIEW_PATH.'crear-ubicacion.view.php');
        require_once(VIEW_PATH.'footer.view.php');
      } else {
        http_response_code(403);
      }
    } else {
      http_response_code(404);
    }
  } else
    echo '<div class="row"><div class="col-md-12 col-sm-12 col-12"><h1 style="text-align: center">404 Not Found</h1></div></div>';
	
?>