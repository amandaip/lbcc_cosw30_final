<!--editing and deleting page-->
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<link rel="stylesheet" type="text/css" href="styles_navbar.css">
<style>
body {
  background-color:white;
}
  		table {
  margin-right: auto;
  margin-left: auto;
	width: 800px;
	border-collapse: collapse;
	overflow: hidden;
	box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

th,td {
	position: relative;
	background: #00aabb;
	border-radius: .4em;
}

.container {
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px;
  margin: 10px 0;
}

.date {
	float: right;
  color: #aaa;
}



</style>
</head>

<body>
<main class="container">
<?php 
$page_title = 'View Message';

include 'header.php';

require("mysqli_connect.php"); 



//To display the content for view message
$user_id = 1;
$message_id = $_GET['id'];


//need to fix this
if($_GET['box']=='in') {
	
	$query = "SELECT U2.first_name, U2.last_name, MESSAGE.* FROM MESSAGE, USER as U1, USER as U2 WHERE MESSAGE.receiver_id = U1.user_id AND MESSAGE.sender_id = U2.user_id AND MESSAGE.receiver_id = $user_id AND message_id = $message_id";
}
	
//need to fix this
if ($_GET['box']=='out') {
	$query = "SELECT U2.first_name, U2.last_name, MESSAGE.* FROM MESSAGE, USER as U1, USER as U2 WHERE MESSAGE.receiver_id = U1.user_id AND MESSAGE.sender_id = U2.user_id AND MESSAGE.sender_id = $user_id AND message_id = $message_id";
}





//$query = "SELECT U2.first_name, U2.last_name, MESSAGE.* FROM MESSAGE, USER as U1, USER as U2 WHERE MESSAGE.receiver_id = U1.user_id AND MESSAGE.sender_id = U2.user_id AND MESSAGE.receiver_id = $user_id AND message_id = $message_id";




$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);


echo "<h2><a href='messaging.php'>INBOX</a> <a href='message_new.php'>OUTBOX</a></h2>";


/*while ($row = mysqli_fetch_assoc($result)) {
	$formattedDate = date('m/d/Y H:i:s', strtotime($row['create_date']));
	echo '<p>SENT BY: ' .  $row["first_name"] . ' ' .  $row["last_name"] . '</p>';
	echo '<p>SUBECT: ' .  $row["subject"] . '</p>';
	echo '<p> CREATE DATE AND TIME: ' .  $formattedDate . '</p>';
	echo '<p>MESSAGE: ' .  $row["body"] . '</p>';
	}*/






// to post the message for reply message
echo '<div>';
// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$problem = false; // No problems so far.
	
	if (empty($_POST['body'])) {
		$problem = true;
	} 
	
	if (!$problem) { // If there weren't any problems...
	
		//Updates for mySOL
		require('mysqli_connect.php');
		
		// Print a message:
		print '<p class="text_success">Your message has been sent to receiver!</p>';

		//To debug
		//print_r($_POST);
		
		//Updates for mySQL
		
		// hard code the sender_id for now
    $sender_id = '1';
    $receiver_id = $_POST['receiver_id'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];

		$sql = "INSERT INTO MESSAGE (message_id, sender_id, receiver_id, subject, body) VALUES ('$sender_id', '$receiver_id', '$subject', '$body')";
		
		
		$add_newmsg = mysqli_query($connection, $sql);
		
		header("Location: message_new.php");

	} 

} // End of handle form IF.

echo '</div>';


?>

<h2>VIEW MESSAGE</h2>

	<p>SENT BY:
	<?php echo $row['first_name']; 
	echo ' '; 
	echo $row['last_name'];?></p>
	
	<p>SUBJECT:
	<?php echo $row['subject']; ?></p>

	<p>MESSAGE:
	<?php echo $row['body']; ?></p>











<h1>REPLY MESSAGE:</h1>
<form action="message_view.php" method="post">
	
	
	<p>SEND TO: 
	<input class="input-text" type="hidden" readonly name="receiver_id" value="<?php echo $row['user_id']; ?>"><?php echo $row["first_name"]; echo " "; echo $row["last_name"];?></p>
	
	
	<p>SUBJECT:
	<input class="input-text" type="text" readonly name="subject" maxlength="150" value="RE: <?php echo $row['subject'];?>"></p>
	

	<p>MESSAGE:<textarea name="body" placeholder="Type your message here..." value="<?php if (isset($_POST['body'])) { print htmlspecialchars($_POST['body']); } ?>" required></textarea></p>
	<br>
<button id="submit" type="submit" name="send" value="send">SEND</button>

</form>

</main>
	<?php include 'footer.php';?>
	
</body>
</html>