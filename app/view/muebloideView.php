<?php


//Vista para la API REST.

class muebloideAPIView
{

  public function response($data, $status)
  {

    header("Content-Type: application/json");
    header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
    echo json_encode($data);
  }

  private function requestStatus($code)
  {
    $status = array(
      200 => "OK",
      201 => "Agregado con éxito.",
      400 => "Faltan parámetros.",
      401 => "Sin permisos para realizar la acción.",
      403 => "Acceso prohibido.",
      404 => "No encontrado.",
      500 => "Internal Server Error"
    );
    return (isset($status[$code])) ? $status[$code] : $status[500];
  }

}