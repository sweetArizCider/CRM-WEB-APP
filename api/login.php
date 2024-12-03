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

if (empty($email) || empty($password)) {
    die(json_encode([
        "success" => false,
        "message" => "Por favor, proporciona un correo y una contraseña."
    ]));
}

try {
    $stmt = $conn->prepare("CALL LoginUser(?, ?)");

    if ($stmt === false) {
        die(json_encode([
            "success" => false,
            "message" => "Error al preparar la consulta: " . $conn->error
        ]));
    }

    $stmt->bind_param("ss", $email, $password);
    
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $message = $data['message'] ?? 'Inicio de sesión exitoso.';
        $token = $data['token'] ?? null;
        $nombre = $data['nombre'] ?? null;
        $apellido = $data['apellido'] ?? null;

        if ($token) {
            echo json_encode([
                "success" => true,
                "message" => $message,
                "token" => $token,
                "nombre" => $nombre,
                "apellido" => $apellido
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
            "message" => "Credenciales incorrectas o error desconocido."
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
