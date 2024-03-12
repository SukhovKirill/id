<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

echo "Добро пожаловать, " . $_SESSION['username'] . "!";

?>