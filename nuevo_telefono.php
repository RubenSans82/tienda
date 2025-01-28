<?php
if (!isset($_POST["telefono"])) {
    header("Location: proveedores");
    exit();
} else {
    include("conexiondb.php");

    $sql = "insert into telefonos (numero, idproveedores) values (:numero, :proveedor_id)";
    $stm=$conexion->prepare($sql);
    $stm->bindParam(":numero", $_POST["numero"]);
    $stm->bindParam(":proveedor_id", $_POST["idproveedor"]);
    $stm->execute();
    header("Location: proveedores?id=".$_POST["idproveedor"]);
    exit();
}