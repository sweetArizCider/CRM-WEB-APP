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
    <title>Requisiciones</title>
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
        <h1>¡Gestiona tus solicitudes!</h1>
        <p>Completa el formulario de requisición y nuestro equipo procesará tu solicitud a la brevedad.</p>
        <div class="d-flex justify-content-end gap-2 mb-3">
            <button id="agregarorden" class="btn btn-primary btn-rounded agregarordenb" onclick="mostrarModal()">Añadir <img src="../img/add.svg" alt="" style="width: 20px; justify-content: center"></button>
            <button id="editarorden" class="btn btn-secondary btn-rounded editarordenb" onclick="mostrarModalEdit()">Editar <img src="../img/edit.svg" alt="" style="width: 20px; justify-content: center"></button>
        </div>

        <div class="table-responsive">
            <table id="tablaRequisiciones" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID Requisición</th>
                        <th>Cliente ID</th>
                        <th>Empresa</th>
                        <th>Fecha Creación</th>
                        <th>Fecha Envío</th>
                        <th>Fecha Entrega</th>
                        <th>Estado</th>
                        <th>Cantidad Servicio</th>
                        <th>Cantidad Dinero</th>
                        <th>Servicio</th>
                        <th>Motivo Cancelación</th>
                        <th>Motivo Posposición</th>
                        <th>Motivo Reembolso</th>
                        <th>Fecha Alteración</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los datos se agregarán aquí dinámicamente -->
                </tbody>
            </table>
        </div>
    </div>
     <!-- Modal para añadir una nueva requisición -->
     <div id="modal">
            <div class="modal-content">
                <span class="close" onclick="cerrarModal()">&times;</span>
                <h2>Agregar Requisición</h2>
                <form id="formRequisicion" onsubmit="enviarRequisicion(event)">
                    <!-- Formulario aquí -->
                    <label for="fkidCliente">Cliente:</label>
                    <select id="fkidCliente" name="fkidCliente" required>
                        <!-- Opciones se llenarán dinámicamente -->
                    </select>
                    <br><br>
                    <label for="fechaCreacion">Fecha de Creación:</label>
                    <input type="date" id="fechaCreacion" name="fechaCreacion" required>
                    <br><br>
                    <label for="cantidadServicio">Cantidad de Servicio:</label>
                    <input type="number" id="cantidadServicio" name="cantidadServicio" required>
                    <br><br>
                    <label for="cantidadDinero">Cantidad de Dinero:</label>
                    <input type="number" step="0.01" id="cantidadDinero" name="cantidadDinero" required>
                    <br><br>
                    <label for="servicio">Servicio:</label>
                    <input type="text" id="servicio" name="servicio" required>
                    <br><br>
                    <button type="submit">Enviar</button>
                </form>
            </div>
        </div>
    </div>

    <div id="modalEdit">
            <div class="modal-content">
                <span class="close" onclick="cerrarModalEdit()">&times;</span>
                <h2>Editar Requisición</h2>
                <form id="editRequisicion" onsubmit="enviarEdicion(event)">
                    <!-- Formulario aquí -->
            <label for="idRequisicion">ID Requisición:</label>
            <input type="text" id="idRequisicion" name="idRequisicion" required>
            
            <label for="estado">Estado:</label>
            <select id="estado" name="estado" required>
                <option value="Creado">Creado</option>
                <option value="En proceso">En proceso</option>
                <option value="Enviado">Enviado</option>
                <option value="Entregado">Entregado</option>
                <option value="Cancelado">Cancelado</option>
                <option value="Pospuesto">Pospuesto</option>
                <option value="Reembolsado">Reembolsado</option>
            </select>
            
            <label for="cantidadServicio">Cantidad de Servicio:</label>
            <input type="number" id="cantidadServicio" name="cantidadServicio">
            
            <label for="cantidadDinero">Cantidad de Dinero:</label>
            <input type="number" step="0.01" id="cantidadDinero" name="cantidadDinero">
            
            <label for="servicio">Servicio:</label>
            <input type="text" id="servicio" name="servicio">
            
            <label for="fechaAlteracion">Fecha de Alteración:</label>
            <input type="date" id="fechaAlteracion" name="fechaAlteracion">
            
            <label for="motivoCancelacion">Motivo Cancelación:</label>
            <input type="text" id="motivoCancelacion" name="motivoCancelacion">
            
            <label for="motivoPosposicion">Motivo Posposición:</label>
            <input type="text" id="motivoPosposicion" name="motivoPosposicion">
            
            <label for="motivoReembolso">Motivo Reembolso:</label>
            <input type="text" id="motivoReembolso" name="motivoReembolso">
            
            <button type="submit">Enviar</button>
        </form>
    </div>
