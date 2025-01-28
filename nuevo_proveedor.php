<?php
if (!isset($_POST["nombre"])) {
    header("Location: proveedores");
    exit();
} else {
    include("conexiondb.php");

    $sql = "insert into proveedores (nombre, web) values (:nombre, :web)";
    $stm=$conexion->prepare($sql);
    $stm->bindParam(":nombre", $_POST["nombre"]);
    $stm->bindParam(":web", $_POST["web"]);
    $stm->execute();
    $id=$conexion->lastInsertId();
    header("Location: proveedores?id=$id");
    exit();
}