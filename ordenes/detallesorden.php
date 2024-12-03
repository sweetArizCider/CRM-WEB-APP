<?php
include("../service/connection.php");
$sql = "SELECT  * FROM  DetOrdenes";
$result = mysqli_query($conn,$sql);
if(!$result){
    echo "problema con la conexion";
}
?>
<!DOCTYPE html>
<html lang="en">
<>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../login_inte/estilo.css">
</head>
<body>

<div class="box-inicio">
<?php include("../login_inte/navbar.php"); ?>
        
        <br>  
    <h1>Detalles de la orden</h1>

    <form class="detalles" action="<?php $_SERVER["PHP_SELF"] ?>" method="POST"  name="editiorden">

    <label for="idOrden">Id_Orden</label>
    <input class="inpudetalles" type="text"  name="idOrden" id="">

    <label for="">Contacto</label>
    <input class="inpudetalles" type="text" id="Nombre" name="contactoedit-n" value="<?php echo $row["Nombre"] ?>">

    <label for="">Empresa</label>
    <input class="inpudetalles" type="text" id="Empresa" name="contactoedit-e" value="<?php echo $row["Empresa"] ?>">

    <label for="">Transacción</label>
    <input class="inpudetalles" type="text" name="tran" id="">

    <label for="">No.Empleado</label>
    <input class="inpudetalles" type="text" name="iduser" id="">

    <label for="">Fecha-inicio</label>
    <input class="inpudetalles" type="text"  name="" id="">

    <label for="">Fecha-fin</label>
    <input class="inpudetalles" type="text" name="" id="">

    <label for="">Estado</label>
    <input class="inpudetalles" type="text" name="" id="">

    <label for="">Producto</label>
    <input class="inpudetalles" type="text" name="" id="">

    <label for="">Cantidad</label>
    <input class="inpudetalles" type="text" name="" id="">

   
    <br>
    <button class="buttonactu" id="Actualizar" type="submit" onclick="return validateform()">Actualizar</button>
    
    
</form>
</div>

</body>
</html>