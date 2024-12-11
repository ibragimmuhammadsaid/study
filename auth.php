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
		$_SESSION['permission'] = $userPermission;

		header("Location: /studentDB/index.php");
		exit();
	} else {
		echo "Login or Password is incorrect!";
		header("Refresh:1; url=" . $_SERVER['PHP_SELF']);
	}

}
?>

<!DOCTYPE Html>
<html>
<title> User Authorization </title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu|Lora">
<style>
	div {
			background-color: lightcyan;
			border: 2px solid lightgreen;
			border-collapse: collapse;
			align-items: center;
			margin-right: auto;
			margin-left: auto;
			padding: 10px;
			width: 300px;
			height: 85px;
			border-radius: 25px
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
		border-radius: 25px;
		background-color: white;
	}
	button {
		width: 100px;
		height: 40px;
		font-weight: bold;
		border: none;
		background-color: aqua;
		font-family: Ubuntu, sans-serif;
		cursor: pointer;
		margin-top: 20px
	}
	label {
		text-align: center;
		font-family: Ubuntu, sans-serif;
		font-size: 22px
	}
</style>

<body>
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
</body>

</html>