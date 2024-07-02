<?php
include 'templates/NavBar.php';
?>
<style>
    header {
        background-image: url('path/to/your/image.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 350px;
        /* Ajustar la altura según sea necesario */
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
    }

    .empresa {
        font-size: 80px;
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;

    }
    .subempresa{
        font-size: 55px;
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    }
</style>
<header class="bg-primary text-white text-center py-5" style="background-image:url('img/cocina.jpg') ;">
    <div class="container">
        <h1 class="display-4 empresa "><img src="img/icons8-logo-48.png" alt="Logo" width="75" height="70">
        Simacol</h1>
        <p class="lead fs-5 subempresa">Mantenimiento de Equipos de Cocinas Industriales</p>
    </div>
</header>

<!-- Main Content -->
<main class="container my-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <h2>Bienvenido a Simacol</h2>
            <p>Ofrecemos servicios de mantenimiento de alta calidad para equipos de cocinas industriales.</p>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-light text-center py-4">
    <div class="container">
        <p class="mb-0">&copy; 2024 Simacol. Todos los derechos reservados.</p>
    </div>
</footer>