<?php
require 'templates/NavBar.php';

if (isset($_SESSION['admin'])) $id = $_SESSION['admin'];
print_r($_SESSION);
$server = new server();
$tasks = $server->tasks();

?>

<div class="container mt-5">
    <div class="encabezados d-flex justify-content-between ">
        <h2 class="mb-4">Listado de Tareas</h2>
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#ModalCrearTarea">
            Crear Tarea
        </button>
    </div>

    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Tarea </th>
                <th>Cliente</th>
                <th>Empleado Asignado</th>
                <th>Fecha y hora</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($tasks as $task) : ?>
                <?php //asignar nombre 
                $employeeName = $server->getEmployee($task['employeeasigned']);
                $employeeAsignedName = $employeeName['name'] . $employeeName['lastname'];

                //estado de las tasks
                $state = "";
                if ($task['state'] == 1) $state = "Pendiente";
                if ($task['state'] == 0) $state = "Realizada";
                ?>
                <tr>
                    <td><?= $task['taskname'] ?></td>
                    <td><?= $task['client'] ?></td>
                    <td><?= $employeeAsignedName  ?> </td>
                    <td><?= $task['date'] . " " .  $task['time'] ?></td>
                    <td><?= $state ?></td>
                    <td>
                        <button data-bs-toggle="modal" data-bs-target="#editTask<?= $task['idtask'] ?>" class="btn btn-info btn">Editar</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTask<?= $task['idtask'] ?>">
                            Eliminar
                        </button>
                    </td>
                </tr>

                <!-- Modal Crear -->
                <div class="modal fade" id="ModalCrearTarea" tabindex="-1" aria-labelledby="ModalCrearTareaLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="ModalCrearTareaLabel">Crear Trea</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary">Crear Tarea</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal editar tasks -->
                <div class="modal fade" id="editTask<?= $task['idtask'] ?>" tabindex="-1" aria-labelledby="editTask<?= $task['idtask'] ?>Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editTaskLabel">Edicion de tareas</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form name="editTask" method="POST">
                                    <input type="hidden" name="id" value="<?= $task['idtask'] ?>">
                                    <div class="m-4">
                                        <label for="name" class="form-label fs-5">Nombre Tarea</label>
                                        <input type="text" class="form-control mb-3" id="name" name="name" value="<?= $task['taskname'] ?>">
                                        <label for="name" class="form-label fs-5">Cliente</label>
                                        <input type="text" class="form-control mb-3" id="client" name="client" value="<?= $task['client'] ?>">
                                        <label for="name" class="form-label fs-5">Empleado Asignado</label>
                                        <select name="assignedemployee" class="form-select mb-3" aria-label="Default select example" name="employeeasigned">
                                            <?php foreach ($server->getEmployees() as $employee) : ?>
                                                <option value="<?= $employee['iduser'] ?>"><?= $employee['name'] . ' ' . $employee['lastname'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="name" class="form-label fs-5">Fecha de Inicio</label>
                                        <input type="date" class="form-control mb-3" id="date" name="date" value="<?= $task['date'] ?>">
                                        <label for="time" class="form-label fs-5"> Hora Tarea </label>
                                        <input type="time" class="form-control mb-3" id="time" name="time" value="<?= $task['time'] ?>">
                                        <label for="name" class="form-label fs-5">Estado</label>
                                        <select class="form-select mb-3" aria-label="Default select example" name="state">
                                            <?php
                                            $realizada = "";
                                            $pendiente = "";
                                            if ($task['state'] == 1) $realizada = "selected";
                                            if ($task['state'] == 0) $pendiente = "selected";

                                            ?>
                                            <option <?= $realizada ?> value="1">Pendiente</option>
                                            <option <?= $pendiente ?> value="0">Realizada</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer p-1">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" onclick="editTasks( <?= $task['idtask'] ?>, editTask.name.value, editTask.client.value, editTask.assignedemployee.value,editTask.state.value,editTask.date.value,editTask.time.value)" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal eliminar tasks -->
                <div class="modal fade" id="deleteTask<?= $task['idtask'] ?>" tabindex="-1" aria-labelledby="deleteTask<?= $task['idtask'] ?>Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="ModalCrearTareaLabel">Confirmacion de eliminacion</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Esta seguro de eliminar la tarea <?= " " . $task['taskname']; ?> ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="deleteTask(<?= $task['idtask'] ?>)" class="btn btn-danger">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
<script>
    function editTasks(id, name, client, assignedemployee, state, date, time) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log(this.responseText);
                location.reload();
            }
        };
        xmlhttp.open("GET", "server/redirects.php?action=editTask&id=" + id + "&name=" + name + "&client=" + client + "&assignedemployee=" + assignedemployee + "&state=" + state + "&date=" + date + "&time=" + time, true);
        xmlhttp.send();
    }

    function deleteTask(id) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log(this.responseText);
                //location.reload();
            }
        };
        xmlhttp.open("GET", "server/redirects.php?action=deleteTask&id=" + id, true);
        xmlhttp.send();
    }
</script>