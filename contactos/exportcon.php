<?php
include("../service/connection.php");
$sql = "SELECT  * FROM  contactos";
$result = mysqli_query($conn,$sql);
if(!$result){
    echo "problema con la conexion";
}
$table = "<table> <tr>
                    <th >Empresa</th>
                    <th >Nombre</th>
                    <th >Apellido</th>
                    <th >Direccion</th>
                    <th >email</th>
                    <th >telefono</th>
                    <th >endswitch</th> 
                </tr>" ;
                while( $row = mysqli_fetch_assoc($result)){
                   $table.= "
    
                  <tr>
                  <td>".$row["Empresa"]."</td>
                  <td>".$row["Nombre"]."</td>
                  <td>".$row["Apellido"]."</td>
                  <td>".$row["Direccion"]."</td>
                  <td>".$row["Correo"]."</td>
                  <td>".$row["Numero"]."</td>
                  <td><input  type='submit' class='button' onclick='header()'>
                  <input type='submit' class='button' value='editar' onclick='edit_con(".$row["id_contacto"].")'>
                  
                  </td>
                </tr>
                "; 
            }  $table.= "</table>";
            header("Content-Type:apllication/xls");
            header("Content-Disposition:attachment;filename=contacto.xls");
            echo $table;

?>
