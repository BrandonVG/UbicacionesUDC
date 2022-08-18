<?php
session_start();
	$_SESSION["salir"]="salir";
    require_once('../includes/config.inc.php');
    require_once('../includes/inc.session.php');
    $as = new SimpleSAML_Auth_Simple($saml_source);
	if ($as ->isAuthenticated()){
		//echo "session true";
		if(isset($_SESSION)){
			//session_unset();
			session_unset($_SESSION["salir"]);
			//$as->logout("http://cenedic3.ucol.mx/saestuc/");
		}
		
		$as->logout($url.'index.php');
		
	}else{
		 //
		session_unset($_SESSION["salir"]);
		$as->logout($url.'index.php');
		echo "NO hay sesion iniciada.";
		redirect_to($url.'index.php');
	}
?>