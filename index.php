<?php
// Session initialization
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$database = "myDB";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT CONCAT(Students.firstName, ' ', Students.Surname) AS Name, 
		Students.ID as ID,
		Students.Year as Year,
		StudentDebts.StudentDebt as Debt
		FROM Students
		LEFT JOIN StudentDebts
		ON Students.ID = StudentDebts.StudentID
		ORDER BY Year, ID";

$result = $conn->query($sql);
$data = $result->fetch_all(MYSQLI_ASSOC);


# ADD STUDENT FUNCTION
function addStudent($conn, $studentData) {
	# Retrieving student info by variables
	$studentFirstName = $studentData['firstName'];
	$studentSurname = $studentData['surname'];
	$studentID = $studentData['id'];
	$studentYear = $studentData['year'];

	# MySQL Query
	$sqlInsert = "INSERT INTO Students (Surname, firstName, ID, Year) VALUES ('$studentSurname', '$studentFirstName', $studentID, $studentYear);";

	# Query Check
	if ($conn->query($sqlInsert) === TRUE) {
        echo "New record created successfully!";
    } else {
        echo "Error: " . $sqlInsert . "<br>" . $conn->error;
    }
}



# REMOVE STUDENT FUNCTION
function removeStudent($conn, $studentData) {
	# ID Extractor
	$id = (int)$studentData['removeid'];

	# MySQL Query
	$sqlDelete = "DELETE FROM Students WHERE ID = $id;";

	# Query Check
	if ($conn->query($sqlDelete) === TRUE) {
        echo "Record deleted successfully!";
    } else {
        echo "Error: " . $sqlDelete . "<br>" . $conn->error;
    }
}



# UPDATE DEBT FUNCTION
function updateDebt($conn, $studentData) {
	# ID Extractor
	$id = (int)$studentData['updateID'];
	$reduceValue = (int)$studentData['reduceDebt'];

	# MySQL Query
	$sqlUpdate = "UPDATE StudentDebts SET StudentDebt = StudentDebt - $reduceValue WHERE StudentID = $id";

	# Query Check
	if ($conn->query($sqlUpdate) === TRUE) {
        echo "Record deleted successfully!";
    } else {
        echo "Error: " . $sqlUpdate . "<br>" . $conn->error;
    }
}



# Form Handling
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['addStudent'])) {
        addStudent($conn, $_POST);
		header("Refresh:1; url=" . $_SERVER['PHP_SELF']);
    } elseif (isset($_POST['removeStudent'])) {
        removeStudent($conn, $_POST);
		header("Refresh:1; url=" . $_SERVER['PHP_SELF']);
    } elseif (isset($_POST['updateDebt'])) {
		updateDebt($conn, $_POST);
		header("Refresh:1; url=" . $_SERVER['PHP_SELF']);
	} elseif (isset($_POST['logOut'])) {
		session_destroy();
		header("Location: /studentDB/auth.php");
	}
}

function permissionLevel ($userPermission) {
	if($userPermission == 'Admin');
}
?>



