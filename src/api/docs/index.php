<?php

$pathLogin = 'none';
require_once(__DIR__ . '/../../../databases.php');
// require_once(__DIR__ . '/../../utils/php/verifySession.php');
require_once(__DIR__ . '/../../utils/php/isType.php');
require_once(__DIR__ . '/../../utils/php/trims.php');

/* Definiendo zona horaria */
date_default_timezone_set('America/Caracas');

/* Arrays de respuestas */
$arrError = false;
$arrSuccess = [];

/* Conexión */
$DB_MARY_CONNECTION = $DB_MARY->getConnection();

if (!$DB_MARY_CONNECTION) {
  $arrError = [
    'status' => 500,
    'error' => 'Lo siento, tenemos problemas con nuestra base de datos'
  ];
}

/* Datos de la request */
$isPOST = $_SERVER['REQUEST_METHOD'] === 'POST';

if (!$arrError && !$isPOST) {
  $arrError = [
    'status' => 400,
    'error' => 'Método incorrecto'
  ];
}

/* Realizar de acuerdo al método */
if (!$arrError) {
  $_POST = json_decode(file_get_contents('php://input'), true);

  /* Validando parámetros */
  $offset = isset($_POST['offset']) ? (int)trim($_POST['offset']) : 0;
  $limit = isset($_POST['limit']) ? (int)trim($_POST['limit']) : 6;
  $sort = isset($_POST['sort']) ? trim($_POST['sort']) : 'Numero';

  $queryUsers = "SELECT email_address, names, surnames FROM PI_STUDENTS";

  /* Acciones */
  switch ($method) {
    case 'GET':

      /* Validación de usuario */
      if (!$user || isTypeSQLInjection($user) || !isTypeEmail($user)) {
        $arrError = [
          'status' => 400,
          'error' => "Debe ingresar un correo válido"
        ];
        break;
      }

      /* Validación de password */
      if (!$password || isTypeSQLInjection($password)) {
        $arrError = [
          'status' => 400,
          'error' => "Debe ingresar una contraseña válida"
        ];
        break;
      }

      $query = "SELECT email_address, names, surnames FROM PI_STUDENTS WITH (NOLOCK) WHERE email_address = '$user' AND password COLLATE Latin1_General_CS_AS = '$password'";

      /* Respuesta */
      $res = $DB_MARY_CONNECTION->prepare($query);
      try {
        $res->execute();
      } catch (Exception $e) {
        $arrError = [
          'status' => 400,
          'error' => 'No se pudo seleccionar al usuario'
        ];
        break;
      }

      $data = $res->fetch(PDO::FETCH_ASSOC);
      $data = $data ? trimObject($data) : false;

      if (!$data) {
        $arrError = [
          'status' => 404,
          'error' => 'El correo o contraseña no son válidos',
        ];
        break;
      }

      $arrSuccess = [
        'status' => 200,
        'results' => [
          'name' => $data['names'] . ' ' . $data['surnames']
        ]
      ];
      break;

    default:
      $arrError = [
        'status' => 405,
        'error' => 'Este endpoint no soporta el método "' . $method . '"',
      ];
      break;
  }
}

if (!$arrError) {
  $arrResponse = $arrSuccess;
} else {
  $arrResponse = $arrError;
}

$arrResponse['status'] = (int) $arrResponse['status'];

header('Content-Type: application/json; charset=utf-8');
echo json_encode($arrResponse, http_response_code($arrResponse['status']));
exit();
