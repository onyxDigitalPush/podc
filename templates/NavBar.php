<?php
session_start();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</head>
<?php
// Incluir el archivo que contiene la clase
include 'server/server.php';
$server = new server();

//si es 1 es admin si es 0 es empleado
if (isset($_SESSION['iduser'])) {
    $admin = $server->employeeOnCharge($_SESSION['iduser']);
}
if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true) {
    echo "Bienvenido, " . $_SESSION['usuario'];
} else {
    echo "No has iniciado sesión.";
}
?>
<body>
    <nav class="navbar" style="background-color: #e3f2fd;">
        <div class="container-fluid ">
            <div class="d-flex">
                <img src="img/icons8-logo-48.png" alt="Logo" width="60" height="50" class="d-inline-block align-text-top">
                <label for="" class="fs-3">SIMACOL SAS</label>
            </div>
            <?php if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true) : ?>
                <button onclick="redirectToTodo()" class="btn btn-outline-success me-5 btn btn-sm fs-3 " type="button">Ir a Tareas</button>
                <?php if ($admin == 1) : ?>
                <button onclick="redirectToAdminEmployee()" class="btn btn-outline-success me-5 btn btn-sm fs-3 " type="button">Admin Empleados</button>
                <?php endif; ?>
                <div class="d-flex ">
                    <p class="pe-4 pt-2 fs-5">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>.</p>
                    <form action="server/logout.php" method="POST">
                        <button type="submit" class="btn btn-danger pt-2">Cerrar sesión</button>
                    </form>

                </div>
            <?php else : ?>
                <form action="server/login.php" method="POST">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#login"> <svg style="width: 40px; height: 35px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M256 73.825a182.18 182.18 0 0 0-182.18 182.18c0 100.617 81.567 182.17 182.18 182.17a182.175 182.175 0 1 0 0-364.35zm-18.096 86.22a18.099 18.099 0 0 1 36.197 0v53.975a18.099 18.099 0 0 1-36.197 0zM256 348.589a92.413 92.413 0 0 1-32.963-178.751v33.38a62.453 62.453 0 1 0 65.93 0v-33.38A92.415 92.415 0 0 1 256 348.588z" data-name="Login" />
                        </svg>Log
                        in
                    </button>
                </form>
            <?php endif; ?>


        </div>
    </nav>



    <!-- Modal -->
    <div class="modal fade" id="login" tabindex="-1" aria-labelledby="loginLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="img/icons8-logo-48.png" alt="Logo" width="60" height="50" class="d-inline-block align-text-top">
                    <label for="" class="fs-3">SIMACOL </label>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="container-fluid">
                    <?php if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true) : ?>
                        <div class="d-flex">
                            <form action="server/logout.php" method="POST">

                                <button type="submit" class="btn btn-danger ">Cerrar sesión</button>
                            </form>

                        </div>
                    <?php else : ?>
                        <form>
                            <div class="d-grid justify-content-around">
                                <label class="fs-5" for="user">Usuario: </label>
                                <input type="text" id="user" name="user" class="form-control"> <br>
                                <label class="fs-5" for="password">Contraseña: </label>
                                <input type="password" id="password" name="password" class="form-control">
                            </div>
                            <div class="modal-footer mt-3">

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" onclick="logearse()">Ingresar</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>




    <script>
        function logearse() {
            // Obtener los valores de los campos del formulario
            var usuario = document.getElementById('user').value;
            var contraseña = document.getElementById('password').value;

            // Crear una instancia de XMLHttpRequest
            var xmlhttp = new XMLHttpRequest();

            // Configurar la función de callback
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    // Manejar la respuesta cuando es exitosa
                    if (this.responseText === "Inicio de sesión exitoso") {
                        // Recargar la página
                        window.location.reload();
                    } else {
                        alert(this.responseText);
                    }
                } else if (this.readyState === 4) {
                    // Manejar otros estados (por ejemplo, error 404)
                    alert('Error: ' + this.status + ' ' + this.responseText);
                }
            };

            // Configurar la solicitud
            xmlhttp.open("POST", "server/login.php", true);
            xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Enviar los datos
            xmlhttp.send("user=" + encodeURIComponent(usuario) + "&password=" + encodeURIComponent(contraseña));
        }

        //solo redirigir
        function redirectToTodo() {
            window.location.href = 'todo.php';
        }

        function redirectToAdminEmployee() {
            window.location.href = 'adminEmployees.php';
        }
    </script>