<?php
require_once __DIR__ . '/../../config.php';
require_once('conexion.php');
require_once __DIR__ . '/php/slugify.php';
require_once __DIR__ . '/../../config.php';
session_start();
// $_SESSION['Departamento'] = "Tecnologia";

if (isset($_GET['recurso_id'])) {
    $recurso_id = $_GET['recurso_id'];
    // Preparar la consulta SQL con marcadores de posición
    $sql = "SELECT titulo,descripcion,ubicacion FROM documentos WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id', $recurso_id);
    // Ejecutar la consulta
    $stmt->execute();
    // Obtener los resultados
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


    if ($results) {
        $res = [
            'status' => 200,
            'message' => 'Recurso obtenido exitosamente',
            'data' => $results
        ];
        echo json_encode($res);
        exit;
    } else {
        $res = [
            'status' => 404,
            'message' => 'Usuario no encontrado'
        ];
        echo json_encode($res);
        exit;
    }
}

if (isset($_POST['eliminar_recurso'])) {
    $recurso_id = $_POST['recurso_id'];

    // Buscar el nombre actual del recurso
    $stmt_doc = $conexion->prepare("SELECT ubicacion FROM documentos WHERE id = :recurso_id");
    $stmt_doc->bindParam(':recurso_id', $recurso_id);
    $stmt_doc->execute();
    $rutaRecurso = $stmt_doc->fetchColumn();

    if ($rutaRecurso && unlink($rutaRecurso)) {
        // El documento se ha eliminado correctamente
        $sql = "DELETE FROM documentos WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $recurso_id);

        if ($stmt->execute()) {
            $rowsDeleted = $stmt->rowCount();  // Verificar el número de filas eliminadas

            if ($rowsDeleted > 0) {
                $res = [
                    'status' => 200,
                    'message' => 'Recurso eliminado correctamente'
                ];
                header('Content-Type: application/json');
                echo json_encode($res);
            } else {
                $res = [
                    'status' => 404,
                    'message' => 'No se encontró el recurso a eliminar'
                ];
                header('Content-Type: application/json');
                echo json_encode($res);
            }
        } else {
            $res = [
                'status' => 500,
                'message' => 'Error al eliminar el recurso'
            ];
            header('Content-Type: application/json');
            echo json_encode($res);
        }
    } else {
        $res = [
            'status' => 500,
            'message' => 'Error al eliminar el recurso'
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
    }
}

if (isset($_POST['crear_recurso'])) {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $depto =  $_SESSION['Departamento'];

    if ($titulo == '' || $descripcion == '' || $depto == '') {
        $res = [
            'status' => 422,
            'message' => 'Todos los campos son obligatorios'
        ];
        echo json_encode($res);
        exit;
    }

    // Verificar si se recibió correctamente el archivo adjunto
    if (isset($_FILES['recurso']) && $_FILES['recurso']['error'] === UPLOAD_ERR_OK) {
        $recurso = $_FILES['recurso'];

        // Validar la extensión del archivo
        $allowedExtensions = array('.pdf', '.doc', '.docx', '.mp4', '.avi', '.mov', '.wmv', '.mkv');
        $fileExtension = strtolower(strrchr($recurso['name'], '.'));
        if (!in_array($fileExtension, $allowedExtensions)) {
            $res = [
                'status' => 422,
                'message' => 'La extensión del archivo no es válida'
            ];
            echo json_encode($res);
            exit;
        }

        // Validar el tamaño del archivo (en bytes)
        $maxSizeInBytes = MAXIMUM_FILE_SIZE_IN_MEGABYTES * 1024 * 1024;
        if ($recurso['size'] > $maxSizeInBytes) {
            $res = [
                'status' => 422,
                'message' => 'El tamaño del archivo supera el límite permitido de "/config.php"'
            ];
            echo json_encode($res);
            exit;
        }

        // Obtener el nombre del archivo y cambiarlo por el título
        $nombreArchivo = slugify($titulo) . $fileExtension;
        $rutaArchivo = '../../files/Documentos/' . $nombreArchivo;

        /* verificar si existe el archivo en la base de datos */
        $query = "SELECT COUNT(id) AS exist FROM documentos WHERE ubicacion='$rutaArchivo'";
        $stmt = $conexion->prepare($query);
        try {
            $stmt->execute();
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if (isset($res['exist']) && $res['exist'] > 0) {
                $res = [
                    'status' => 422,
                    'message' => 'El título del recurso ya se encuentra registrado'
                ];
                echo json_encode($res);
                exit;
            }
        } catch (\Throwable $th) {
            $res = [
                'status' => 422,
                'message' => 'Error al verificar si existe el recurso'
            ];
            echo json_encode($res);
            exit;
        }

        // Mover el archivo a la carpeta de destino
        if (!move_uploaded_file($recurso['tmp_name'], $rutaArchivo)) {
            $res = [
                'status' => 500,
                'message' => 'Error al mover el archivo a la carpeta de destino'
            ];
            echo json_encode($res);
            exit;
        }
    } else {
        echo json_encode(
            [
                'status' => 422,
                'message' => 'Error interno',
            ]
        );
        exit;

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
            'message' => $phpFileUploadErrors[$_FILES['recurso']['error']] ?? 'No se recibió el archivo adjunto',
        ];

        echo json_encode($res);
        exit;
    }

    // Preparar la consulta SQL con marcadores de posición
    $sql = "INSERT INTO documentos (titulo, descripcion, ubicacion, departamento) VALUES (:titulo, :descripcion, :ubicacion, :depto)";
    $stmt = $conexion->prepare($sql);

    // Asociar los valores a los marcadores de posición
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':ubicacion', $rutaArchivo);
    $stmt->bindParam(':depto', $depto);

    if ($stmt->execute()) {
        $rowsInserted = $stmt->rowCount(); // Obtener el número de filas afectadas

        if ($rowsInserted > 0) {
            $res = [
                'status' => 200,
                'message' => 'Recurso creado exitosamente'
            ];
            header('Content-Type: application/json');
            echo json_encode($res);
        } else {
            $res = [
                'status' => 500,
                'message' => 'Error al crear el recurso'
            ];
            header('Content-Type: application/json');
            echo json_encode($res);
        }
    } else {
        $res = [
            'status' => 500,
            'message' => 'Error al crear el recurso'
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
    }
}

