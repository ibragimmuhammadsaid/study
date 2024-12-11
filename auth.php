<?php
// Initialize session
session_start();

// Database connection settings
$servername = "localhost";
$rootAccess = "root";
$password = "";
$database = "userInfo";

// Create a connection
$conn = new mysqli($servername, $rootAccess, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$enterUsername = $_POST['username'];
	$enterPassword = $_POST['password'];
	$sql = "SELECT UserName, UserPassword, UserPermission FROM UserInfo WHERE UserName = '$enterUsername';";

	$result = $conn->query($sql);
	$data = $result->fetch_all(MYSQLI_ASSOC);

	if(password_verify($enterPassword, $data[0]['UserPassword'])) {
		echo "Permission Granted!";
		$userPermission = $data[0]['UserPermission'];
		$currentUsername = $data[0]['UserName'];
		$_SESSION['permission'] = $userPermission;
		$_SESSION['username'] = $currentUsername;

		header("Location: /studentDB/index.php");
		exit();
	} else {
		echo "Login or Password is incorrect!";
	}

}
?>

<!DOCTYPE Html>
<html>
<title> User Authorization </title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu|Lora">
<style>
	div {
			background-color: mediumturquoise;
			border: 2px solid lightgreen;
			border-collapse: collapse;
			align-items: center;
			margin-right: auto;
			margin-left: auto;
			padding: 10px;
			width: 300px;
			height: 85px;
			border-radius: 45px
	}
	h1 {
		text-align: center;
		font-family: Lora, serif;
	}
	form {
		text-align: center;
		font-size: 30px;
	}
	body {
		background-color: lightblue;
	}
	input {
		width: 300px;
		height: 25px;
		border: 1px solid black;
		border-radius: 30px 50px 50px 100px;
		background-color: white;
		padding-left: 20px
	}
	button {
		width: 100px;
		height: 40px;
		font-weight: bold;
		border: none;
		background-color: aqua;
		font-family: Ubuntu, sans-serif;
		cursor: pointer;
		margin-top: 20px;
		border-radius: 30px 100px 30px 100px;
	}
	label {
		text-align: center;
		font-family: Ubuntu, sans-serif;
		font-size: 22px
	}
</style>

<body>
	<div style="width: 600px; height:800px; background-color: dodgerblue; border:none">
	<div> <h1> Sign In </h1> </div>
	<br>

	<form action="" method='POST'>
		<!-- UserAuth -->
		<input type="hidden" name="userAuth" value="1">

		<label for="username"> Username </label><br>
		<input type='text' id='username' name='username' required><br>

		<label for="password"> Password </label><br>
		<input type='password' id='password' name='password' required><br>

		<button type='submit'> Log In </button>

		<!-- UserReg -->

		<button onclick="window.location.href='registration.php';"> Sign Up </button>
	</form>
	</div>
</body>

</html>