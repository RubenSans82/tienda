<?php
if (!isset($_POST["calle"])) {
    header("Location: proveedores");
    exit();
} else {
    include("conexiondb.php");

    $sql = "insert into direcciones (calle, numero, comuna, ciudad, proveedores_id) values (:calle, :numero, :comuna, :ciudad, :proveedor_id)";
    $stm=$conexion->prepare($sql);
    $stm->bindParam(":calle", $_POST["calle"]);
    $stm->bindParam(":numero", $_POST["numero"]);
    $stm->bindParam(":comuna", $_POST["comuna"]);
    $stm->bindParam(":ciudad", $_POST["ciudad"]);
    $stm->bindParam(":proveedor_id", $_POST["idproveedor"]);
    $stm->execute();
    $id=$conexion->lastInsertId();
    header("Location: proveedores?id=$id");
    exit();
}