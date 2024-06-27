<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST['user'];
    $contraseña = $_POST['password'];

    // Aquí puedes procesar los datos como desees
    // Por ejemplo, realizar la verificación de usuario y contraseña
    require '../templates/conexion.php';

    $sql = "SELECT * FROM users";
    $results = mysqli_query($conn, $sql);
    foreach ($results as $result) {
        if ($usuario === $result['user'] && $contraseña === $result['password']) {
            // Establecer variables de sesión
            $_SESSION['usuario'] = $result['name'];
            $_SESSION['logueado'] = true;
            echo "Inicio de sesión exitoso";
        } else {
            echo "Usuario o contraseña incorrectos";
        }
    }
} else {
    echo "Método no permitido";
}
