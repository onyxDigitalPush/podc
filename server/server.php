<?php
class server
{
    public function connection()
    {
        // Incluir el archivo de conexión
        $conn = require 'templates/conexion.php';
        return $conn;
    }
    public function employeeOnCharge($id)
    {
        $conn = mysqli_connect("localhost", "root", "", "simacol_cp");
        $sql = "SELECT encargado FROM users WHERE iduser = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        return $row['encargado'];
    }

    public function getEmployees()
    {
        require 'templates/conexion.php';
        $sql = "SELECT * FROM users ";
        $result = mysqli_query($conn, $sql);
        $rows = array();
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
    public function getEmployee($id)
    {
        require 'templates/conexion.php';
        $sql = "SELECT iduser,user,name,lastname,encargado FROM users  WHERE iduser = $id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        return $row;
    }

    public function editEmployee($id, $name, $lastName, $phone, $charge)
    {
        // Conectar a la base de datos
        $conn = mysqli_connect("localhost", "root", "", "simacol_cp");

        // Verificar si la conexión fue exitosa
        if (!$conn) {
            die("Conexión fallida: " . mysqli_connect_error());
        }

        // Escapar las variables para evitar inyecciones SQL
        $id = mysqli_real_escape_string($conn, $id);
        $name = mysqli_real_escape_string($conn, $name);
        $lastName = mysqli_real_escape_string($conn, $lastName);
        $phone = mysqli_real_escape_string($conn, $phone);

        // Preparar la consulta SQL
        $sql = "UPDATE users SET name = '$name', lastname = '$lastName', telefono = '$phone' , encargado = '$charge' WHERE iduser = '$id'";

        // Ejecutar la consulta
        if (mysqli_query($conn, $sql)) {
            echo "Registro actualizado correctamente.";
        } else {
            echo "Error al actualizar el registro: " . mysqli_error($conn);
        }

        // Cerrar la conexión
        mysqli_close($conn);
    }
    public function deleteEmployee($id)
    {
        // Conectar a la base de datos
        require '../templates/conexion.php';        // Preparar la consulta SQL
        $sql = "DELETE FROM users WHERE iduser = $id";

        // Ejecutar la consulta
        if (mysqli_query($conn, $sql)) {
            echo "Registro actualizado correctamente.";
        } else {
            echo "Error al actualizar el registro: " . mysqli_error($conn);
        }

        // Cerrar la conexión
        mysqli_close($conn);
    }
    public function createEmployee($name, $lastname, $phone, $charge, $user, $password)
    {
        // Conectar a la base de datos
        $conn = mysqli_connect("localhost", "root", "", "simacol_cp");
        // Verificar si la conexión fue exitosa
        if (!$conn) {
            die("Conexión fallida: " . mysqli_connect_error());
        }
        // Preparar la consulta SQL
        $sql = "INSERT INTO users (name, lastname, telefono, encargado,user,password) 
        VALUES ('$name', '$lastname', '$phone','$charge','$user','$password')";
        if (mysqli_query($conn, $sql)) {
            echo "Registro creado correctamente.";
        } else {
            echo "Error al crear el registro: " . mysqli_error($conn);
        }
    }
    public function editTask($id, $name, $client, $employee, $state, $date, $time)
    {
        require '../templates/conexion.php';
        if (!$conn) {
            die("Conexión fallida: " . mysqli_connect_error());
        }

        $sql = "UPDATE works SET taskname = '$name', employeeasigned = '$employee', client = '$client', state = '$state' , date = '$date' , time = '$time' WHERE idtask = '$id'";
        if (mysqli_query($conn, $sql)) {
            echo "Registro actualizado correctamente.";
        } else {
            echo "Error al actualizar el registro: " . mysqli_error($conn);
        }
        mysqli_close($conn);
    }

    public function tasks()
    {
        require 'templates/conexion.php';
        // Verificar si la conexión fue exitosa
        if (!$conn) {
            die("Conexión fallida: " . mysqli_connect_error());
        }
        $sql = "SELECT * FROM works";
        // Ejecutar la consulta
        if (mysqli_query($conn, $sql)) {
            return (mysqli_query($conn, $sql));
        } else {
            echo "Error al traer el registro: " . mysqli_error($conn);
        }
    }

    public function createTask($name, $client, $assignedemployee, $date, $time)
    {
        
        require '../templates/conexion.php';
        if (!$conn) {
            die("Conexión fallida: " . mysqli_connect_error());
        }
        $sql = "INSERT INTO works (taskname, client, employeeasigned, date,
        time,state) VALUES ('$name', '$client', '$assignedemployee', '$date', '$time',1)
        ";
        if (mysqli_query($conn, $sql)) {
            echo "Registro creado correctamente.";
        } else {
            echo "Error al crear el registro: " . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
    public function deleteTask($id)
    {
        $conn = mysqli_connect("localhost", "root", "", "simacol_cp");
        // Verificar si la conexión fue exitosa
        if (!$conn) {
            die("Conexión fallida: " . mysqli_connect_error());
        }
        $sql = "DELETE FROM works WHERE idtask = '$id'";
        if (mysqli_query($conn, $sql)) {
            echo "Registro eliminado correctamente.";
        } else {
            echo "Error al eliminar el registro: " . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
    public function getClients()
    {
        require 'templates/conexion.php';
        // Verificar si la conexión fue exitosa
        if (!$conn) {
            die("Conexión fallida: " . mysqli_connect_error());
        }
        $sql = "SELECT * FROM clients";
        // Ejecutar la consulta
        if (mysqli_query($conn, $sql)) {
            return (mysqli_query($conn, $sql));
        } else {
            echo "Error al traer el registro: " . mysqli_error($conn);
        }
    }

    public function createClient($name, $incharge, $adress, $phone)
    {
        require '../templates/conexion.php';
        // Verificar si la conexión fue exitosa
        if (!$conn) {
            die("Conexión fallida: " . mysqli_connect_error());
        }
        $sql = "INSERT INTO clients (clientname, incharge, adress, phone) VALUES ('$name', '$incharge', '$adress', '$phone')";
        if (mysqli_query($conn, $sql)) {
            echo "Registro agregado correctamente.";
        } else {
            echo "Error al agregar el registro: " . mysqli_error($conn);
        }
        mysqli_close($conn);
    }

    public function editClient($id, $name, $incharge, $adress, $phone)
    {
        require '../templates/conexion.php';
        // Verificar si la conexión fue exitosa
        if (!$conn) {
            die("Conexión fallida: " . mysqli_connect_error());
        }
        $sql = "UPDATE clients SET clientname = '$name', incharge = '$incharge', adress = '$adress', phone = '$phone' WHERE idclient = $id";
        if (mysqli_query($conn, $sql)) {
            echo "Registro editado correctamente.";
        } else {
            echo "Error al editar el registro: " . mysqli_error($conn);
        }
    }

    public function deleteClient($id)
    {
        require '../templates/conexion.php';
        // Verificar si la conexión fue exitosa
        if (!$conn) {
            die("Conexión fallida: " . mysqli_connect_error());
        }
        $sql = "DELETE FROM clients WHERE idclient = $id";
        if (mysqli_query($conn, $sql)) {
            echo "Registro eliminado correctamente.";
        } else {
            echo "Error al eliminar el registro: " . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}
