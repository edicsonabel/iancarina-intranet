<?php
require_once(__DIR__ . '/../../../config.php');
require_once(__DIR__ . '/../../../databases.php');

function generateToken($user)
{
  /* La hora actual */
  $time = time();
  $payload = array(
    'user' => $user['USUARIO'],
    'name' => $user['NOMEUSUARIO'],
    'iat' => $time,
    'exp' => $time + 60 * 60 * 10
  );
  global $PREGRADO_LY;

  $token = $PREGRADO_LY::createToken($payload);

  if (defined('COOKIE_SECURE') && COOKIE_SECURE) {
    setcookie(
      COOKIE_LOGIN,
      $token,
      array(
        'expires' => $time + 60 * 60 * 10,
        'path' => '/',
        // 'domain' => '.example.com', // leading dot for compatibility or use subdomain
        'secure' => true,     // or false
        'httponly' => true,    // or false
        'samesite' => 'Strict' // None || Lax  || Strict
      )
    );
  } else {
    setcookie(
      COOKIE_LOGIN,
      $token,
      $time + 60 * 60 * 10,
      '/',
      '',
      false,
      true
    );
  }
}
