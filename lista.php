<?php
  require_once('includes/config.inc.php');
  require_once('includes/inc.session.php');

  if (!isset($_GET['sitio']) || $_GET['sitio'] != $_SESSION['url'] || $_SESSION['rol'] > 3 || $_SESSION['rol'] < 2) {
    http_response_code(403);
    echo "<div style='background-color: #f0ad4e; padding: 15px 20px; text-align: center; color: #fff; font-family: \".Helvetica Neue\",Helvetica,Arial,sans-serif;'><img src='https://wayf.ucol.mx/imglogin/UdClog.png'><br>Correo ".$_SESSION['uCorreo']." NO tiene permiso en sitio<br> <a href='".$url."'>Regresar al inicio</a> </div>";
  } else if ($_SESSION['rol'] == 2) {
    $ruta = array('<li>Editor</li>');
    $titulo = 'EDITOR';
    require_once(VIEW_PATH . 'header.view.php');
    require_once(VIEW_PATH . 'editar.view.php');
    require_once(VIEW_PATH . 'footer.view.php');
  } else if ($_SESSION['rol'] == 3) {
    $ruta = array('<li>Validar</li>');
    $titulo = 'VALIDADAR UBICACIONES';
    require_once(VIEW_PATH . 'header.view.php');

    //URL
    echo "<script>var url = 'https://".$_SERVER['SERVER_NAME']."/ubicaciones/'</script>";

    echo '<script type>const idSitio = '.$_SESSION['idSitio'].';</script>';
    require_once(VIEW_PATH . 'validar.view.php');
    require_once(VIEW_PATH . 'footer.view.php');
  }

?>