</div>



    <script src="../css/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

    <script>
      function mostrarModal() {
    const modal = document.getElementById('modal');
    modal.style.display = 'block';
}

function cerrarModal() {
    const modal = document.getElementById('modal');
    modal.style.display = 'none';
}

function mostrarModalEdit() {
    const modalEdit = document.getElementById('modalEdit');
    modalEdit.style.display = 'block';
}

function cerrarModalEdit() {
    const modalEdit = document.getElementById('modalEdit');
    modalEdit.style.display = 'none';
}

// Cerrar modal al hacer clic fuera
window.onclick = function(event) {
    const modal = document.getElementById('modal');
    const modalEdit = document.getElementById('modalEdit');
    if (event.target === modal) cerrarModal();
    if (event.target === modalEdit) cerrarModalEdit();
};


function mostrarModalEdit() {
    document.getElementById('modalEdit').style.display = 'block';
    document.getElementById('modal').style.display = 'none'; // Cierra el otro modal si está abierto
}

function cerrarModalEdit() {
    document.getElementById('modalEdit').style.display = 'none';
}




        async function enviarEdicion(event) {
            event.preventDefault();
            const form = document.getElementById('editRequisicion');
            const formData = new FormData(form);

            try {
                const response = await fetch('http://18.223.99.187/api/modifyRequisicion.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();
                if (result.success) {
                    alert('Requisición modificada con éxito.');
                    cerrarModalEdit();
                    // Llamar a una función para actualizar la tabla si es necesario.
                    cargarDatos();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error al enviar la edición:', error);
                alert('Error en la solicitud. Inténtalo de nuevo.');
            }
        }


        async function cargarClientes() {
            try {
                const response = await fetch('http://18.223.99.187/api/getClientesNombre.php');
                if (!response.ok) {
                    throw new Error('Error en la respuesta de la API: ' + response.status);
                }
                const clientes = await response.json();
                const selectCliente = document.getElementById('fkidCliente');
                selectCliente.innerHTML = ''; // Limpiar opciones anteriores

                if (Array.isArray(clientes) && clientes.length > 0) {
                    clientes.forEach(cliente => {
                        const option = document.createElement('option');
                        option.value = cliente.idCliente;
                        option.textContent = cliente.empresa;
                        selectCliente.appendChild(option);
                    });
                } else {
                    console.log('No se encontraron clientes.');
                    const option = document.createElement('option');
                    option.textContent = 'No hay clientes disponibles';
                    selectCliente.appendChild(option);
                }
            } catch (error) {
                console.error('Error al cargar los clientes:', error);
            }
        }

        async function cargarDatos() {
            try {
                const response = await fetch('http://18.223.99.187/api/getRequisiciones.php');
                if (!response.ok) {
                    throw new Error('Error en la respuesta de la API de requisiciones: ' + response.status);
                }
                const requisiciones = await response.json();
                const tbody = document.querySelector('#tablaRequisiciones tbody');
                tbody.innerHTML = ''; // Limpiar datos antiguos

                requisiciones.forEach(requisicion => {
                    const tr = document.createElement('tr');
                    Object.values(requisicion).forEach(valor => {
                        const td = document.createElement('td');
                        td.textContent = valor;
                        tr.appendChild(td);
                    });
                    tbody.appendChild(tr);
                });
            } catch (error) {
                console.error('Error al cargar los datos de requisiciones:', error);
            }
        }

       

        async function enviarRequisicion(event) {
            event.preventDefault();
            const form = document.getElementById('formRequisicion');
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('http://18.223.99.187/api/createRequisicion.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();
                if (result.success) {
                    alert('Requisición creada con éxito.');
                    cerrarModal();
                    cargarDatos(); // Actualizar la tabla después de enviar
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error al enviar la requisición:', error);
                alert('Error en la solicitud. Inténtalo de nuevo.');
            }
        }
            async function enviarEdicion(event) {
        event.preventDefault();
        const form = document.getElementById('editRequisicion');
        const formData = new FormData(form);

        try {
            const response = await fetch('http://18.223.99.187/api/modifyRequisicion.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            if (result.success) {
                alert('Requisición modificada con éxito.');
                cerrarModalEdit();
                // Llamar a una función para actualizar la tabla si es necesario.
                cargarDatos();
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error al enviar la edición:', error);
            alert('Error en la solicitud. Inténtalo de nuevo.');
        }
    }

    window.onload = () => {
    cargarClientes();
    cargarDatos(); // Llamar al cargar la página para la tabla

    // Asegúrate de que los modales estén ocultos al cargar
    document.getElementById('modal').style.display = 'none';
    document.getElementById('modalEdit').style.display = 'none';
};


    </script>
</body>
</html>
