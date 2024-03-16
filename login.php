<?php

session_start();

// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

$ip_address = $_SERVER['REMOTE_ADDR'];

$query = "SELECT * FROM ip_addresses WHERE ip_address = '$ip_address'";
$result = $connection->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['is_allowed'] == 1) {
        echo "Доступ разрешен!";
    } else {
        echo "Доступ запрещен!";
    }
} else {
    $insert_query = "INSERT INTO ip_addresses (ip_address) VALUES ('$ip_address')";
    $connection->query($insert_query);
    echo "IP адрес добавлен в базу данных!";
}

$connection->close();

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
