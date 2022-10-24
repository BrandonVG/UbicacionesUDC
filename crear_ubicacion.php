<?php  
	require_once('includes/config.inc.php');
	require_once('includes/inc.session.php');
	if (!isset($_GET['sitio']) || $_GET['sitio'] != $_SESSION['url'] || $_SESSION['rol'] == 3) {
		http_response_code(403);
		echo "<div style='background-color: #f0ad4e; padding: 15px 20px; text-align: center; color: #fff; font-family: \".Helvetica Neue\",Helvetica,Arial,sans-serif;'><img src='https://wayf.ucol.mx/imglogin/UdClog.png'><br>Correo ".$_SESSION['uCorreo']." NO tiene permiso en sitio<br>	<a href='".$url."'>Regresar al inicio</a> </div>";
		die();
	}

	$ruta = array('<li class="active">Crear ubicaci&oacute;n</li>');
	$titulo = "CREAR UBICACI&Oacute;N";
	
	$_SESSION["Id_Modulo"] = $_SESSION['idSitio'];
	// $_SESSION["fck_folder"] ="ubicaciones/".$_SESSION["Id_Modulo"]."/";
	$_SESSION["fck_folder"] = EN_PRODUCCION ? "ubicaciones/".$_SESSION["Id_Modulo"]."/" : "assets/img/ubicaciones/content/".$_SESSION["Id_Modulo"]."/";
	$_SESSION['pkusr'] = $_SESSION['uCorreo']; //Para permitir upload

	require_once(VIEW_PATH.'header.view.php');	
	// $dirigido = Dirigido::getAllEnabled();
	$defaultDelegacion = Usuario::getDelegacionByCorreoAndSitio($_SESSION['uCorreo'], $_SESSION['url'])->s_delegacion;

	//URL
	echo "<script>
				var url = 'https://".$_SERVER['SERVER_NAME']."/ubicaciones/'; 
				var urlSitio = '".$_SESSION['url']."';
				var delegaciones = ".json_encode($delegaciones).";
				var defaultDelegacionId = ".$defaultDelegacion." 
		</script>";

	require_once(VIEW_PATH.'crear-ubicacion.view.php');
	require_once(VIEW_PATH.'footer.view.php');
?>