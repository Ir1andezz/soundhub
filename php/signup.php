<?php

    session_start();
    require_once 'connect.php';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $photo = $_POST['photo '];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if ($password === $password_confirm) {

        // $path = 'img/avatar' . time() . $_FILES['photo']['name'];
        // if (!move_uploaded_file($_FILES['photo']['tmp_name'], '../' . $path)) {
        //     $_SESSION['message'] = 'Ошибка при загрузке сообщения';
        //     header('Location: ../account.php');
        // }

        $password = md5($password);

        mysqli_query($connect, "INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`) VALUES (NULL, '$name', '$email', '$phone', '$password')");

        $_SESSION['message'] = 'Регистрация прошла успешно!';
        header('Location: ../auth.php');


    } else {
        $_SESSION['message'] = 'Пароли не совпадают';
        header('Location: ../regist.php');
    }

?>