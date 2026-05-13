<?php
// Establecer conexión con la base de datos MySQL
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$correo = $_POST['correo'];
$no_telefono = $_POST['no_telefono'];
$estado_c = $_POST['estado_c'];
$municipio_c = $_POST['municipio_c'];
$colonia_c = $_POST['colonia_c'];
$calle_c = $_POST['calle_c'];
$no_calle_c = $_POST['no_calle_c'];
$estado_e = $_POST['estado_e'];
$municipio_e = $_POST['municipio_e'];
$colonia_e = $_POST['colonia_e'];
$calle_e = $_POST['calle_e'];
$no_calle_e = $_POST['no_calle_e'];
$fecha_evento = $_POST['fecha_evento'];
$hora_evento = $_POST['hora_evento'];
$hora_entrega = $_POST['hora_entrega'];
$fecha_devolucion = $_POST['fecha_devolucion'];
$hora_devolucion = $_POST['hora_devolucion'];

// Iniciar una transacción
$conn->begin_transaction();

try {
    // Insertar primero en la tabla domicilio_c
    $sql_domicilio_c = "INSERT INTO domicilio_c (estado, municipio, colonia, calle, no_calle)
                        VALUES ('$estado_c', '$municipio_c', '$colonia_c', '$calle_c', $no_calle_c)";

    if ($conn->query($sql_domicilio_c) !== TRUE) {
        throw new Exception("Error al insertar en la tabla domicilio_c: " . $conn->error);
    }

    $id_domicilio_c = $conn->insert_id;

    // Insertar en la tabla domicilio_e
    $sql_domicilio_e = "INSERT INTO domicilio_e (estado_e, municipio_e, colonia_e, calle_e, no_calle_e)
                        VALUES ('$estado_e', '$municipio_e', '$colonia_e', '$calle_e', $no_calle_e)";

    if ($conn->query($sql_domicilio_e) !== TRUE) {
        throw new Exception("Error al insertar en la tabla domicilio_e: " . $conn->error);
    }

    $id_domicilio_e = $conn->insert_id;

    // Insertar en la tabla cliente
    $sql_cliente = "INSERT INTO cliente (nombre, apellidos, correo, no_telefono, id_domicilio_c)
                    VALUES ('$nombre', '$apellidos', '$correo', '$no_telefono', $id_domicilio_c)";

    if ($conn->query($sql_cliente) !== TRUE) {
        throw new Exception("Error al insertar en la tabla cliente: " . $conn->error);
    }

    $id_cliente = $conn->insert_id;

    // Insertar en la tabla alquiler
    $sql_alquiler = "INSERT INTO alquiler (id_cliente, fecha_evento, hora_evento, hora_entrega, fecha_devolucion, hora_devolucion)
                     VALUES ($id_cliente,'$fecha_evento', '$hora_evento', '$hora_entrega', '$fecha_devolucion', '$hora_devolucion')";

    if ($conn->query($sql_alquiler) !== TRUE) {
        throw new Exception("Error al insertar en la tabla alquiler: " . $conn->error);
    }

    // Confirmar la transacción
    $conn->commit();
    echo "Cliente y detalles de alquiler agregados correctamente.<br>";
    echo "Redirigiendo en 3 segundos a rentas.<br>";
    header("refresh:3;url=rentas.html");
} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

// Cerrar conexión
$conn->close();
?>
