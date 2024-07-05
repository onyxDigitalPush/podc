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
            $server->editEmployee($id, $name, $lastname, $phone);
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

        case"createEmployee":
            try {
                $name = $_GET['name'];
                $lastname = $_GET['lastname'];
                $phone = $_GET['phone'];
                $charge = $_GET['charge'];
                $user = $_GET['user'];
                $password = $_GET['password'];
                $server->createEmployee($name, $lastname, $phone,$charge,$user,$password);
            } catch (Exception $ex) {
                http_response_code(404);
                $msg = $ex->getMessage();
                echo $msg;
            }
            break;
}
