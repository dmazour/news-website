<!DOCTYPE html>
<!-- The landing page. Users can enter their user name to be validated by validate.php -->
<head><title>Log-in</title></head>
<body>

<h1>Read Stories</h1>
<!-- <button><a href="http://ec2-52-22-103-67.compute-1.amazonaws.com/fall2015-module3-greg-lubin-424128-dan-mazour-431275/stories.php">
   Read Now
</a></button> -->

<form style="display: inline" action="http://ec2-52-22-158-9.compute-1.amazonaws.com/~dmazour/stories.php" method="get">
  <button>Read Now</button>
</form>



<h1>Sign In</h1>
<form action="validate.php" method="POST">
	<p>
		<label for="username">User Name:</label>
		<input type="text" name="username" id="username" />
	</p>
	<p>
		<label for="password">Password:</label>
		<input type="password" name="password" id="password" />
	</p>
	<p>
		<input type="submit" value="Send" />
		<input type="reset" />
	</p>
</form>

<h1>Create an Account</h1>
<form action="signup.php" method="POST">
	<p>
		<label for="desiredusername">Desired User Name:</label>
		<input type="text" name="desiredusername" id="desiredusername" />
	</p>
	<p>
		<label for="desiredpassword">Desired Password:</label>
		<input type="password" name="desiredpassword" id="desiredpassword" />
	</p>
	<p>
		<input type="submit" value="Send" />
		<input type="reset" />
	</p>
</form>



</body>
</html>