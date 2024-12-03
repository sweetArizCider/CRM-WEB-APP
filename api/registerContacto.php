<?php
file_put_contents('php://stderr', print_r($_POST, true));

header('Content-Type: application/json');

$host = "bo7u6pimi9mondx2jxvm-mysql.services.clever-cloud.com";
$database = "bo7u6pimi9mondx2jxvm";
$user = "ujcxv1mcmvh3szov";
$password = "HC2zESAuuPDUBO3WLngB";
$port = 3306;

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die(json_encode([
        "success" => false,
        "message" => "Error de conexión: " . $conn->connect_error
    ]));
}

$nombre = $_POST['nombre'] ?? '';
$apellido = $_POST['apellido'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$correo = $_POST['correo'] ?? '';
$numero = $_POST['numero'] ?? '';
$empresa = $_POST['empresa'] ?? '';

if (empty($nombre) || empty($apellido) || empty($direccion) || empty($correo) || empty($numero)) {
    die(json_encode([
        "success" => false,
        "message" => "Por favor, completa todos los campos."
    ]));
}

try {
    $stmt = $conn->prepare("CALL addContacto(?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die(json_encode([
            "success" => false,
            "message" => "Error al preparar la consulta: " . $conn->error
        ]));
    }

    $stmt->bind_param("ssssss", $nombre, $apellido, $direccion, $correo, $numero, $empresa);
    
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "success" => true,
            "message" => "Contacto registrado exitosamente."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Hubo un problema al registrar el contacto."
        ]);
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}
?>
