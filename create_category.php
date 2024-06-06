<?php
use App\Models\Categorias;

require 'vendor/autoload.php';
require 'config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    $category = new Categorias();
    $category->name = $name;
    $category->user_id = $_SESSION['user_id']; 
    $category->save();

    header('Location: index.php');
    exit;
}
?>