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

$fkidCliente = $_POST['fkidCliente'] ?? '';
$fechaCreacion = $_POST['fechaCreacion'] ?? '';
$cantidadServicio = $_POST['cantidadServicio'] ?? '';
$cantidadDinero = $_POST['cantidadDinero'] ?? '';
$servicio = $_POST['servicio'] ?? '';

if (empty($fkidCliente) || empty($fechaCreacion) || empty($cantidadServicio) || empty($cantidadDinero) || empty($servicio)) {
    die(json_encode([
        "success" => false,
        "message" => "Por favor, completa todos los campos."
    ]));
}

try {
    $stmt = $conn->prepare("CALL CrearRequisicion(?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die(json_encode([
            "success" => false,
            "message" => "Error al preparar la consulta: " . $conn->error
        ]));
    }

    $stmt->bind_param("isdss", $fkidCliente, $fechaCreacion, $cantidadServicio, $cantidadDinero, $servicio);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result) {
        $data = $result->fetch_assoc();
        $message = $data['message'] ?? 'Operación completada exitosamente';
        $idRequisicion = $data['idRequisicion'] ?? null;

        echo json_encode([
            "success" => true,
            "message" => $message,
            "idRequisicion" => $idRequisicion
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "No se pudo crear la requisición."
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
