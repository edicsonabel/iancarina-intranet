<?php
require_once('conexion.php');
require_once __DIR__ . '/php/slugify.php';
require_once __DIR__ . '/../../config.php';
session_start();
// $_SESSION['Departamento'] = "Tecnologia";

if (isset($_GET['archivo_id'])) {
    $archivo_id = $_GET['archivo_id'];
    // Preparar la consulta SQL con marcadores de posición
    $sql = "SELECT id, titulo, descripcion, ubicacion FROM e_learning  WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id', $archivo_id);
    // Ejecutar la consulta
    $stmt->execute();
    // Obtener los resultados
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


    if ($results) {
        $res = [
            'status' => 200,
            'message' => 'Archivo obtenido exitosamente',
            'data' => $results
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 404,
            'message' => 'Archivo no encontrado'
        ];
        echo json_encode($res);
        return;
    }
}

if (isset($_POST['eliminar_archivo'])) {
    $archivo_id = $_POST['archivo_id'];

    // Buscar el nombre actual del documento
    $stmt_doc = $conexion->prepare("SELECT ubicacion FROM e_learning  WHERE id = :archivo_id");
    $stmt_doc->bindParam(':archivo_id', $archivo_id);
    $stmt_doc->execute();
    $rutaDocumento = $stmt_doc->fetchColumn();

    if ($rutaDocumento && unlink($rutaDocumento)) {
        // El documento se ha eliminado correctamente
        $sql = "DELETE FROM e_learning  WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $archivo_id);

        if ($stmt->execute()) {
            $rowsDeleted = $stmt->rowCount();  // Verificar el número de filas eliminadas

            if ($rowsDeleted > 0) {
                $res = [
                    'status' => 200,
                    'message' => 'Archivo eliminado correctamente'
                ];
                header('Content-Type: application/json');
                echo json_encode($res);
            } else {
                $res = [
                    'status' => 404,
                    'message' => 'No se encontró el archivo a eliminar'
                ];
                header('Content-Type: application/json');
                echo json_encode($res);
            }
        } else {
            $res = [
                'status' => 500,
                'message' => 'Error al eliminar el archivo'
            ];
            header('Content-Type: application/json');
            echo json_encode($res);
        }
    } else {
        $res = [
            'status' => 500,
            'message' => 'Error al eliminar el archivo'
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
    }
}

if (isset($_POST['crear_archivo'])) {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    //$depto =  $_SESSION['Departamento'];

    if ($titulo == '' || $descripcion == '') {
        $res = [
            'status' => 422,
            'message' => 'Todos los campos son obligatorios'
        ];
        echo json_encode($res);
        return;
    }

    // Verificar si se recibió correctamente el archivo adjunto
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $archivo = $_FILES['archivo'];

        // Validar la extensión del archivo
        $allowedExtensions = array('.pdf', '.doc', '.docx', '.mp4', '.avi', '.mov', '.wmv', '.mkv');
        $fileExtension = strtolower(strrchr($archivo['name'], '.'));
        if (!in_array($fileExtension, $allowedExtensions)) {
            $res = [
                'status' => 422,
                'message' => 'La extensión del archivo no es válida'
            ];
            echo json_encode($res);
            return;
        }

        // Validar el tamaño del archivo (en bytes)
        $maxSizeInBytes = MAXIMUM_FILE_SIZE_IN_MEGABYTES * 1024 * 1024;
        if ($archivo['size'] > $maxSizeInBytes) {
            $res = [
                'status' => 422,
                'message' => 'El tamaño del archivo supera el límite permitido de "/config.php"'
            ];
            echo json_encode($res);
            return;
        }

        // Obtener el nombre del archivo y cambiarlo por el título
        $nombreArchivo = slugify($titulo) . $fileExtension;
        $rutaArchivo = '../../files/Archivos/' . $nombreArchivo;

        /* verificar si existe el archivo en la base de datos */
        $query = "SELECT COUNT(id) AS exist FROM e_learning  WHERE ubicacion='$rutaArchivo'";
        $stmt = $conexion->prepare($query);
        try {
            $stmt->execute();
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if (isset($res['exist']) && $res['exist'] > 0) {
                $res = [
                    'status' => 422,
                    'message' => 'El título del archivo ya se encuentra registrado'
                ];
                echo json_encode($res);
                return;
            }
        } catch (\Throwable $th) {
            $res = [
                'status' => 422,
                'message' => 'Error al verificar si existe el archivo'
            ];
            echo json_encode($res);
            return;
        }

        // Mover el archivo a la carpeta de destino
        if (!move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
            $res = [
                'status' => 500,
                'message' => 'Error al mover el archivo a la carpeta de destino'
            ];
            echo json_encode($res);
            return;
        }
    } else {
        $phpFileUploadErrors = [
            0 => 'No hay ningún error, el archivo se cargó con éxito',
            1 => 'El archivo cargado excede la directiva "upload_max_filesize=' . ini_get('upload_max_filesize') . '" en php.ini',
            2 => 'El archivo cargado excede la directiva MAX_FILE_SIZE especificada en el formulario HTML',
            3 => 'El archivo cargado se cargó sólo parcialmente',
            4 => 'No se cargó ningún archivo',
            6 => 'Falta una carpeta temporal',
            7 => 'Error al escribir el archivo en el disco.',
            8 => 'Una extensión PHP detuvo la carga del archivo.',
        ];

        $res = [
            'status' => 422,
            'message' => $phpFileUploadErrors[$_FILES['archivo']['error']] ?? 'No se recibió el archivo adjunto',
        ];

        echo json_encode($res);
        return;
    }

    // Preparar la consulta SQL con marcadores de posición
    $sql = "INSERT INTO e_learning  (titulo, descripcion, ubicacion) VALUES (:titulo, :descripcion, :ubicacion)";
    $stmt = $conexion->prepare($sql);

    // Asociar los valores a los marcadores de posición
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':ubicacion', $rutaArchivo);


    if ($stmt->execute()) {
        $rowsInserted = $stmt->rowCount(); // Obtener el número de filas afectadas

        if ($rowsInserted > 0) {
            $res = [
                'status' => 200,
                'message' => 'Archivo creado exitosamente'
            ];
            header('Content-Type: application/json');
            echo json_encode($res);
        } else {
            $res = [
                'status' => 500,
                'message' => 'Error al crear el archivo'
            ];
            header('Content-Type: application/json');
            echo json_encode($res);
        }
    } else {
        $res = [
            'status' => 500,
            'message' => 'Error al crear el archivo'
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
    }
}

