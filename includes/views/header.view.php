<?php echo file_get_contents("https://www.ucol.mx/cms/headerapp2.php?TITULO=".urlencode("Ubicaciones")); ?>
<link href="<?php echo $url; ?>public/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"></link>
<script src="<?php echo $url; ?>public/js/axios.min.js"></script>
<script src="<?php echo $url; ?>public/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $url; ?>public/js/dataTables.bootstrap4.min.js"></script>
<script>
  var gURL = '<?php echo $url; ?>';
</script>
<section class="page-breadcrumb">
	<div class="container ">
		<div id="path">
      <ol class="breadcrumb">
        <li>Usted est&aacute; en:</li>
        <li><a href="<?php echo $url ?>">Inicio</a></li>
        <?php  
        	for ($i=0; $i < count($ruta); $i++) { 
        		echo $ruta[$i];//En el archivo .php que manda llamar al header y a la vista se declara el array con el li y a
        	}
        ?>
			</ol>
	  </div>
	  <div id="sesion">
      <ol class="breadcrumb">
	      <?php if($as->isAuthenticated()) { ?> <!--Validar sesión-->
		      <li>Bienvenido(a):</li>
	        <li class="user-name"><?php echo $_SESSION['uNombre']; ?></li>
	        <li><a href="<?php //echo $url.'logout.php'; ?>">Salir</a></li>
	      <?php } else {
          echo '<li> <a href="'.$url.'login.php?urlAnterior='.$_SERVER['REQUEST_URI'].'">Iniciar sesión</a> </li>';
        } ?>
			</ol>
	  </div>
	</div>
</section>
<section class="page-header">
  <div class="container">
      <h1 class="title-ucol"><?php echo $titulo; ?></h1>
  </div>
</section>
<div class="container c-principal">
  <div class="row p-contenido">
      <div class="col-xl-3 col-lg-4 col-md-4 col-xs-12 sidebar" id="sidebar">
	      <h2>Men&uacute;</h2>
	      <div id="navcontainer">
	        <ul id="navlist">
            <?php 
              if($as->isAuthenticated()) {
                if($_SESSION['rol'] == 1) {//Administrador
            ?>
              <li>
                <p href="#">Cat&aacute;logos</p>
                <ul id="navlist">
                  <li><a href="<?php echo $url.$_SESSION['url']; ?>/actividades">Actividades</a></li>
                  <li><a href="<?php echo $url.$_SESSION['url']; ?>/equipamiento">Equipamiento</a></li>
                  <li><a href="<?php echo $url.$_SESSION['url']; ?>/tipos-ubicaciones">Tipos de Ubicaciones</a></li>
                  <li><a href="<?php echo $url.$_SESSION['url']; ?>/dirigido">Dirigido</a></li>
                </ul>
              </li>
            <?php  
                }
              }
              if($as->isAuthenticated()) {
                if($_SESSION['rol'] == 3 || $_SESSION['rol'] == 1) {//Editor
            ?>
               <li>
                  <p href="#">Validador</p>
                  <ul id="navlist">
                    <li>
                      <a href="<?php echo $url.$_SESSION['url'].'/todas-validador'; ?>">
                      Todas</a>
                    </li>
                  </ul>
                  <ul id="navlist">
                    <li>
                      <a href="<?php echo $url.$_SESSION['url'].'/validar'; ?>">
                      Pendientes por validar</a>
                    </li>
                  </ul>
               </li>
              <?php  
                  }
                }
                if($as->isAuthenticated()) {
                  // if() {//Editor
              ?>
                <li>
                   <p href="#">Editor</p>
                   <ul id="navlist">
                     <li>
                       <a href="<?php echo $url.$_SESSION['url'].'/editar'; ?>">
                       Ver todas</a>
                     </li>
                      <li><a href="<?php echo $url.$_SESSION['url'].'/crear-ubicacion'; ?>">Crear</a></li>
                   </ul>
                </li>
              <?php  
                  }
                //}
              ?>
            <li><a href="/ubicaciones">Inicio</a></li>
	        </ul>
	      </div>