<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /');
    exit();
}
require_once 'php/connect.php';
$currentUserId = $_SESSION['user']['id'];

$queryTracks = "SELECT track.id, track.duration as track_duration, track.name AS track_name, album.img AS album_img, album.name AS album_name, artist.name AS artist_name, plays_number 
FROM track JOIN album ON track.id_album = album.id JOIN artist ON track.id_artist = artist.id";

if ($resultTracks = mysqli_query($connect, $queryTracks)) {
    $tracks = mysqli_fetch_all($resultTracks, MYSQLI_ASSOC);
} else {
    die(mysqli_error($connect));
}

$queryPlaylists = "SELECT playlist.name AS playlist_name, playlist.img AS playlist_img 
                   FROM playlist 
                   WHERE playlist.id_user = $currentUserId";


if ($resultPlaylists = mysqli_query($connect, $queryPlaylists)) {
    $playlists = mysqli_fetch_all($resultPlaylists, MYSQLI_ASSOC);
} else {
    die(mysqli_error($connect));
}

$queryAlbum = "SELECT album.name AS album_name, artist.name AS artist_name, album.img AS album_img, album.id as album_id
                FROM album JOIN artist ON album.id_artist = artist.id JOIN users ON album.id_user = users.id";

if ($resultAlbum = mysqli_query($connect, $queryAlbum)) {
    $albums = mysqli_fetch_all($resultAlbum, MYSQLI_ASSOC);
} else {
    die(mysqli_error($connect));
}
$queryArtists = "SELECT artist.name AS artist_name, artist.img AS artist_img, genre.name AS artist_genre 
                FROM artist 
                JOIN genre ON artist.id_genre = genre.id";

if ($resultArtists = mysqli_query($connect, $queryArtists)) {
    $artists = mysqli_fetch_all($resultArtists, MYSQLI_ASSOC);
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
    <title>Главная</title>
</head>

<body class="body">
    <?php include 'header.php'; ?>
    <section class="section">
        <div class="container">
            <div class="top_items">
                <div class="top_items_left">
                    <form class="search_form" action="search.php" method="post">
                        <input type="text" name="search" placeholder="Поиск">
                    </form>
                </div>
                <div class="top_items_right">
                    <img class="top_img" src="img/avatar/<?= $_SESSION['user']['photo'] ?>" id="avatarImage" alt="">
                    <a href="account.php">
                        <?= $_SESSION['user']['name'] ?>
                    </a>
                </div>
            </div>
            <div class="account_block next_block">
                <div class="section_title">
                    <h1 class="">Для вас</h1>
                </div>
                <swiper-container class="for_you" slides-per-view="auto" free-mode="true"
                    no-swiping-class="swiper_no_swiping">
                    <?php foreach ($albums as $album): ?>
                        <div class="for_you_card swiper-slide">
                            <div class="for_you_img">
                                <img class="default_img" src="img/album/<?= $album['album_img']; ?>" alt="">
                                <div class="hover_block">
                                    <a href="album.php?album_id=<?= $album['album_id']; ?>"
                                        class="album-link swiper_no_swiping"><img class="hover_img" src="img/play_hover.png"
                                            alt=""></a>
                                </div>
                            </div>
                            <div class="for_you_bottom">
                                <div class="for_you_autor">
                                    <p>
                                        <?= $album['artist_name']; ?>
                                    </p>
                                </div>
                                <div class="for_you_name">
                                    <p>
                                        <?= $album['album_name']; ?>
                                    </p>
                                    <img src="img/heart.png" alt="">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </swiper-container>
                <div class="top_100">
                    <div class="section_title show_all">
                        <h1 class="">Топ-100</h1>
                        <a class="exit" href="top-100.php">Показать все</a>
                    </div>
                    <div>
                        <?php
                        $trackNumber = 1;
                        foreach ($tracks as $track):
                            if ($trackNumber > 5) {
                                break;
                            }
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
                                    <svg width="16" height="15" viewBox="0 0 16 15" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
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
            </div>
        </div>
    </section>
    <script src="js/pop_up.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-element-bundle.min.js"></script>
    <script src="js/menu.js"></script>
</body>

</html>