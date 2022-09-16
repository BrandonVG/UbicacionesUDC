<?php
  //include_once("config.php");
  
  require_once($SamlLibrary);
  $as = new SimpleSAML_Auth_Simple($saml_source);   // Se pasa como parametro la fuente de autenticación definida en el authsources del SP.
  $as->requireAuth();
  $attributes = $as->getAttributes();
  //print_r($attributes);
?>
