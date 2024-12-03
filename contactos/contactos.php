
<?php
include("../service/connection.php");
$sql = "SELECT  * FROM  contactos";
$result = mysqli_query($conn,$sql);
if(!$result){
    echo "problema con la conexion";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../login_inte/estilo.css">

</head>


<body>
    <div class="box-inicio">
        <header><?php include("../login_inte/navbar.php"); ?></header>
        <br>  
        <h1>Contactos</h1>
        <input type="submit" id="agregarcontacto" value="    +    ">
        <a href="exportcon.php"><button class="botonexportar">Export</button></a>
        
        <div class="table">
            <table>
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
                                <button><img src='../img/editar.png' alt='editar' width='25rem' height='25rem' align='start' onclick='edit_con(".$row["id_contacto"].")'></button>
                                <button id='btneliminar' onclick='confirmDelete(".$row["id_contacto"].")'>
                                    <img src='../img/eliminar.png' alt='eliminar' width='25rem' height='25rem' align='end'>
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
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>¿Está seguro que desea eliminar este contacto?</h2>
            <br>
            <p>
                <div class="button-container">
                    <button class="butonelim" id="btneliminar-confirm">Eliminar</button>
                    <button class="butonelim" id="btncancelar">Cancelar</button>
                </div>
            </p>
        </div>
    </div>

    <script>
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


   <style>
    .modal {
  display: none; /* La modal está oculta por defecto */
  position: fixed;
  z-index: 1; /* Aparece sobre otros elementos */
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4); /* Fondo oscuro */
  
}

/* Estilos para el contenido de la modal */
.modal-content {
  border-radius: 5px;
  background-color: #fff;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width: 500px;
  display: block;
  
  
}

/* Estilos para el botón de cierre (X) */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

</style>

    <!-- Este es el cuadro en el que salen -->
    <div id="fondo" ></div>
   

    <!-- Esto es el contenido de la ventana -->
    <form  id="ventana" method="POST" action="añadircontacto.php" name="añacon">
    <button type="button" id="cerrarVentana">X</button> <h2>Agregar Contacto</h2>

        <label for="Empresa">Empresa</label>
        <input type="text" placeholder="Escribe la empresa" id="Empresa" name="contacto-e">

        <label for="Nombre">Nombre</label>
        <input type="text" placeholder="Escribe el nombre" id="Nombre" name="contacto-n">

        <label for="ApellidoP">Apellido </label>
        <input type="text" placeholder="Escribe el apellido " id="ApellidoP" name="contacto-a">

        <label for="Telefono">Telefono</label>
        <input type="tel" placeholder="Escribe el numero" id="Telefono" name="contacto-t">

        <label for="Direccion">Direccion</label>
        <input type="text" placeholder="Escribe la direccion" id="" name="contacto-d">

        <label for="Correo">Correo</label>
        <input type="text" placeholder="ejem@gmail.com" id="Correo" name="contacto-c">
        <br>
        <button id="Añadir" type="submit" onclick="return validateForm()">Añadir</button>
        
    </form>

    <style>
    #agregarcontacto{
    background-color: rgb(42, 72, 204);
    font-size: 15px;
    color: #FFFFFF;
    cursor: pointer;
    margin-bottom: 5px;
    
    }
    #ventana {
    display: none; /* Ocultar por defecto */
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 400px;
    padding: 20px;
    background-color: rgb(226, 223, 223);
    border: 1px solid #ccc;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    border-radius: 5px;
    
    }
    #fondo {
    display: none; /* Ocultar por defecto */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 999;
    }
    #cerrarVentana{
    background-color:red;
    color: #FFFFFF;
    cursor: pointer;
    padding: 5px 8px;
    font-size: 18px;
    border: none;
    border-radius: 5px;
    margin-bottom: 15px;
    outline: none;  
   }
   #Añadir{
    background-color: rgb(42, 72, 204);
    color: #FFFFFF;
    cursor: pointer;
    padding: 9px 8px;
    font-size: 17px;
    border: black;
    border-radius: 10px;
    margin-bottom: 25px;
    outline: none;  
   }

    </style>
</body>
</html>