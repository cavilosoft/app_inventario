<?php
    // Este encabezado que la respuesta del servidor sea en formato JSON
    header('Content-Type: application/json');

    // Datos de conexión a la base de datos
    $host = 'localhost'; // Cambia esto si tu base de datos no está en el mismo servidor
    $usuario = 'root'; 
    $password = '';
    $baseDatos = 'app_inventario'; 

    // Crear conexión
    $conexion = new mysqli($host, $usuario, $password, $baseDatos);

    // Verificar conexión
    if ($conexion->connect_error) {
        echo json_encode([
            "success" => false,
            "message" => "Error de conexión a la base de datos: " . $conexion->connect_error
        ]);
    }

    $conexion->set_charset("utf8");
?>