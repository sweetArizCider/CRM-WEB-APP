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

$empresa = $_POST['empresa'] ?? '';
$cdMatriz = $_POST['cdMatriz'] ?? '';
$presupuesto = $_POST['presupuesto'] ?? '';
$estatus = $_POST['estatus'] ?? '';
$calle = $_POST['calle'] ?? '';
$cp = $_POST['cp'] ?? '';
$numExterior = $_POST['numExterior'] ?? '';

if (empty($empresa) || empty($cdMatriz) || empty($presupuesto) || empty($estatus) || empty($calle) || empty($cp) || empty($numExterior)) {
    die(json_encode([
        "success" => false,
        "message" => "Por favor, completa todos los campos."
    ]));
}

try {
    $stmt = $conn->prepare("CALL InsertarClienteConDireccion(?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die(json_encode([
            "success" => false,
            "message" => "Error al preparar la consulta: " . $conn->error
        ]));
    }

    $stmt->bind_param("ssdssss", $empresa, $cdMatriz, $presupuesto, $estatus, $calle, $cp, $numExterior);
    
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($result) {
        $data = $result->fetch_assoc();
        $message = $data['message'] ?? 'Operación completada exitosamente';

        echo json_encode([
            "success" => true,
            "message" => $message
        ]);
    } else {
        echo json_encode([
            "success" => true,
            "message" => "El cliente se ha registrado exitosamente."
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
