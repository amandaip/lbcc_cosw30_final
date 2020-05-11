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

<?php 
//messaging landing page listing list of chats
$page_title = 'Inbox';

include('header.php');
require('mysqli_connect.php'); 


//if the message is read, change thread to 1; if the message is unread, change thread to 0 




//view a specific chat between 2 users

$user_id = 1;
//$query = "SELECT * FROM MESSAGE WHERE receiver_id = $user_id";
//show the results stored in database
$query = "SELECT U2.first_name, U2.last_name, MESSAGE.* FROM MESSAGE, USER as U1, USER as U2 WHERE MESSAGE.receiver_id = U1.user_id AND MESSAGE.sender_id = U2.user_id AND MESSAGE.receiver_id = $user_id";

$result = mysqli_query($connection, $query);


echo "<div class='container'>";
echo "<h2>INBOX <a href='message_new.php'>OUTBOX</a></h2>";
//READ MESSAGE table headings
echo "
<table>
<thead>
<td class='center'>SENT BY</td>
<td class='center'>SUBJECT</td>
<td class='center'>CREATE DATE AND TIME</td>
<td class='center'>TRASH</td>
</thead>"; 

//READ 
while ($row = mysqli_fetch_assoc($result)) {
	
	$formattedDate = date('m/d/Y H:i:s', strtotime($row['create_date']));

	echo "
	<tr>
	<td class='center'>" . $row['first_name'] . " " . $row['last_name'] . "</td>
	<td><a href='message_view.php?id=" . $row['message_id'] . "&box=in'>" . $row['subject'] . "</a></td>
	<td class='center'>". $formattedDate . "</td>
	<td><a href='message_edit.php?id=" . $row['message_id'] . "' class='link'>delete</a></td>
	</tr>";
	}
echo "</table>"; // close table
echo "</div>";
?>

<?php include('footer.php');?>
</body>
</html>