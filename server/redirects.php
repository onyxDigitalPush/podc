<?php
include 'server.php';
$server = new server();

switch ($_GET["action"]) {
    case "editEmployee":
        try {
            $id = $_GET['id'];
            $name = $_GET['name'];
            $lastname = $_GET['lastname'];
            $phone = $_GET['phone'];
            $charge = $_GET['charge'];
            $server->editEmployee($id, $name, $lastname, $phone, $charge);
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
            echo $msg;
        }
        break;

    case "deleteEmployee":
        try {
            $id = $_GET['id'];
            $server->deleteEmployee($id);
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
            echo $msg;
        }
        break;

    case "createEmployee":
        try {
            $name = $_GET['name'];
            $lastname = $_GET['lastname'];
            $phone = $_GET['phone'];
            $charge = $_GET['charge'];
            $user = $_GET['user'];
            $password = $_GET['password'];
            $server->createEmployee($name, $lastname, $phone, $charge, $user, $password);
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
            echo $msg;
        }
        break;

    case "editTask":
        try {
            $id = $_GET['id'];
            $name = $_GET['name'];
            $client = $_GET['client'];
            $assignedemployee = $_GET['assignedemployee'];
            $state = $_GET['state'];
            $date = $_GET['date'];
            $time = $_GET['time'];
            $server->editTask($id, $name, $client, $assignedemployee, $state, $date, $time);
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
            echo $msg;
        }
        break;

    case "deleteTask":
        try {
            $id = $_GET['id'];
            $server->deleteTask($id);
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
            echo $msg;
        }
        break;

    case "createClient":
        try {
            $name = $_GET['name'];
            $incharge = $_GET['incharge'];
            $adress = $_GET['adress'];
            $phone = $_GET['phone'];
            $server->createClient($name, $incharge, $adress, $phone);
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
            echo $msg;
        }
        break;

    case "editClient":
        try {
            $id = $_GET['id'];
            $name = $_GET['name'];
            $incharge = $_GET['incharge'];
            $adress = $_GET['adress'];
            $phone = $_GET['phone'];
            $server->editClient($id, $name, $incharge, $adress, $phone);
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
            echo $msg;
        }
        break;

    case "deleteClient":
        try {
            $id = $_GET['id'];
            $server->deleteClient($id);
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
            echo $msg;
        }
        break;
}
