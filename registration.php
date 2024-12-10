<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$database = "userInfo";

// Permissions
$permissions = ["admin" => ["create", "read", "update", "delete"],
				"editor" => ["create", "read", "update"],
				"viewer" => ["read"]];

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM UserInfo";

$result = $conn->query($sql);
$data = $result->fetch_all(MYSQLI_ASSOC);

function addUser($conn, $userInfo) {
	$userName = $_POST['username'];
	$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
	$permission = $_POST['permission'];

	$sqlInsert = "INSERT INTO UserInfo (UserName, UserPassword, UserPermission) VALUES ('$userName', '$password', '$permission');";

	# Query Check
	if ($conn->query($sqlInsert) === TRUE) {
        echo "User added successfully!";
    } else {
        echo "Error: " . $sqlInsert . "<br>" . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['userReg'])) {
        addUser($conn, $_POST);
		header("Location: /studentDB/auth.php");
		exit();
	}
}

$conn->close();
?>

<!DOCTYPE Html>
<html>
<title> User Registration </title>
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
	}font-family: "Times New Roman", Times, serif;
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
	<h1> Registration </h1>
	<br>

	<form action="" method='POST'>
		<input type="hidden" name="userReg" value="1">

		<label for="username"> Enter username </label><br>
		<input type='text' id='username' name='username' required><br>

		<label for="password"> Enter password </label><br>
		<input type='password' id='password' name='password' required><br>

	<!-- User Permission Choice -->
		<input type="radio" id="Admin" name="permission" value="Admin" required>
		<label for="Admin"> Admin </label>

		<input type="radio" id="Editor" name="permission" value="Editor">
		<label for="Editor"> Editor </label>

		<input type="radio" id="Viewer" name="permission" value="Viewer">
		<label for="Viewer"> Viewer </label><br>

		<button type='submit'> Register </button>
	</form>
</body>

</html>
