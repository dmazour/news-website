<!DOCTYPE html><head><title>Read Story</title></head><style>
	#sendBack{
		text-decoration: none;
	}
</style><body>

<form action="http://ec2-52-22-103-67.compute-1.amazonaws.com/fall2015-module3-greg-lubin-424128-dan-mazour-431275/stories.php" method="get">
  <button>Back To Stories</button>
</form>
<?php


$mysqli = new mysqli('localhost', 'admin', 'admin', 'mod3');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
} 
session_start();
$username = $_SESSION['username'];
$linkNumber = $_GET['link'];
$userLoggedIn = (strlen($username) > 0);

$stmt = $mysqli->prepare("select title, storyText, link, username from stories where link=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $linkNumber);
$stmt->execute();
$stmt->bind_result($title, $storyText, $link, $author);

while($stmt->fetch()){
	printf("\t<h3>%s by %s</h3><p>%s</p>\n",
		htmlspecialchars($title),
		htmlspecialchars($author),
		htmlspecialchars($storyText)
		);
}
$stmt->close();

if ($username == $author){
	echo "<form method=\"get\" action=\"editstory.php\"><p><input type=\"hidden\" name=\"link\" value=\"$linkNumber\"><input type=\"submit\" value=\"Edit Story\"></p></form>";
	echo "<form method=\"get\" action=\"deletestory.php\"><p><input type=\"hidden\" name=\"link\" value=\"$linkNumber\"><input type=\"submit\" value=\"Delete Story\"></p></form>";

}

// display comments

if ($userLoggedIn){ 
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

	echo "<strong>Comments</strong>
	<form action=\"addcomment.php\" method=\"POST\">
	<p>
	<label for=\"comment\">Comment:</label><input type=\"text\" name=\"comment\" id=\"comment\" />
	</p>
	<p><input type=\"hidden\" name=\"link\" value=\"$linkNumber\" id=\"link\">
	<p><input type=\"submit\" value=\"Send\" />
	<input type=\"reset\" />
	</p></form>";

	$stmt = $mysqli->prepare("select username, commentText, count from comments where link=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('s', $linkNumber);
	$stmt->execute();
	$stmt->bind_result($gotUser, $gotComment, $gotCount);
	while($stmt->fetch()){
		printf("\t<h3>%s: %s</h3>\n",
			htmlspecialchars($gotUser),
			htmlspecialchars($gotComment)
			);

		if ($username == $gotUser){
			echo "<form method=\"post\" action=\"editcomment.php\"><p><input type=\"hidden\" name=\"link\" value=\"$linkNumber\"><input type=\"hidden\" name=\"count\" value=\"$gotCount\"><input type=\"submit\" value=\"Edit Comment\"></p></form>";
			echo "<form method=\"post\" action=\"deletecomment.php\"><p><input type=\"hidden\" name=\"link\" value=\"$linkNumber\"><input type=\"hidden\" name=\"count\" value=\"$gotCount\"><input type=\"submit\" value=\"Delete Comment\"></p></form>";

		}


	}
	$stmt->close();



} else {

	$stmt = $mysqli->prepare("select username, commentText, count from comments where link=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('s', $linkNumber);
	$stmt->execute();
	$stmt->bind_result($gotUser, $gotComment, $gotCount);
	while($stmt->fetch()){
		printf("\t<h3>%s: %s</h3>\n",
			htmlspecialchars($gotUser),
			htmlspecialchars($gotComment)
			);

	}
	$stmt->close();


}
echo "</body>";
?>



<?php 
echo "</html>"
?>