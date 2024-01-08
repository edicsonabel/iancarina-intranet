<?php
/* Includes */
require_once(__DIR__ . '/../../../config.php');
require_once(__DIR__ . '/../../libraries/vendor/php-jwt.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/* Connection */

class Connection
{
  protected $SERVER = '';
  protected $NAME = '';
  protected $USER = '';
  protected $PASS = '';

  public function __construct(
    $server,
    $name,
    $user,
    $pass
  ) {
    $this->SERVER = $server;
    $this->NAME = $name;
    $this->USER = $user;
    $this->PASS = $pass;
  }

  public function getConnection()
  {
    $conn = null;
    try {
      $conn = new PDO('sqlsrv:Server=' . $this->SERVER . ';Database=' . $this->NAME . ';TrustServerCertificate=true', $this->USER, $this->PASS);
    } catch (PDOException $e) {
      $data = array(
        'error' => $e->getMessage()
      );
      header('Content-Type: application/json');
      echo json_encode($data);
      $conn = null;
    }
    return $conn;
  }

  static function closeConnection(&$conn)
  {
    $conn = null;
  }

  static function createToken(&$payload)
  {
    return JWT::encode($payload, JWT_SECRET, 'HS256');
  }

  static function verifyToken(&$token)
  {
    try {
      $data =  (array) JWT::decode($token, new Key(JWT_SECRET, 'HS256'));
      return $data;
    } catch (\Throwable $th) {
      return null;
    }
  }
}
