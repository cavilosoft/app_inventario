<?php

require_once '../config/conexion.php';

    // Verificar que se recibieron los datos necesarios
    if($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            "success" => false,
            "message" => "Método no permitido. Use POST."
        ]);
        exit;
    }

    // Obtener los datos del cuerpo de la solicitud
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');           
    $password = $_POST['password'] ?? '';

    // Validar que los campos no estén vacíos
    if(empty($nombre) || empty($correo) || empty($password)) {
        echo json_encode([
            "success" => false,
            "message" => "Todos los campos son obligatorios."
        ]);
        exit;
    }

    // Verificar si el correo ya está registrado
    $sqlVerificarCorreo = "SELECT id FROM usuarios WHERE correo = ?";
    $stmt = $conexion->prepare($sqlVerificarCorreo);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if($resultado->num_rows > 0) {
        echo json_encode([
            "success" => false,
            "message" => "El correo ya está registrado."
        ]);
        exit;
    }

    // Hashear la contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar el nuevo usuario en la base de datos
    $sqlInsertar = "INSERT INTO usuarios (nombre, correo, password) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sqlInsertar);
    $stmt->bind_param("sss", $nombre, $correo, $passwordHash);
    
    if($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Usuario registrado exitosamente."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Error al registrar el usuario."
        ]);
    }

?>