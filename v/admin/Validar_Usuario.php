<?php
require_once 'conexion.php';

// Verificar si se ha recibido la solicitud POST con los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $usuario = $_POST['usuario_login'];
    $clave = $_POST['clave_login'];

    // Verificar los datos del usuario en la base de datos
    $sql = "SELECT * FROM usuarios WHERE usuario = :usuario AND clave = :clave";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':clave', $clave);
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        // El usuario ha iniciado sesión correctamente
        // Crear las variables de sesión
        session_start();
        $_SESSION['Usuario'] = $result['usuario'];
        $_SESSION['Departamento'] = $result['departamento'];
        $_SESSION['Nivel'] = $result['nivel'];
        $_SESSION['last_activity'] = time();

        // Devolver la respuesta en formato JSON
        $res = [
            'status' => 200,
            'message' => 'Inicio de sesión exitoso'
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
    } else {
        // No se ha encontrado al usuario en la base de datos
        $res = [
            'status' => 404,
            'message' => 'Usuario no encontrado'
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
    }
}
