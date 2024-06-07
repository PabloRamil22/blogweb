<?php

use App\Models\Post;
use App\Models\Categorias;
use App\Models\User;
require 'vendor/autoload.php';
require 'config.php';

session_start();

$posts = Post::with('user')->get();
$categories = Categorias::all();
$isLoggedIn = isset($_SESSION['user_id']);
$userName = '';
$userImage = '';

if ($isLoggedIn) {
    $user = User::find($_SESSION['user_id']);
    if ($user) {
        $userName = $user->name;
        $userImage = $user->image;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .profile-image {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index">Foro</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto align-items-center">
                    <?php if ($isLoggedIn) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="profile">
                                <img src="<?= htmlspecialchars($userImage) ?>" alt="Perfil" class="profile-image">
                                <?= htmlspecialchars($userName) ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout">Cerrar sesión</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login">Inicio de sesión</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="my-4">Posts</h1>

                <!-- Blog Post -->
                <?php foreach ($posts as $post) : ?>
                    <div class="card mb-4">
                        <!-- Ajusta la ruta de la imagen en la etiqueta img -->
                        <img class="card-img-top" src="<?= $post->image ?>" alt="Card image cap">
                        <div class="card-body">
                            <h2 class="card-title"><?= $post->title ?></h2>
                            <p class="card-text"><?= $post->body ?></p>
                            <a href="#" class="btn btn-primary">Leer más &rarr;</a>
                        </div>
                        <div class="card-footer text-muted">
                            Publicado el <?= date("d/m/Y", strtotime($post->create_date)) ?> por
                            <a href="user_posts?user_id=<?= $post->user->id ?>"><?= $post->user->name ?></a>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

            <!-- Sidebar Widgets Column -->
            <div class="col-md-4">

                <!-- Search Widget -->
                <div class="card my-4">
                    <h5 class="card-header">Buscar</h5>
                    <div class="card-body">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Buscar...">
                            <span class="input-group-append">
                                <button class="btn btn-secondary" type="button">Buscar</button>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Categories Widget -->
                <div class="card my-4">
                    <h5 class="card-header">Categorías</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <ul class="list-unstyled mb-0">
                                    <?php foreach ($categories as $category) : ?>
                                        <li>
                                            <a href="#"><?= $category->name ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Create Post Form -->
                <?php if ($isLoggedIn) : ?>
                    <div class="card my-4">
                        <h5 class="card-header">Crear Nuevo Post</h5>
                        <div class="card-body">
                            <form action="create_post.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="title">Título:</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="form-group">
                                    <label for="body">Contenido:</label>
                                    <textarea class="form-control" id="body" name="body" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="category_id">Categoría:</label>
                                    <select class="form-control" id="category_id" name="category_id" required>
                                        <?php foreach ($categories as $category) : ?>
                                            <option value="<?= $category->id ?>"><?= $category->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="image">Imagen:</label>
                                    <input type="file" class="form-control-file" id="image" name="image">
                                </div>
                                <button type="submit" class="btn btn-primary">Crear Post</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Create Category Form -->
                <?php if ($isLoggedIn) : ?>
                    <div class="card my-4">
                        <h5 class="card-header">Crear Nueva Categoría</h5>
                        <div class="card-body">
                            <form action="create_category.php" method="POST">
                                <div class="form-group">
                                    <label for="name">Nombre:</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Crear Categoría</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Foro &copy; <?= date("Y") ?></p>
        </div>
        <!-- /.container -->
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
