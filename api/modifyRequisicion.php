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

$p_idRequisicion = $_POST['idRequisicion'] ?? null;
$p_estado = $_POST['estado'] ?? null;
$p_cantidadServicio = $_POST['cantidadServicio'] ?? null;
$p_cantidadDinero = $_POST['cantidadDinero'] ?? null;
$p_servicio = $_POST['servicio'] ?? null;
$p_fechaAlteracion = $_POST['fechaAlteracion'] ?? null;
$p_motivoCancelacion = $_POST['motivoCancelacion'] ?? null;
$p_motivoPosposicion = $_POST['motivoPosposicion'] ?? null;
$p_motivoReembolso = $_POST['motivoReembolso'] ?? null;

if (empty($p_idRequisicion) || empty($p_estado)) {
    die(json_encode([
        "success" => false,
        "message" => "Por favor, completa todos los campos obligatorios."
    ]));
}

try {
    $sql = "CALL ModificarRequisicion(?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        throw new Exception("Error al preparar la consulta: " . $conn->error);
    }

    $p_cantidadServicio = $p_cantidadServicio !== null ? floatval($p_cantidadServicio) : null;
    $p_cantidadDinero = $p_cantidadDinero !== null ? floatval($p_cantidadDinero) : null;
    $p_servicio = $p_servicio !== null ? strval($p_servicio) : null;
    $p_fechaAlteracion = $p_fechaAlteracion !== null ? strval($p_fechaAlteracion) : null;
    $p_motivoCancelacion = $p_motivoCancelacion !== null ? strval($p_motivoCancelacion) : null;
    $p_motivoPosposicion = $p_motivoPosposicion !== null ? strval($p_motivoPosposicion) : null;
    $p_motivoReembolso = $p_motivoReembolso !== null ? strval($p_motivoReembolso) : null;


    $stmt->bind_param(
        "issssssss",
        $p_idRequisicion,
        $p_estado,
        $p_cantidadServicio,
        $p_cantidadDinero,
        $p_servicio,
        $p_fechaAlteracion,
        $p_motivoCancelacion,
        $p_motivoPosposicion,
        $p_motivoReembolso
    );

    // Ejecutar la consulta
    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
    }

    // Verificar resultados
    echo json_encode([
        "success" => true,
        "message" => "Requisición modificada con éxito",
        "idRequisicion" => $p_idRequisicion
    ]);

    // Cerrar consulta y conexión
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    // Registrar errores para depuración
    error_log("Error en API ModificarRequisicion: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}
