<?php
include("../service/connection.php");

if (isset($_GET['id'])) {
    $id_contacto = intval($_GET['id']);

    $sql = "CALL EliminarContacto(?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_contacto);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result) {
            $row = $result->fetch_assoc();
            echo $row['Resultado'];
        } else {
            echo 'Error al ejecutar el procedimiento.';
        }
    } else {
        echo 'Error en la consulta: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'ID de contacto no proporcionado.';
}
?>
