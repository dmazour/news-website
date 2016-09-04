<?php
	$mysqli = new mysqli('localhost', 'admin', 'admin', 'mod3');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
} 
session_start();
$username = $_SESSION['username'];
$title = $_POST['title'];
$story = $_POST['story'];

if( !preg_match('/^[\w_\.\-\s]+$/', $title) ){
	echo "Invalid Title";
	exit;
}

if( !preg_match('/^[\w_\.\-\s]+$/', $story) ){
	echo "Invalid Story";
	exit;
}

$stmt = $mysqli->prepare("insert into stories (title, storyText, username) values (?, ?, ?)");
	if(!$stmt){
		printf("Query Prep Failed(2): %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('sss', $title, $story, $username);
	$stmt->execute();
	$stmt->close();
	header('Location: http://ec2-52-22-103-67.compute-1.amazonaws.com/fall2015-module3-greg-lubin-424128-dan-mazour-431275/stories.php');
	exit;



?>