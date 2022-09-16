<?php
// session_start();
//Configuración de la federación
defined('EN_PRODUCCION') ? NULL : define('EN_PRODUCCION', false);
defined('EN_TESTING') ? NULL : define('EN_TESTING', true);
$SamlLibrary = EN_PRODUCCION ? "/simplesamlphp/lib/_autoload.php" : "/simplesamlphp/lib/_autoload.php";
$saml_source = EN_PRODUCCION ? 'ubicaciones' : 'desarrollo4sistemas';

//Definición de variable global
// $url="https://cenedic3.ucol.mx/ubicaciones/";
$url = EN_PRODUCCION ?
          "https://".$_SERVER['SERVER_NAME']."/ubicaciones/" :
          "https://".$_SERVER['SERVER_NAME']."/ubicaciones/";

//Definir el código de caracteres
header('Content-Type: text/html; charset=utf-8');
////////////////////////////////////////////////////////////////////////////////
// Configure the default time zone
////////////////////////////////////////////////////////////////////////////////
date_default_timezone_set('MST');

////////////////////////////////////////////////////////////////////////////////
// Configure the default currency
////////////////////////////////////////////////////////////////////////////////
setlocale(LC_MONETARY, 'en_US');


////////////////////////////////////////////////////////////////////////////////
// Define constants for database connectivty
////////////////////////////////////////////////////////////////////////////////

if(EN_PRODUCCION) {
  defined('DATABASE_HOST') ? NULL : define('DATABASE_HOST', 'localhost');
  defined('DATABASE_NAME') ? NULL : define('DATABASE_NAME', 'ubicaciones');
  defined('DATABASE_USER') ? NULL : define('DATABASE_USER', 'ubicaciones');
  defined('DATABASE_PASSWORD') ? NULL : define('DATABASE_PASSWORD', 'JvR.;bd@Ym~S)5n}');
}
else {
  defined('DATABASE_HOST') ? NULL : define('DATABASE_HOST', 'localhost');
  defined('DATABASE_NAME') ? NULL : define('DATABASE_NAME', 'ubicaciones');
  defined('DATABASE_USER') ? NULL : define('DATABASE_USER', 'ubicaciones');
  defined('DATABASE_PASSWORD') ? NULL : define('DATABASE_PASSWORD', 'JvR.;bd@Ym~S)5n}');
}

////////////////////////////////////////////////////////////////////////////////
// Define absolute application paths
////////////////////////////////////////////////////////////////////////////////

// Use PHP's directory separator for windows/unix compatibility
defined('DS') ? NULL : define('DS', DIRECTORY_SEPARATOR);

// Define absolute path to server root
defined('SITE_ROOT') ? NULL : define('SITE_ROOT', dirname(dirname(__FILE__)).DS);

// Define absolute path to includes
defined('INCLUDE_PATH') ? NULL : define('INCLUDE_PATH', SITE_ROOT.'includes'.DS);
//defined('FUNCTION_PATH') ? NULL : define('FUNCTION_PATH', INCLUDE_PATH.'functions'.DS);
defined('LIB_PATH') ? NULL : define('LIB_PATH', INCLUDE_PATH.'libraries'.DS);
defined('MODEL_PATH') ? NULL : define('MODEL_PATH', INCLUDE_PATH.'models'.DS);
defined('VIEW_PATH') ? NULL : define('VIEW_PATH', INCLUDE_PATH.'views'.DS);

////////////////////////////////////////////////////////////////////////////////
// Include library, helpers, functions
////////////////////////////////////////////////////////////////////////////////
//require_once(FUNCTION_PATH.'functions.inc.php');
require_once(LIB_PATH.'database.class.php');

require_once(MODEL_PATH.'general.model.php');
// catalogos
require_once(MODEL_PATH.'equipamiento.model.php');
require_once(MODEL_PATH.'actividad.model.php');
require_once(MODEL_PATH.'log.model.php');
require_once(MODEL_PATH.'ubicacion.model.php');
require_once(MODEL_PATH.'imagen.model.php');
require_once(MODEL_PATH.'usuario.model.php');
require_once(MODEL_PATH.'tipoUbicacion.model.php');
require_once(MODEL_PATH.'catalogo.model.php');
require_once(MODEL_PATH.'mail.model.php');
require_once(MODEL_PATH.'dirigido.model.php');
// require_once(MODEL_PATH.'usuario.model.php');
// require_once(MODEL_PATH.'rolesUsuarios.model.php');
// require_once(MODEL_PATH.'roles.model.php');
// require_once(MODEL_PATH.'Ubicacion/ubicacion.model.php');
// require_once(MODEL_PATH.'Ubicacion/imagen.model.php');
require_once($SamlLibrary);
$as = new SimpleSAML_Auth_Simple($saml_source);   # Se pasa como parametro la fuente de autenticaci�n definida en el authsources del SP
// $dirigido = array('Estudiantes', 'Docentes', 'Público en general', 'Trabajadores');
$delegaciones = array(1 => 'Manzanillo', 2 => 'Tecomán', 3 => 'Colima', 4 => 'Coquimatlán', 5 => 'Villa de Álvarez');

if (preg_match('/\?login$/',$_SERVER['REQUEST_URI'])) {
  require_once('includes/inc.session.php');
  header('Location: ' . explode('?', $_SERVER['REQUEST_URI'])[0]);
}

if (preg_match('/\?logout$/',$_SERVER['REQUEST_URI'])) {
  session_unset();
  $as->logout($url);
}