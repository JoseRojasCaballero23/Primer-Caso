<?php
// Mostrar errores para depuración (deshabilitar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Obtener la ruta de la URL actual
$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Verificar si la ruta tiene exactamente tres caracteres alfanuméricos
if (!preg_match('/^[a-zA-Z0-9]{3}$/', $path)) {
    // Generar tres caracteres aleatorios (letras y números)
    $codigoAleatorio = generarCodigoAleatorio(3);
    
    // Redirigir a la URL con los tres caracteres
    header("Location: /$codigoAleatorio");
    exit();
}

// Directorio donde se almacenarán los archivos para este código
$directorio = 'uploads/' . $path;

if (!is_dir($directorio)) {
    mkdir($directorio, 0777, true);
}

function generarCodigoAleatorio($tamano) {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $codigoAleatorio = '';
    for ($i = 0; $i < $tamano; $i++) {
        $codigoAleatorio .= $caracteres[random_int(0, strlen($caracteres) - 1)];
    }
    return $codigoAleatorio;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compartir archivos</title>
  <link rel="stylesheet" href="estilo.css">
</head>
<body>
  <div class="container">
    <h1>Compartir archivos</h1>
    <div class="upload-container">
      <div class="upload-box">
        <form action="upload.php?codigo=<?php echo $path; ?>" method="post" enctype="multipart/form-data">
          <label>Seleccione archivos:</label>
          <input type="file" id="archivo" name="archivos[]" multiple>
          <button type="submit">Subir archivos</button>
        </form>
      </div>
      <div class="file-list-container">
        <div class="file-list">
          <h2>Archivos subidos:</h2>
          <ul>
            <?php
              // Mostrar archivos subidos
              $archivos = glob("$directorio/*");
              if ($archivos) {
                foreach ($archivos as $archivo) {
                  $nombreArchivo = basename($archivo);
                  echo "<li><a href='$archivo' download='$nombreArchivo'>$nombreArchivo</a> <button onclick=\"eliminarArchivo('$nombreArchivo')\">Eliminar</button></li>";
                }
              } else {
                echo "<li>No hay archivos subidos aún.</li>";
              }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <script>
    function eliminarArchivo(nombreArchivo) {
      if (confirm("¿Seguro que quieres eliminar este archivo?")) {
        window.location.href = `delete.php?archivo=${nombreArchivo}&codigo=<?php echo $path; ?>`;
      }
    }
  </script>
</body>
</html>
