<?php

// URL de la API de login
$api_url = 'http://18.223.99.187/api/login.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = filter_input(INPUT_POST, "correo-login", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "pass-login", FILTER_SANITIZE_SPECIAL_CHARS);

    // Preparar los datos para enviar a la API
    $post_data = [
        'email' => $correo,
        'password' => $password
    ];

    // Inicializar cURL
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_HEADER, false);

    // Ejecutar la solicitud y obtener la respuesta
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Decodificar la respuesta JSON
    $response_data = json_decode($response, true);

    if ($http_code == 200 && isset($response_data['success']) && $response_data['success']) {
        if (isset($response_data['token']) && isset($response_data['nombre']) && isset($response_data['apellido'])) {
            // Guardar el token, el nombre y el apellido en la sesión
            session_start();
            $_SESSION['token'] = $response_data['token'];
            $_SESSION['nombre'] = $response_data['nombre']; // Almacenar el nombre del usuario
            $_SESSION['apellido'] = $response_data['apellido']; // Almacenar el apellido del usuario
            $_SESSION['email'] = $correo; // Puedes agregar más detalles si es necesario
    
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
