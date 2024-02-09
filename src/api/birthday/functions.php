<?php
require_once __DIR__ . '/../../../databases.php';
require_once __DIR__ . '/../../utils/php/trims.php';

function getBirthday($dep = 'all', $sort = 'fecha_nacimiento')
{
  global $DB_BIRTHDAY;

  /* Conexión */
  $DB_BIRTHDAY_CONNECTION = $DB_BIRTHDAY->getConnection();
  if ($dep === 'all') {
    $query = "SELECT * FROM general.dw_spi_reh_trabajador ORDER BY $sort ASC;";
  } else {
    $query = "SELECT * FROM general.dw_spi_reh_trabajador WHERE departamento IN ('$dep') ORDER BY $sort ASC;";
  }

  /* Respuesta */
  $res = $DB_BIRTHDAY_CONNECTION->prepare($query);
  try {
    $res->execute();
  } catch (Exception $e) {
    $arrError = [
      'status' => 400,
      'error' => 'No se pudo seleccionar los documentos'
    ];
  }

  $data = $res->fetchAll(PDO::FETCH_ASSOC);
  $data = $data ? trimArray($data) : false;

  return $data;
}
