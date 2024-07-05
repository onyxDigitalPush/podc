<?php
session_start();
require '../templates/conexion.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST['user'];
    $contraseña = $_POST['password'];

    $sql = "SELECT * FROM users";
    $results = mysqli_query($conn, $sql);

    $login_exitoso = false;

    while ($result = mysqli_fetch_assoc($results)) {
        if ($usuario === $result['user'] && $contraseña === $result['password']) {
            // Establecer variables de sesión
            $_SESSION['encargado'] = $result['encargado'];
            $_SESSION['usuario'] = $result['name'];
            $_SESSION['logueado'] = true;
            $_SESSION['iduser'] = $result['iduser'];
            $login_exitoso = true;
            break; // Salir del bucle una vez que se encuentre una coincidencia
        }
    }

    if ($login_exitoso) {
        echo "Inicio de sesión exitoso";
    } else {
        echo "Usuario o contraseña incorrectos";
    }
} else {
    echo "Método no permitido";
}
