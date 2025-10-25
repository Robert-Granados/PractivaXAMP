# PracticaTiendaWeb3 — Inventario simple en PHP

Aplicación web  en PHP para gestionar un inventario de productos. Permite:
- Agregar productos con nombre y precio.
- Listar los productos existentes.
- Alternar el estado "adquirido" de cada producto.

La app usa MySQL/MariaDB (extensión `mysqli`) y está pensada para correr en XAMPP/LAMPP/MAMP de forma local.

## Requisitos
- PHP 7.4+ (o 8.x) con extensión `mysqli` habilitada.
- MySQL/MariaDB en ejecución.
- Servidor web (Apache en XAMPP recomendado).
- Navegador moderno.

## Instalación
1. Copia este proyecto en el directorio público de tu servidor web (por ejemplo, `htdocs` en XAMPP).
2. Asegúrate de tener Apache y MySQL en ejecución.
3. Crea la base de datos y tabla necesarias.

## Configuración de la base de datos
Por defecto el proyecto intenta conectarse a `127.0.0.1` con usuario `root`, contraseña vacía y base de datos `tienda` (ver `index.php`).

Crea la base de datos y la tabla `productos` con el siguiente SQL de ejemplo:

```sql
CREATE DATABASE IF NOT EXISTS tienda CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tienda;

CREATE TABLE IF NOT EXISTS productos (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  precio DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  adquirido TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```



- En XAMPP: inicia Apache y MySQL desde el panel de control.
- Accede en el navegador a: `http://localhost/PracticaTiendaWeb3/`

## Uso
- En el formulario inicial ingresa `Nombre` y `Precio`, y presiona "Agregar" para insertar un producto.
- En la tabla, el enlace "Toggle" cambia el estado de `adquirido` entre Sí/No.
- Los productos se listan en orden descendente por `id`.

## Estructura del proyecto
- `index.php` — Script principal: conexión a BD, inserción de productos, alternar estado y renderizado de la vista.



---
Este proyecto es educativo y muestra un flujo CRUD muy básico centrado en inserción y toggling de estado.
