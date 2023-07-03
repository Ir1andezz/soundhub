<?php
session_start();
if (!$_SESSION['user']) {
    // Редирект пользователя на страницу входа или другую нужную вам страницу
    header("Location: my_library.php");
    exit();
}
require_once 'connect.php';

// Проверяем наличие параметра playlist_id в URL
if (isset($_GET['playlist_id'])) {
    // Получаем идентификатор плейлиста из параметра запроса
    $playlistId = $_GET['playlist_id'];

    // Проверяем, является ли текущий пользователь владельцем плейлиста
    $userId = $_SESSION['user']['id'];
    $queryCheckOwnership = "SELECT * FROM playlist WHERE id = $playlistId AND user_id = $userId";
    $result = mysqli_query($connect, $queryCheckOwnership);
    if ($result && mysqli_num_rows($result) > 0) {
        // Пользователь является владельцем плейлиста, отображаем страницу плейлиста и определяем действия пользователя

        // Обработка удаления плейлиста
        if (isset($_POST['delete_playlist'])) {
            // Получаем идентификатор плейлиста для удаления
            $playlistToDelete = $_POST['delete_playlist'];

            // Здесь выполните запрос для удаления плейлиста из базы данных
            // Используйте $playlistToDelete для указания плейлиста, который нужно удалить
            // Например:
            $queryDeletePlaylist = "DELETE FROM playlist WHERE id = $playlistToDelete";

            // Выполните запрос на удаление плейлиста
            if (mysqli_query($connect, $queryDeletePlaylist)) {
                // Плейлист успешно удален, выполните перенаправление на страницу со списком плейлистов или другую нужную вам страницу
                header("Location: playlists.php");
                exit();
            } else {
                die(mysqli_error($connect));
            }
        }

        // Отображение страницы плейлиста и другой код для работы с плейлистом

    } else {
        // Пользователь не является владельцем плейлиста, выполните перенаправление на страницу с сообщением об ошибке или другую нужную вам страницу
        header("Location: error.php");
        exit();
    }
} else {
    echo "Идентификатор плейлиста не указан.";
}
?>