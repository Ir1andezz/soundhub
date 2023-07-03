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
    <title>Альбом</title>
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
                <?php
                // Проверяем наличие параметра album_id в URL
                if (isset($_GET['album_id'])) {
                    // Получаем идентификатор альбома из параметра запроса
                    $albumId = $_GET['album_id'];

                    // Здесь выполните запрос для получения информации о конкретном альбоме и его треках
                    // Используйте $albumId для фильтрации данных только для выбранного альбома
                    // Например:
                    $queryAlbumInfo = "SELECT album.name AS album_name, artist.name AS artist_name, album.img AS album_img 
                        FROM album JOIN artist ON album.id_artist = artist.id 
                        WHERE album.id = $albumId";

                    // Выполните запрос и получите информацию об альбоме
                    if ($resultAlbumInfo = mysqli_query($connect, $queryAlbumInfo)) {
                        $albumInfo = mysqli_fetch_assoc($resultAlbumInfo);

                        // Здесь выполните запрос для получения треков, связанных с альбомом
                        // Используйте $albumId для фильтрации данных только для выбранного альбома
                        // Например:
                        $queryTracks = "SELECT track.duration as track_duration, track.name AS track_name, album.img AS album_img, album.name AS album_name, artist.name AS artist_name, plays_number, id_album 
                        FROM track JOIN album ON track.id_album = album.id JOIN artist ON track.id_artist = artist.id WHERE id_album = $albumId";

                        // Выполните запрос и получите список треков альбома
                        if ($resultTracks = mysqli_query($connect, $queryTracks)) {
                            $tracks = mysqli_fetch_all($resultTracks, MYSQLI_ASSOC);

                            // Здесь выведите информацию об альбоме и его треках на страницу
                            // Используйте $albumInfo для доступа к информации об альбоме, а $tracks - к списку треков
                            // Например:
                            ?>
                            <div class="account_position">
                                <div class="album_img">
                                    <img src="img/album/<?= $albumInfo['album_img']; ?>" alt="">
                                </div>
                                <div class="album__right">
                                    <div class="album__top">
                                        <p class="album_title">Альбом</p>
                                        <p class="album_name">
                                            <?= $albumInfo['album_name']; ?>
                                        </p>
                                        <p class="album_author">
                                            <?= $albumInfo['artist_name']; ?>
                                        </p>
                                    </div>
                                    <div class="album__bottom">
                                        <svg width="38" height="38" viewBox="0 0 38 38" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="19" cy="19" r="18.5" stroke="white" />
                                            <path d="M25 18.5L16 13V24L25 18.5Z" fill="white" stroke="white" stroke-width="2"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <svg width="16" height="15" viewBox="0 0 16 15" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.5 1C8 1 8 4 8 4C8 4 8 1 4.5 1C2.567 1 1.00004 2.85714 1 5.33333C1.00007 9.07189 8 14 8 14C8 14 15 8.85065 15 5.33333C15 3.02597 13.433 1 11.5 1Z"
                                                stroke="white" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <!-- Остальной код для отображения треков -->
                            <?php
                        } else {
                            die(mysqli_error($connect));
                        }
                    } else {
                        die(mysqli_error($connect));
                    }
                } else {
                    echo "Идентификатор альбома не указан.";
                }
                ?>
            </div>
            <div class="track_position">
            <?php
            $trackNumber = 1;
            foreach ($tracks as $track):
                ?>
                <div class="song_block">
                    <div class="song_block_left">
                        <p class="song_number">
                            <?php echo $trackNumber; ?>
                        </p>
                        <img src="img/album/<?= $track['album_img']; ?>" alt="">
                        <div class="song_block_left_position">
                            <p class="song_name">
                                <?= $track['track_name']; ?>
                            </p>
                            <p class="song_author">
                                <?= $track['artist_name']; ?>
                            </p>
                        </div>
                    </div>
                    <div class="song_block_mmiddle">
                        <a href="">
                            <?= $track['album_name']; ?>
                        </a>
                    </div>
                    <div class="song_block_right">
                        <div class="add_to_playlist-button">
                            <img src="img/plus.png" alt="">
                        </div>
                        <div class="add_to_playlist" id="add_block">
                                        <?php foreach ($playlists as $playlist): ?>
                                            <form method="POST" action="add_to_playlist.php">
                                                <input type="hidden" name="playlistId" value="<?= $playlist['playlist_id']; ?>">
                                                <input type="hidden" name="trackId" value="<?= $track['id'] ?>">
                                                <button class="add_to_playlist_button" type="submit">
                                                    <?= $playlist['playlist_name']; ?>
                                                </button>
                                            </form>
                                        <?php endforeach; ?>
                                    </div>
                        <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.5 1C8 1 8 4 8 4C8 4 8 1 4.5 1C2.567 1 1.00004 2.85714 1 5.33333C1.00007 9.07189 8 14 8 14C8 14 15 8.85065 15 5.33333C15 3.02597 13.433 1 11.5 1Z"
                                stroke="white" stroke-linejoin="round" />
                        </svg>
                        <p>
                            <?= $track['track_duration']; ?>
                        </p>
                    </div>
                </div>
                <?php
                $trackNumber++;
            endforeach;
            ?>
            </div>

        </div>
    </section>
    <script src="js/menu.js"></script>
    <script src="js/pop_up.js"></script>
    <script src="js/hover.js"></script>
</body>

</html>