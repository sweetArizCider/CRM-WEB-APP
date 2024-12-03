<?php 
include("../service/connection.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/PHPMailer-master/src/SMTP.php';

if(!empty($_POST)){
    $email = $_POST["correo"];
    $sql = "SELECT * from Users where email = '$email';";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    
    if(mysqli_num_rows($result) > 0){
    
    $mail = new PHPMailer(true);

    try {
    $mail->isSMTP();                                        
    $mail->Host       = 'smtp.gmail.com';                 
    $mail->SMTPAuth   = true;                                 
    $mail->Username   = 'crmutt450@gmail.com';                  
    $mail->Password   = 'sisk qxtk joas ufek';                         
    $mail->Port       = 587;                                   
    $mail->setFrom('crmutt450@gmail.com', 'Mailer');
    $mail->addAddress($row["email"], $row["nombre"]);    


    $mail->isHTML(true);                                 
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();
    echo '
    <script>
    alert("Correo enviado");
    
    </script>
    ';
    } catch (Exception $e) {
    echo '<script>
    alert("Message could not be sent. Mailer Error: {'.$mail->ErrorInfo.'}");
 
    </script>';
    }
}else {
    echo '
    <script>
    alert("No se encontro correo");
    window.location = "home.html";
    </script>
    ';
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>recordar</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <form class="rc" method="POST" action="<?php $_SERVER["PHP_SELF"];?>">
        <h2>Olvide mi contraseña</h2>
        <label for="Correo">Ingresa tu direccion de correo electronico asociada con tu cuenta de usuario</label>
        <input type="email" placeholder="ejem@gmail.com" id="Correo" name="correo">
        <input type="submit" class="button" value="Enviar">
    </form>
</body>
</html>