if (isset($_POST['editar_recurso'])) {
    $recurso_id = $_POST['recurso_id'];
    $titulo = $_POST['titulo_edit'];
    $descripcion = $_POST['descripcion_edit'];
    $depto = $_SESSION['Departamento'];

    if ($titulo == '' || $descripcion == '' || $recurso_id == '') {
        $res = [
            'status' => 422,
            'message' => 'El título y la descripción son obligatorios'
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
        exit;
    }

    // Verificar si se recibió correctamente un nuevo archivo adjunto
    if (isset($_FILES['recurso_edit']) && $_FILES['recurso_edit']['error'] === UPLOAD_ERR_OK) {
        $recurso = $_FILES['recurso_edit'];

        // Validar la extensión del archivo
        $allowedExtensions = array('.pdf', '.doc', '.docx', '.mp4', '.avi', '.mov', '.wmv', '.mkv');
        $fileExtension = strtolower(strrchr($recurso['name'], '.'));
        if (!in_array($fileExtension, $allowedExtensions)) {
            $res = [
                'status' => 422,
                'message' => 'La extensión del archivo no es válida'
            ];
            echo json_encode($res);
            exit;
        }

        // Validar el tamaño del archivo (en bytes)
        $maxSizeInBytes = MAXIMUM_FILE_SIZE_IN_MEGABYTES * 1024 * 1024;
        if ($recurso['size'] > $maxSizeInBytes) {
            $res = [
                'status' => 422,
                'message' => 'El tamaño del archivo supera el límite permitido de "/config.php"'
            ];
            echo json_encode($res);
            exit;
        }

        // Buscar y eliminar el recurso anterior
        $stmt_doc = $conexion->prepare("SELECT ubicacion FROM documentos WHERE id = :recurso_id");
        $stmt_doc->bindParam(':recurso_id', $recurso_id);
        $stmt_doc->execute();
        $rutaRecursoAntigua = $stmt_doc->fetchColumn();

        // Obtener el nombre del archivo y cambiarlo por el título
        $nombreArchivo = slugify($titulo) . $fileExtension;
        $rutaArchivo = '../../files/Documentos/' . $nombreArchivo;

        /* verificar si existe el archivo en la base de datos */
        if ($rutaRecursoAntigua !== $rutaArchivo) {
            $query = "SELECT COUNT(id) AS exist FROM documentos WHERE ubicacion='$rutaArchivo'";
            $stmt = $conexion->prepare($query);
            try {
                $stmt->execute();
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                if (isset($res['exist']) && $res['exist'] > 0) {
                    $res = [
                        'status' => 422,
                        'message' => 'El título del recurso ya se encuentra registrado'
                    ];
                    echo json_encode($res);
                    exit;
                }
            } catch (\Throwable $th) {
                $res = [
                    'status' => 422,
                    'message' => 'Error al verificar si existe el recurso'
                ];
                echo json_encode($res);
                exit;
            }
        }

        // Eliminar el recurso antiguo
        if (file_exists($rutaRecursoAntigua)) {
            unlink($rutaRecursoAntigua);
        }

        // Mover el archivo a la carpeta de destino
        if (!move_uploaded_file($recurso['tmp_name'], $rutaArchivo)) {
            $res = [
                'status' => 500,
                'message' => 'Error al mover el archivo a la carpeta de destino'
            ];
            echo json_encode($res);
            exit;
        }

        $sql = "UPDATE documentos SET titulo = :titulo, departamento = :depto, DEScRIPCION = :descripcion, ubicacion = :ubicacion WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':depto', $depto);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':ubicacion', $rutaArchivo);
        $stmt->bindParam(':id', $recurso_id);

        if ($stmt->execute()) {
            // Actualización exitosa
            $res = [
                'status' => 200,
                'message' => 'Recurso actualizado correctamente'
            ];
            echo json_encode($res);
            exit;
        } else {
            // Error en la actualización
            $res = [
                'status' => 500,
                'message' => 'Error al actualizar el recurso'
            ];
            echo json_encode($res);
            exit;
        }
    } else {
        $phpFileUploadErrors = [
            0 => 'No hay ningún error, el archivo se cargó con éxito',
            1 => 'El archivo cargado excede la directiva "upload_max_filesize=' . ini_get('upload_max_filesize') . '" en php.ini',
            2 => 'El archivo cargado excede la directiva MAX_FILE_SIZE especificada en el formulario HTML',
            3 => 'El archivo cargado se cargó sólo parcialmente',
            6 => 'Falta una carpeta temporal',
            7 => 'Error al escribir el archivo en el disco.',
            8 => 'Una extensión PHP detuvo la carga del archivo.',
        ];

        if (isset($_FILES['recurso_edit']['error']) && isset($phpFileUploadErrors[$_FILES['recurso_edit']['error']])) {
            $res = [
                'status' => 422,
                'message' => $phpFileUploadErrors[$_FILES['recurso_edit']['error']]
            ];
            echo json_encode($res);
            exit;
        }

        // Si no se recibió un nuevo archivo adjunto, actualiza solo el título y la descripción en la base de datos
        // Buscar el nombre actual del recurso
        $stmt_doc = $conexion->prepare("SELECT ubicacion FROM documentos WHERE id = :recurso_id");
        $stmt_doc->bindParam(':recurso_id', $recurso_id);
        $stmt_doc->execute();
        $rutaRecurso = $stmt_doc->fetchColumn();
        $extension = substr($rutaRecurso, strrpos($rutaRecurso, '.') + 1);
        // Renombramos el recurso
        $rutaRecursoNueva = '../../files/Documentos/' . slugify($titulo) . '.' . $extension;

        /* verificar si existe el archivo en la base de datos */
        if ($rutaRecurso !== $rutaRecursoNueva) {
            $query = "SELECT COUNT(id) AS exist FROM documentos WHERE ubicacion='$rutaRecursoNueva'";
            $stmt = $conexion->prepare($query);
            try {
                $stmt->execute();
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                if (isset($res['exist']) && $res['exist'] > 0) {
                    $res = [
                        'status' => 422,
                        'message' => 'El título del recurso ya se encuentra registrado'
                    ];
                    echo json_encode($res);
                    exit;
                }
            } catch (\Throwable $th) {
                $res = [
                    'status' => 422,
                    'message' => 'Error al verificar si existe el recurso'
                ];
                echo json_encode($res);
                exit;
            }
        }

        rename($rutaRecurso, $rutaRecursoNueva);

        $sql = "UPDATE documentos SET titulo = :titulo, descripcion = :descripcion, ubicacion = :ubicacion WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':ubicacion', $rutaRecursoNueva);
        $stmt->bindParam(':id', $recurso_id);
        if ($stmt->execute()) {
            // Actualización exitosa
            $res = [
                'status' => 200,
                'message' => 'Recurso editado exitosamente (sin cambios en el archivo)'
            ];
            header('Content-Type: application/json');
            echo json_encode($res);
            exit;
        } else {
            // Error en la actualización
            $res = [
                'status' => 500,
                'message' => 'Error al actualizar el recurso'
            ];
            header('Content-Type: application/json');
            echo json_encode($res);
            exit;
        }
    }
}
