<!DOCTYPE html><head><title>My Profile</title></head><body>
<form action="http://ec2-52-22-158-9.compute-1.amazonaws.com/fall2015-module3-greg-lubin-424128-dan-mazour-431275/stories.php" method="get">
  <button>Back To Stories</button>
</form>
<form action="logout.php" method="GET">
	<p>
		<input type="submit" value="Log Out" />
	</p>
	</form>

<h1> Dashboard </h1>
<?php 
$mysqli = new mysqli('localhost', 'admin', 'admin', 'mod3');
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
} 
session_start();
$username = $_SESSION['username'];
$linkNumbers = array();
$titleArray = array();
$countComments = array();

$stmt = $mysqli->prepare("select title, username, link from stories where username=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($gotTitle, $gotUsername, $gotLink);

while($stmt->fetch()){
	// printf("\t<h3>%s - %s - %s</h3>\n",
	// 	htmlspecialchars($gotTitle),
	// 	htmlspecialchars($gotUsername),
	// 	htmlspecialchars($gotLink)
	// 	);
	array_push($titleArray, $gotTitle);
	array_push($linkNumbers, $gotLink);
}

foreach ($linkNumbers as $value){
	$stmt = $mysqli->prepare("select COUNT(link) from comments where link=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('s', $value);
	$stmt->execute();
	$stmt->bind_result($countLink);
	while($stmt->fetch()){
	// 	printf("\t<h3>Number of views!!! %s</h3>\n",
	// 		htmlspecialchars($countLink)
	// 		);
		array_push($countComments, $countLink);

	}
	$stmt->close();
}


for($i=0; $i<count($linkNumbers); $i++) {
	printf("\t<h4>%s currently has %s comments</h4>\n",
			htmlspecialchars($titleArray[$i]),
			htmlspecialchars($countComments[$i])
			);
}


echo "<h1>Read Your Stories</h1>";

$stmt = $mysqli->prepare("select title, storyText, link from stories where username=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($title, $storyText, $link);
while($stmt->fetch()){
	printf("\t<h4>%s</h4>\n",
		htmlspecialchars($title)
	);
	echo "<form method=\"get\" action=\"viewfile.php\"><p><input type=\"hidden\" name=\"link\" value=\"$link\"><input type=\"submit\" value=\"Read\"></p></form>";
}
$stmt->close();


?>



</body></html>