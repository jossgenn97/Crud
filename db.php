<?php

$host="localhost";
$db="tienda";
$usuario="root";
$password="";

try {
    $conexion = new PDO("mysql:host=$host;dbname=$db",$usuario,$password);
    if($conexion){
        
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}

?>