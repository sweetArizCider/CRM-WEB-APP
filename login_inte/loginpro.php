<?php

$api_url = 'http://18.223.99.187/api/login.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = filter_input(INPUT_POST, "correo-login", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "pass-login", FILTER_SANITIZE_SPECIAL_CHARS);

    $post_data = [
        'email' => $correo,
        'password' => $password
    ];

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_HEADER, false);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $response_data = json_decode($response, true);

    if ($http_code == 200 && isset($response_data['success']) && $response_data['success']) {
        if (isset($response_data['token']) && isset($response_data['nombre']) && isset($response_data['apellido'])) {
            
            session_start();
            $_SESSION['token'] = $response_data['token'];
            $_SESSION['nombre'] = $response_data['nombre']; 
            $_SESSION['apellido'] = $response_data['apellido']; 
            $_SESSION['email'] = $correo; 
    
            echo '<script>
            alert("Bienvenido");
            window.location = "home.php";
            </script>';
        } else {
            echo '<script>
            alert("Error: ' . htmlspecialchars($response_data['message']) . '");
            window.location = "/login_inte/login.html";
            </script>';
        }
    } else {
        echo '<script>
        alert("Usuario no encontrado o credenciales incorrectas");
        window.location = "/login_inte/login.html";
        </script>';
    }
    
}
?>
