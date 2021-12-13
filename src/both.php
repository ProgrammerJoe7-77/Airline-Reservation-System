<!DOCTYPE html>
<html>
<head>
	<title>GSU Airways</title>
	<link rel="stylesheet" type="text/css" href="../css/lstyle.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php
$counter=0;
$cookie = 0;
    if (!isset($_COOKIE[$counter]))
    {
        setcookie($counter, $cookie);
    }
	?>
<div class="container" id="container">
<div class="form-container sign-up-container">

 <form method = "post" action = "register.php">
	<h1>Register</h1>
	 <input type="text" name="fname" class="namesimg" placeholder="First Name">
	 <input type="text" name="lname" placeholder="Last Name" class="namesimg">
	 <input type="text" id="personimg" name="username" placeholder="Username">
	<input type="password" class="passimg" name="password" id="password" placeholder="Password">
	<input type="email"  class="emailimg" name="email" placeholder="Email">
	<input type="phone" id="phoneimg" name="phone" placeholder="Phone Number">
	<button input type="submit" name="register" >Register</button>
</form>
</div>
<div class="form-container sign-in-container">
 <form method = "post" action = "login.php">
		<h1>Login</h1>
	<input type="text" id="personimg" name="username" placeholder="Username">
	<input type="password" class="passimg" name="password" placeholder="Password">
	<a href="#">Forgot Your Password?</a>

	<button input type="submit" name="login">Login</button>
	</form>
</div>
<div class="overlay-container">
	<div class="overlay">
		<div class="overlay-panel overlay-left">
			<h1>Have an account?</h1><br><br><br>
			<button class="ghost" id="signIn">Login</button>
		</div>
		<div class="overlay-panel overlay-right">
			<h1>Need an account?</h1><br><br><br>
			<button class="ghost" id="signUp">Register</button>
		</div>
	</div>
</div>
</div>

<script type="text/javascript">
	const signUpButton = document.getElementById('signUp');
	const signInButton = document.getElementById('signIn');
	const container = document.getElementById('container');

	signUpButton.addEventListener('click', () => {
		container.classList.add("right-panel-active");
	});
	signInButton.addEventListener('click', () => {
		container.classList.remove("right-panel-active");
	});
</script>


</body>
</html>
