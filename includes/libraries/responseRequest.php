<?php  
  function responseRequest($code, $message, $finishConnection = false) {
    http_response_code($code);
    echo json_encode(["error" => $message]);

    if($finishConnection)
      die();
  }
?>