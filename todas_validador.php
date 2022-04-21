<?php
  require_once('includes/config.inc.php');
  require_once('includes/inc.session.php');

  if (!isset($_GET['sitio']) || $_GET['sitio'] != $_SESSION['url'] || $_SESSION['rol'] == 2) {
    http_response_code(403);
    echo "<div style='background-color: #f0ad4e; padding: 15px 20px; text-align: center; color: #fff; font-family: \".Helvetica Neue\",Helvetica,Arial,sans-serif;'><img src='https://wayf.ucol.mx/imglogin/UdClog.png'><br>Correo ".$_SESSION['uCorreo']." NO tiene permiso en sitio<br> <a href='".$url."'>Regresar al inicio</a> </div>";
    die();
  }

  $ruta = array('<li>Todas las ubicaciones</li>');
  $titulo = 'TODAS LAS UBICACIONES';
  
  //Para saber si es necesario cargar en la vista el dropdown con todas las depencias y pueda validarlas
  $isAdmin = false;
  if($_SESSION['rol'] == 1) {
    $dependencias = Ubicacion::getAllDependencias();
  }
  
  require_once(VIEW_PATH . 'header.view.php');

  //URL
  echo "<script>var url = 'https://".$_SERVER['SERVER_NAME']."/ubicaciones/'</script>";

  echo '<script type>const idSitio = '.$_SESSION['idSitio'].';</script>';
  require_once(VIEW_PATH . 'todas-validador.view.php');
  require_once(VIEW_PATH . 'footer.view.php');
?>