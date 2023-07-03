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
                    <form class="search_form" action="" method="post">
                        <input type="text" placeholder="Поиск">
                    </form>
                </div>
                <div class="top_items_right">
                    <img class="top_img" src="img/avatar/<?=$_SESSION['user']['photo']?>" id="avatarImage" alt="">
                    <a href="account.php"><?= $_SESSION['user']['name'] ?></a>
                </div>
            </div>
            <div class="contact_block">
                <div class="section_title">
                    <h1 class="">Контакты</h1>
                </div>
                <div class="contact_items">
                    <p>ООО «Soundhub», аффилированные лица и лицензиары. Все права защищены.</p>
                    <p>Юридический адрес: 107140, Москва г,вн.тер.г. муниципальный округ Красносельский, туп Большой Краснопрудный, д. 8/12, этаж 0, помещ. 2, ком. 4, офис 96</p>
                    <p>Почтовый адрес: 121170 г. Москва,ул. Поклонная, д. 3, секция Е4, 6 этаж.</p>
                    <p>Почта для связи со службой поддержки —support@soundhub.com</p>
                </div>
            </div>
        </div>
    </section>
    <script src="js/menu.js"></script>
    <script src="js/hover.js"></script>
</body>
</html>