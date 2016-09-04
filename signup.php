<?php

$mysqli = new mysqli('localhost', 'admin', 'admin', 'mod3');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
} 


session_start();
$username = $_POST['desiredusername'];
$username = (string) $username;
$password = $_POST['desiredpassword'];
$password = (string) $password;


// Make sure the username + password is valid (regex)
if( !preg_match('/^[\w_\.\-]+$/', $username) ){
	echo "Invalid Username";
	exit;
}
if( !preg_match('/^[\w_\.\-]+$/', $password) ){
	echo "Invalid Password";
	exit;
}

// Make sure the username isn't taken
$stmt = $mysqli->prepare("select username from users where username=?");


if(!$stmt){
	printf("Query Prep Failed(1): %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $username);

$stmt->execute();

$stmt->bind_result($result);
$stmt->fetch();


if (is_null($result)){
	// sign-in the user
	$_SESSION['username'] = $username;

	//Add that to the users query
	$stmt = $mysqli->prepare("insert into users (username, password) values (?, ?)");
	if(!$stmt){
		printf("Query Prep Failed(2): %s\n", $mysqli->error);
		exit;
	}
	$cryptPwd = crypt($password);
	$stmt->bind_param('ss', $username, $cryptPwd);
	$stmt->execute();
	$stmt->close();
	echo "You Created An Account!";
	header('refresh:3; url=http://ec2-52-22-103-67.compute-1.amazonaws.com/fall2015-module3-greg-lubin-424128-dan-mazour-431275/stories.php');
	exit;
} else {
	echo "Username Taken!";
	header('refresh:3; url=http://ec2-52-22-103-67.compute-1.amazonaws.com/fall2015-module3-greg-lubin-424128-dan-mazour-431275/mod3index.php');
}

?>