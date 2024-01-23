<?php
// class Conexion
// {
//     public static function Conectar()
//     { {
//             define('servidor', '');
//             define('nombrebd', '');
//             define('usuario', '');
//             define('password', '');
//         }


//         try {
//             $conexion = new PDO("mysql:host=" . servidor . ";dbname=" . nombrebd, usuario, password);

//             return $conexion;
//         } catch (PDOException $e) {
//             die("El error de conexión es: " . $e->getMessage());  // captura el mensaje de error de conexión con el servidor
//         }
//     }
// }

// $objeto = new Conexion();
// $conexion = $objeto->Conectar();

require_once __DIR__ . '/../../databases.php';
$objeto = $DB_MARY;
$conexion = $objeto->getConnection();
