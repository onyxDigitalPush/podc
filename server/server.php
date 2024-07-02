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
        require 'templates/conexion.php';
        $sql = "SELECT encargado FROM users WHERE iduser = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        return $row['encargado'];
    }

    public function getEmployees(){
        require 'templates/conexion.php';
        $sql = "SELECT * FROM users ";
        $result = mysqli_query($conn, $sql);
        $rows = array();
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
            }
            return $rows;
    }
}
