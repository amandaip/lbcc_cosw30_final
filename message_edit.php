<!DOCTYPE HTML>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<link rel="stylesheet" type="text/css" href="styles_navbar.css">
</head>

<body>
<?php
//Delete a message
//change the status N (default) to Y

$page_title = 'Delete Message';
include 'header.php';
require("mysqli_connect.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//print_r($_POST);
	$message_id = $_POST['message_id'];
	$status = $_POST['status'];
	$update_query = 
		"UPDATE MESSAGE SET
		status = '$status'
		WHERE message_id = $message_id";
		
		
	$update_result = mysqli_query($connection, $update_query);
	if ($update_result) {
		//Success
		//echo "Data successfully updated!";
		header("Location: messaging.php?msg=ok");
		exit;
	}
	else {
		echo "Update failed!";
	}
	
	exit("Testing");
}
else {
$message_id = $_GET['id'];
$query = "SELECT * FROM MESSAGE WHERE message_id = $message_id";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);	

}

?>
<h2><a href="messaging.php">INBOX</a> <a href="message_new.php">OUTBOX</a></h2>
<h2>Delete Message</h2> 
<form action="message_edit.php" method="post">
	<p>Are you sure you want to delete this message? <br>
	(Note: it cannot be undone)
	<input type="hidden" name="message_id" value="<?php echo $row['message_id']; ?>">
	<select class="input-text" name="status" value="<?php echo $row['status']; ?>">
  <option value="N">No</option>
  <option value="Y">Yes</option>
  </select></p>

	<button id="submit" type="submit" value="submit">Submit</button>
</form>

</main>
	<?php include 'footer.php';?>
</body>
</html>










