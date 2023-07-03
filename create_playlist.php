<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
}
require_once 'php/connect.php';
$currentUserId = $_SESSION['user']['id'];

$queryPlaylists = "SELECT playlist.name AS playlist_name, playlist.img AS playlist_img 
                   FROM playlist 
                   WHERE playlist.id_user = $currentUserId";


if ($resultPlaylists = mysqli_query($connect, $queryPlaylists)) {
    $playlists = mysqli_fetch_all($resultPlaylists, MYSQLI_ASSOC);
} else {
    die(mysqli_error($connect));
}

// Проверка, был ли отправлен поисковый запрос
if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];

    // Здесь вы можете обработать поисковый запрос и выполнить SQL-запрос с условием WHERE
    // чтобы выбрать только альбомы с совпадающими названиями

    // Пример:
    $queryAlbum = "SELECT album.name AS album_name, artist.name AS artist_name, album.img AS album_img 
                    FROM album 
                    JOIN artist ON album.id_artist = artist.id
                    WHERE album.name LIKE '%$searchTerm%'";

    if ($resultAlbum = mysqli_query($connect, $queryAlbum)) {
        $albums = mysqli_fetch_all($resultAlbum, MYSQLI_ASSOC);
    }
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="scss/style.css">
    <title>Создать плейлист</title>
</head>

<body class="body">
<?php include 'header.php'; ?>
    <section class="section">
        <div class="container">
            <div class="top_items">
                <div class="top_items_left">
                    <form class="search_form" action="#" method="post">
                        <input type="text" placeholder="Поиск">
                    </form>
                </div>
                <div class="top_items_right">
                    <img class="top_img" src="img/avatar/<?= $_SESSION['user']['photo'] ?>" id="avatarImage" alt="">
                    <a href="account.php">
                        <?= $_SESSION['user']['name'] ?>
                    </a>
                </div>
            </div>
            <div class="account_block">
                <div class="section_title">
                    <h1 class="">Плейлист</h1>
                </div>
                <div class="account_position">
                    <form class="account_position" method="POST" action="" enctype="multipart/form-data">
                        <div class="playlist_img">
                            <img class="preview_image" id="preview_image" src="" alt="" style="display: none;">
                            <label for="cover_image">Добавить обложку</label>
                            <input class="add_playlist_img" type="file" name="cover_image" id="cover_image"
                                accept="image/jpeg, image/png">
                        </div>

                        <script>
                            const coverImageInput = document.getElementById('cover_image');
                            const previewImage = document.getElementById('preview_image');

                            coverImageInput.addEventListener('change', function (event) {
                                const file = event.target.files[0];
                                const reader = new FileReader();

                                reader.onload = function (e) {
                                    previewImage.src = e.target.result;
                                    previewImage.style.display = 'block';
                                };

                                reader.readAsDataURL(file);
                            });
                        </script>
                        <div class="account_right">
                            <div class="account_username">
                                <input type="text" name="playlist_name" placeholder="Имя плейлиста" required>
                            </div>
                            <button type="submit" class="create_playlist_button">Создать</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="no_track">
                <p>Треков пока нет</p>
            </div>
        </div>
    </section>
    <script src="js/menu.js"></script>
    <script src="js/hover.js"></script>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['playlist_name'])) {
            $playlistName = $_POST['playlist_name'];

            // Здесь добавляется код для обработки загрузки обложки плейлиста, если требуется
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
                $coverImage = $_FILES['cover_image'];
                $coverImageName = $coverImage['name'];
                $coverImageTmp = $coverImage['tmp_name'];

                // Генерация уникального имени файла для изображения
                $newImageName = uniqid() . '.' . pathinfo($coverImageName, PATHINFO_EXTENSION);

                // Путь для сохранения изображения
                $targetPath = 'img/playlist/' . $newImageName;

                // Перемещение загруженного изображения в папку назначения
                move_uploaded_file($coverImageTmp, $targetPath);

                // Присваиваем переменной $playlistImg путь к загруженному изображению
                $playlistImg = '../playlist/' . $newImageName;

                // Вставка пути к изображению в базу данных
                $insertQuery = "INSERT INTO playlist (id_user, name, img) VALUES ('$currentUserId', '$playlistName', '$playlistImg')";

                if (mysqli_query($connect, $insertQuery)) {
                    
                    echo "";
                    
                } else {
                    echo "" . mysqli_error($connect);
                }
            } else {
                // Если изображение не было загружено, можно присвоить пустую строку
                $playlistImg = '';

                // Вставка пути к изображению (пустая строка) в базу данных
                $insertQuery = "INSERT INTO playlist (id_user, name, img) VALUES ('$currentUserId', '$playlistName', '$playlistImg')";

                if (mysqli_query($connect, $insertQuery)) {
                    echo "";
                } else {
                    echo "" . mysqli_error($connect);
                }
            }

            // Проверяем, существует ли плейлист с таким же названием для текущего пользователя
            $checkQuery = "SELECT * FROM playlist WHERE id_user = $currentUserId AND name = '$playlistName'";
            $result = mysqli_query($connect, $checkQuery);

            if (mysqli_num_rows($result) > 0) {
                echo "";
            } else {
                $insertQuery = "INSERT INTO playlist (id_user, name, img) 
                            VALUES ('$currentUserId', '$playlistName', '$playlistImg')";

                if (mysqli_query($connect, $insertQuery)) {
                    echo "";
                } else {
                    echo " " . mysqli_error($connect);
                }
            }
        }
    }
    ?>
</body>

</html>