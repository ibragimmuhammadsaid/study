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
	} else if (isset($_POST['authorize'])) {
		header("Location: /studentDB/auth.php");
	}
}

$conn->close();
?>

<!DOCTYPE Html>
<html>
<title> User Registration </title>
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
		font-family: "Times New Roman", Times, serif;
		align-items: center;
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
	select {
		margin-right: 20px;
		width: 100px;
		border: 1px solid grey;
		background-color: lightcyan;
		height: 25px;
		border-radius: 100px 100px 50px 50px
	}
</style>

<body>
	<div style="width: 600px; height:800px; background-color: dodgerblue; border:none">
	<div> <h1> Registration </h1> </div>
	<br>

	<form action="" method='POST'>
		<input type="hidden" name="userReg" value="1">

		<label for="username"> Enter username </label><br>
		<input type='text' id='username' name='username' required><br>

		<label for="password"> Enter password </label><br>
		<input type='password' id='password' name='password' required><br>

	<!-- User Permission Choice -->
	<select id="permission" name="permission">
      <option value="Admin">Admin</option>
      <option value="Editor">Editor</option>
      <option value="Viewer">Viewer</option>
    </select>

		<button type='submit'> Register </button>
	</form>

	<!-- I already have an account -->
	<form action="" method='POST'>
		<input type="hidden" name="authorize" value="1">
		<button type='submit' style="width: 200px"> I already have an account </button>
	</form>
	</div>
</body>

</html>