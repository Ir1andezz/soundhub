<?php

session_start();

if (!isset($_SESSION['user'])) {
    // Пользователь не авторизован, выполните необходимые действия (например, перенаправление на страницу авторизации)
    header('Location: /');
    exit();
}

require_once 'php/connect.php';

$currentUserId = $_SESSION['user']['id'];
$playlistId = $_POST['playlistId'];
$trackId = $_POST['trackId'];

// Добавление трека в плейлист
// Реализуйте добавление трека в плейлист в соответствии с вашей базой данных и логикой приложения
// Например:
$query = "UPDATE track SET id_playlist = '$playlistId' WHERE id = '$trackId'";

if (mysqli_query($connect, $query)) {
   
    header('Location: index.php');
    exit();
} else {

    header('Location: playlist_error.php');
    exit();
}
?>