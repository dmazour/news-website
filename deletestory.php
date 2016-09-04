<?php 
$mysqli = new mysqli('localhost', 'admin', 'admin', 'mod3');
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
} 
session_start();
$username = $_SESSION['username'];
$linkNumber = $_GET['link'];

$stmt = $mysqli->prepare("DELETE FROM stories WHERE link=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $linkNumber);
$stmt->execute();
$stmt->close();

header("Location: http://ec2-52-22-158-9.compute-1.amazonaws.com/fall2015-module3-greg-lubin-424128-dan-mazour-431275/stories.php");
exit;

?>