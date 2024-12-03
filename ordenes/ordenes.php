<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requisiciones</title>
    <link rel="stylesheet" href="../login_inte/estilo.css">
</head>
<body>
<div class="box-inicio">
    <header><?php include("../login_inte/navbar.php"); ?></header>
    <br>
    <h1>Requisiciones</h1>
    <input type="submit" id="agregarorden" value="Añadir órden">
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

    <script>
        async function cargarDatos() {
            try {
                const response = await fetch('http://18.223.99.187/api/getRequisiciones.php');
                console.log('Respuesta de la API:', response);

                if (!response.ok) {
                    throw new Error('Error en la respuesta de la API: ' + response.status);
                }

                const requisiciones = await response.json();
                console.log('Datos parseados:', requisiciones);

                // Seleccionamos la tabla y limpiamos el contenido anterior
                const tabla = document.querySelector('#tablaRequisiciones tbody');
                tabla.innerHTML = '';

                if (Array.isArray(requisiciones) && requisiciones.length > 0) {
                    requisiciones.forEach(requisicion => {
                        const fila = document.createElement('tr');
                        fila.innerHTML = `
                            <td>${requisicion.idRequisicion}</td>
                            <td>${requisicion.fkidCliente}</td>
                            <td>${requisicion.empresa}</td>
                            <td>${requisicion.fechaCreacion}</td>
                            <td>${requisicion.fechaEnvio || 'N/A'}</td>
                            <td>${requisicion.fechaEntrega || 'N/A'}</td>
                            <td>${requisicion.estado}</td>
                            <td>${requisicion.cantidadServicio}</td>
                            <td>${requisicion.cantidadDinero}</td>
                            <td>${requisicion.servicio}</td>
                            <td>${requisicion.motivoCancelacion || 'N/A'}</td>
                            <td>${requisicion.motivoPosposicion || 'N/A'}</td>
                            <td>${requisicion.motivoReembolso || 'N/A'}</td>
                            <td>${requisicion.fechaAlteracion || 'N/A'}</td>
                        `;
                        tabla.appendChild(fila);
                    });
                } else {
                    console.log('No se encontraron requisiciones.');
                    const fila = document.createElement('tr');
                    fila.innerHTML = '<td colspan="14">No hay datos disponibles.</td>';
                    tabla.appendChild(fila);
                }
            } catch (error) {
                console.error('Error al cargar los datos:', error);
            }
        }

        // Llamar a la función para cargar los datos al cargar la página
        window.onload = cargarDatos;
    </script>

    <style>
        #agregarorden {
            background-color: rgb(42, 72, 204);
            font-size: 15px;
            color: #FFFFFF;
            cursor: pointer;
            margin-bottom: 5px;
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

        th {
            background-color: #f4f4f4;
        }
    </style>
</div>
</body>
</html>