<!-- HTML -->
<!DOCTYPE Html>
<html>

	<title> Student Database </title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu|Lora">
	<style>
		body {
			background-color: lightblue;
			font-family: "Times New Roman", Times, serif;
		}
		table {
			background-color: white;
			border: 2px solid black;
			margin-left: 300px;
			border-collapse: collapse;
			font-size: 18px;
			float:left
		}
		tr {
			height: 25px;
			border-bottom: 2px solid black;
		}
		hr {
			color: green;
		}
		form {
			text-align: center;
			float: right;
			margin-right: 20px
		}
		h2 {
			text-align: center;
			font-family: Ubuntu, sans-serif;
		}
		h1 {
			text-align: center;
			font-family: Lora, serif;
		}
		div {
			background-color: lightcyan;
			border: 2px solid lightgreen;
			border-collapse: collapse;
			align-items: center;
			padding: 10px;
			width: 200px;
			height: 65px;
			border-radius: 25px
		}
		input {
			width: 200px;
			height: 25px;
			border: 1px solid black;
			border-radius: 25px;
			background-color: white;
			margin: 5px
		}
		button {
			width: 200px;
			border: none;
			background-color: white;
			height: 20px;
			cursor: pointer
		}
	</style>

	<body>
	
	<?php if($_SESSION['permission'] == "Admin" 
			|| $_SESSION['permission'] == "Editor" 
			|| $_SESSION['permission'] == "Viewer") { ?>

	<form action="" method="POST">
    	<input type="hidden" name="logOut" value="1">
    	<button type="submit">Log Out</button>
	</form>

	<header style="text-align: center"> <h2> Student Database </h2> </header>	

	<table>
		<tr style="background-color: lightgreen">
			<th width="300"> Name </th>
			<th width="200"> ID </th>
			<th width="100"> Year </th>
			<th width="200"> Debt </th>
		</tr>
		
		<?php foreach ($data as $value) { 
		$colorStyle = $value["Debt"] > 0 ? 'style="color: crimson; border-color: black; font-weight: bold"' : "" ?>
		
		<tr style="text-align:center">
			<td <?php echo $colorStyle ?>> <?php echo $value["Name"]; ?> </td>
			<td <?php echo $colorStyle ?>> <?php echo $value["ID"]; ?> </td>
			<td <?php echo $colorStyle ?>> <?php echo $value["Year"]; ?> </td>
			<td <?php echo $colorStyle ?>> <?php if ($value['Debt'] > 0) { echo $value["Debt"] , " sum" ;} ?> </td>
		</tr>
		<?php } ?>
	</table>
	<?php } else { ?>
		<h1> You have no access to this page! </h1>

			<form action="" method="POST">
    			<input type="hidden" name="logOut" value="1">
    			<button type="submit"> Authorize </button>
			</form>
		<?php } ?>

	<?php if($_SESSION['permission'] == "Admin" 
			|| $_SESSION['permission'] == "Editor") { ?>

		<!-- Add student form -->
	<form action="" method='POST'>
		<div> <h2> Add Student </h2> </div> <br>

		<!-- addStudent hidden name -->
		<input type="hidden" name="addStudent" value="1">

		<label for="firstName"> First Name </label><br>
		<input type='text' id='firstName' name='firstName'><br>

		<label for="surname"> Surname </label><br>
		<input type='text' id='surname' name='surname'><br>

		<label for="id"> ID </label><br>
		<input type='text' id='id' name='id'><br>

		<label for="year"> Year </label><br>
		<input type='text' id='year' name='year'><br>

		<input type='submit' value='Add' style="background-color: lightgreen; cursor: pointer">
	</form>
	<?php } ?>

	<?php if($_SESSION['permission'] == "Admin") { ?>
		<!-- Remove student form -->
	<form action="" method='POST'>
		<div> <h2> Remove Student </h2> </div> <br>

		<!-- removeStudent hidden name -->
		<input type="hidden" name="removeStudent" value="1">

		<label for="removeid"> ID </label><br>
		<input type='text' id='removeid' name='removeid'><br>

		<input type='submit' value='Remove' style="background-color: crimson; cursor: pointer">
	</form>
	<?php } ?>
	

	<?php if($_SESSION['permission'] == "Admin" 
			|| $_SESSION['permission'] == "Editor") { ?>
		<!-- Update debt form -->
	<form action="" method='POST'>
		<div> <h2> Pay Debt </h2> </div> <br>

		<!-- updateDebt hidden name -->
		<input type="hidden" name="updateDebt" value="1">

		<label for="updateID"> ID </label><br>
		<input type='text' id='updateID' name='updateID'><br>

		<label for="reduceDebt"> Reduce Amount </label><br>
		<input type='text' id='reduceDebt' name='reduceDebt'><br>

		<input type='submit' value='Pay' style="background-color: aqua; cursor: pointer">
	</form>
	<?php } ?>

	</body>

</html>
