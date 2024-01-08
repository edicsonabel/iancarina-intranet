<?php
require_once(__DIR__ . '/../../../config.php');
require_once(__DIR__ . '/../../../databases.php');

$pathLogin = isset($pathLogin) && $pathLogin ? $pathLogin : '../login/';
$pathHome = isset($pathHome) && $pathHome ? $pathHome : false;
$currentUser = false;
$isAdmin = false;

if (!empty($_COOKIE[COOKIE_LOGIN]) && $PREGRADO_LY::verifyToken($_COOKIE[COOKIE_LOGIN])) {
  $currentUser = $PREGRADO_LY::verifyToken($_COOKIE[COOKIE_LOGIN]);

  /* Verificando si es administrador */
  $usuario = $currentUser['user'];
  $query = "SELECT COUNT(USUARIO) AS isAdmin FROM PADUSUARIO WITH (NOLOCK) WHERE USUARIO IN ('$usuario') AND PADACES IN ('NI_DACE')";

  try {
    $conn = $PREGRADO_LY->getConnection();
    $res = $conn->prepare($query);
    $res->execute();
    $arrUser = $res->fetch(PDO::FETCH_ASSOC);
    $isAdmin = $arrUser['isAdmin'] > 0;
  } catch (Exception $e) {
    $isAdmin = false;
  }
}

if ($pathLogin !== 'none' && !$currentUser) {
  header("Location: $pathLogin");
  exit();
}

if ($pathHome && $currentUser) {
  header("Location: $pathHome");
  exit();
}
