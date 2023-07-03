<!-- <?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// session_start();
// require_once 'connect.php';

// if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
//     $avatar = $_FILES['avatar'];
//     $tempPath = $avatar['tmp_name'];
//     $newFileName = uniqid() . '_' . $avatar['name'];
//     $uploadPath = 'img/avatar/' . $newFileName;

//     if (move_uploaded_file($tempPath, $uploadPath)) {
//         $userId = $_SESSION['user']['id'];

//         // Удаление предыдущей аватарки, если она существует
//         $previousPhoto = $_SESSION['user']['photo'];
//         if ($previousPhoto && file_exists("img/avatar/$previousPhoto")) {
//             unlink("img/avatar/$previousPhoto");
//         }

//         // Обновление информации о пользователе в БД
//         $query = "UPDATE `users` SET `photo` = '$newFileName' WHERE `id` = '$userId'";
//         if (mysqli_query($connect, $query)) {
//             // Обновление информации о пользователе в сессии
//             $_SESSION['user']['photo'] = $newFileName;
//             $_SESSION['message'] = 'Фотография успешно изменена!';
//         } else {
//             $_SESSION['message'] = 'Ошибка при выполнении запроса: ' . mysqli_error($connect);
//         }
//     } else {
//         $_SESSION['message'] = 'Ошибка при загрузке фотографии';
//     }
// } else {
//     $_SESSION['message'] = 'Ошибка при загрузке фотографии';
// }

// header('Location: ../account.php');
?> -->