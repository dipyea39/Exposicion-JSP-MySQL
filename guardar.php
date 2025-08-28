<?php
// Conexión a la base de datos
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "medsports";

// Crea el objeto MySQLi e intenta abrir la conexión con los datos anteriores
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$nombres   = $_POST['nombres'];   // Nombre(s) del cliente
$ciudad    = $_POST['ciudad'];    // Ciudad
$direccion = $_POST['direccion']; // Dirección
$celular   = $_POST['celular'];   // Teléfono/celular

// Esperado: inputs tipo checkbox/text con nombres del estilo productos[Balón], cantidades[Balón]
$productosSeleccionados = $_POST['productos']  ?? []; // Ej.: ['Balón'=>'on','Guantes'=>'on']
$cantidades             = $_POST['cantidades'] ?? []; // Ej.: ['Balón'=>'2','Guantes'=>'1']

// Preparación para procesar productos y calcular total
$listaProductos = [];
$total = 0;

// Tabla de precios de referencia (puedes cambiar valores o cargarlos desde BD)
$precios = [
    "Balón"      => 50000,
    "Guantes"    => 40000,
    "Zapatillas" => 150000,
    "Camiseta"   => 30000
];

foreach ($productosSeleccionados as $producto => $valor) {
    // Busca la cantidad enviada para ese producto (si no existe, toma 0)
    $cantidad = isset($cantidades[$producto]) ? (int)$cantidades[$producto] : 0;

    // Solo procesa si la cantidad es positiva
    if ($cantidad > 0) {
        // Agrega a la lista con el formato "Producto xN"
        $listaProductos[] = $producto . " x" . $cantidad;

        // Si hay precio definido para ese producto, suma al total
        if (isset($precios[$producto])) {
            $total += $precios[$producto] * $cantidad;
        }
    }
}

// Convierte la lista de productos seleccionados en una cadena: "Balón x2, Guantes x1"
$productosTexto = implode(", ", $listaProductos);

// Inserción en la base de datos con Prepared Statement
$sql = "INSERT INTO cotizaciones (nombres, ciudad, direccion, celular, productos, total, fecha)
        VALUES (?, ?, ?, ?, ?, ?, NOW())";

// Prepara la sentencia
$stmt = $conn->prepare($sql);

// Enlaza parámetros
$stmt->bind_param("sssssd", $nombres, $ciudad, $direccion, $celular, $productosTexto, $total);

// Ejecuta y comprueba el resultado
if ($stmt->execute()) {
        echo "✅ Cotización guardada correctamente. <a href='mostrar.php'>Ver listado</a>";
} else {
      echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
