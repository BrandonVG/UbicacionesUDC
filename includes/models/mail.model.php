<?php  
  class Mail {
    private static $messageHead =
      '<html>
      <head>
        <title>Sistema de ubicaciones</title>
      </head>';

    private static $messageFoot = 
      '<footer>
        <br>Este correo es generado automáticamente, favor de no responderlo.<br>
        <hr>
        <div style="text-align: center;"> 
          Universidad de Colima
        </div>
      </footer>
      </html>';

    private static $headers = array(
      'MIME-Version: 1.0',
      'Content-type: text/html; charset=utf-8',
      'From: no-reply <sistemas@ucol.mx>',
      'BCC: sistemas@ucol.mx',
      'BCC: crodriguez20@ucol.mx',
      'BCC: bmosqueda@ucol.mx'
    );

    //Se envía un correo a todos los validadores de ese sitio
    public static function ubicacionEnviada($ubicacion) {
      $msg = self::$messageHead .
      '<body>
        <h1 style="color: black">Universidad de Colima</h1>
        Su solicitud de creación de la ubicación con título "<strong style="color: #000">'.$ubicacion->titulo.'</strong>" ya fue enviada al validador. Después de su valoración, le llegará un correo que le informará el estatus.<br>
      </body>' .
      self::$messageFoot;
      $subject = '[sis-ucol] Solicitud de creación de ubicación';

      if(isset($_SESSION['noCorreo']))
        return true;

      return mail($_SESSION['uCorreo'], $subject, $msg, implode("\r\n", self::$headers));
    }

    public static function ubicacionRecibidaValidadores($ubicacion, $urlSitio) {
      $validadores = Ubicacion::getCorreosValidadoresByIdSitio($ubicacion->idSitio);
      $url = "https://".$_SERVER['SERVER_NAME']."/ubicaciones/";

      $msg = self::$messageHead.
        '<body>
          <h1 style="color: black">Universidad de Colima</h1>
          Usted ha recibido una nueva solicitud de registro de ubicación, para evaluar su aprobación, favor de ingresar al siguiente enlace: 
          <a href="'.$url.$urlSitio.'/validar">'.$url.$urlSitio.'/validar</a><br>
          Información de la ubicación:<br>
          Etiqueta: "<strong style="color: #000">' . $ubicacion->etiqueta . '</strong>"<br>
          Título: "<strong style="color: #000">' . $ubicacion->titulo . '</strong>"<br>
        </body>' .
        self::$messageFoot;
        $subject = '[sis-ucol] Solicitud de creación de ubicación';

      if(isset($_SESSION['noCorreo']))
        return true;

      if(EN_TESTING) 
        return mail('bmosqueda@ucol.mx,gcruz@ucol.mx,crodriguez20@ucol.mx', $subject, $msg, implode("\r\n", self::$headers));
      else
        foreach ($validadores as $validador)
          return mail($validador->correo, $subject, $msg, implode("\r\n", self::$headers));
    }

    public static function ubicacionRechazadaEditores($ubicacion, $motivo = false, $editor = false) {
      $editores = Ubicacion::getCorreosEditoresByIdSitio($ubicacion->idSitio);
      if($editor)
        array_push($editores, $editor);

      if($motivo)
        $motivo = "Motivo: ".$motivo;

      $msg = self::$messageHead .
      '<body>
        <h1 style="color: black">Universidad de Colima</h1>
        El registro de la ubicación "<strong style="color: #000">'.$ubicacion->titulo.'</strong>" ha sido rechazado por incumplir con los lineamientos. Favor de verificar nuevamente los criterios de aprobación.<br>
        '.$motivo.'<br>
      </body>' .
      self::$messageFoot;
      $subject = '[sis-ucol] Cancelación de ubicación';

      if(isset($_SESSION['noCorreo']))
        return true;

      if(EN_TESTING)
        return mail('bmosqueda@ucol.mx,gcruz@ucol.mx,crodriguez20@ucol.mx', $subject, $msg, implode("\r\n", self::$headers));
      else
        foreach ($editores as $editor) {
          return mail($editor->correo, $subject, $msg, implode("\r\n", self::$headers));
        }
    }

    public static function ubicacionAceptadaEditores($ubicacion) {
      $editores = Ubicacion::getCorreosEditoresByIdSitio($ubicacion->idSitio);

      $msg = self::$messageHead .
      '<body>
        <h1 style="color: black">Universidad de Colima</h1>
        Se le informa que la publicación de la ubicación "<strong style="color: #000">'.$ubicacion->titulo.'</strong>" ha sido aceptada.<br>
      </body>' .
      self::$messageFoot;
      $subject = '[sis-ucol] Publicación de la ubicación aceptada';

      if(isset($_SESSION['noCorreo']))
        return true;

      if(EN_TESTING)
        return mail('bmosqueda@ucol.mx,gcruz@ucol.mx,crodriguez20@ucol.mx', $subject, $msg, implode("\r\n", self::$headers));
      else
        foreach ($editores as $editor) {
          return mail($editor->correo, $subject, $msg, implode("\r\n", self::$headers));
        }
    }

    public static function test($correo) {
      $msg = self::$messageHead .
      '<body>
        <h1 style="color: black">Universidad de Colima</h1>
        Su solicitud de creación de la ubicación con título "<strong style="color: #000">titulo</strong>" ya fue enviada al validador. Después de su valoración, le llegará un correo que le informará el estatus de su actividad.<br>
      </body>' .
      self::$messageFoot;
      $subject = '[sis-ucol] Solicitud de creación de ubicación';

      if(isset($_SESSION['noCorreo']))
        return true;
      
      return mail($correo, $subject, $msg, implode("\r\n", self::$headers));
    }
  }
?>