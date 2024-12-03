<?php
session_start();

// Verificar si la sesión está activa
if (!isset($_SESSION['token'])) {
    header('Location: /login_inte/login.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="box-inicio">
        <?php include("../login_inte/navbar.php"); ?>
        <br>
        <div class="box-contenido">
            <div class="contenido">
                <?php
                if (isset($_SESSION['nombre'])) {
                    echo "B I E N V E N I D O, " . htmlspecialchars($_SESSION['nombre'] . " " . $_SESSION['apellido']);
                } 
                ?>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
    </div>
</body>
</html>
