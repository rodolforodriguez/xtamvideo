<?php
require("conexion.php");
        
//evitar inserccion de cualquier caracter que no sea letra o numero



    //variables POST
    $cedu = $_POST['cedula'];
    $nom = $_POST['nombre'];
    $fech = $_POST['fecha'];
    $cargo = $_POST['cargo'];
    //consulta mysql para insertar los datos del empleados
    $consulta = "INSERT INTO empleados(cedula,nombre,fecha,cargo) VALUES ('" .$cedu. "','" .$nom. "','" .$fech. "','" .$cargo. "')";
    echo $consulta;
    mysqli_query($con, $consulta);
    if($consulta)
    {            
        echo "Empleado Guardado Correctamente";
    }
    else
    {
        echo "No se pudieron guardar los datos";
    }

?>