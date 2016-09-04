<!DOCTYPE html><head><title>Stories</title></head><body>
<form action="http://ec2-52-22-158-9.compute-1.amazonaws.com/fall2015-module3-greg-lubin-424128-dan-mazour-431275/mod3index.php" method="get">
  <button>Back To Home</button>
</form>

<?php


$mysqli = new mysqli('localhost', 'admin', 'admin', 'mod3');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
} 
session_start();
$username = $_SESSION['username'];

$userLoggedIn = (strlen($username) > 0);

if ($userLoggedIn){ 
	echo "<form action=\"createstory.php\" method=\"GET\"><p><input type=\"submit\" value=\"Create Story\" /></p></form>";
	echo "<form action=\"logout.php\" method=\"GET\">
	<p>
		<input type=\"submit\" value=\"Log Out\" />
	</p>
	</form>";
	echo "<form action=\"userprofile.php\" method=\"GET\">
	<p>
		<input type=\"submit\" value=\"My Profile\" />
	</p>
</form>";
	echo "---------------------";
}

?>


<?php

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


echo "</body></html>";
?>
