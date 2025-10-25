<?php
/**
 * Sistema de Inventario Simple
 * 
 * Este archivo implementa una aplicación web básica para gestionar un inventario de productos.
 * Permite agregar nuevos productos y marcarlos como adquiridos/no adquiridos.
 * 
 * Requisitos:
 * - Servidor MySQL/MariaDB
 * - PHP con extensión mysqli
 * - Base de datos 'tienda' con tabla 'productos'
 */

// Configuración de la conexión a la base de datos
$host = "127.0.0.1";  // Host de la base de datos
$user = "root";       // Usuario de la base de datos
$pass = "";          // Contraseña de la base de datos
$db = "tienda";      // Nombre de la base de datos
// Establecer conexión con la base de datos
$mysqli = new mysqli($host, $user, $pass, $db);

// Verificar si hay error en la conexión
if ($mysqli->connect_errno) { 
    die("Error de conexión: " . $mysqli->connect_error); 
}

// Procesar el formulario de agregar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener y validar los datos del formulario
    $nombre = trim($_POST['nombre'] ?? '');
    $precio = floatval($_POST['precio'] ?? 0);

    // Verificar que los datos sean válidos
    if ($nombre !== '' && $precio > 0) {
        // Preparar y ejecutar la consulta para insertar el nuevo producto
        $stmt = $mysqli->prepare("INSERT INTO productos (nombre, precio) VALUES (?, ?)");
        $stmt->bind_param("sd", $nombre, $precio);
        $stmt->execute();
        $stmt->close();
    }
    // Redireccionar para evitar reenvío del formulario
    header("Location: index.php");
    exit;
}
// Manejar la acción de alternar el estado de adquisición
if (isset($_GET['toggle'])) {
    // Convertir el ID a entero para seguridad
    $id = intval($_GET['toggle']);
    // Actualizar el estado del producto (cambia entre 0 y 1)
    $mysqli->query("UPDATE productos SET adquirido = 1 - adquirido WHERE id = $id");
    // Redireccionar después de la actualización
    header("Location: index.php");
    exit;
}
// Obtener todos los productos ordenados por ID en orden descendente
$res = $mysqli->query("SELECT * FROM productos ORDER BY id DESC");
$items = $res->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Tienda (mini)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* Estilos básicos para la aplicación */
        body {
            font-family: Arial;
            max-width: 720px;
            margin: 24px auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            border: 1px solid #ddd;
            padding: 8px;
        }
        form {
            margin: 16px 0;
        }
        .ok {
            color: green;
            font-weight: bold;
        }
        .btn {
            padding: 6px 10px;
            text-decoration: none;
            border: 1px solid #555;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <!-- Título de la aplicación -->
    <h1>Inventario simple</h1>

    <!-- Formulario para agregar nuevos productos -->
    <form method="post">
        <label>Nombre: <input name="nombre" required></label>
        <label>Precio: <input name="precio" type="number" step="0.01" required></label>
        <button>Agregar</button>
    </form>

    <!-- Tabla de productos -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Adquirido</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
 <?php foreach($items as $p): ?><tr>
 <td><?= htmlspecialchars($p['id']) ?></td>
 <td><?= htmlspecialchars($p['nombre']) ?></td>
 <td><?= number_format($p['precio'], 2) ?></td>
 <td><?= $p['adquirido'] ? '<span class="ok">Sí</span>' : 'No' ?></td>
 <td><a class="btn" href="?toggle=<?= intval($p['id']) ?>">Toggle</a></td>
 </tr><?php endforeach; ?></tbody></table>
</body>
</html>