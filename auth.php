<?php
// Initialize session
session_start();

// Database connection settings
$servername = "localhost";
$rootAccess = "root";
$password = "";
$database = "userInfo";

$permissions = ["admin" => ["create", "read", "update", "delete"],
				"editor" => ["create", "read", "update"],
				"viewer" => ["read"]];

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
		header("Location: /studentDB/index.php");
		exit();
	} else {
		echo "Login or Password is incorrect!";
	}

	$userPermission = $data[0]['UserPermission'];

	$_SESSION['permission'] = $userPermission;

}
?>

<!DOCTYPE Html>
<html>
<title> User Authorization </title>
<style>
	h1 {
		font-family: "Times New Roman", Times, serif;
		text-align: center;
		font-size: 50px;
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
	}
	button {
		width: 100px;
		height: 40px;
		font-weight: bold;
		background-color: lightgreen;
	}
	label {
		font-family: "Times New Roman", Times, serif;
		font-size: 20px;
	}
</style>

<body>
	<h1> Sign In </h1>
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
