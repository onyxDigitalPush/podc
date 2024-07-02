<?php
require 'templates/NavBar.php';


//Traer los empleados
$employees = $server->getEmployees();

?>


<div class="container mt-5">
    <h2 class="mb-4">Listado de Empleados</h2>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cargo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($employees as $empleado) {
                if($empleado['encargado'] == 1) $puesto = "Encargado";
                else $puesto = "Empleado";

                echo "<tr>
                    <td>{$empleado['name']}</td>
                    <td>{$empleado['lastname']}</td>
                    <td> {$puesto}</td>
                    <td>
                        <button onclick='editEmployee({$empleado['iduser']})' class='btn btn-primary btn-sm'>Editar</button>
                        <button onclick='deleteEmployee({$empleado['iduser']})' class='btn btn-danger btn-sm'>Eliminar</button>               
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>


    
</div>

<script>
    function editEmployee(id) {


    }
</script>
</body>

</html>