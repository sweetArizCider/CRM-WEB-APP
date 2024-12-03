<?php
session_start();
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
    <title> LEAR - Requisiciones</title>
    <link rel="shortcut icon" href="../img/learlogo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/normalized.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap-5.3.3-dist/css/bootstrap.min.css">

    <style>
        .navbar {
            background: linear-gradient(100deg,  #451851, #F39F59);
        }

        .navbar a {
            color: white !important;
            font-family: Montserrat;
            font-weight: 500;

        }

        h1 {
            text-align: left;
            font-family: Montserrat;
            font-weight: 700;
            color: #451851;
        }
        h2{
        text-align: left;
            font-family: Montserrat;
            font-weight: 700;
            color: #451851;
            margin-bottom: 1rem;
        }

        p {
            text-align: left;
            font-size: 1.2rem;
            font-family: Inter;
        }

        .btn-rounded {
            border-radius: 30px;
        }

        .table {
            margin-top: 20px;
        }

        table {
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }
        .navbar-nav {
            display: flex;
            justify-content: center;
            gap: 30px;
            width: 100%;
        }
        .navordenes{
            margin-left: 5em;
            margin-right: 5em;
        }
        .iconcerrar{
            margin-right: 2em;
        }
        .agregarordenb{
            background-color: #451851;
            border: none;
            padding-left: 20px;
            padding-right: 20px;
           
        }
        .editarordenb{
            background-color:  #AD445A;
            border: none;
            padding-left: 20px;
            padding-right: 20px;
            
        }
    #modal, #modalEdit {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1040;
    }

    .modal-content {
        background-color: #fff;
        border-radius: 8px;
        padding: 20px;
        position: relative;
        margin: auto;
        top: 50%;
        transform: translateY(-50%);
        width: 90%;
        max-width: 500px;
        z-index: 1050;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        font-size: 24px;
        color: #aaa;
    }

    .close:hover {
        color: black;
    }

    </style>
</head>
<body>
<header>
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
            <div class="container-fluid text-center">
                <a class="navbar-brand text-center" href="../login_inte/home.php">
                    <img src="../img/logoinvert.png" alt="logo" width="35px" style="margin-left: 2em; ">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="../contactos/contactos.php">Contactos</a>
                        </li>
                        <li class="nav-item">
                            <a  class="nav-link navordenes" href="../ordenes/ordenes.php">Órdenes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../clientes/clientes.php">Clientes</a>
                        </li>
                    </ul>
                    <a class="nav-link iconcerrar" href="../login_inte/logout.php">
                        <img src="../img/off.svg" alt="Cerrar Sesión" width="25px">
                    </a>
                </div>
            </div>
        </nav>
    </header>
    <div class="container mt-5 pt-5">
        <?php
        if (isset($_SESSION['nombre'])) {
            echo "<h1> ¡Bienvenido de nuevo, <br> <span> " . htmlspecialchars($_SESSION['nombre'] . " " . $_SESSION['apellido']) ."!</h1>";
        } 
        ?>
    </div>
</body>
</html>
