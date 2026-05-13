<?php
//Establecer conexión con la base de datos local MySQL
// quite la BD
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

// Obtener datos del formulario rentas.html
$silla = $_POST['silla'];
$cantidadSilla = $_POST['cantidadSilla'];
$mesa = $_POST['mesa'];
$cantidadMesa = $_POST['cantidadMesa'];
$mantel = $_POST['mantel'];
$colorMantel = $_POST['colorMantel'];
$cantidadMantel = $_POST['cantidadMantel'];
$carpa = $_POST['carpa'];
$colorCarpa = $_POST['colorCarpa'];
$cantidadCarpa = $_POST['cantidadCarpa'];
$inflable = $_POST['inflable'];
$cantidadInflable = $_POST['cantidadInflable'];

//Iniciar una transacción (se abre una puerta entre el codigo y la base de datos)
$conn->begin_transaction();

try {
    //tabla sillas
    $sql_sillas = "INSERT INTO sillas (nombre_silla, descripcion_silla, costo_s, existencia_s)
                   VALUES ('$silla', 'Descripción de $silla', 70.00, $cantidadSilla)";

    if ($conn->query($sql_sillas) !== TRUE) {
        throw new Exception("Error al insertar en la tabla sillas: " . $conn->error);
    }

    $id_tipo_s = $conn->insert_id;

    //tabla mesas
    $sql_mesas = "INSERT INTO mesas (nombre_mesas, descripcion_mesas, capacidad, costo_me, existencia_mesas)
                  VALUES ('$mesa', 'Descripción de $mesa', 10, 200.00, $cantidadMesa)";

    if ($conn->query($sql_mesas) !== TRUE) {
        throw new Exception("Error al insertar en la tabla mesas: " . $conn->error);
    }

    $id_tipo_me = $conn->insert_id;

    //tabla manteles
    $sql_manteles = "INSERT INTO manteles (nombre_manteles, descripcion_manteles, colores_manteles, costo_ma, existencia_manteles)
                     VALUES ('$mantel', 'Descripción de $mantel', '$colorMantel', 30.00, $cantidadMantel)";

    if ($conn->query($sql_manteles) !== TRUE) {
        throw new Exception("Error al insertar en la tabla manteles: " . $conn->error);
    }

    $id_tipo_ma = $conn->insert_id;

    //tabla carpas
    $sql_carpas = "INSERT INTO carpas (nombre_carpas, descripcion, colores_carpas, costo_carpas, existencia_carpas)
                   VALUES ('$carpa', 'Descripción de $carpa', '$colorCarpa', 1000.00, $cantidadCarpa)";

    if ($conn->query($sql_carpas) !== TRUE) {
        throw new Exception("Error al insertar en la tabla carpas: " . $conn->error);
    }

    $id_tipo_c = $conn->insert_id;

    //tabla inflables
    $sql_flables = "INSERT INTO flables (nombre_inflables, descripcion_inflables, costo_fables, existencia_flables)
               VALUES ('$inflable', 'Descripción de $inflable', 0.00, $cantidadInflable)";



if ($conn->query($sql_flables) === TRUE) {
    echo "Registro insertado correctamente.";
} else {
    echo "Error al insertar registro en fables: " . $conn->error;
}

    $id_tipo_f = $conn->insert_id;

    //tabla mobiliario
    $subtotal = ($cantidadSilla * 70) + ($cantidadMesa * 200) + ($cantidadMantel * 30) + ($cantidadCarpa * 1000) + ($cantidadInflable * 1500);
    $sql_mobiliario = "INSERT INTO mobiliario (id_tipo_s, id_tipo_me, id_tipo_ma, id_tipo_c, id_tipo_f, cantidad_si, cantidad_me, cantidad_ma, cantidad_c, cantidad_f, subtotal)
                       VALUES ($id_tipo_s, $id_tipo_me, $id_tipo_ma, $id_tipo_c, $id_tipo_f, $cantidadSilla, $cantidadMesa, $cantidadMantel, $cantidadCarpa, $cantidadInflable, $subtotal)";

    if ($conn->query($sql_mobiliario) !== TRUE) {
        throw new Exception("Error al insertar en la tabla mobiliario: " . $conn->error);
    }

    // Confirmar la transacción de datos a la base 
    $conn->commit();
    echo "Datos insertados correctamente.<br>";
    echo "Redirigiendo en 3 segundos a rentas.<br>";
    header("refresh:3;url=ticked.php");
} catch (Exception $e) {
    //Revertir la transacción en caso de error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

// Cerrar conexión
$conn->close();
?>
