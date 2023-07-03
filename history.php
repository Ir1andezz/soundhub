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
    <title>История</title>
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
            <div class="section_title liked_songs_title">
                <h1 class="">История</h1>                  
            </div>
            <div>
                <div class="song_block">
                    <div class="song_block_left">
                        <img src="img/song_mask.png" alt="">
                        <div class="song_block_left_position">
                            <p class="song_name">Название трека</p>
                            <p class="song_author">Автор</p>
                        </div>
                    </div>
                    <div class="song_block_mmiddle">
                        <a href="">Название альбома</a>
                    </div>
                    <div class="song_block_right">
                        <img src="img/plus.png" alt="">
                        <img src="img/heart.png" alt="">
                        <p>00:00</p>
                    </div>
                </div>
                <div class="song_block">
                    <div class="song_block_left">
                        <img src="img/song_mask.png" alt="">
                        <div class="song_block_left_position">
                            <p class="song_name">Название трека</p>
                            <p class="song_author">Автор</p>
                        </div>
                    </div>
                    <div class="song_block_mmiddle">
                        <a href="">Название альбома</a>
                    </div>
                    <div class="song_block_right">
                        <img src="img/plus.png" alt="">
                        <img src="img/heart.png" alt="">
                        <p>00:00</p>
                    </div>
                </div>
                <div class="song_block">
                    <div class="song_block_left">
                        <img src="img/song_mask.png" alt="">
                        <div class="song_block_left_position">
                            <p class="song_name">Название трека</p>
                            <p class="song_author">Автор</p>
                        </div>
                    </div>
                    <div class="song_block_mmiddle">
                        <a href="">Название альбома</a>
                    </div>
                    <div class="song_block_right">
                        <img src="img/plus.png" alt="">
                        <img src="img/heart.png" alt="">
                        <p>00:00</p>
                    </div>
                </div>
                <div class="song_block">
                    <div class="song_block_left">
                        <img src="img/song_mask.png" alt="">
                        <div class="song_block_left_position">
                            <p class="song_name">Название трека</p>
                            <p class="song_author">Автор</p>
                        </div>
                    </div>
                    <div class="song_block_mmiddle">
                        <a href="">Название альбома</a>
                    </div>
                    <div class="song_block_right">
                        <img src="img/plus.png" alt="">
                        <img src="img/heart.png" alt="">
                        <p>00:00</p>
                    </div>
                </div>
                <div class="song_block">
                    <div class="song_block_left">
                        <img src="img/song_mask.png" alt="">
                        <div class="song_block_left_position">
                            <p class="song_name">Название трека</p>
                            <p class="song_author">Автор</p>
                        </div>
                    </div>
                    <div class="song_block_mmiddle">
                        <a href="">Название альбома</a>
                    </div>
                    <div class="song_block_right">
                        <img src="img/plus.png" alt="">
                        <img src="img/heart.png" alt="">
                        <p>00:00</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="js/menu.js"></script>
    <script src="js/hover.js"></script>
</body>
</html>