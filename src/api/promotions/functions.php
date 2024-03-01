<?php
require_once __DIR__ . '/../../../databases.php';
require_once __DIR__ . '/../../utils/php/trims.php';

function getPromotions($dep = 'all', $page = 1, $limit = 6, $sort = 'id')
{
  global $DB_MARY;

  $offset = ($page - 1) * $limit;
  /* Conexión */
  $DB_MARY_CONNECTION = $DB_MARY->getConnection();
  if ($dep === 'all') {
    $query = "SELECT * FROM promociones ORDER BY $sort DESC, id DESC LIMIT $offset, $limit;";
    $queryCount = "SELECT COUNT(id) AS count FROM promociones;";
  } else {
    $query = "SELECT * FROM promociones WHERE departamento IN ('$dep') ORDER BY $sort DESC, id DESC LIMIT $offset, $limit;";
    $queryCount = "SELECT COUNT(id) AS count FROM promociones WHERE departamento IN ('$dep');";
  }

  /* Respuesta */
  $res = $DB_MARY_CONNECTION->prepare($query);
  try {
    $res->execute();
  } catch (Exception $e) {
    $arrError = [
      'status' => 400,
      'error' => 'No se pudo seleccionar las promociones'
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
        'error' => 'No se pudo seleccionar la cantidad de promociones'
      ];
    }
    $countPromotions = $res->fetch(PDO::FETCH_ASSOC)['count'];
    $pagination = ceil($countPromotions / $limit);
  } else {
    $pagination = 1;
    $data = [];
  }

  return ['promotions' => $data, 'active' => $page, 'pagination' => $pagination];
}

function getPromotionByID($id, $dep = 'all')
{
  global $DB_MARY;

  /* Conexión */
  $DB_MARY_CONNECTION = $DB_MARY->getConnection();

  $forDep = "";
  if ($dep !== 'all') {
    $forDep = "AND departamento='$dep'";
  }

  $query = "SELECT * FROM promociones WHERE id='$id' $forDep";

  /* Respuesta */
  $res = $DB_MARY_CONNECTION->prepare($query);
  try {
    $res->execute();
  } catch (Exception $e) {
    $arrError = [
      'status' => 400,
      'error' => 'No se pudo seleccionar la promoción'
    ];
  }

  $data = $res->fetch(PDO::FETCH_ASSOC);

  if ($data) {
    $queryNext = "SELECT id AS next FROM promociones WHERE id > '$id' $forDep ORDER BY fecha ASC, id ASC LIMIT 1;";
    $queryPrev = "SELECT id AS prev FROM promociones WHERE id < '$id' $forDep ORDER BY fecha DESC, id DESC LIMIT 1;";

    /* Noticia siguiente */
    $res = $DB_MARY_CONNECTION->prepare($queryNext);
    try {
      $res->execute();
    } catch (Exception $e) {
      $arrError = [
        'status' => 400,
        'error' => 'No se pudo seleccionar la siguiente noticia'
      ];
    }

    $next = $res->fetch(PDO::FETCH_ASSOC)['next'] ?? '';

    /* Noticia anterior */
    $res = $DB_MARY_CONNECTION->prepare($queryPrev);
    try {
      $res->execute();
    } catch (Exception $e) {
      $arrError = [
        'status' => 400,
        'error' => 'No se pudo seleccionar la anterior noticia'
      ];
    }

    $prev = $res->fetch(PDO::FETCH_ASSOC)['prev'] ?? '';

    $data['next'] = $next;
    $data['prev'] = $prev;
  }

  $data = $data ? trimObject($data) : false;

  return $data;
}
