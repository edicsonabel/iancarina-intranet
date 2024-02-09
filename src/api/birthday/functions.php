<?php
require_once __DIR__ . '/../../../databases.php';
require_once __DIR__ . '/../../utils/php/trims.php';

function getBirthdayToday()
{
  global $DB_BIRTHDAY;

  /* Conexión */
  $DB_BIRTHDAY_CONNECTION = $DB_BIRTHDAY->getConnection();
  $query = "SELECT *
    FROM general.dw_spi_reh_trabajador a
    WHERE extract(day from NOW()) = extract(day from a.fecha_nacimiento)
    AND extract(month from NOW()) = extract(month from a.fecha_nacimiento)
    AND estatus = '1'
    ORDER BY a.fecha_nacimiento";

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

function getBirthdayMonth()
{
  global $DB_BIRTHDAY;

  /* Conexión */
  $DB_BIRTHDAY_CONNECTION = $DB_BIRTHDAY->getConnection();
  $query = "SELECT *, to_char(fecha_nacimiento, 'DD') AS fecha , to_char(fecha_nacimiento, 'DD-MM') AS fecha_dos  , to_char(fecha_nacimiento, 'MM') AS mes
  FROM general.dw_spi_reh_trabajador WHERE to_char(fecha_nacimiento, 'MM') = '" . date('m') . "'
  AND general.dw_spi_reh_trabajador.estatus='1'
  ORDER BY fecha_dos";

  /* Respuesta */
  $res = $DB_BIRTHDAY_CONNECTION->prepare($query);
  try {
    $res->execute();
  } catch (Exception $e) {
    $arrError = [
      'status' => 400,
      'error' => 'No se pudo seleccionar los cumpleaños'
    ];
  }

  $data = $res->fetchAll(PDO::FETCH_ASSOC);
  $data = $data ? trimArray($data) : false;

  return $data;
}
