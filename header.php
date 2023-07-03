<?php
$queryPlaylists = "SELECT playlist.name AS playlist_name, playlist.img AS playlist_img, playlist.id as playlist_id 
FROM playlist 
WHERE playlist.id_user = $currentUserId";


if ($resultPlaylists = mysqli_query($connect, $queryPlaylists)) {
$playlists = mysqli_fetch_all($resultPlaylists, MYSQLI_ASSOC);
} else {
die(mysqli_error($connect));
}?>

<header class="header">
        <nav class="header_nav">
            <div class="header_media">
                <img src="img/logo_main.png" alt="">
                <form class="search_form" action="#" method="post">
                    <input type="text" placeholder="Поиск">
                </form>
                <button class="header_burger-btn" id="burger">
                    <span></span><span></span><span></span>
                </button>
            </div>
            <div class="header_media_menu">
                <div class="top_items_right">
                    <img class="top_img" src="img/avatar/<?= $_SESSION['user']['photo'] ?>" id="avatarImage" alt="">
                    <a href="account.php">
                        <?= $_SESSION['user']['name'] ?>
                    </a>
                </div>
                <div class="header_media_menu__bottom">
                    <div class="header_menu">
                        <div class="header_title">
                            <h1>МЕНЮ</h1>
                        </div>
                        <ul class="menu_item">
                            <li><a href="index.php">Главная</a></li>
                            <li><a href="my_library.php">Моя медиатека</a></li>
                            <li><a href="liked.php">Любимые треки</a></li>
                            <li><a class="menu_item_bottom" href="about.php">О сервисе</a></li>
                            <li><a class="menu_item_bottom" href="contacts.php">Контакты</a></li>
                        </ul>
                    </div>
                    <div class="header_playlist">
                        <div class="header_title header_playlist_top">
                            <h1>ПЛЕЙЛИСТЫ</h1>
                            <a href="create_playlist.php"><img src="img/plus.png" alt=""></a>
                        </div>
                        <div class="header_playlist_bottom">
                            <?php
                            $count = 0; // Переменная счетчика
                            
                            foreach ($playlists as $playlist) {
                                if ($count < 5) {
                                    // Отображение плейлиста
                                    ?>
                                    <div class="playlist_mini">
                                        <img src="img/playlist/<?= $playlist['playlist_img']; ?>" alt="">
                                        <p>
                                            <?= $playlist['playlist_name']; ?>
                                        </p>
                                    </div>
                                    <?php
                                    $count++; // Увеличение счетчика после отображения плейлиста
                                } else {
                                    break; // Прерывание цикла после отображения трех плейлистов
                                }
                            }

                            // Проверка, есть ли плейлисты для отображения
                            if (count($playlists) > 5) {
                                ?>
                            <button class="see-more-button"> <a href=""></a> Смотреть еще</button>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header_top">
                <div class="header_logo">
                    <img src="img/logo_main.png" alt="">
                </div>
                <div class="header_menu">
                    <div class="header_title">
                        <h1>МЕНЮ</h1>
                    </div>
                    <ul class="menu_item">
                        <li><a href="index.php">Главная</a></li>
                        <li><a href="my_library.php">Моя медиатека</a></li>
                        <li><a href="liked.php">Любимые треки</a></li>
                    </ul>
                </div>
                <div class="header_playlist">
                    <div class="header_title header_playlist_top">
                        <h1>ПЛЕЙЛИСТЫ</h1>
                        <a href="create_playlist.php"><img src="img/plus.png" alt=""></a>
                    </div>
                    <div class="header_playlist_bottom">
                        <?php
                        $count = 0; // Переменная счетчика
                        
                        foreach ($playlists as $playlist) {
                            if ($count < 5) {
                                // Отображение плейлиста
                                ?>
                                <div class="playlist_mini">
                                <a href="playlist.php?playlist_id=<?= $playlist['playlist_id']; ?>" class="album-link"><img src="img/playlist/<?= $playlist['playlist_img']; ?>" alt=""></a>
                                    
                                    <p>
                                        <?= $playlist['playlist_name']; ?>
                                    </p>
                                </div>
                                <?php
                                $count++; // Увеличение счетчика после отображения плейлиста
                            } else {
                                break; // Прерывание цикла после отображения трех плейлистов
                            }
                        }


                        ?>
                    </div>
                </div>
            </div>
            <div class="header_bottom">
                <a href="about.php">О сервисе</a>
                <a href="contacts.php">Контакты</a>
            </div>
        </nav>
    </header>