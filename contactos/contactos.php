
<?php
include("../service/connection.php");
$sql = "SELECT  * FROM  contactos";
$result = mysqli_query($conn,$sql);
if(!$result){
    echo "problema con la conexion";
}

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
    <title> LEAR - Contactos</title>
    <link rel="shortcut icon" href="../img/learlogo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/normalized.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>

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
            background-color: #451851 !important;
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
    #myModal, #myModaal {
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
    .iconEditarBorrar{
        border: none;
        background: none;
    }

    </style>


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
       
        <h1>¡Mantén tus contactos actualizados!</h1>
        <p>Gestiona y organiza toda la información de tus contactos de manera eficiente para facilitar tus relaciones comerciales.</p>
        <div class="d-flex justify-content-end gap-2 mb-3">
       
        <input class="btn btn-primary btn-rounded agregarordenb" type="submit" id="agregarcontacto" value="+" onclick="mostrarMyModal()">
        <a href="exportcon.php"><button class="botonexportar btn btn-secondary btn-rounded editarordenb">Export</button></a>
        </div>
        
    <div class="table table-responsive">
        <div class="table" >
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Direccion</th>
                        <th>Email</th>
                        <th>Telefono</th>
                        <th>Endswitch</th> 
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                    <tr>
                        <td>".$row["Empresa"]."</td>
                        <td>".$row["Nombre"]."</td>
                        <td>".$row["Apellido"]."</td>
                        <td>".$row["Direccion"]."</td>
                        <td>".$row["Correo"]."</td>
                        <td>".$row["Numero"]."</td>
                        <td>
                            <div class='button-container-icon'>
                                <button class='iconEditarBorrar'><img src='../img/editarcontacto.svg' alt='editar' width='25px' height='25px' align='start' onclick='edit_con(".$row["id_contacto"].")'></button>
                                <button class='iconEditarBorrar' id='btneliminar' onclick='confirmDelete(".$row["id_contacto"].")'>
                                    <img src='../img/eliminarcontacto.svg' alt='eliminar' width='25px' height='25px' align='end'>
                                </button>
                            </div>
                        </td>
                    </tr>
                    "; 
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    

    <div id="myModal" class="modal">
        <div class="modal-content" style="max-height: 90vh; overflow-y: auto;">
        <span class="close" onclick="cerrarModalAgregarCliente()">&times;</span>
            <h2>¿Está seguro que desea eliminar este contacto?</h2>
            
            <p>
                <div class="button-container">
                    <button class="butonelim btn btn-primary btn-rounded agregarordenb"  id="btneliminar-confirm">Eliminar</button>
                    <button class="butonelim btn btn-secondary btn-rounded editarordenb"  id="btncancelar">Cancelar</button>
                </div>
            </p>
        </div>
    </div>

   
   
    <div id="myModaal" class="modal">
        <div class="modal-content" style="max-height: 90vh; overflow-y: auto;">
        <span class="close" onclick="cerrarMyModal()">&times;</span>
    <!-- Esto es el contenido de la ventana -->

    <form  id="ventana" method="POST" action="añadircontacto.php" name="añacon">
   <h2>Agregar Contacto</h2>
   <div class="mb-3">
        <label for="Empresa" class="form-label">Empresa</label>
        <input type="text" placeholder="Escribe la empresa" id="Empresa" name="contacto-e" class="form-control">
   </div>
        <div class="mb-3">
        <label for="Nombre" class="form-label">Nombre</label>
        <input type="text" placeholder="Escribe el nombre" id="Nombre" name="contacto-n" class="form-control">
        </div>
        <div class="mb-3">
        <label for="ApellidoP" class="form-label">Apellido </label>
        <input type="text" placeholder="Escribe el apellido " id="ApellidoP" name="contacto-a" class="form-control">
        </div>
        <div class="mb-3">
        <label for="Telefono" class="form-label">Telefono</label>
        <input type="tel" placeholder="Escribe el numero" id="Telefono" name="contacto-t" class="form-control">
        </div>
        <div class="mb-3">
        <label for="Direccion" class="form-label">Direccion</label>
        <input type="text" placeholder="Escribe la direccion" id="" name="contacto-d" class="form-control">
        </div>
        <div class="mb-3">
        <label for="Correo" class="form-label">Correo</label>
        <input type="email" placeholder="ejem@gmail.com" id="Correo" name="contacto-c" class="form-control">
        <br>
        <button id="Añadir" class="btn btn-primary btn-rounded agregarordenb" type="submit" onclick="return validateForm()">Añadir</button>
        
    </form>
        </div>
    </div>
</div>
    <script src="../css/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function mostrarMyModal() {
        document.getElementById('myModaal').style.display = 'block';
    }
    
    function cerrarMyModal() {
        document.getElementById('myModaal').style.display = 'none';
    }

        var modal = document.getElementById("myModal");
        var span = document.getElementsByClassName("close")[0];
        var btnc = document.getElementById("btncancelar");
        var btnEliminarConfirm = document.getElementById("btneliminar-confirm");
        const mostrarVentanaBtn = document.getElementById('agregarcontacto');


        function confirmDelete(id) {
            modal.style.display = "block";
            btnEliminarConfirm.onclick = function() {
                // Enviar la solicitud de eliminación al servidor
                fetch(`eliminar_contacto.php?id=${id}`)
                    .then(response => response.text())
                    .then(data => {
                        alert(data); // Mostrar la respuesta del servidor
                        modal.style.display = "none";
                        location.reload(); // Recargar la página para reflejar los cambios
                    })
                    .catch(error => console.error('Error:', error));
            };
        }

        mostrarVentanaBtn.addEventListener('click', function() {
    ventana.style.display = 'block';
    fondo.style.display = 'block';
});


        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        btnc.onclick = function() {
            modal.style.display = "none";
        }

        function edit_con(a) {
            window.location = "detallecontacto_edit.php?id=" + a;
        }
    </script>



   

    

    
</body>
</html>