<?php
require_once 'connect.php';

// // Проверяем, была ли отправлена форма
// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     // Получаем значение поискового запроса
//     $searchQuery = $_POST["search_query"];

//     // Проверяем, что поисковый запрос не пустой
//     if (!empty($searchQuery)) {
//         // Формируем SQL-запрос для поиска в нескольких таблицах
//         $sql = "SELECT name FROM artist WHERE name LIKE '%$searchQuery%' 
//                 ";

//         // Выполняем запрос
//         $result = $connect->query($sql);

//         // Обработка результатов запроса
//         if ($result->num_rows > 0) {
//             // Вывод найденных результатов
//             while ($row = $result->fetch_assoc()) {
//                 echo "name: " . $row["name"] . "<br>";
//             }
//         } else {
//             echo "Ничего не найдено.";
//         }
//     }
// }

?>
