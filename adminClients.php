<?php
require 'templates/NavBar.php';

//Traer los empleados
$clients = $server->getclients();
$server = new server();

?>

<div class="container mt-5">
    <div class="encabezados d-flex justify-content-between ">
        <h2 class="mb-4">Listado de Clientes</h2>
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#ModalCrear">
            Crear Cliente
        </button>

    </div>
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Nombre </th>
                <th>Encargado</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client) : ?>
                <tr>
                    <td><?= $client['clientname'] ?></td>
                    <td><?= $client['incharge']  ?> </td>
                    <td><?= $client['adress'] ?></td>
                    <td><?= $client['phone'] ?></td>
                    <td>
                        <button data-bs-toggle="modal" data-bs-target="#editClient<?= $client['idclient'] ?>" class="btn btn-info btn">Editar</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDelete<?= $client['idclient'] ?>">
                            Eliminar
                        </button>
                    </td>
                </tr>
                <!-- Modal Crear empleado -->
                <div class="modal fade" id="ModalCrear" tabindex="-1" aria-labelledby="ModalCrearLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="ModalCrearLabel">Crear Cliente</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" name="createClient">
                                    <label for="user" class="form-label fs-5">Nombre Cliente</label>
                                    <input type="text" class="form-control mb-3" name="name" value="">
                                    <label for="incharge" class="form-label fs-5">Nombre Encargado</label>
                                    <input type="text" class="form-control mb-3" name="incharge" value="">
                                    <label for="password2" class="form-label fs-5">Direccion Cliente</label>
                                    <input type="text" class="form-control mb-3" name="adress" value="">
                                    <label for="phone" class="form-label fs-5">Telefono</label>
                                    <input type="text" class="form-control mb-3" name="phone" value="">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" onclick="createClients(createClient.name.value,createClient.incharge.value,createClient.adress.value,createClient.phone.value)">Crear Empleado</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal edit employee  -->
                <div class="modal fade" id="editClient<?= $client['idclient'] ?>" tabindex="-1" aria-labelledby="editClientLabel<?= $client['idclient'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-4" id="editClientLabel<?= $client['idclient'] ?>">Editar Cliente </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form name="editClient" method="POST">
                                    <input type="hidden" name="id" value="<?= $client['idclient'] ?>">
                                    <div class="m-4">
                                        <input type="hidden" class="form-control mb-3" id="idclient" name="idclient" value="<?= $client['idclient'] ?>">
                                        <label for="name" class="form-label fs-5">Nombre</label>
                                        <input type="text" class="form-control mb-3" id="name" name="name" value="<?= $client['clientname'] ?>">
                                        <label for="incharge" class="form-label fs-5">Encargado</label>
                                        <input type="text" class="form-control mb-3" id="incharge" name="incharge" value="<?= $client['incharge'] ?>">
                                        <label for="adress" class="form-label fs-5">Direccion</label>
                                        <input type="text" class="form-control mb-3" id="adress" name="adress" value="<?= $client['adress'] ?>">
                                        <label for="phone" class="form-label fs-5">Telefono</label>
                                        <input type="text" class="form-control mb-3" id="phone" name="phone" value="<?= $client['phone'] ?>">
                                    </div>

                                    <div class="modal-footer p-1">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" onclick="editClients(this.form)" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Delete -->
                <div class="modal fade" id="modalDelete<?= $client['idclient'] ?>" tabindex="-1" aria-labelledby="modalDelete<?= $client['idclient'] ?>Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalDelete<?= $client['idclient'] ?>Label">Eliminar Empleado <?= $client['idclient'] ?></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Estas seguro de eliminar empleado? 
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="button" onclick="deleteClient(<?= $client['idclient'] ?>)" class="btn btn-danger">Eliminar</button>
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
    function createClients(name, incharge, adress, phone) {
        console.log(name, incharge, adress, phone);

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log(this.responseText);
                location.reload();
            }
        };
        xmlhttp.open("GET", "server/redirects.php?action=createClient&name=" + name + "&incharge=" + incharge + "&adress=" + adress + "&phone=" + phone, true);
        xmlhttp.send();

    }

    function editClients(form) {
        var name = form.name.value;
        var incharge = form.incharge.value;
        var adress = form.adress.value;
        var phone = form.phone.value;
        var id = form.idclient.value;

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log(this.responseText);
               location.reload();
            }
        };
        xmlhttp.open("GET", "server/redirects.php?action=editClient&id=" + id + "&name=" + name + "&incharge=" + incharge + "&adress=" + adress + "&phone=" + phone, true);
        xmlhttp.send();
    }

    function deleteClient(id) {
        console.log(id);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log(this.responseText);
                location.reload();
            }
        };
        xmlhttp.open("GET", "server/redirects.php?action=deleteClient&id=" + id, true);
        xmlhttp.send();
    }
</script>

</html>