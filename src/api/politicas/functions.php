<?php
require_once __DIR__ . '/../../../databases.php';
require_once __DIR__ . '/../../utils/php/trims.php';

function getPoliticas($dep = 'all', $page = 1, $limit = 6, $sort = 'id')
{
  global $DB_MARY;

  $offset = ($page - 1) * $limit;
  /* Conexión */
  $DB_MARY_CONNECTION = $DB_MARY->getConnection();
  if ($dep === 'all') {
    $query = "SELECT * FROM e_learning ORDER BY $sort DESC, id DESC LIMIT $offset, $limit;";
    $queryCount = "SELECT COUNT(id) AS count FROM e_learning;";
  } else {
    $query = "SELECT * FROM e_learning WHERE departamento IN ('$dep') ORDER BY $sort DESC, id DESC LIMIT $offset, $limit;";
    $queryCount = "SELECT COUNT(id) AS count FROM e_learning WHERE departamento IN ('$dep');";
  }

  /* Respuesta */
  $res = $DB_MARY_CONNECTION->prepare($query);
  try {
    $res->execute();
  } catch (Exception $e) {
    $arrError = [
      'status' => 400,
      'error' => 'No se pudo seleccionar las políticas'
    ];
  }

  $data = $res->fetchAll(PDO::FETCH_ASSOC);
  $data = $data ? trimArray($data) : false;

  if ($data) {
    $res = $DB_MARY_CONNECTION->prepare($queryCount);
    try {
      $res->execute();
    } catch (Exception $e) {
      $arrError = [
        'status' => 400,
        'error' => 'No se pudo seleccionar la cantidad de políticas'
      ];
    }
    $countPoliticas = $res->fetch(PDO::FETCH_ASSOC)['count'];
    $pagination = ceil($countPoliticas / $limit);
  } else {
    $pagination = 1;
    $data = [];
  }

  return ['politicas' => $data, 'active' => $page, 'pagination' => $pagination];
}
