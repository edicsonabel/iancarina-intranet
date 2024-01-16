<?php
require_once __DIR__ . '/../../../databases.php';
require_once __DIR__ . '/../../utils/php/trims.php';

function getNews($dep = 'all', $page = 1, $limit = 6, $sort = 'fecha')
{
  global $DB_MARY;

  $offset = ($page - 1) * $limit;
  /* Conexión */
  $DB_MARY_CONNECTION = $DB_MARY->getConnection();
  if ($dep === 'all') {
    $query = "SELECT * FROM noticias ORDER BY $sort DESC OFFSET $offset ROWS FETCH NEXT $limit ROWS ONLY";
    $queryCount = "SELECT COUNT(id) AS count FROM noticias";
  } else {
    $query = "SELECT * FROM noticias WHERE departamento IN ('$dep') ORDER BY $sort DESC OFFSET $offset ROWS FETCH NEXT $limit ROWS ONLY";
    $queryCount = "SELECT COUNT(id) AS count FROM noticias WHERE departamento IN ('$dep')";
  }

  /* Respuesta */
  $res = $DB_MARY_CONNECTION->prepare($query);
  try {
    $res->execute();
  } catch (Exception $e) {
    $arrError = [
      'status' => 400,
      'error' => 'No se pudo seleccionar las noticias'
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
        'error' => 'No se pudo seleccionar la cantidad de noticias'
      ];
    }
    $countNews = $res->fetch(PDO::FETCH_ASSOC)['count'];
    $pagination = ceil($countNews / $limit);
  }


  return ['news' => $data, 'active' => $page, 'pagination' => $pagination];
}

function getNewByID($id)
{
  global $DB_MARY;

  /* Conexión */
  $DB_MARY_CONNECTION = $DB_MARY->getConnection();
  $query = "SELECT * FROM Noticias WITH (NOLOCK) WHERE id='$id'";

  /* Respuesta */
  $res = $DB_MARY_CONNECTION->prepare($query);
  try {
    $res->execute();
  } catch (Exception $e) {
    $arrError = [
      'status' => 400,
      'error' => 'No se pudo seleccionar al usuario'
    ];
  }

  $data = $res->fetch(PDO::FETCH_ASSOC);

  if ($data) {
    $dtNew = str_replace(' ', 'T', $data['Fecha']);
    $queryNext = "SELECT TOP 1 id AS next FROM Noticias WITH (NOLOCK) WHERE id<>'$id' AND Fecha > '$dtNew' ORDER BY Fecha ASC";
    $queryPrev = "SELECT TOP 1 id AS prev FROM Noticias WITH (NOLOCK) WHERE id<>'$id' AND Fecha < '$dtNew' ORDER BY Fecha DESC";

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
