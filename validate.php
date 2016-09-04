<?php

$mysqli = new mysqli('localhost', 'admin', 'admin', 'mod3');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
} 

session_start();
$username = $_POST['username'];
$username = (string) $username;
$password = $_POST['password'];
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

// $stmt = $mysqli->prepare("select username from users where username=?");
$stmt = $mysqli->prepare("SELECT COUNT(*), username, password from users where username=?");
if(!$stmt){
	printf("Query Prep Failed(1): %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($count, $returnUsr, $returnPwd);
$stmt->fetch();
$stmt->close();
$stmt = $mysqli->prepare("select title, storyText, link from stories order by link");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->execute();
$stmt->bind_result($title, $storyText, $link);
while($stmt->fetch()){
	printf("\t<h3>%s</h3>\n",
		htmlspecialchars($title)
	);
	echo "<form method=\"get\" action=\"viewfile.php\"><p><input type=\"hidden\" name=\"link\" value=\"$link\"><input type=\"submit\" value=\"Read\"></p></form>";
}
$stmt->close();

if ($count == 1 && crypt($password, $returnPwd)==$returnPwd){
	$_SESSION['username'] = $username;
	header('Location: http://ec2-52-22-103-67.compute-1.amazonaws.com/fall2015-module3-greg-lubin-424128-dan-mazour-431275/stories.php');
	exit;
}else{
	echo "Incorrect Username or Password";
	header('Location: http://ec2-52-22-103-67.compute-1.amazonaws.com/fall2015-module3-greg-lubin-424128-dan-mazour-431275/mod3index.php');
	exit;
}

?>

