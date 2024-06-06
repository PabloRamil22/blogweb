<?php

use App\Models\Post;
use App\Models\Categorias;

require 'vendor/autoload.php';
require 'config.php';

session_start();

$posts = Post::with('user')->get(); 
$categories = Categorias::all();
$isLoggedIn = isset($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/index.css">
    <title>Foro</title>
</head>
<body>
    <div class="header">
        <h1>Foro</h1>
        <?php if ($isLoggedIn): ?>
            <a href="logout.php" class="login-button">Cerrar sesión</a>
        <?php else: ?>
            <a href="login.php" class="login-button">Inicio de sesión</a>
        <?php endif; ?>
    </div>

    <h1>Posts</h1>
    <?php foreach ($posts as $post): ?>
        <div>
            <h2><?= $post->title ?></h2>
            <p><?= $post->body ?></p>
            <p>Publicado por: <?= $post->user->name ?></p> <!-- Mostrar el nombre del usuario -->
        </div>
    <?php endforeach; ?>
    <hr>
    <h1>Categorias</h1>
    <?php foreach ($categories as $categoria): ?>
        <div>
            <h3><?= $categoria->name ?></h3>
        </div>
    <?php endforeach; ?>
    
    <?php if ($isLoggedIn): ?>
        <hr>
        <h2>Crear Nuevo Post</h2>
        <form action="create_post.php" method="POST">
            <div>
                <label for="title">Título:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div>
                <label for="body">Contenido:</label>
                <textarea id="body" name="body" required></textarea>
            </div>
            <button type="submit">Crear Post</button>
        </form>

        <hr>
        <h2>Crear Nueva Categoría</h2>
        <form action="create_category.php" method="POST">
            <div>
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <button type="submit">Crear Categoría</button>
        </form>
    <?php endif; ?>
</body>
</html>
