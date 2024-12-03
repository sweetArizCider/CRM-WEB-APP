<?php 
include("../service/connection.php");
 if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $correo = filter_input(INPUT_POST, "contacto-c", FILTER_SANITIZE_SPECIAL_CHARS);
    $direccion = filter_input(INPUT_POST, "contacto-d", FILTER_SANITIZE_SPECIAL_CHARS);
    $apellido = filter_input(INPUT_POST, "contacto-a", FILTER_SANITIZE_SPECIAL_CHARS);
    $telefono = filter_input(INPUT_POST, "contacto-t", FILTER_SANITIZE_SPECIAL_CHARS);
    $nombre = filter_input(INPUT_POST, "contacto-n", FILTER_SANITIZE_SPECIAL_CHARS);
    $empresa = filter_input(INPUT_POST, "contacto-e", FILTER_SANITIZE_SPECIAL_CHARS);
    

    $sql = "INSERT INTO `contactos`(`Nombre`, `Apellido`, `Direccion`, `Correo`, `Numero`,`Empresa`) 
    VALUES ('$nombre','$apellido','$direccion','$correo','$telefono','$empresa')";
      mysqli_query($conn,$sql);
      echo '
      <script>
        alert("Aqui esta su orden doncangrejo")
        window.location = "contactos.php";
      </script>
      ';
 }
 mysqli_close($conn);

?>