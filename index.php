<?php
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

$conn->close();
?>

<!DOCTYPE Html>
<html>

<title> Practice </title>
<header style="text-align: center"> <h2> Student Database </h2> </header>

<table border=2 style="margin-left: auto; margin-right: auto; border-collapse: collapse">
	<tr style="background-color: lightgrey">
	<th width="300"> Name </th>
	<th width="200"> ID </th>
	<th width="100"> Year </th>
	<th width="200"> Debt </th>
	</tr>
	
	<?php foreach ($data as $value) { 
	$colorStyle = $value["Debt"] > 0 ? 'style="color: crimson; border-color: black"' : "" ?>
	
	<tr style="text-align:center">
		<td <?php echo $colorStyle ?>> <?php echo $value["Name"]; ?> </td>
		<td <?php echo $colorStyle ?>> <?php echo $value["ID"]; ?> </td>
		<td <?php echo $colorStyle ?>> <?php echo $value["Year"]; ?> </td>
		<td <?php echo $colorStyle ?>> <?php if ($value["Debt"]) { echo $value["Debt"] , " sum" ;} ?> </td>
	</tr>
	<?php } ?>
</table>

</html>
