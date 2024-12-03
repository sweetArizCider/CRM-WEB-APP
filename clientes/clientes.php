<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../login_inte/estilo.css">

    <style>
    /* Agregar estilos específicos de la página si es necesario */

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
    /* Estilo para el modal */
    .modal {
    display: none; /* Oculto por defecto */
    position: fixed;
    z-index: 1000; /* Número alto para asegurarse de que esté encima de otros elementos */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro */
    
}

/* Contenido del modal */
.modal-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 20px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    width: 400px;
    z-index: 1001; /* Un número mayor que el del contenedor modal para estar en la capa superior */
}

/* Estilo para el botón de cerrar */
.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    cursor: pointer;
}

/* Botones y formulario */
form {
    display: flex;
    flex-direction: column;
}

form label,
form input {
    margin-bottom: 10px;
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

#agregarCliente {
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

#agregarCliente:hover {
    background-color: #007bb5; /* Azul oscuro */
    transform: scale(1.05); /* Efecto de aumento */
}


    
</style>
</head>

<body>
    <div class="box-inicio">
        <header><?php include("../login_inte/navbar.php"); ?></header>
        <br>
        <h1>Gestión de Clientes</h1>
        <button id="agregarCliente" onclick="mostrarModalAgregarCliente()">Añadir Cliente</button>

        <br><br>

        <div class="table">
            <table id="tablaClientes">
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
        <div id="modalAgregarCliente" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="cerrarModalAgregarCliente()">&times;</span>
        <h2>Agregar Cliente</h2>
        <form id="formAgregarCliente" onsubmit="enviarCliente(event)">
            <label for="empresa">Empresa:</label>
            <input type="text" id="empresa" name="empresa" required>
            <br><br>
            
            <label for="cdMatriz">CD Matriz:</label>
            <input type="text" id="cdMatriz" name="cdMatriz" required>
            <br><br>
            
            <label for="presupuesto">Presupuesto:</label>
            <input type="number" step="0.01" id="presupuesto" name="presupuesto" required>
            <br><br>
            
            <label for="estatus">Estatus:</label>
            <select id="estatus" name="estatus" required>
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
            </select>
            <br><br>
            
            <label for="calle">Calle:</label>
            <input type="text" id="calle" name="calle" required>
            <br><br>
            
            <label for="cp">Código Postal:</label>
            <input type="text" id="cp" name="cp" required>
            <br><br>
            
            <label for="numExterior">Número Exterior:</label>
            <input type="text" id="numExterior" name="numExterior" required>
            <br><br>
            
            <button type="submit">Agregar</button>
        </form>
    </div>
</div>


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