<?php

session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin.php");
}

echo "Вы вошли как администратор, " . $_SESSION['username'] . "!";

?>