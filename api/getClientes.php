<?php
header('Content-Type: application/json');

$host = "bo7u6pimi9mondx2jxvm-mysql.services.clever-cloud.com";
$database = "bo7u6pimi9mondx2jxvm";
$user = "ujcxv1mcmvh3szov";
$password = "HC2zESAuuPDUBO3WLngB";
$port = 3306;

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Error de conexión"]));
}

$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';  

$query = "SELECT empresa, CdMatriz AS ciudad, estatus, presupuesto FROM Cliente ORDER BY empresa $order";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $clientes = [];
    while ($row = $result->fetch_assoc()) {
        $clientes[] = [
            "empresa" => $row['empresa'],
            "ciudad" => $row['ciudad'], 
            "estatus" => $row['estatus'],
            "presupuesto" => $row['presupuesto']
        ];
    }
    echo json_encode($clientes);
} else {
    echo json_encode([]);
}

$conn->close();
?>
