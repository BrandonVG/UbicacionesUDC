<?php
  if(!isset($_SESSION)) {
  	session_start();
  }

  if(EN_PRODUCCION)
		$_SESSION["fck_folder_root"]="/sftp/demo/cms/"; //SobreEscribe FileSystem.php->getDocumentRootPath()
		
	require_once(MODEL_PATH.'usuario.model.php');

	$as->requireAuth();
	   
	$attributes = $as->getAttributes();
	$_SESSION['uCorreo'] = $attributes['uCorreo'][0];
	$_SESSION['uNombre'] = $attributes['uNombre'][0];


	
	$usuario = Usuario::getInfoFromFederada($_SESSION['uCorreo']);	//Si no est� en esta vista es porque no tiene permisos

	if($_SESSION['uCorreo'] == 'gcruz@ucol.mx')
		$rol = 1;

	if($usuario !== null){
		$_SESSION['idSitio'] = $usuario->id_sitio;
		$_SESSION['url'] = $usuario->url;

		if(!isset($rol))
			$rol = strpos($usuario->rol, 'E') !== false ? 2 : 3; //Si no es editor, es validador, ahorita s�lo se puede 1;
		$_SESSION['rol'] = $rol;
	}
	else{
		echo "<div style='background-color: #f0ad4e; padding: 15px 20px; text-align: center; color: #fff; font-family: \".Helvetica Neue\",Helvetica,Arial,sans-serif;'><img src='https://wayf.ucol.mx/imglogin/UdClog.png'><br>Correo ".$_SESSION['uCorreo']." NO tiene permiso en sitio<br>	<a href='".$url.$_SESSION["url"]."'>Regresar al inicio</a> </div>";
		die();
	}
?>