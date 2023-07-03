<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

session_start();

if ($_SESSION['user']) {
    header('Location: account.php');
    exit();
}

$error = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);


?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="scss/style.css">
    <title>Авторизация</title>
</head>
<body>
    <section class="auth">
        <div class="auth_wrap">
            <div class="auth_left">
                <img src="img/logo_icon.png" alt="">
            </div>
            <div class="auth_right">
                <div class="auth_right_wrap">
                    <h1>Авторизация</h1>
                    <form class="form" action="php/signin.php" method="post" onsubmit="return validateForm()">
                        <input class="auth_input" name="email" id="emailField" type="text" placeholder="Почта" required>
                        <div id="emailError" class="error"></div>

                        <input class="auth_input" name="password" id="passwordField" type="password"
                            placeholder="Пароль" required>
                        <div id="passwordError" class="error"></div>
                        <?php if ($error): ?>
                            <div class="error"><?= $error ?></div>
                        <?php endif; ?>
                        <button type="submit" class="accept_button">Продолжить</button>
                    </form>
                    <a class="auth_bottom_link" href="regist.php">Еще нет аккаунта?</a>
                </div>

            </div>
        </div>
    </section>
    <script src="js/valid_auth.js"></script>
</body>
</html>