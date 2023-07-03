<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /');
    exit();
}
require_once '../php/connect.php';
$currentUserId = $_SESSION['user']['id'];

function generateForeignKeySelect($tableName, $columnName, $referenceTable)
{
    global $connect;
    $query = mysqli_query($connect, "SELECT * FROM $referenceTable");
    echo '<select name="' . $columnName . '" required>';
    while ($row = mysqli_fetch_assoc($query)) {
        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }
    echo '</select>';
}

function getAllTables()
{
    global $connect;
    $query = mysqli_query($connect, "SHOW FULL TABLES WHERE Table_Type = 'BASE TABLE'");
    $tables = array();
    while ($row = mysqli_fetch_row($query)) {
        $tables[] = $row[0];
    }
    return $tables;
}

function getAllViews()
{
    global $connect;
    $query = mysqli_query($connect, "SHOW FULL TABLES WHERE Table_Type = 'VIEW'");
    $views = array();
    while ($row = mysqli_fetch_row($query)) {
        $views[] = $row[0];
    }
    return $views;
}

// Функция для получения данных из выбранной таблицы
function getTableData($tableName)
{
    global $connect;
    $query = mysqli_query($connect, "SELECT * FROM $tableName");
    $tableData = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $tableData[] = $row;
    }
    return $tableData;
}

// Функция для добавления записи в выбранную таблицу
function addRecord($tableName, $data)
{
    global $connect;
    $columns = implode(", ", array_keys($data));
    $values = "'" . implode("', '", array_values($data)) . "'";
    unset($data['id']); // Удалить поле 'id' из массива данных
    mysqli_query($connect, "INSERT INTO $tableName ($columns) VALUES ($values)");
}

// Функция для удаления записи из выбранной таблицы
function deleteRecord($tableName, $id)
{
    global $connect;
    mysqli_query($connect, "DELETE FROM $tableName WHERE id = $id");
}

// Функция для обновления записи в выбранной таблице
function updateRecord($tableName, $id, $data)
{
    global $connect;
    $setValues = "";
    foreach ($data as $key => $value) {
        if ($key !== 'id' && $value !== '') { // Пропустить поле 'id' и пустые значения полей
            $setValues .= "$key = '$value', ";
        }
    }
    $setValues = rtrim($setValues, ', ');
    mysqli_query($connect, "UPDATE $tableName SET $setValues WHERE id = $id");
}

// Получение всех таблиц из базы данных
$tables = getAllTables();

// Проверка выбранной таблицы
if (isset($_GET['table']) && in_array($_GET['table'], $tables)) {
    $tableName = $_GET['table'];
    $tableData = getTableData($tableName);

    // Обработка добавления записи
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && (!isset($_GET['action']) || $_GET['action'] !== 'edit')) {
        $data = $_POST;
        addRecord($tableName, $data);
        header("Location: index.php?table=$tableName");
        exit();
    }

    // Обработка удаления записи
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $id = $_GET['id'];
        deleteRecord($tableName, $id);
        header("Location: index.php?table=$tableName");
        exit();
    }

    // Обработка обновления записи
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $record = null;
        foreach ($tableData as $row) {
            if ($row['id'] == $id) {
                $record = $row;
                break;
            }
        }
        if (!$record) {
            die("Запись не найдена.");
        }

        // Обработка обновления записи
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $data['id'] = $id; // Добавить идентификатор в массив данных
            updateRecord($tableName, $id, $data);
            header("Location: index.php?table=$tableName");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../scss/style.css">
    <title>Аккаунт</title>
</head>

