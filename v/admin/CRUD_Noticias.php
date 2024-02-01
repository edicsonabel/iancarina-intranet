<?php
require_once('conexion.php');
require_once __DIR__ . '/php/slugify.php';
session_start();

if (isset($_POST['crear_noticia'])) {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $depto =  $_SESSION['Departamento'];
    $fecha = $_POST['fecha'];
    $autor = $_POST['autor'];

    if ($titulo == '' || $contenido == '' || $depto == '' || $fecha == '' || $autor == '') {
        $res = [
            'status' => 422,
            'message' => 'Todos los campos son obligatorios'
        ];
        echo json_encode($res);
        return;
    }

    // Verificar si se recibió correctamente el archivo adjunto
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen = $_FILES['imagen'];

        // Validar la extensión del archivo .jpg, .jpeg, .png
        $allowedExtensions = array('.jpg', '.jpeg', '.png');
        $fileExtension = strtolower(strrchr($imagen['name'], '.'));
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
        if ($imagen['size'] > $maxSizeInBytes) {
            $res = [
                'status' => 422,
                'message' => 'El tamaño del archivo supera el límite permitido'
            ];
            echo json_encode($res);
            return;
        }

        // Obtener el nombre del archivo y cambiarlo por el título
        $nombreArchivo = slugify($titulo) . $fileExtension;
        $rutaArchivo = '../../files/Imagenes/' . $nombreArchivo;

        /* verificar si existe el archivo en la base de datos */
        $query = "SELECT COUNT(id) AS exist FROM noticias WHERE imagen='$rutaArchivo'";
        $stmt = $conexion->prepare($query);
        try {
            $stmt->execute();
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if (isset($res['exist']) && $res['exist'] > 0) {
                $res = [
                    'status' => 422,
                    'message' => 'El título de la noticia ya se encuentra registrado'
                ];
                echo json_encode($res);
                return;
            }
        } catch (\Throwable $th) {
            $res = [
                'status' => 422,
                'message' => 'Error al verificar si existe la noticia'
            ];
            echo json_encode($res);
            return;
        }

        // Mover el archivo a la carpeta de destino
        if (!move_uploaded_file($imagen['tmp_name'], $rutaArchivo)) {
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
    $sql = "INSERT INTO noticias (titulo, contenido, imagen, fecha, autor, departamento) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    // Asociar los valores a los marcadores de posición
    $stmt->bindValue(1, $titulo);
    $stmt->bindValue(2, $contenido);
    $stmt->bindValue(3, $rutaArchivo);
    $stmt->bindValue(4, $fecha);
    $stmt->bindValue(5, $autor);
    $stmt->bindValue(6, $depto);

    if ($stmt->execute()) {
        $rowsInserted = $stmt->rowCount(); // Obtener el número de filas afectadas

        if ($rowsInserted > 0) {
            $res = [
                'status' => 200,
                'message' => 'Noticia creads exitosamente'
            ];
            echo json_encode($res);
        } else {
            $res = [
                'status' => 500,
                'message' => 'Error al crear la noticia'
            ];
            echo json_encode($res);
        }
    } else {
        $res = [
            'status' => 500,
            'message' => 'Error al crear la noticia'
        ];
        echo json_encode($res);
    }
}

if (isset($_POST['eliminar_noticia'])) {
    $noticia_id = $_POST['noticia_id'];
    //buscar el nombre actual del documento
    $stmt_doc = $conexion->prepare("SELECT imagen FROM noticias WHERE id = :noticia_id");
    $stmt_doc->bindParam(':noticia_id', $noticia_id);
    $stmt_doc->execute();
    $rutaDocumento = $stmt_doc->fetchColumn();

    if ($rutaDocumento) {
        if (unlink($rutaDocumento)) {
            // El documento se ha eliminado correctamente
            $sql = "DELETE FROM noticias WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $noticia_id);

            if ($stmt->execute()) {
                $rowsDeleted = $stmt->rowCount();  // Verificar el número de filas eliminadas

                if ($rowsDeleted > 0) {
                    $res = [
                        'status' => 200,
                        'message' => 'Noticia eliminada correctamente'
                    ];
                    echo json_encode($res);
                } else {
                    $res = [
                        'status' => 404,
                        'message' => 'No se encontró la noticia a eliminar'
                    ];
                    echo json_encode($res);
                }
            } else {
                $res = [
                    'status' => 500,
                    'message' => 'Error al eliminar la noticia'
                ];
                echo json_encode($res);
            }
        } else {
            $res = [
                'status' => 500,
                'message' => 'Error al eliminar la imagen de la noticia'
            ];
            echo json_encode($res);
        }
    } else {
        $res = [
            'status' => 404,
            'message' => 'No se encontró la noticia a eliminar'
        ];
        echo json_encode($res);
    }
}

if (isset($_GET['noticia_id'])) {
    $noticia_id = $_GET['noticia_id'];
    // Preparar la consulta SQL con marcadores de posición
    // $sql = "SELECT id, titulo, contenido, imagen, DATE_FORMAT(fecha, '%d/%m/%Y') as fecha, autor, departamento FROM noticias WHERE id = :id;";
    $sql = "SELECT id, titulo, contenido, imagen, DATE_FORMAT(fecha, '%Y-%m-%d') as fecha, autor, departamento FROM noticias WHERE id = :id;";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id', $noticia_id);
    // Ejecutar la consulta
    $stmt->execute();
    // Obtener los resultados
    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($results) {
        $res = [
            'status' => 200,
            'message' => 'Noticia obtenida exitosamente',
            'data' => $results
        ];
        echo json_encode($res);
    } else {
        $res = [
            'status' => 404,
            'message' => 'Noticia no encontrada'
        ];
        echo json_encode($res);
    }
}

if (isset($_POST['editar_noticia'])) {
    $noticia_id = $_POST['noticia_id'];
    $titulo = $_POST['titulo_edit'];
    $autor = $_POST['autor_edit'];
    $fecha = $_POST['fecha_edit'];
    $contenido = $_POST['contenido_edit'];
    $depto = $_SESSION['Departamento'];

    if ($titulo == '' || $contenido == '' || $autor == '' || $fecha == '') {
        $res = [
            'status' => 422,
            'message' => 'Todos los campos son obligatorios'
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
        return;
    }

    // Verificar si se recibió correctamente un nuevo archivo adjunto
    if (isset($_FILES['imagen_edit']) && $_FILES['imagen_edit']['error'] === UPLOAD_ERR_OK) {
        $imagen = $_FILES['imagen_edit'];
        // Validar la extensión del archivo  .jpg, .jpeg, .png
        $allowedExtensions = array('.jpg', '.jpeg', '.png');
        $fileExtension = strtolower(strrchr($imagen['name'], '.'));
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
        if ($imagen['size'] > $maxSizeInBytes) {
            $res = [
                'status' => 422,
                'message' => 'El tamaño del archivo supera el límite permitido'
            ];
            echo json_encode($res);
            return;
        }

        // Obtener la ruta de la imagen antigua
        $stmt_doc = $conexion->prepare("SELECT imagen FROM noticias WHERE id = :noticia_id");
        $stmt_doc->bindParam(':noticia_id', $noticia_id);
        $stmt_doc->execute();
        $rutaImagenAntigua = $stmt_doc->fetchColumn();

        // Guardar la imagen nueva
        $nombreArchivo = slugify($titulo) . $fileExtension;
        $rutaArchivo = '../../files/Imagenes/' . $nombreArchivo;

        /* verificar si existe el archivo en la base de datos */
        if ($rutaImagenAntigua !== $rutaArchivo) {
            $query = "SELECT COUNT(id) AS exist FROM noticias WHERE imagen='$rutaArchivo'";
            $stmt = $conexion->prepare($query);
            try {
                $stmt->execute();
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                if (isset($res['exist']) && $res['exist'] > 0) {
                    $res = [
                        'status' => 422,
                        'message' => 'El título de la noticia ya se encuentra registrado'
                    ];
                    echo json_encode($res);
                    return;
                }
            } catch (\Throwable $th) {
                $res = [
                    'status' => 422,
                    'message' => 'Error al verificar si existe la noticia'
                ];
                echo json_encode($res);
                return;
            }
        }

        // Eliminar la imagen antigua
        if (file_exists($rutaImagenAntigua)) {
            unlink($rutaImagenAntigua);
        }

        // Mover el archivo a la carpeta de destino
        if (!move_uploaded_file($imagen['tmp_name'], $rutaArchivo)) {
            $res = [
                'status' => 500,
                'message' => 'Error al mover el archivo a la carpeta de destino'
            ];
            echo json_encode($res);
            return;
        }
    }

    // Actualizar la noticia en la base de datos
    $sql = "UPDATE noticias SET titulo = :titulo, departamento = :depto, contenido = :contenido, autor = :autor, fecha = :fecha";
    if (isset($rutaArchivo)) {
        $sql .= ", imagen = :imagen";
    }
    $sql .= " WHERE id = :id";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':depto', $depto);
    $stmt->bindParam(':contenido', $contenido);
    $stmt->bindParam(':autor', $autor);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':id', $noticia_id);
    if (isset($rutaArchivo)) {
        $stmt->bindParam(':imagen', $rutaArchivo);
    }

    if ($stmt->execute()) {
        // Actualización exitosa
        $res = [
            'status' => 200,
            'message' => 'La Noticia ha sido actualizada correctamente'
        ];
        echo json_encode($res);
    } else {
        // Error en la actualización
        $res = [
            'status' => 500,
            'message' => 'Error al actualizar la noticia'
        ];
        echo json_encode($res);
    }
}
