<?php
/* Includes */
require_once(__DIR__ . '/../../../config.php');

/* Connection MySQL */
class Connection
{
  protected $SERVER = '';
  protected $NAME = '';
  protected $USER = '';
  protected $PASS = '';
  protected $CHARSET = '';

  public function __construct(
    $server,
    $name,
    $user,
    $pass,
    $charset = 'utf8mb4'
  ) {
    $this->SERVER = $server;
    $this->NAME = $name;
    $this->USER = $user;
    $this->PASS = $pass;
    $this->CHARSET = $charset;
  }

  public function getConnection()
  {
    $conn = null;
    try {
      /* SQL Server */
      // $connection = 'sqlsrv:Server=' . $this->SERVER . ';Database=' . $this->NAME . ';TrustServerCertificate=true';

      /* PostgreSQL */
      // $connection = 'pgsql:host=' . $this->SERVER . ';dbname=' . $this->NAME . '';

      /* MySQL */
      $connection = 'mysql:host=' . $this->SERVER  . ';dbname=' . $this->NAME  . ';charset=' . $this->CHARSET;

      /* Options */
      $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES   => false,
      ];

      /* Connection variable */
      $conn = new PDO($connection, $this->USER, $this->PASS, $options);
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
}


/* Connection PostgreSQL */
class ConnectionPG
{
  protected $SERVER = '';
  protected $NAME = '';
  protected $USER = '';
  protected $PASS = '';
  protected $PORT = '';

  public function __construct(
    $server,
    $name,
    $user,
    $pass,
    $port = '5432'
  ) {
    $this->SERVER = $server;
    $this->NAME = $name;
    $this->USER = $user;
    $this->PASS = $pass;
    $this->PORT = $port;
  }

  public function getConnection()
  {
    $conn = null;
    try {
      /* SQL Server */
      // $connection = 'sqlsrv:Server=' . $this->SERVER . ';Database=' . $this->NAME . ';TrustServerCertificate=true';

      /* PostgreSQL */
      $connection = 'pgsql:host=' . $this->SERVER . ';port=' . $this->PORT . ';dbname=' . $this->NAME . '';

      /* MySQL */
      // $connection = 'mysql:host=' . $this->SERVER  . ';dbname=' . $this->NAME  . ';charset=' . $this->CHARSET;

      /* Options */
      $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES   => false,
      ];

      /* Connection variable */
      $conn = new PDO($connection, $this->USER, $this->PASS, $options);
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
}
