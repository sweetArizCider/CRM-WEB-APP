<?php
include("../service/connection.php");
    if(isset($_GET["id"])){  
        $d =  mysqli_real_escape_string($conn, $_GET['id']);
        $sql = "SELECT  * FROM  contactos where id_contacto = '$d'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($result);
  }else{
    header("location: contactos.php");
        exit;
  }
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $corr = filter_input(INPUT_POST,"contactoedit-c",FILTER_SANITIZE_SPECIAL_CHARS);
    $dir = filter_input(INPUT_POST,"contactoedit-d",FILTER_SANITIZE_SPECIAL_CHARS);
    $apell = filter_input(INPUT_POST,"contactoedit-a",FILTER_SANITIZE_SPECIAL_CHARS);
    $nom = filter_input(INPUT_POST,"contactoedit-n",FILTER_SANITIZE_SPECIAL_CHARS);
    $emp = filter_input(INPUT_POST,"contactoedit-e",FILTER_SANITIZE_SPECIAL_CHARS);
    $tel = filter_input(INPUT_POST,"contactoedit-t",FILTER_SANITIZE_SPECIAL_CHARS);

    $up = "UPDATE contactos set Nombre = '$nom',
     Apellido = '$apell', 
     Direccion = '$dir', 
     Correo = '$corr', 
     Numero ='$tel',
     Empresa = '$emp' where id_contacto = '$d'";
    
    $update = mysqli_query($conn,$up);
    
    header("location: contactos.php");
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content=" width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../login_inte/estilo.css">
 
   
</head>

<body>
<div class="box-inicio">
<?php include("../login_inte/navbar.php"); ?>
    <br>
     <h1>Detalles del contacto</h1>
    
    <form class="detalles" action="<?php $_SERVER["PHP_SELF"] ?>" method="POST"  name="editi">
    <label for="Empresa">Empresa</label>
    <input class="inpudetalles" type="text" id="Empresa" name="contactoedit-e" value="<?php echo $row["Empresa"] ?>">

    <label for="Nombre">Nombre</label>
    <input class="inpudetalles" type="text" id="Nombre" name="contactoedit-n" value="<?php echo $row["Nombre"] ?>">

    <label for="ApellidoP">Apellido</label>
    <input class="inpudetalles" type="text" id="ApellidoP" name="contactoedit-a" value="<?php echo $row["Apellido"] ?>">

    <label for="Telefono">Telefono</label>
    <input class="inpudetalles" type="tel"  id="Telefono" name="contactoedit-t" value="<?php echo $row["Numero"] ?>">

    <label for="Direccion">Direccion</label>
    <input class="inpudetalles"  type="text" id="" name="contactoedit-d" value="<?php echo $row["Direccion"] ?>">

    <label for="Correo">Correo</label>
    <input class="inpudetalles" type="email" id="Correo" name="contactoedit-c" value="<?php echo $row["Correo"] ?>">
    <br>
    <button class="buttonactu"  id="Actualizar"type="submit" onclick="return validateForm() ">Actualizar</button>
    </form>
    <br>
    <br>

    
    <script>
    function validateForm(){
            var b = document.forms["editi"]["contactoedit-a"].value;
            var a = document.forms["editi"]["contactoedit-n"].value;
            var c = document.forms["editi"]["contactoedit-t"].value;
            var d = document.forms["editi"]["contactoedit-d"].value;
            var f = document.forms["editi"]["contactoedit-c"].value;
            var g = document.forms["editi"]["contactoedit-e"].value;

            if(a == "" || b == "" || c == "" ||d == "" ||f == "" || g == "" ){
                alert("Favor de rellenar todos los campos ");
                return false;
            }
        }
    </script>

</body>