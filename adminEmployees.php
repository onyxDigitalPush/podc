<?php
require 'templates/NavBar.php';

//Traer los empleados
$employees = $server->getEmployees();
$server = new server();
?>
<div class="container mt-5">
    <div class="encabezados d-flex justify-content-between ">
        <h2 class="mb-4">Listado de Empleados</h2>
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#ModalCrear">
            Crear Empleado
        </button>
    </div>
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Nombre </th>
                <th>Apellido</th>
                <th>Telefono</th>
                <th>Cargo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $empleado) : ?>
                <?php $puesto = ($empleado['encargado'] == 1) ? "Encargado" : "Empleado"; ?>

                <tr>
                    <td><?= $empleado['name'] ?></td>
                    <td><?= $empleado['lastname']  ?> </td>
                    <td><?= $empleado['telefono'] ?></td>
                    <td><?= $puesto ?></td>
                    <td>
                        <button data-bs-toggle="modal" data-bs-target="#editEmployee<?= $empleado['iduser'] ?>" class="btn btn-info btn">Editar</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDelete<?= $empleado['iduser'] ?>">
                            Eliminar
                        </button>
                    </td>
                </tr>
                <!-- Modal Crear empleado -->
                <div class="modal fade" id="ModalCrear" tabindex="-1" aria-labelledby="ModalCrearLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="ModalCrearLabel">Crear Empleado</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" name="createEmployee">
                                    <label for="user" class="form-label fs-5">Usuario</label>
                                    <input type="text" class="form-control mb-3" name="user" value="">
                                    <label for="password" class="form-label fs-5">Contraseña</label>
                                    <input type="password" class="form-control mb-3" name="password" value="">
                                    <label for="password2" class="form-label fs-5">Confirmar Contraseña</label>
                                    <input type="password" class="form-control mb-3" name="password2" value="">
                                    <label for="name" class="form-label fs-5">Nombre</label>
                                    <input type="text" class="form-control mb-3" name="name" value="">
                                    <label for="lastname" class="form-label fs-5">Apellidos</label>
                                    <input type="text" class="form-control mb-3" name="lastname" value="">
                                    <label for="phone" class="form-label fs-5">Telefono</label>
                                    <input type="text" class="form-control mb-3" name="phone" value="">
                                    <label for="charge class=" form-label fs-5">Puesto trabajador</label>
                                    <select name="charge" class="form-select" aria-label="Floating label select example">
                                        <option value="1">Encargado</option>
                                        <option value="0">Empleado</option>
                                    </select>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" onclick="createEmployees()">Crear Empleado</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal edit employee  -->
                <div class="modal fade" id="editEmployee<?= $empleado['iduser'] ?>" tabindex="-1" aria-labelledby="editEmployeeLabel<?= $empleado['iduser'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-4" id="editEmployeeLabel<?= $empleado['iduser'] ?>">Editar Empleado </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form name="editEmployee" method="POST">
                                    <input type="hidden" name="id" value="<?= $empleado['iduser'] ?>">
                                    <div class="m-4">
                                        <label for="name" class="form-label fs-5">Nombre</label>
                                        <input type="text" class="form-control mb-3" id="name" name="name" value="<?= $empleado['name'] ?>">
                                        <label for="lastname" class="form-label fs-5">Apellidos</label>
                                        <input type="text" class="form-control mb-3" id="lastname" name="lastname" value="<?= $empleado['lastname'] ?>">
                                        <label for="telefono" class="form-label fs-5">Telefono</label>
                                        <input type="text" class="form-control mb-3" id="telefono" name="telefono" value="<?= $empleado['telefono'] ?>">
                                    </div>

                                    <div class="modal-footer p-1">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" onclick="editEmployees( <?= $empleado['iduser'] ?>, editEmployee.name.value, editEmployee.lastname.value, editEmployee.telefono.value)" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Delete -->
                <div class="modal fade" id="modalDelete<?= $empleado['iduser'] ?>" tabindex="-1" aria-labelledby="modalDelete<?= $empleado['iduser'] ?>Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalDelete<?= $empleado['iduser'] ?>Label">Eliminar Empleado <?= $empleado['iduser'] ?></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Estas seguro de eliminar empleado? <?= $empleado['iduser'] ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="button" onclick="deleteEmployee(<?= $empleado['iduser'] ?>)" class="btn btn-danger">Eliminar</button>
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
    function createEmployees() {
        //cambie la forma de obtener los datos por que me daba error con el .value desde el formulario
        var form = document.forms['createEmployee'];
        var user = form['user'].value;
        var password = form['password'].value;
        var password2 = form['password2'].value;
        var name = form['name'].value;
        var lastname = form['lastname'].value;
        var phone = form['phone'].value;
        var charge = form['charge'].value;

        console.log(name, lastname, phone, charge, user, password, password2);
            if(password == password2){ name,lastname,phone,charge,user,password,password2
            console.log(name,lastname,phone,charge);
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    console.log(this.responseText);
                    location.reload();
                }
            };
            xmlhttp.open("GET", "server/redirects.php?action=createEmployee&name=" + name + "&lastname=" + lastname + "&phone=" + phone + "&charge=" + charge
            + "&user=" + user + "&password=" + password, true);
            xmlhttp.send();
        }
        else{
            alert("Las contraseñas no coinciden");
            }
    }

    function editEmployees(id, name, lastname, phone) {
        console.log(id, name, lastname, phone);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log(this.responseText);
                location.reload();
            }
        };
        xmlhttp.open("GET", "server/redirects.php?action=editEmployee&id=" + id + "&name=" + name + "&lastname=" + lastname + "&phone=" + phone, true);
        xmlhttp.send();
    }

    function deleteEmployee(id) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log(this.responseText);
                location.reload();
            }
        };
        xmlhttp.open("GET", "server/redirects.php?action=deleteEmployee&id=" + id, true);
        xmlhttp.send();
    }
</script>

</html>