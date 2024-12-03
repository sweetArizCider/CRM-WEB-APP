<?php
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

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$apellido = $_POST['apellido'] ?? '';
$empresa = $_POST['empresa'] ?? '';

if (empty($email) || empty($password) || empty($nombre) || empty($apellido) || empty($empresa)) {
    die(json_encode([
        "success" => false,
        "message" => "Por favor, completa todos los campos."
    ]));
}

try {
    $stmt = $conn->prepare("CALL CreateUser(?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die(json_encode([
            "success" => false,
            "message" => "Error al preparar la consulta: " . $conn->error
        ]));
    }

    $stmt->bind_param("sssss", $email, $password, $nombre, $apellido, $empresa);
    
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($result) {
        $data = $result->fetch_assoc();
        $message = $data['message'] ?? 'Error desconocido';

        if (strpos($message, 'exitosamente') !== false) {
            echo json_encode([
                "success" => true,
                "message" => $message
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => $message
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Error al procesar el registro."
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
