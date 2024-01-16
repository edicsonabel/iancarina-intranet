<?php
require_once __DIR__ . '/../../../databases.php';
require_once __DIR__ . '/../../utils/php/trims.php';

function getDocs($dep = 'all', $sort = 'id')
{
  global $DB_MARY;

  /* Conexión */
  $DB_MARY_CONNECTION = $DB_MARY->getConnection();
  if ($dep === 'all') {
    $query = "SELECT * FROM Documentos ORDER BY $sort DESC";
  } else {
    $query = "SELECT * FROM Documentos WHERE departamento IN ('$dep') ORDER BY $sort DESC";
  }

  /* Respuesta */
  $res = $DB_MARY_CONNECTION->prepare($query);
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

// function getDocByID($id)
// {
//   global $DB_MARY;

//   /* Conexión */
//   $DB_MARY_CONNECTION = $DB_MARY->getConnection();
//   $query = "SELECT * FROM Documentos WHERE id='$id'";

//   /* Respuesta */
//   $res = $DB_MARY_CONNECTION->prepare($query);
//   try {
//     $res->execute();
//   } catch (Exception $e) {
//     $arrError = [
//       'status' => 400,
//       'error' => 'No se pudo el documento'
//     ];
//   }

//   $data = $res->fetch(PDO::FETCH_ASSOC);
//   $data = $data ? trimObject($data) : false;

//   return $data;
// }
