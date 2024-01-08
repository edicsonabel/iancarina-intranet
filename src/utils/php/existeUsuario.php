<?php

require_once(__DIR__ . '/../../../databases.php');

function existeUsuario($user)
{
  $query = "SELECT COUNT(usuario) as exist FROM USUARIO WITH (NOLOCK) WHERE USUARIO='$user'";
  $exist = false;
  $conn = $PREGRADO_LY->getConnection();

  try {
    $res = $conn->prepare($query);
    $res->execute();
    $exist = $res->fetch(PDO::FETCH_ASSOC)['exist'] > 0;
    return $exist;
  } catch (Exception $e) {
    return null;
  }
}
