<?php
session_start();
if (!isset($_SESSION['user'])) {
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
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");



?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="scss/style.css">
    <title>Аккаунт</title>
</head>

<body class="body">
<?php include 'header.php'; ?>
    <section class="section">
        <div class="container">
            <div class="top_items">
                <div class="top_items_left">
                    <form class="search_form" action="" method="post">
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
                    <h1 class="">Личный кабинет</h1>
                </div>
                <div class="account_position">
                    <form class="change_avatar_form" id="avatarForm" action="#" method="POST"
                        enctype="multipart/form-data">
                        <div class="account_img">
                        <img src="img/avatar/<?= $_SESSION['user']['photo'] ?>?timestamp=<?= time() ?>" id="avatarImage" alt="">
                        <input class="update_avatar_img" type="file" name="avatar_image" id="avatar_image" accept="image/jpeg, image/png">
                        </div>
                        <div class="account_right">
                            <div class="account_username">
                                <p class="username">
                                    <?= $_SESSION['user']['name'] ?>
                                </p>
                                <a href="php/logout.php" class="exit">Выйти</a>
                            </div>
                            <button class="change_photo_button" id="changePhotoButton" type="submit">Изменить
                                фотографию</button>
                        </div>
                    </form>
                    <script>
                        const avatarInput = document.getElementById('avatar_image');
                        const avatarImage = document.getElementById('avatarImage');

                        avatarInput.addEventListener('change', function (event) {
                            const file = event.target.files[0];
                            const reader = new FileReader();

                            reader.onload = function (e) {
                                avatarImage.src = e.target.result;
                                avatarImage.style.display = 'block';
                            };

                            reader.readAsDataURL(file);
                        });
                    </script>
                </div>
            </div>
            <div class="section_title pd_title">
                <h1 class="">Персональные данные</h1>
            </div>
            <div class="personal_data">
                <div class="personal_data_left">
                    <p>Телефон:</p>
                    <p>Почта:</p>
                </div>
                <div class="personal_data_right">
                    <p>
                        <?= $_SESSION['user']['phone'] ?>
                    </p>
                    <p>
                        <?= $_SESSION['user']['email'] ?>
                    </p>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- <script src="js/avatar.js"></script> -->
    <script src="js/menu.js"></script>
    <!-- <script src="js/hover.js"></script> -->

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES['avatar_image']) && $_FILES['avatar_image']['error'] === UPLOAD_ERR_OK) {
            $avatarImage = $_FILES['avatar_image'];
            $avatarImageName = $avatarImage['name'];
            $avatarImageTmp = $avatarImage['tmp_name'];

            // Генерация уникального имени файла для изображения
            $newImageName = uniqid() . '.' . pathinfo($avatarImageName, PATHINFO_EXTENSION);

            // Путь для сохранения изображения
            $targetPath = 'img/avatar/' . $newImageName;

            // Перемещение загруженного изображения в папку назначения
            move_uploaded_file($avatarImageTmp, $targetPath);

            // Присваиваем переменной $avatarImagePath путь к загруженной аватарке
            $avatarImagePath = '../avatar/' . $newImageName;

            // Обновление пути к аватарке в базе данных
            $updateQuery = "UPDATE users SET photo = '$avatarImagePath' WHERE id = $currentUserId";

            if (mysqli_query($connect, $updateQuery)) {
       
            } else {
                
            }
        } else {
         
        }
    }
    ?>


</body>

</html>