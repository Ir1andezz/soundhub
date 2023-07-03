<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
    exit();
} 

require_once 'php/connect.php';
$currentUserId = $_SESSION['user']['id'];

$queryPlaylists = "SELECT playlist.id AS playlist_id, playlist.name AS playlist_name, playlist.img AS playlist_img 
                   FROM playlist 
                   WHERE playlist.id_user = $currentUserId";

if ($resultPlaylists = mysqli_query($connect, $queryPlaylists)) {
    $playlists = mysqli_fetch_all($resultPlaylists, MYSQLI_ASSOC);
} else {
    die(mysqli_error($connect));
}
error_reporting(0);
ini_set('display_errors', 0);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="scss/style.css">
    <title>Плейлист</title>
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
                if (isset($_GET['playlist_id'])) {
                    $playlistId = $_GET['playlist_id'];

                    $queryPlaylistInfo = "SELECT playlist.name AS playlist_name, playlist.img AS playlist_img 
                                          FROM playlist 
                                          WHERE playlist.id_user = $currentUserId AND playlist.id = $playlistId";

                    if ($resultPlaylistInfo = mysqli_query($connect, $queryPlaylistInfo)) {
                        $playlistInfo = mysqli_fetch_assoc($resultPlaylistInfo);

                        $queryTracks = "SELECT track.duration AS track_duration, track.name AS track_name, album.img AS album_img, album.name AS album_name, artist.name AS artist_name, plays_number, id_album 
                                        FROM track 
                                        JOIN album ON track.id_album = album.id 
                                        JOIN artist ON track.id_artist = artist.id 
                                        WHERE id_playlist = $playlistId AND track.id_user = $currentUserId";

                        if ($resultTracks = mysqli_query($connect, $queryTracks)) {
                            $tracks = mysqli_fetch_all($resultTracks, MYSQLI_ASSOC);

                            // Удаление плейлиста
                            if (isset($_POST['delete_playlist'])) {
                                $deletePlaylistId = $_POST['delete_playlist'];

                                $queryDeletePlaylist = "DELETE FROM playlist WHERE id = $deletePlaylistId";

                                if (mysqli_query($connect, $queryDeletePlaylist)) {
                                    header("Location: playlist.php");
                                    exit();
                                } else {
                                    echo "Ошибка при удалении плейлиста.";
                                }
                            }

                            // Добавление трека в плейлист
                            if (isset($_POST['add_track'])) {
                                $addTrackId = $_POST['add_track'];

                                // Здесь выполните запрос для добавления трека в плейлист
                                // Используйте $addTrackId для указания трека, который нужно добавить
                                // Например:
                                $queryAddTrack = "INSERT INTO playlist_track (id_playlist, id_track) VALUES ($playlistId, $addTrackId)";

                                if (mysqli_query($connect, $queryAddTrack)) {
                                    // Трек успешно добавлен в плейлист
                                    header("Location: playlist.php?playlist_id=$playlistId");
                                    exit();
                                } else {
                                    echo "Ошибка при добавлении трека в плейлист.";
                                }
                            }
                            ?>

                            <div class="account_position">
                                <div class="album_img">
                                    <img src="img/album/<?= $playlistInfo['playlist_img']; ?>" alt="">
                                </div>
                                <div class="album__right">
                                    <div class="album__top">
                                        <p class="album_title">Плейлист</p>
                                        <p class="album_name"><?= $playlistInfo['playlist_name']; ?></p>
                                        <form class="delete-form" method="post" action="">
                                            <input type="hidden" name="delete_playlist" value="<?= $playlistId ?>">
                                            <button type="submit" class="delete-album">Удалить плейлист</button>
                                        </form>
                                    </div>
                                    <div class="album__bottom">
                                        <svg width="38" height="38" viewBox="0 0 38 38" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="19" cy="19" r="18.5" stroke="white" />
                                            <path d="M25 18.5L16 13V24L25 18.5Z" fill="white" stroke="white"
                                                  stroke-width="2" stroke-linejoin="round" />
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

                            <div class="track_position">
                                <?php
                                $trackNumber = 1;
                                foreach ($tracks as $track):
                                    ?>
                                    <div class="song_block">
                                        <div class="song_block_left">
                                            <p class="song_number"><?= $trackNumber; ?></p>
                                            <img src="img/album/<?= $track['album_img']; ?>" alt="">
                                            <div class="song_block_left_position">
                                                <p class="song_name"><?= $track['track_name']; ?></p>
                                                <p class="song_author"><?= $track['artist_name']; ?></p>
                                            </div>
                                        </div>
                                        <div class="song_block_mmiddle">
                                            <a href="album.php?album_id=<?= $track['id_album']; ?>">
                                                <?= $track['album_name']; ?>
                                            </a>
                                        </div>
                                        <div class="song_block_right">
                                            <div class="add_to_playlist-button">
                                                <img src="img/plus.png" alt="">
                                            </div>
                                            <div class="add_to_playlist" id="add_block">
                                                <?php foreach ($playlists as $playlist): ?>
                                                    <form class="add-track-form" method="post" action="">
                                                        <input type="hidden" name="playlist_id" value="<?= $playlist['playlist_id']; ?>">
                                                        <input type="hidden" name="track_id" value="<?= $track['id_track']; ?>">
                                                        <button type="submit" class="add-track-button"><?= $playlist['playlist_name']; ?></button>
                                                    </form>
                                                <?php endforeach; ?>
                                            </div>
                                            <svg width="16" height="15" viewBox="0 0 16 15" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11.5 1C8 1 8 4 8 4C8 4 8 1 4.5 1C2.567 1 1.00004 2.85714 1 5.33333C1.00007 9.07189 8 14 8 14C8 14 15 8.85065 15 5.33333C15 3.02597 13.433 1 11.5 1Z"
                                                    stroke="white" stroke-linejoin="round" />
                                            </svg>
                                            <p><?= $track['track_duration']; ?></p>
                                        </div>
                                    </div>
                                    <?php
                                    $trackNumber++;
                                endforeach;
                                ?>
                            </div>
                            <?php
                        } else {
                            die(mysqli_error($connect));
                        }
                    } else {
                        die(mysqli_error($connect));
                    }
                } else {
                    echo "Идентификатор плейлиста не указан.";
                }
                ?>
            </div>
        </div>
    </section>
    <script src="js/menu.js"></script>
    <script src="js/hover.js"></script>
    <script src="js/pop_up.js"></script>
</body>

</html>
