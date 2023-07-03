<?php
session_start();
require_once '../php/connect.php';

$email = $_POST['email'];
$password = md5($_POST['password']);

if (empty($email) || empty($password)) {
    $_SESSION['message'] = 'Пожалуйста, заполните все поля';
    header('Location: ../auth.php');
    exit();
}

$check_admin = mysqli_query($connect, "SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$password' AND `admin` = '1'");

if (mysqli_num_rows($check_admin) > 0) {
    $user = mysqli_fetch_assoc($check_admin);

    $_SESSION['user'] = [
        "id" => $user['id'],
        "name" => $user['name'],
        "photo" => $user['photo'],
        "phone" => $user['phone'],
        "email" => $user['email'],
        "admin" => $user['admin']
    ];

    header('Location: index.php');
    exit();
} else {
    $_SESSION['message'] = 'Неверный логин или пароль';
    header('Location: auth.php');
    exit();
}

?>