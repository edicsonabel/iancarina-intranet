<?php
require_once('conexion.php');
require_once __DIR__ . '/php/slugify.php';
session_start();
// $_SESSION['Departamento'] = "Tecnologia";

if (isset($_GET['promocion_id'])) {
    $promocion_id = $_GET['promocion_id'];
    // Preparar la consulta SQL con marcadores de posición
    $sql = "SELECT id, trabajador, descripcion, ubicacion FROM promociones WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id', $promocion_id);
    // Ejecutar la consulta
    $stmt->execute();
    // Obtener los resultados
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


    if ($results) {
        $res = [
            'status' => 200,
            'message' => 'Promocion obtenida exitosamente',
            'data' => $results
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 404,
            'message' => 'Promocion no encontrada'
        ];
        echo json_encode($res);
        return;
    }
}

if (isset($_POST['eliminar_promocion'])) {
    $promocion_id = $_POST['promocion_id'];

    // Buscar el nombre actual del documento
    $stmt_doc = $conexion->prepare("SELECT ubicacion FROM promociones WHERE id = :promocion_id");
    $stmt_doc->bindParam(':promocion_id', $promocion_id);
    $stmt_doc->execute();
    $rutaDocumento = $stmt_doc->fetchColumn();

    if ($rutaDocumento && unlink($rutaDocumento)) {
        // El documento se ha eliminado correctamente
        $sql = "DELETE FROM promociones WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $promocion_id);

        if ($stmt->execute()) {
            $rowsDeleted = $stmt->rowCount();  // Verificar el número de filas eliminadas

            if ($rowsDeleted > 0) {
                $res = [
                    'status' => 200,
                    'message' => 'Promocion eliminada correctamente'
                ];
                header('Content-Type: application/json');
                echo json_encode($res);
            } else {
                $res = [
                    'status' => 404,
                    'message' => 'No se encontró la promocion a eliminar'
                ];
                header('Content-Type: application/json');
                echo json_encode($res);
            }
        } else {
            $res = [
                'status' => 500,
                'message' => 'Error al eliminar el documento'
            ];
            header('Content-Type: application/json');
            echo json_encode($res);
        }
    } else {
        $res = [
            'status' => 500,
            'message' => 'Error al eliminar el documento'
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
    }
}

if (isset($_POST['crear_promocion'])) {
    $trabajador = $_POST['trabajador'];
    $descripcion = $_POST['descripcion'];

    if ($trabajador == '' || $descripcion == '') {
        $res = [
            'status' => 422,
            'message' => 'Todos los campos son obligatorios'
        ];
        echo json_encode($res);
        return;
    }

    // Verificar si se recibió correctamente el archivo adjunto
    if (isset($_FILES['documento']) && $_FILES['documento']['error'] === UPLOAD_ERR_OK) {
        $documento = $_FILES['documento'];

        // Validar la extensión del archivo
        $allowedExtensions = array('.pdf', '.doc', '.docx');
        $fileExtension = strtolower(strrchr($documento['name'], '.'));
        if (!in_array($fileExtension, $allowedExtensions)) {
            $res = [
                'status' => 422,
                'message' => 'La extensión del archivo no es válida'
            ];
            echo json_encode($res);
            return;
        }

        // Validar el tamaño del archivo (en bytes)
        $maxSizeInBytes = 5242880; // 5 MB
        if ($documento['size'] > $maxSizeInBytes) {
            $res = [
                'status' => 422,
                'message' => 'El tamaño del archivo supera el límite permitido'
            ];
            echo json_encode($res);
            return;
        }

        // Obtener el nombre del archivo y cambiarlo por el título
        $nombreArchivo = slugify($trabajador) . $fileExtension;
        $rutaArchivo = '../../files/Promociones/' . $nombreArchivo;

        /* verificar si existe el archivo en la base de datos */
        $query = "SELECT COUNT(id) AS exist FROM promociones WHERE ubicacion='$rutaArchivo'";
        $stmt = $conexion->prepare($query);
        try {
            $stmt->execute();
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if (isset($res['exist']) && $res['exist'] > 0) {
                $res = [
                    'status' => 422,
                    'message' => 'El título de la promocion ya se encuentra registrado'
                ];
                echo json_encode($res);
                return;
            }
        } catch (\Throwable $th) {
            $res = [
                'status' => 422,
                'message' => 'Error al verificar si existe la promocion'
            ];
            echo json_encode($res);
            return;
        }

        // Mover el archivo a la carpeta de destino
        if (!move_uploaded_file($documento['tmp_name'], $rutaArchivo)) {
            $res = [
                'status' => 500,
                'message' => 'Error al mover el archivo a la carpeta de destino'
            ];
            echo json_encode($res);
            return;
        }
    } else {
        $res = [
            'status' => 422,
            'message' => 'No se recibió el archivo adjunto'
        ];
        echo json_encode($res);
        return;
    }

    // Preparar la consulta SQL con marcadores de posición
    $sql = "INSERT INTO promociones (trabajador, descripcion, ubicacion) VALUES (:trabajador, :descripcion, :ubicacion)";
    $stmt = $conexion->prepare($sql);

    // Asociar los valores a los marcadores de posición
    $stmt->bindParam(':trabajador', $trabajador);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':ubicacion', $rutaArchivo);


    if ($stmt->execute()) {
        $rowsInserted = $stmt->rowCount(); // Obtener el número de filas afectadas

        if ($rowsInserted > 0) {
            $res = [
                'status' => 200,
                'message' => 'Promocion creada exitosamente'
            ];
            header('Content-Type: application/json');
            echo json_encode($res);
        } else {
            $res = [
                'status' => 500,
                'message' => 'Error al crear la promocion'
            ];
            header('Content-Type: application/json');
            echo json_encode($res);
        }
    } else {
        $res = [
            'status' => 500,
            'message' => 'Error al crear promocion'
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
    }
}

if (isset($_POST['editar_promocion'])) {
    $promocion_id = $_POST['promocion_id'];
    $trabajador = $_POST['trabajador_edit'];
    $descripcion = $_POST['descripcion_edit'];

    if ($trabajador == '' || $descripcion == '' || $promocion_id == '') {
        $res = [
            'status' => 422,
            'message' => 'El título y la descripción son obligatorios'
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
        return;
    }

    // Verificar si se recibió correctamente un nuevo archivo adjunto
    if (isset($_FILES['documento_edit']) && $_FILES['documento_edit']['error'] === UPLOAD_ERR_OK) {
        $documento = $_FILES['documento_edit'];

        // Validar la extensión del archivo
        $allowedExtensions = array('.pdf', '.doc', '.docx');
        $fileExtension = strtolower(strrchr($documento['name'], '.'));
        if (!in_array($fileExtension, $allowedExtensions)) {
            $res = [
                'status' => 422,
                'message' => 'La extensión del archivo no es válida'
            ];
            echo json_encode($res);
            return;
        }

        // Validar el tamaño del archivo (en bytes)
        $maxSizeInBytes = 5242880; // 5 MB
        if ($documento['size'] > $maxSizeInBytes) {
            $res = [
                'status' => 422,
                'message' => 'El tamaño del archivo supera el límite permitido'
            ];
            echo json_encode($res);
            return;
        }

        // Buscar y eliminar el documento anterior
        $stmt_doc = $conexion->prepare("SELECT ubicacion FROM promociones WHERE id = :promocion_id");
        $stmt_doc->bindParam(':promocion_id', $promocion_id);
        $stmt_doc->execute();
        $rutaDocumentoAntigua = $stmt_doc->fetchColumn();

        // Obtener el nombre del archivo y cambiarlo por el título
        $nombreArchivo = slugify($trabajador) . $fileExtension;
        $rutaArchivo = '../../files/Promociones/' . $nombreArchivo;

        /* verificar si existe el archivo en la base de datos */
        if ($rutaDocumentoAntigua !== $rutaArchivo) {
            $query = "SELECT COUNT(id) AS exist FROM promociones WHERE ubicacion='$rutaArchivo'";
            $stmt = $conexion->prepare($query);
            try {
                $stmt->execute();
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                if (isset($res['exist']) && $res['exist'] > 0) {
                    $res = [
                        'status' => 422,
                        'message' => 'El título de la promocion ya se encuentra registrado'
                    ];
                    echo json_encode($res);
                    return;
                }
            } catch (\Throwable $th) {
                $res = [
                    'status' => 422,
                    'message' => 'Error al verificar si existe la promocion'
                ];
                echo json_encode($res);
                return;
            }
        }

        // Eliminar el documento antiguo
        if (file_exists($rutaDocumentoAntigua)) {
            unlink($rutaDocumentoAntigua);
        }

        // Mover el archivo a la carpeta de destino
        if (!move_uploaded_file($documento['tmp_name'], $rutaArchivo)) {
            $res = [
                'status' => 500,
                'message' => 'Error al mover el archivo a la carpeta de destino'
            ];
            echo json_encode($res);
            return;
        }

        $sql = "UPDATE promociones SET trabajador = :trabajador,  descripcion = :descripcion, ubicacion = :ubicacion WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':trabajador', $trabajador);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':ubicacion', $rutaArchivo);
        $stmt->bindParam(':id', $promocion_id);

        if ($stmt->execute()) {
            // Actualización exitosa
            $res = [
                'status' => 200,
                'message' => 'Documento actualizado correctamente'
            ];
            echo json_encode($res);
            return;
        } else {
            // Error en la actualización
            $res = [
                'status' => 500,
                'message' => 'Error al actualizar el documento'
            ];
            echo json_encode($res);
            return;
        }
    } else {
        // Si no se recibió un nuevo archivo adjunto, actualiza solo el título y la descripción en la base de datos
        // Buscar el nombre actual del documento
        $stmt_doc = $conexion->prepare("SELECT ubicacion FROM promociones WHERE id = :promocion_id");
        $stmt_doc->bindParam(':promocion_id', $promocion_id);
        $stmt_doc->execute();
        $rutaDocumento = $stmt_doc->fetchColumn();
        $extension = substr($rutaDocumento, strrpos($rutaDocumento, '.') + 1);
        // Renombramos el documento
        $rutaDocumentoNueva = '../../files/Promociones/' . slugify($trabajador) . '.' . $extension;

        /* verificar si existe el archivo en la base de datos */
        if ($rutaDocumento !== $rutaDocumentoNueva) {
            $query = "SELECT COUNT(id) AS exist FROM promociones WHERE ubicacion='$rutaDocumentoNueva'";
            $stmt = $conexion->prepare($query);
            try {
                $stmt->execute();
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                if (isset($res['exist']) && $res['exist'] > 0) {
                    $res = [
                        'status' => 422,
                        'message' => 'El título de la promocion ya se encuentra registrado'
                    ];
                    echo json_encode($res);
                    return;
                }
            } catch (\Throwable $th) {
                $res = [
                    'status' => 422,
                    'message' => 'Error al verificar si existe el documento'
                ];
                echo json_encode($res);
                return;
            }
        }

        rename($rutaDocumento, $rutaDocumentoNueva);

        $sql = "UPDATE promociones SET trabajador = :trabajador, descripcion = :descripcion, ubicacion = :ubicacion WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':trabajador', $trabajador);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':ubicacion', $rutaDocumentoNueva);
        $stmt->bindParam(':id', $promocion_id);
        if ($stmt->execute()) {
            // Actualización exitosa
            $res = [
                'status' => 200,
                'message' => 'Documento editado exitosamente (sin cambios en el archivo)'
            ];
            header('Content-Type: application/json');
            echo json_encode($res);
            return;
        } else {
            // Error en la actualización
            $res = [
                'status' => 500,
                'message' => 'Error al actualizar el documento'
            ];
            header('Content-Type: application/json');
            echo json_encode($res);
            return;
        }
    }
}
