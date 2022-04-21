<?php
	$cadena=file_get_contents("https://www.ucol.mx/cms/headerapp2.php?TITULO=".urlencode("Sistema"));
	echo $cadena;
?>
<section class="page-breadcrumb">
 <div class="container ">
  <div id="path">
        <ol class="breadcrumb">
            <li>Usted est&aacute; en:</li>
          <li><a href="/">Inicio</a></li>
  </ol>
    </div>
    <div id="sesion">
        <ol class="breadcrumb">
            <li>Bienvenido(a):</li>
          <li class="user-name">FERNANDEZ PALOMINOS PEDRO</li>
          <li><a href="#">Salir</a></li>
  </ol>
    </div>
 </div> <!--cierra path-->
</section>
<section class="page-header">
    <div class="container">
      <h1 class="title-ucol">Aqu&iacute; va el t&iacute;tulo</h1>
  </div><!--/ Cierra .container /-->
</section>
<nav class="nav-sistema">
    <button class="navbar-toggler hidden-md-up pull-right collapsed" type="button" data-toggle="collapse" data-target="#navbar-header2" aria-controls="navbar-header2" aria-expanded="false">?</button>
<div class="collapse navbar-toggleable-sm" id="navbar-header2">
      <ul id="navlist" class="nav navbar-primary navbar-nav pull-md-right">
          <li class="nav-item">
              <a class="a1 nav-link" data-hover="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                  <div class="oIcono opci&oacute;n1"></div>
                  Opci&oacute;n 1
              </a>
              <!--[if gte IE 7]><!--><!--<![endif]--><!--[if lte IE 6]>
              <table>
                  <tr>
                      <td>
                          <![endif]-->
                          <ul id="subnavlist" class="dropdown-menu">
                              <li><a href="#">Sub-opción 1</a></li>
                        <li><a href="#">Sub-opci&oacute;n 2</a></li>
                        <li><a href="#">Sub-opci&oacute;n 3</a></li>
                        <li><a href="#">Sub-opci&oacute;n 4</a></li>
                          </ul>
                          <!--[if lte IE 6]>
                      </td>
                  </tr>
              </table>
              </a><![endif]-->
          </li>
          <li class="nav-item">
              <a class="a1 nav-link" data-hover="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                  <div class="oIcono opci&oacute;n1"></div>
                  Opci&oacute;n 2
              </a>
              <ul id="subnavlist" class="dropdown-menu">
                  <li><a href="#">Sub-opci&oacute;n 1</a></li>
                <li><a href="#">Sub-opci&oacute;n 2</a></li>
              </ul>
              <!--[if gte IE 7]><!--><!--<![endif]-->
          </li>
          <li class="nav-item">
              <a class="a3 nav-link" href="plantillas.php">
                  <div class="oIcono opci&oacute;n3"></div>
                  Opci&oacute;n 3
              </a>
              <!--[if gte IE 7]><!--><!--<![endif]-->
          </li>
      </ul>
  </div>
</nav>
<div class="container c-principal">
   <div class="row p-contenido">
      <div class="col-xl-3 col-lg-4 col-md-4 col-xs-12 sidebar">
         <h2>Men&uacute;</h2>
         <div id="navcontainer">
            <ul id="navlist">
               <li>
                  <a href="#">Inicio</a>
                  <ul id="navlist">
                     <li><a href="#">Opci&oacute;n 1</a></li>
                     <li><a href="#">Opci&oacute;n 2</a></li>
                     <li><a href="#">Opci&oacute;n 3</a></li>
                  </ul>
               </li>
               <li>
                  <a href="#">Parte dos</a>
                  <ul id="navlist">
                     <li><a href="#">Ejemplo 1</a></li>
                     <li><a href="#">Ejemplo 2</a></li>
                  </ul>
               </li>
               <li><a href="#">Otra parte</a></li>
            </ul>
         </div>
      </div>
      <!-- <div class="col-xl-9 col-lg-8 col-md-8 col-xs-12 main"> <--Con  contenido izquierdo o derecho uno de los dos
         <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 main"> <--Pagina completa -->
      <div class="col-xl-6 col-lg-4 col-md-4 col-xs-12 main">
         <!--Con contenido izquierdo y derecho -->
         <div class="row">
            <div class="col-12">
               <form action="#">
                  <div class="form-group">
                     <label for="nombre">Nombre</label>
                     <input class="form-control" type="text" placeholder="Nombre" name="nombre" required >
                  </div>
                  <div class="form-group">
                     <label for="correo">Correo</label>
                     <input class="form-control" type="email" placeholder="Correo" name="correo" required>
                  </div>
                  <div class="form-group">
                     <label for="contrasena">Contrase&ntilde;a</label>
                     <input class="form-control" type="password" placeholder="Contrase&ntilde;a" name="contrasena" required>
                  </div>
                  <div class="form-group">
                     <label>Dependencia</label>
                     <select class="form-control">
                        <option value="1">opci&oacute;n 1</option>
                        <option value="2">opci&oacute;n 2</option>
                        <option value="3">opci&oacute;n 3</option>
                     </select>
                  </div>
                  <div class="form-check">
                     <input type="radio" name="radioEjemplo" class="form-check-input">
                     <label class="form-check-label">Radio 1 </label>
                  </div>
                  <div class="form-check">
                     <input type="radio" name="radioEjemplo" class="form-check-input">
                     <label class="form-check-label">Radio 2 </label>
                  </div>
                  <div class="form-check">
                     <input type="checkbox" name="check1" class="form-check-input">
                     <label class="form-check-label">checkbox 1 </label>
                  </div>
                  <div class="form-check">
                     <input type="checkbox" name="check1" class="form-check-input">
                     <label class="form-check-label">checkbox 2 </label>
                  </div>
									<div class="form-group">
										<label for="">Ejemplo textarea</label>
										<textarea class="form-control" rows="3" required></textarea>
									</div>
                  <div class="form-group">
                     <button type="submit" name="button" class="btn btn-success">Enviar</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-lg-4 col-md-4 col-xs-12 sidebar">
         <button type="button" name="button" class="btn  btn-primary" data-toggle="modal" data-target="#modal">Modal</button>
      </div>
   </div>
   <div class="row p-inferior">
      <div class="col-md-12 p-content"></div>
   </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <p>Modal Body</p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
         </div>
      </div>
   </div>
</div>
<?php
   $header = fopen('https://www.ucol.mx/cms/footerapp2.php','rb');
   echo stream_get_contents($header);
   ?>
