<?php
include 'connect.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUP Medical Services Department Login - Faculty</title>
    <link rel="stylesheet" href="login.css">
    <script defer src="login.js"></script>
</head>
<body>
   <section>
		<div class="box">
			<img src="images/pup-logo2.png" alt="" class="logo">
			<h2>PUP - MSD Faculty Module beta</h2>
      <form action="login_process_faculty.php" method="post">
        <input id="email" type="text" name="email" placeholder="Email" required/>
        <input id="password" type="password" name="pass" placeholder="Password"
        required/>
        <p id="erorrMessage" hidden></p>
        <input type="submit" type="submit" value="Sign In"/>
        <a href="#">I forgot my password</a>
      </form>
			<p>By using this service, you understood and agree to the <a href="#">PUP Online Services Terms of Use</a> and <a href="#">Privacy Statement</a></p>
			<p>For SHS Teachers, <a href="#">click here</a></p>
		</div>
	</section>
</body>
</html>