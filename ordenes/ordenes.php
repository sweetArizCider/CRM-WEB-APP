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
    <link rel="stylesheet" href="../login_inte/estilo.css">
    <style>
        /* Agregar estilos para que el modal se centre */
        #modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 1000; /* Asegura que el modal esté sobre otros elementos */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
        }


        .table {
            margin-top: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        #agregarorden {
            background-color: #2A48CC;
            color: #FFFFFF;
            border: none;
            border-radius: 8px; /* Bordes redondeados */
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s; /* Efecto de transición */
        }

        #agregarorden:hover {
            background-color: #1A2F8D; /* Cambio de color al pasar el ratón */
            transform: scale(1.05); /* Efecto de zoom */
        }

        #formRequisicion button {
            background-color: #28A745;
            color: #FFFFFF;
            border: none;
            border-radius: 8px; /* Bordes redondeados */
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s; /* Efecto de transición */
        }

        #formRequisicion button:hover {
            background-color: #218838; /* Cambio de color al pasar el ratón */
            transform: scale(1.05); /* Efecto de zoom */
        }

         /* Estilo para el modal */
         #modalEdit {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Estilización del botón */
button[type="submit"] {
    background-color: #4CAF50; /* Verde */
    color: white;
    border: none;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #45a049; /* Verde oscuro */
}

/* Estilización del select */
select {
    width: 100%;
    padding: 8px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    outline: none;
    box-sizing: border-box; /* Asegura que el padding esté incluido en el ancho total */
}

select:focus {
    border-color: #4CAF50; /* Color de borde cuando se enfoca */
    box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
}

/* Estilización del botón "Editar órden" */
#editarorden {
    background-color: #008CBA; /* Azul */
    color: white;
    border: none;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

#editarorden:hover {
    background-color: #007bb5; /* Azul oscuro */
    transform: scale(1.05); /* Efecto de aumento */
}

#editarorden:focus {
    outline: none; /* Eliminar el borde de enfoque */
}



    </style>
</head>


<body>
    <div class="box-inicio">
        <header><?php include("../login_inte/navbar.php"); ?></header>
        <br>
        <h1>Requisiciones</h1>
        <button id="agregarorden" onclick="mostrarModal()">Añadir órden</button>
        <button id="editarorden" onclick="mostrarModalEdit()">Editar órden</button>

        <br><br>

        <div class="table">
            <table id="tablaRequisiciones">
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

        <!-- Modal para añadir una nueva requisición -->
        <div id="modal">
            <div class="modal-content">
                <span class="close" onclick="cerrarModal()">&times;</span>
                <h2>Agregar Requisición</h2>
                <form id="formRequisicion" onsubmit="enviarRequisicion(event)">
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


    <script>
        function mostrarModalEdit() {
            document.getElementById('modalEdit').style.display = 'block';
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

        function mostrarModal() {
            document.getElementById('modal').style.display = 'block';
        }

        function cerrarModal() {
            document.getElementById('modal').style.display = 'none';
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
