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
    // public function getEmployee($id){
    //     require 'templates/conexion.php';
    //     $sql = "SELECT * FROM users  WHERE iduser = $id";
    //     $result = mysqli_query($conn, $sql);


    //         return $result;
    // }

    public function editEmployee($id, $name, $lastName, $phone)
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
        $sql = "UPDATE users SET name = '$name', lastname = '$lastName', telefono = '$phone' WHERE iduser = '$id'";

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
        $conn = mysqli_connect("localhost", "root", "", "simacol_cp");
        // Preparar la consulta SQL
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
    public function createEmployee($name, $lastname, $phone, $charge,$user,$password)
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

        // Ejecutar la consulta
        if (mysqli_query($conn, $sql)) {
            echo "Registro creado correctamente.";
        } else {
            echo "Error al crear el registro: " . mysqli_error($conn);
        }
        
    }
}
