<?php
require_once('conexion.php');

if (isset($_POST['crear_usuario'])) {
    $usuario = $_POST['usuario'];
    $nombre = $_POST['nombre'];
    $depto = $_POST['depto'];
    $clave = $_POST['clave'];
    $nivel = $_POST['nivel'];

    if ($usuario == NULL || $nombre == NULL || $depto == NULL || $clave == NULL || $nivel == NULL) {
        $res = [
            'status' => 422,
            'message' => 'Todos los campos son obligatorios'
        ];
        echo json_encode($res);
        return;
    }

    // Preparar la consulta SQL con marcadores de posición
    $sql = "INSERT INTO usuarios (usuario, clave, nombre, departamento, nivel) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    // Asociar los valores a los marcadores de posición
    $stmt->bindValue(1, $usuario);
    $stmt->bindValue(2, $clave);
    $stmt->bindValue(3, $nombre);
    $stmt->bindValue(4, $depto);
    $stmt->bindValue(5, $nivel);

    if ($stmt->execute()) {
        $rowsInserted = $stmt->rowCount(); // Verificar el número de filas insertadas

        if ($rowsInserted > 0) {
            $res = [
                'status' => 200,
                'message' => 'Usuario creado exitosamente'
            ];
            echo json_encode($res);
        } else {
            $res = [
                'status' => 500,
                'message' => 'Error al crear el usuario'
            ];
            echo json_encode($res);
        }
    } else {
        $res = [
            'status' => 500,
            'message' => 'Error al crear el usuario'
        ];
        echo json_encode($res);
    }
}

if (isset($_GET['usuario_id'])) {
    $usuario_id = $_GET['usuario_id'];

    // Preparar la consulta SQL con marcadores de posición
    $sql = "SELECT nombre, departamento, nivel, clave FROM usuarios WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $usuario_id);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        $res = [
            'status' => 200,
            'message' => 'Usuario obtenido exitosamente',
            'data' => $results
        ];
        echo json_encode($res);
    } else {
        $res = [
            'status' => 404,
            'message' => 'Usuario no encontrado'
        ];
        echo json_encode($res);
    }
}

if (isset($_POST['editar_usuario'])) {
    $usuario_id = $_POST['usuario_id'];
    $nombre = $_POST['nombre_edit'];
    $depto = $_POST['depto_edit'];
    $clave = $_POST['clave_edit'];
    $nivel = $_POST['nivel_edit'];

    if ($nombre == NULL || empty($depto) || $clave == NULL || $nivel == NULL) {
        $res = [
            'status' => 422,
            'message' => 'Todos los campos son obligatorios'
        ];
        echo json_encode($res);
        return;
    }

    $sql = "UPDATE usuarios SET nombre = ?, departamento = ?, clave = ?, nivel = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);

    // Ejecutar la consulta con los valores pasados directamente en el método execute()
    if ($stmt->execute([$nombre, $depto, $clave, $nivel, $usuario_id])) {
        // Actualización exitosa
        $res = [
            'status' => 200,
            'message' => 'Usuario actualizado correctamente'
        ];
        echo json_encode($res);
    } else {
        // Error en la actualización
        $res = [
            'status' => 500,
            'message' => 'Error al actualizar el usuario'
        ];
        echo json_encode($res);
    }
}

if (isset($_POST['eliminar_usuario'])) {
    $usuario_id = $_POST['usuario_id'];

    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conexion->prepare($sql);

    // Ejecutar la consulta con el valor pasado directamente en el método execute()
    if ($stmt->execute([$usuario_id])) {
        // Eliminación exitosa
        $res = [
            'status' => 200,
            'message' => 'Usuario eliminado correctamente'
        ];
        echo json_encode($res);
    } else {
        // Error en la eliminación
        $res = [
            'status' => 500,
            'message' => 'Error al eliminar el usuario'
        ];
        echo json_encode($res);
    }
}
