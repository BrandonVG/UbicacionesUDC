<?php
require_once('includes/config.inc.php');
require_once(INCLUDE_PATH.'inc.session.php');

if($_SESSION['rol'] != 1) { //Sólo admin
  http_response_code(403);
  echo "<div style='background-color: #f0ad4e; padding: 15px 20px; text-align: center; color: #fff; font-family: \".Helvetica Neue\",Helvetica,Arial,sans-serif;'><img src='https://wayf.ucol.mx/imglogin/UdClog.png'><br>Correo ".$_SESSION['uCorreo']." NO tiene permiso en sitio<br> <a href='".$url."'>Regresar al inicio</a> </div>";
  session_unset();
  die();
}

$ruta = array('<li>Cat&aacute;logo Tipos Ubicaciones</li>');
$titulo = 'CAT&Aacute;LOGO DE TIPOS UBICACIONES';
require_once(VIEW_PATH . 'header.view.php');

//URL
echo "<script>var url = 'https://".$_SERVER['SERVER_NAME']."/ubicaciones/'</script>";

echo "<script> window.api = 'tipoUbicacion' </script>";
require_once(VIEW_PATH . 'catalogo.view.php');
require_once(VIEW_PATH . 'footer.view.php');
?>