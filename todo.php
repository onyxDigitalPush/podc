<?php
require 'templates/NavBar.php';

if (isset($_SESSION['admin'])) $id = $_SESSION['admin'];

$server = new server();
$tasks = $server->tasks();
$clients = $server->getClients();

?>

<div class="container mt-5">
    <div class="encabezados d-flex justify-content-between ">
        <h2 class="mb-4">Listado de Tareas</h2>
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#ModalCrearTarea">
            Crear Tarea
        </button>
    </div>


    <!-- Modal Crear -->
    <div class="modal fade" id="ModalCrearTarea" tabindex="-1" aria-labelledby="ModalCrearTareaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModalCrearTareaLabel">Crear Tarea</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createTaskForm" action="createTask" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label fs-5">Nombre Tarea</label>
                            <input type="text" class="form-control" name="name" value="">
                            <label for="client" class="form-label fs-5">Cliente</label>
                            <select class="form-select" name="client" aria-label="Default select example">
                                <option selected>Selecciona un cliente</option>
                                <?php
                                foreach ($clients as $client) :
                                ?>
                                    <option value="<?= $client['clientname']; ?>"><?= $client['clientname']; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                            <label for="assignedEmployee" class="form-label fs-5"> Empleado Asignado</label>
                            <select class="form-select" name="assignedEmployee" aria-label="Default select example">
                                <option selected>Selecciona un empleado</option>
                                <?php
                                foreach ($server->getEmployees() as $employee) :
                                ?>
                                    <option value="<?= $employee['iduser']; ?>"><?= $employee['name'] . " " . $employee['lastname']; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                            <label for="date" class="form-label fs-5">Fecha</label>
                            <input type="date" class="form-control" name="date">
                            <label for="time" class="form-label fs-5">Hora</label>
                            <input type="time" class="form-control" name="time">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="createTask(this.form)">Crear Tarea</button>
                </div>
            </div>
        </div>
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
                $employeeAsignedName = $employeeName['name'] . " " . $employeeName['lastname'];

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



                <!-- Modal editar tasks -->
                <div class="modal fade" id="editTask<?= $task['idtask'] ?>" tabindex="-1" aria-labelledby="editTask<?= $task['idtask'] ?>Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editTaskLabel">Edición de tareas</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editTaskForm<?= $task['idtask'] ?>" method="POST">
                                    <input type="hidden" name="id" value="<?= $task['idtask'] ?>">
                                    <div class="m-4">
                                        <label for="name" class="form-label fs-5">Nombre Tarea</label>
                                        <input type="text" class="form-control mb-3" name="name" value="<?= $task['taskname'] ?>">

                                        <label for="client" class="form-label fs-5">Cliente</label>
                                        <select name="client" class="form-select mb-3" aria-label="Default select example">
                                            <?php
                                            foreach ($clients as $client) :
                                                    $selected = ($client['clientname'] == $task['client']) ? "selected" : "";
                                            ?>
                                                    <option <?= $selected ?> value="<?= $client['clientname'] ?>"><?= $client['clientname'] ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                        <label for="assignedemployee" class="form-label fs-5">Empleado Asignado</label>
                                        <select name="assignedemployee" class="form-select mb-3" aria-label="Default select example">
                                            <?php
                                            foreach ($server->getEmployees() as $employee) :
                                                $selected = ($employee['iduser'] == $task['employeeasigned']) ? "selected" : "";
                                            ?>
                                                <option <?= $selected ?> value="<?= $employee['iduser'] ?>"><?= $employee['name'] . ' ' . $employee['lastname'] ?></option>
                                            <?php endforeach; ?>
                                        </select>

                                        <label for="date" class="form-label fs-5">Fecha de Inicio</label>
                                        <input type="date" class="form-control mb-3" name="date" value="<?= $task['date'] ?>">

                                        <label for="time" class="form-label fs-5">Hora Tarea</label>
                                        <input type="time" class="form-control mb-3" name="time" value="<?= $task['time'] ?>">

                                        <label for="state" class="form-label fs-5">Estado</label>
                                        <select class="form-select mb-3" name="state" aria-label="Default select example">
                                            <option value="1" <?= $task['state'] == 1 ? "selected" : "" ?>>Pendiente</option>
                                            <option value="0" <?= $task['state'] == 0 ? "selected" : "" ?>>Realizada</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer p-1">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" onclick="editTasks('editTaskForm<?= $task['idtask'] ?>')" class="btn btn-primary">Enviar</button>
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
    function createTask() {
        var form = document.getElementById('createTaskForm');
        var name = form['name'].value;
        var client = form['client'].value;
        var assignedEmployee = form['assignedEmployee'].value;
        var date = form['date'].value;
        var time = form['time'].value;

        console.log(assignedEmployee);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log(this.responseText);
                location.reload();
            }
        };
        xmlhttp.open("GET", "server/redirects.php?action=createTask&name=" + name + "&client=" + client + "&assignedEmployee=" + assignedEmployee + "&date=" + date + "&time=" + time, true);
        xmlhttp.send();

    }



    function editTasks(formId) {
        var form = document.getElementById(formId);
        var id = form['id'].value;
        var name = form['name'].value;
        var client = form['client'].value;
        var assignedEmployee = form['assignedemployee'].value;
        var date = form['date'].value;
        var time = form['time'].value;
        var state = form['state'].value;

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log(this.responseText);
                location.reload();
            }
        };
        xmlhttp.open("GET", "server/redirects.php?action=editTask&id=" + id + "&name=" + name + "&client=" + client + "&assignedemployee=" + assignedEmployee + "&state=" + state + "&date=" + date + "&time=" + time, true);
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