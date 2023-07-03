<?php

    $connect = mysqli_connect('localhost', 'root', '', 'soundhub');

    if (!$connect) {
        die('Error connect to DataBase');
    }