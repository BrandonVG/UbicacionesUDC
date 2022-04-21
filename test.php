<?php  

  function guardarImagen ($name) {
    $path = '/sftp/content/ubicaciones';

    /*$extension = explode('.', $_FILES['imagen']['name']);
    $extension = array_pop($extension);
    $name = $idSitio.'_'.$id.".".$extension;*/
    if (!file_exists($path)) {
      mkdir($path, 0777);
    }

    $imageUpload = move_uploaded_file("public/default.png", $path.$name);
    return $imageUpload;
  }

  var_dump(guardarImagen("default.png"));
?>