if (isset($_POST['editar_archivo'])) {
    $archivo_id = $_POST['archivo_id'];
    $titulo = $_POST['titulo_edit'];
    $descripcion = $_POST['descripcion_edit'];


    if ($titulo == '' || $descripcion == '' || $archivo_id == '') {
        $res = [
            'status' => 422,
            'message' => 'El título y la descripción son obligatorios'
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
        return;
    }

    // Verificar si se recibió correctamente un nuevo archivo adjunto
    if (isset($_FILES['archivo_edit']) && $_FILES['archivo_edit']['error'] === UPLOAD_ERR_OK) {
        $archivo = $_FILES['archivo_edit'];

        // Validar la extensión del archivo
        $allowedExtensions = array('.pdf', '.doc', '.docx', '.mp4', '.avi', '.mov', '.wmv', '.mkv');
        $fileExtension = strtolower(strrchr($archivo['name'], '.'));
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
        if ($archivo['size'] > $maxSizeInBytes) {
            $res = [
                'status' => 422,
                'message' => 'El tamaño del archivo supera el límite permitido'
            ];
            echo json_encode($res);
            return;
        }

        // Buscar y eliminar el documento anterior
        $stmt_doc = $conexion->prepare("SELECT ubicacion FROM e_learning  WHERE id = :archivo_id");
        $stmt_doc->bindParam(':archivo_id', $archivo_id);
        $stmt_doc->execute();
        $rutaDocumentoAntigua = $stmt_doc->fetchColumn();

        // Obtener el nombre del archivo y cambiarlo por el título
        $nombreArchivo = slugify($titulo) . $fileExtension;
        $rutaArchivo = '../../files/Archivos/' . $nombreArchivo;

        /* verificar si existe el archivo en la base de datos */
        if ($rutaDocumentoAntigua !== $rutaArchivo) {
            $query = "SELECT COUNT(id) AS exist FROM e_learning WHERE ubicacion='$rutaArchivo'";
            $stmt = $conexion->prepare($query);
            try {
                $stmt->execute();
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                if (isset($res['exist']) && $res['exist'] > 0) {
                    $res = [
                        'status' => 422,
                        'message' => 'El título del archivo ya se encuentra registrado'
                    ];
                    echo json_encode($res);
                    return;
                }
            } catch (\Throwable $th) {
                $res = [
                    'status' => 422,
                    'message' => 'Error al verificar si existe el archivo'
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
        if (!move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
            $res = [
                'status' => 500,
                'message' => 'Error al mover el archivo a la carpeta de destino'
            ];
            echo json_encode($res);
            return;
        }

        $sql = "UPDATE e_learning  SET titulo = :titulo, DESCRIPCION = :descripcion, ubicacion = :ubicacion WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':ubicacion', $rutaArchivo);
        $stmt->bindParam(':id', $archivo_id);

        if ($stmt->execute()) {
            // Actualización exitosa
            $res = [
                'status' => 200,
                'message' => 'Archivo actualizado correctamente'
            ];
            echo json_encode($res);
            return;
        } else {
            // Error en la actualización
            $res = [
                'status' => 500,
                'message' => 'Error al actualizar el archivo'
            ];
            echo json_encode($res);
            return;
        }
    } else {
        // Si no se recibió un nuevo archivo adjunto, actualiza solo el título y la descripción en la base de datos
        // Buscar el nombre actual del documento
        $stmt_doc = $conexion->prepare("SELECT ubicacion FROM e_learning  WHERE id = :archivo_id");
        $stmt_doc->bindParam(':archivo_id', $archivo_id);
        $stmt_doc->execute();
        $rutaDocumento = $stmt_doc->fetchColumn();
        $extension = substr($rutaDocumento, strrpos($rutaDocumento, '.') + 1);
        // Renombramos el documento
        $rutaDocumentoNueva = '../../files/Archivos/' . slugify($titulo) . '.' . $extension;

        /* verificar si existe el archivo en la base de datos */
        if ($rutaDocumento !== $rutaDocumentoNueva) {
            $query = "SELECT COUNT(id) AS exist FROM e_learning WHERE ubicacion='$rutaDocumentoNueva'";
            $stmt = $conexion->prepare($query);
            try {
                $stmt->execute();
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                if (isset($res['exist']) && $res['exist'] > 0) {
                    $res = [
                        'status' => 422,
                        'message' => 'El título del archivo ya se encuentra registrado'
                    ];
                    echo json_encode($res);
                    return;
                }
            } catch (\Throwable $th) {
                $res = [
                    'status' => 422,
                    'message' => 'Error al verificar si existe el archivo'
                ];
                echo json_encode($res);
                return;
            }
        }

        rename($rutaDocumento, $rutaDocumentoNueva);

        $sql = "UPDATE e_learning SET titulo = :titulo, descripcion = :descripcion, ubicacion = :ubicacion WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':ubicacion', $rutaDocumentoNueva);
        $stmt->bindParam(':id', $archivo_id);
        if ($stmt->execute()) {
            // Actualización exitosa
            $res = [
                'status' => 200,
                'message' => 'Archivo editado exitosamente (sin cambios en el archivo)'
            ];
            header('Content-Type: application/json');
            echo json_encode($res);
            return;
        } else {
            // Error en la actualización
            $res = [
                'status' => 500,
                'message' => 'Error al actualizar el archivo'
            ];
            header('Content-Type: application/json');
            echo json_encode($res);
            return;
        }
    }
}
