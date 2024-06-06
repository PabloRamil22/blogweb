<?php
use App\Models\Post;

require 'vendor/autoload.php';
require 'config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $image = $_FILES['image'];

    // Directorio donde se almacenarán las imágenes subidas
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($image['name']);

    // Mueve el archivo subido al directorio de destino
    if (move_uploaded_file($image['tmp_name'], $targetFile)) {
        // Crear una nueva instancia de Post
        $post = new Post();
        $post->title = $title;
        $post->body = $body;
        $post->image = $targetFile; // Guarda la ruta de la imagen en la base de datos
        $post->user_id = $_SESSION['user_id'];
        $post->save();
        
        // Redirige de vuelta a la página principal
        header('Location: index.php');
        exit;
    } else {
        echo "Error al subir el archivo.";
    }
}
?>