<body class="body">
    <header class="header">
        <nav class="header_nav">
            <div class="header_top">
                <div class="header_logo">
                    <img src="../img/logo_main.png" alt="">
                </div>
                <div class="header_menu">
                    <div class="header_title">
                        <h1>ТАБЛИЦЫ</h1>
                    </div>
                    <ul class="menu_item">
                        <?php
                        // Получение списка таблиц
                        $tables = getAllTables();
                        ?>
                        <?php foreach ($tables as $table): ?>
                            <li><a href="index.php?table=<?php echo $table; ?>"><?php echo $table; ?></a></li>
                        <?php endforeach; ?>

                    </ul>
                </div>
                <div class="header_menu">
                    <div class="header_title">
                        <h1>ПРЕДСТАВЛЕНИЯ</h1>
                    </div>
                    <ul class="menu_item">
                        <?php
                        // Получение списка представлений
                        $views = getAllViews();
                        ?>
                        <?php foreach ($views as $view): ?>
                            <li><a href="index.php?table=<?php echo $view; ?>"><?php echo $view; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="header_playlist">
                    <div class="header_title header_playlist_top">
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <section class="section">
        <div class="container">
            <div class="top_items">
                <div class="top_items_right">
                    <a href="../php/logout.php" class="exit">Выйти</a>
                    <img class="top_img" src="../img/avatar/<?= $_SESSION['user']['photo'] ?>" id="avatarImage" alt="">
                    <p> <?= $_SESSION['user']['name'] ?></p>
                       
                </div>
            </div>
            <?php if (isset($tableName)): ?>
                <div class="table">
                    <h2>
                        <?php echo $tableName; ?>
                    </h2>
                    <table>
                        <thead>
                            <tr>
                                <?php foreach ($tableData[0] as $column => $value): ?>
                                    <th>
                                        <?php echo $column; ?>
                                    </th>
                                <?php endforeach; ?>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tableData as $row): ?>
                                <tr>
                                    <?php foreach ($row as $value): ?>
                                        <td>
                                            <?php echo $value; ?>
                                        </td>
                                    <?php endforeach; ?>
                                    <td>
                                        <a
                                            href="index.php?table=<?php echo $tableName; ?>&action=edit&id=<?php echo $row['id']; ?>">Редактировать</a>
                                        <a
                                            href="index.php?table=<?php echo $tableName; ?>&action=delete&id=<?php echo $row['id']; ?>">Удалить</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <h2 class="add_note">Добавить запись</h2>
                    <form class="add_note_form" method="POST" action="index.php?table=<?php echo $tableName; ?>">
                        <?php foreach ($tableData[0] as $column => $value): ?>
                            <?php if ($column === 'id')
                                continue; ?> <!-- Пропустить поле id -->
                            <?php if ($column === 'id_artist'): ?>
                                <label for="<?php echo $column; ?>"><?php echo $column; ?>:</label>
                                <?php generateForeignKeySelect($tableName, $column, 'artist'); ?>
                                <br>
                            <?php elseif ($column === 'id_user'): ?>
                                <label for="<?php echo $column; ?>"><?php echo $column; ?>:</label>
                                <?php generateForeignKeySelect($tableName, $column, 'users'); ?>
                                <br>
                            <?php elseif ($column === 'id_genre'): ?>
                                <label for="<?php echo $column; ?>"><?php echo $column; ?>:</label>
                                <?php generateForeignKeySelect($tableName, $column, 'genre'); ?>
                                <br>
                            <?php elseif ($column === 'id_album'): ?>
                                <label for="<?php echo $column; ?>"><?php echo $column; ?>:</label>
                                <?php generateForeignKeySelect($tableName, $column, 'album'); ?>
                                <br>
                            <?php elseif ($column === 'id_playlist'): ?>
                                <label for="<?php echo $column; ?>"><?php echo $column; ?>:</label>
                                <?php generateForeignKeySelect($tableName, $column, 'playlist'); ?>
                                <br>
                            <?php else: ?>
                                <label for="<?php echo $column; ?>"><?php echo $column; ?>:</label>
                                <input type="text" name="<?php echo $column; ?>" required>
                                <br>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <button type="submit">Добавить</button>
                    </form>

                    <?php if (isset($record)): ?>
                        <h2 lass="edit_note">Редактировать запись</h2>
                        <form class="edit_note_form" method="POST"
                            action="index.php?table=<?php echo $tableName; ?>&action=edit&id=<?php echo $record['id']; ?>">
                            <?php foreach ($record as $column => $value): ?>
                                <label for="<?php echo $column; ?>"><?php echo $column; ?>:</label>
                                <input type="text" name="<?php echo $column; ?>" value="<?php echo $value; ?>" <?php if ($value === null)
                                          echo 'placeholder="NULL"'; ?>>
                                <br>
                            <?php endforeach; ?>

                            <button type="submit">Обновить</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</body>

</html>