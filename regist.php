<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

session_start();
if ($_SESSION['user']) {
    header('Location: account.php');
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="scss/style.css">
    <title>Регистрация</title>
</head>

<body>
    <section class="auth">
        <div class="auth_wrap">
            <div class="auth_left">
                <img src="img/logo_icon.png" alt="">
            </div>
            <div class="auth_right">
                <div class="auth_right_wrap">
                    <h1>Регистрация</h1>
                    <form class="form" action="php/signup.php" method="post" onsubmit="return validateForm()">
                        <input class="auth_input" name="name" id="nameField" type="text" placeholder="Имя" required>
                        <div id="nameError" class="error"></div>

                        <input class="auth_input" name="email" id="emailField" type="text" placeholder="Почта" required>
                        <div id="emailError" class="error"></div>

                        <input class="auth_input" name="phone" id="phoneField" type="text" placeholder="Номер телефона"
                            required>
                        <div id="phoneError" class="error"></div>

                        <input class="auth_input" name="password" id="passwordField" type="password"
                            placeholder="Пароль" required>
                        <div id="passwordError" class="error"></div>

                        <input class="auth_input" name="password_confirm" id="confirmPasswordField" type="password"
                            placeholder="Подтвердите пароль" required>
                        <div id="confirmPasswordError" class="error"></div>

                        <button type="submit" class="accept_button">Продолжить</button>
                    </form>
                    <a class="auth_bottom_link" href="auth.php">Уже есть аккаунт?</a>
                </div>

            </div>
        </div>
    </section>
    <script src="js/valid_regist.js"></script>
</body>

</html>