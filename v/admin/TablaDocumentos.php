<?php
require_once('conexion.php');
$sql = "SELECT id, titulo, descripcion, ubicacion, departamento FROM documentos";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devuelve los datos como JSON
header("Content-Type: application/json");
echo json_encode($data);
