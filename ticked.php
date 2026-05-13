<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Ticket de Alquiler</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .container {
            width: 80%;
            margin: auto;
        }
        h2 {
            margin-bottom: 10px;
        }
        p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Detalle de Ticket de Alquiler</h1>
        <?php
        // Configuración de la conexión a la base de datos
        // Quite los parametros para que no puedan acceder a la base de datos
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

        // Consulta SQL para obtener detalles de un alquiler específico con los elementos de mobiliario alquilados
        $id_alquiler = 1; // ID del alquiler a mostrar, ajustar según necesidad
        $sql = "SELECT a.id_alquiler, a.fecha_evento, a.hora_evento, a.fecha_devolucion, a.hora_devolucion, a.total,
                       c.id_cliente, c.nombre, c.apellidos, c.correo, c.no_telefono,
                       dc.estado, dc.municipio, dc.colonia, dc.calle, dc.no_calle,
                       s.nombre_silla, ms.nombre_mesas, ma.nombre_manteles, 
                       carpas.nombre_carpas, f.nombre_inflables
                FROM alquiler AS a
                INNER JOIN cliente AS c ON a.id_cliente = c.id_cliente
                INNER JOIN domicilio_c AS dc ON c.id_domicilio_c = dc.id_domicilio_c
                LEFT JOIN mobiliario AS m ON a.id_mobiliario = m.id_mobiliario
                LEFT JOIN sillas AS s ON m.id_tipo_s = s.id_tipo_s
                LEFT JOIN mesas AS ms ON m.id_tipo_me = ms.id_tipo_me
                LEFT JOIN manteles AS ma ON m.id_tipo_ma = ma.id_tipo_ma
                LEFT JOIN carpas AS carpas ON m.id_tipo_c = carpas.id_tipo_c
                LEFT JOIN flables AS f ON m.id_tipo_f = f.id_tipo_f
                WHERE a.id_alquiler = ?";

        // Preparar y ejecutar la consulta
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $id_alquiler);
            $stmt->execute();
            $result = $stmt->get_result();

            // Verificar si se encontraron resultados
            if ($result->num_rows > 0) {
                // Mostrar los detalles del alquiler y del cliente
                $row = $result->fetch_assoc();
                echo "<h2>Datos de Alquiler</h2>";
                echo "<p>ID de Alquiler: " . $row['id_alquiler'] . "</p>";
                echo "<p>Fecha del Evento: " . $row['fecha_evento'] . "</p>";
                echo "<p>Hora del Evento: " . $row['hora_evento'] . "</p>";
                echo "<p>Fecha de Devolución: " . $row['fecha_devolucion'] . "</p>";
                echo "<p>Hora de Devolución: " . $row['hora_devolucion'] . "</p>";
                echo "<p>Total: $" . $row['total'] . "</p>";

                echo "<h2>Datos del Cliente</h2>";
                echo "<p>ID de Cliente: " . $row['id_cliente'] . "</p>";
                echo "<p>Nombre: " . $row['nombre'] . " " . $row['apellidos'] . "</p>";
                echo "<p>Correo: " . $row['correo'] . "</p>";
                echo "<p>Teléfono: " . $row['no_telefono'] . "</p>";

                echo "<h2>Datos de Domicilio del Cliente</h2>";
                echo "<p>Estado: " . $row['estado'] . "</p>";
                echo "<p>Municipio: " . $row['municipio'] . "</p>";
                echo "<p>Colonia: " . $row['colonia'] . "</p>";
                echo "<p>Calle: " . $row['calle'] . " No. " . $row['no_calle'] . "</p>";

                // Mostrar los elementos de mobiliario alquilados
                echo "<h2>Elementos de Mobiliario Alquilados</h2>";
                echo "<table>";
                echo "<tr><th>Sillas</th><th>Mesas</th><th>Manteles</th><th>Carpas</th><th>Inflables</th></tr>";
                echo "<tr>";
                echo "<td>" . $row['nombre_silla'] . "</td>";
                echo "<td>" . $row['nombre_mesas'] . "</td>";
                echo "<td>" . $row['nombre_manteles'] . "</td>";
                echo "<td>" . $row['nombre_carpas'] . "</td>";
                echo "<td>" . $row['nombre_inflables'] . "</td>";
                echo "</tr>";
                echo "</table>";

                // Calcular el subtotal
                $subtotal = 0;
                $subtotal += obtenerPrecioElemento('silla', $row['nombre_silla'], $conn);
                $subtotal += obtenerPrecioElemento('mesa', $row['nombre_mesas'], $conn);
                $subtotal += obtenerPrecioElemento('mantel', $row['nombre_manteles'], $conn);
                $subtotal += obtenerPrecioElemento('carpa', $row['nombre_carpas'], $conn);
                $subtotal += obtenerPrecioElemento('inflable', $row['nombre_inflables'], $conn);

                echo "<h2>Total: $" . number_format($subtotal, 2) . "</h2>";
            } else {
                echo "No se encontraron resultados para el ID de alquiler proporcionado.";
            }

            // Liberar el conjunto de resultados
            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $conn->error;
        }

        // Cerrar conexión
        $conn->close();

        // Función para obtener el precio del elemento
        function obtenerPrecioElemento($tipo_elemento, $nombre_elemento, $conn) {
            $precio = 0;
            switch ($tipo_elemento) {
                case 'silla':
                    $sql = "SELECT costo_s FROM sillas WHERE nombre_silla = ?";
                    break;
                case 'mesa':
                    $sql = "SELECT costo_me FROM mesas WHERE nombre_mesas = ?";
                    break;
                case 'mantel':
                    $sql = "SELECT costo_ma FROM manteles WHERE nombre_manteles = ?";
                    break;
                case 'carpa':
                    $sql = "SELECT costo_carpas FROM carpas WHERE nombre_carpas = ?";
                    break;
                case 'inflable':
                    $sql = "SELECT costo_fables FROM flables WHERE nombre_inflables = ?";
                    break;
                default:
                    return $precio;
            }

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $nombre_elemento);
                $stmt->execute();
                $stmt->bind_result($costo);
                if ($stmt->fetch()) {
                    $precio = $costo;
                }
                $stmt->close();
            } else {
                echo "Error al preparar la consulta: " . $conn->error;
            }

            return $precio;
        }
        ?>
    </div>
</body>
</html>
  
