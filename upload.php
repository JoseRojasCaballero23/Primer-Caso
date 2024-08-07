<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivos'])) {
    $codigo = $_GET['codigo'] ?? null;
    if (!$codigo || !preg_match('/^[a-zA-Z0-9]{3}$/', $codigo)) {
        die('Código inválido.');
    }

    $archivos = $_FILES['archivos'];
    $carpetaDestino = 'uploads/' . $codigo . '/';
    
    if (!is_dir($carpetaDestino)) {
        mkdir($carpetaDestino, 0777, true);
    }

    foreach ($archivos['name'] as $index => $nombreOriginal) {
        $nombreArchivo = str_replace(' ', '_', $nombreOriginal); // Reemplazar espacios por guiones bajos
        $rutaDestino = $carpetaDestino . $nombreArchivo;

        if (move_uploaded_file($archivos['tmp_name'][$index], $rutaDestino)) {
            // Archivo subido con éxito
        } else {
            echo "Error al subir el archivo $nombreOriginal.";
        }
    }

    header("Location: /$codigo");
    exit();
}
