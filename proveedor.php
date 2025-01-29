<?php
if (!isset($_GET["id"])) {
    header("Location: proveedores");
    exit();
}

include("partials/cabecera.php");

$sql = "SELECT p.id, p.nombre, p.web, 
               GROUP_CONCAT(DISTINCT CONCAT(d.calle, ' ', d.numero, ' ', d.comuna, ' ', d.ciudad) ORDER BY d.id ASC) AS direcciones,
               GROUP_CONCAT(DISTINCT t.numero ORDER BY t.id ASC) AS telefonos
        FROM proveedores p
        LEFT JOIN direcciones d ON p.id = d.proveedores_id
        LEFT JOIN telefonos t ON t.idproveedores = p.id
        WHERE p.id = :id
        GROUP BY p.id;";

$stm = $conexion->prepare($sql);
$stm->bindParam(":id", $_GET["id"]);
$stm->execute();

// Obtener el único proveedor con direcciones y teléfonos concatenados
$proveedor = $stm->fetch(PDO::FETCH_ASSOC);

// Verificamos si se obtuvo datos del proveedor
if ($proveedor) {
    // Convertimos las direcciones y teléfonos en arrays
    $direcciones = $proveedor['direcciones'] ? explode(',', $proveedor['direcciones']) : [];
    $telefonos = $proveedor['telefonos'] ? explode(',', $proveedor['telefonos']) : [];
    ?>
    <section>
        <h1><?php echo htmlspecialchars($proveedor['nombre']); ?></h1>
        <p>Web: <a href="<?php echo htmlspecialchars($proveedor['web']); ?>" target="_blank"><?php echo htmlspecialchars($proveedor['web']); ?></a></p>
        
        <h2>Direcciones:</h2>
        <ul>
            <?php
            if ($direcciones) {
                foreach ($direcciones as $direccion) {
                    echo "<li>" . htmlspecialchars($direccion) . "</li>";
                }
            } else {
                echo "<li>No hay direcciones disponibles.</li>";
            }
            ?>
        </ul>

        <h2>Teléfonos:</h2>
        <ul>
            <?php
            if ($telefonos) {
                foreach ($telefonos as $telefono) {
                    echo "<li>" . htmlspecialchars($telefono) . "</li>";
                }
            } else {
                echo "<li>No hay teléfonos disponibles.</li>";
            }
            ?>
        </ul>
    </section>
    <?php
} else {
    echo "<p>No se encontraron datos del proveedor.</p>";
}

include("partials/footer.php");
?>
