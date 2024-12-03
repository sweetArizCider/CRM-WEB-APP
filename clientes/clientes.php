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
    <title> LEAR - Clientes</title>
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
        /* Ajustes en estilos del modal */
    #modalAgregarCliente, #modalEdit {
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
        
        <h1>¡Administra tus clientes!</h1>
        <p>Accede y actualiza la información de tus clientes para mantener relaciones eficientes y efectivas.</p>
        <div class="d-flex justify-content-end gap-2 mb-3">
        <button id="agregarCliente" onclick="mostrarModalAgregarCliente()" class="btn btn-primary btn-rounded agregarordenb">Añadir <img src="../img/add.svg" alt="" style="width: 20px; justify-content: center"></button>
        </div>
        

        <div class="table table-responsive">
            <table id="tablaClientes" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Ciudad</th>
                        <th>Estatus</th>
                        <th>Presupuesto</th>
                    </tr>
                </thead>
                <tbody id="tablaClientesBody">
                    <!-- Los datos se agregarán aquí dinámicamente -->
                </tbody>
            </table>
        </div>

        <!-- Modal para añadir un nuevo cliente -->
    <div id="modalAgregarCliente" >
    <div class="modal-content" style="max-height: 90vh; overflow-y: auto;">
        <span class="close" onclick="cerrarModalAgregarCliente()">&times;</span>
        <h2>Agregar Cliente</h2>
        <form id="formAgregarCliente" onsubmit="enviarCliente(event)">
        <div class="mb-3">
            <label for="empresa"  class="form-label">Empresa:</label>
            <input type="text" id="empresa" name="empresa" class="form-control" required>
        </div>
            <div class="mb-3">
            <label for="cdMatriz"  class="form-label">CD Matriz:</label>
            <input type="text" id="cdMatriz" name="cdMatriz" class="form-control" required>
            </div>
            <div class="mb-3">
            <label for="presupuesto"  class="form-label">Presupuesto:</label>
            <input type="number" step="0.01" id="presupuesto" name="presupuesto" class="form-control" required>
            </div>
            <div class="mb-3">
            <label for="estatus"  class="form-label">Estatus:</label>
            <select id="estatus" name="estatus" class="form-select" required>
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
            </select>
            </div>
            <div class="mb-3">
            <label for="calle"  class="form-label">Calle:</label>
            <input type="text" id="calle" name="calle" class="form-control" required>
            </div>
            <div class="mb-3">
            <label for="cp"  class="form-label">Código Postal:</label>
            <input type="text" id="cp" name="cp" class="form-control" required>
            </div>
            <div class="mb-3">
            <label for="numExterior"  class="form-label">Número Exterior:</label>
            <input type="text" id="numExterior" name="numExterior" class="form-control" required>
            </div>
            <div class="mb-3">
            <button type="submit" class="btn btn-primary btn-rounded agregarordenb">Agregar</button>
            </div>
        </form>
    </div>
</div>

<script src="../css/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>


<script>
    function mostrarModalAgregarCliente() {
        document.getElementById('modalAgregarCliente').style.display = 'block';
    }
    
    function cerrarModalAgregarCliente() {
        document.getElementById('modalAgregarCliente').style.display = 'none';
    }

    async function enviarCliente(event) {
        event.preventDefault();
        const form = document.getElementById('formAgregarCliente');
        const formData = new FormData(form);

        try {
            const response = await fetch('http://18.223.99.187/api/registerCliente.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            if (result.success) {
                alert('Cliente agregado con éxito.');
                cerrarModalAgregarCliente();
                cargarClientes(); // Actualizar la tabla después de agregar
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error al enviar el cliente:', error);
            alert('Error en la solicitud. Inténtalo de nuevo.');
        }
    }

    async function cargarClientes() {
        try {
            const response = await fetch('http://18.223.99.187/api/getClientes.php');
            if (!response.ok) {
                throw new Error('Error en la respuesta de la API: ' + response.status);
            }
            const clientes = await response.json();
            const tablaClientesBody = document.getElementById('tablaClientesBody');
            tablaClientesBody.innerHTML = ''; // Limpiar la tabla antes de llenarla

            if (Array.isArray(clientes) && clientes.length > 0) {
                clientes.forEach(cliente => {
                    const fila = document.createElement('tr');
                    fila.innerHTML = `
                        <td>${cliente.empresa}</td>
                        <td>${cliente.ciudad}</td>
                        <td>${cliente.estatus}</td>
                        <td>${parseFloat(cliente.presupuesto).toFixed(2)}</td>
                    `;
                    tablaClientesBody.appendChild(fila);
                });
            } else {
                const fila = document.createElement('tr');
                fila.innerHTML = `<td colspan="4">No se encontraron clientes.</td>`;
                tablaClientesBody.appendChild(fila);
            }
        } catch (error) {
            console.error('Error al cargar los clientes:', error);
        }
    }

    // Cargar clientes al cargar la página
    window.onload = cargarClientes;

    // Agregar la funcionalidad para mostrar y cerrar el modal al hacer clic en el botón
    document.getElementById('agregarCliente').addEventListener('click', mostrarModalAgregarCliente);
    document.querySelector('.close').addEventListener('click', cerrarModalAgregarCliente);
</script>

</body>

</body>
</html>