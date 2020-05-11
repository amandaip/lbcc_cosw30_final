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
<main = "container">
<?php 
//messaging landing page listing list of chats
$page_title = 'Outbox';

include('header.php');
require('mysqli_connect.php'); 

//view a specific chat between 2 users

//show the results stored in database

// I'm user_id (1)
$user_id = 1;
//$query = "SELECT * FROM MESSAGE WHERE receiver_id = $user_id";
$query = "SELECT U2.first_name, U2.last_name, MESSAGE.* FROM MESSAGE, USER as U1, USER as U2 WHERE MESSAGE.sender_id = U1.user_id AND MESSAGE.receiver_id = U2.user_id AND MESSAGE.sender_id = $user_id";

$result = mysqli_query($connection, $query);

echo "<h2><a href='messaging.php'>INBOX</a> OUTBOX</h2>";



//READ MESSAGE table headings
echo "
<table>
<thead>
<td class='center'>SENT TO</td>
<td class='center'>SUBJECT</td>
<td class='center'>CREATE DATE AND TIME</td>
<td class='center'>TRASH</td>
</thead>"; 

//READ 
while ($row = mysqli_fetch_assoc($result)) {
echo "
<tr>
<td class='center'>" . $row['first_name'] . " " . $row['last_name'] . "</td>
<td><a href='message_view.php?id=" . $row['message_id'] . "&box=out'>" . $row['subject'] . "</a></td>
<td class='center'>" . $row['create_date'] . "</td>
<td><a href='message_edit.php?id=" . $row['message_id'] . "' class='link'>delete</a></td></tr>";
}
echo "</table>"; // close table





// To send new message
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

		//change table name later
		$sql = "INSERT INTO MESSAGE (sender_id, receiver_id, subject, body) VALUES ('$sender_id', '$receiver_id', '$subject', '$body')";
		
		
		$add_newmsg = mysqli_query($connection, $sql);
		
		header("Location: messaging.php");
	
		
		/*To debug
		
		if ($add_newmsg) {
			echo '<p class="text_success">New message is stored into database!</p>';
		} else {
			echo "Error: ".$sql . "<br>" . mysqli_error($conn);
		}*/

	} 

} // End of handle form IF.

echo '</div>';

$query = "SELECT * FROM USER";
$result = mysqli_query($connection, $query);
?>

<h1>New Message:</h1>
<form action="message_new.php" method="post">
	
		<p>Send to: 
	<select name="receiver_id">
	<?php 
  	while($row = mysqli_fetch_assoc($result)) {
  		echo "<option value = '" . $row["user_id"]. "'>" . $row["first_name"]. " " . $row["last_name"]. "</option>";
  	}
  ?>
  </select>
	<p>Subject: <input type="text" name="subject" maxlength="150" value="<?php if (isset($_POST['subject'])) { print htmlspecialchars($_POST['subject']); } ?>"></p>
	<p>Message:<textarea name="body" placeholder="Type your message here..." value="<?php if (isset($_POST['body'])) { print htmlspecialchars($_POST['body']); } ?>" required></textarea></p>
	<br>
<button id="submit" type="submit" name="send" value="send">SEND</button>

</form>

</main>
<?php include('footer.php'); ?>
</body>
</html>
