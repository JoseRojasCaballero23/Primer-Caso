<?php
$codigo = $_GET['codigo'] ?? null;
$archivo = $_GET['archivo'] ?? null;

if ($codigo && preg_match('/^[a-zA-Z0-9]{3}$/', $codigo) && $archivo) {
    $archivoPath = 'uploads/' . $codigo . '/' . $archivo;

    if (file_exists($archivoPath)) {
        unlink($archivoPath); // Eliminar el archivo
        echo "Archivo eliminado con éxito.";
    } else {
        echo "El archivo no existe.";
    }
}

header("Location: /$codigo");
exit();
