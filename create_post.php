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

    $post = new Post();
    $post->title = $title;
    $post->body = $body;
    $post->user_id = $_SESSION['user_id']; 
    $post->save();

    header('Location: index.php');
    exit;
}
?>