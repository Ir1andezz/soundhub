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



?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="scss/style.css">
    <title>О сервисе</title>
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
                    <img class="top_img" src="img/avatar/<?=$_SESSION['user']['photo']?>" id="avatarImage" alt="">
                    <a href="account.php"><?= $_SESSION['user']['name'] ?></a>
                </div>
            </div>
            <div class="about_block scroll-link">
                <div class="section_title">
                    <h1 class="">О сервисе</h1>
                </div>
                <div class="about_top_items">
                    <div class="about_text">
                        <p>Аудиосервис SoundHub — это миллионы треков, HiFi-качество музыки, подкасты, эксклюзивы и персонализированные Волны.</p>
                    </div>
                    <div class="about_phone">
                        <img src="img/phone.png" alt="">
                    </div>
                </div>
            </div>
            <div class="about_bottom_items" id="target-element">
                <div class="about_bottom_items_position">
                    <div class="about-cards">
                        <h1>Более 70 млн треков</h1>
                        <p>Миллионы треков, тысячи плейлистов, новинки, хиты и топ-чарты.</p>
                    </div>
                    <div class="about-cards">
                        <h1>HiFi-качество звука</h1>
                        <p>Включайте HiFi-качество и наслаждайтесь звуком с повышенной детализацией.</p>
                    </div>
                </div>
                <div class="about_bottom_items_position">
                    <div class="about-cards">
                        <h1>Личный профиль</h1>
                        <p>Удобный способ делиться любимой музыкой и следить за обновлениями интересных пользователей и артистов.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="js/scroll.js"></script>
    <script src="js/menu.js"></script>
    <script src="js/hover.js"></script>
</body>
</html>