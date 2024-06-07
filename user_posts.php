<?php

use App\Models\Post;
use App\Models\User;
require 'vendor/autoload.php';
require 'config.php';


if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    $user = User::find($userId);
    $posts = Post::where('user_id', $userId)->get();
} else {
    
    header('Location: index');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .post-image {
        max-height: 200px; /* Altura máxima de la imagen */
        object-fit: cover; /* La imagen cubrirá el contenedor */
    }
</style>
</head>
<body>
    <h1>Posts de <?= htmlspecialchars($user->name) ?></h1>
    <a href="index" class="btn btn-secondary">Volver a Inicio</a>
    <?php foreach ($posts as $post) : ?>
        <div class="card mb-4">
            <img class="card-img-top post-image" src="<?= $post->image ?>" alt="Card image cap">
            <div class="card-body">
                <h2 class="card-title"><?= $post->title ?></h2>
                <p class="card-text"><?= $post->body ?></p>
                <a href="#" class="btn btn-primary">Leer más &rarr;</a>
            </div>
            <div class="card-footer text-muted">
                Publicado el <?= date("d/m/Y", strtotime($post->create_date)) ?> por
                <a href="#"><?= $user->name ?></a>
            </div>
        </div>
    <?php endforeach; ?>
</body>
</html>



