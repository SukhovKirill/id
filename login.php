<?php

session_start();

// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

$allowed_ips = array("127.0.0.1"); // Здесь перечисленны разрешенные IP-адреса

$client_ip = $_SERVER['REMOTE_ADDR']; // Получаем IP-адрес текущего пользователя

if (!in_array($client_ip, $allowed_ips)) {
    die("Доступ запрещен"); // Завершаем выполнение скрипта, если IP-адрес не в списке разрешенных
}

if($conn===false)
{
	die("connection error");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = mysqli_real_escape_string($conn, $username);
	$password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn,$sql);
    $row=mysqli_fetch_array($result);

    if($row["role"]=="user")
	{	

		$_SESSION["username"]=$username;

		header("location:index.php");
	}

	elseif($row["role"]=="admin")
	{

		$_SESSION["username"]=$username;
		
		header("location:admin.php");
	}

	else
	{
		echo "username or password incorrect";
	}
}

$conn->close();

?>

<form method="post" action="login.php">
    <input type="text" name="username" placeholder="Имя пользователя" required><br>
    <input type="password" name="password" placeholder="Пароль" required><br>
    <input type="submit" value="Войти">
</form>