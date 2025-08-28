<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Usuario por defecto en XAMPP
$password = "";     // Contraseña por defecto en XAMPP
$dbname = "medsports"; // Nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar los datos
$sql = "SELECT id, nombres, ciudad, direccion, celular, productos, total, fecha FROM cotizaciones";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos de Cotizaciones</title>
    <style>
        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #333;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Listado de Cotizaciones</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombres</th>
            <th>Ciudad</th>
            <th>Dirección</th>
            <th>Celular</th>
            <th>Productos</th>
            <th>Total</th>
            <th>Fecha</th>
        </tr>
        <?php
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["nombres"] . "</td>
                        <td>" . $row["ciudad"] . "</td>
                        <td>" . $row["direccion"] . "</td>
                        <td>" . $row["celular"] . "</td>
                        <td>" . $row["productos"] . "</td>
                        <td>" . $row["total"] . "</td>
                        <td>" . $row["fecha"] . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No hay registros</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
