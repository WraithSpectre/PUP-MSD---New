<?php
include("connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUP Medical Services Department - Registration</title>
    <link rel="stylesheet" href="./styles/login.css">
</head>
<body>
   <section>
		<div class="box">
			<img src="images/pup-logo2.png" alt="" class="logo">
			<h2>PUP - MSD Medical Staff Module Registration beta</h2>
      <h6>Sign in to start your session<h6>

      <form action="register_process_admin.php" method="POST">
        <input id="first_name" type="text" name="first_name" placeholder="First Name" required/>
        <input id="last_name" type="text" name="last_name" placeholder="Last Name" required/>
        <input id="email" type="email" name="email" placeholder="Email" required/>
        <input id="pass" type="password" name="pass" placeholder="Password" required/>
        <input id="cpass" type="password" name="cpass" placeholder="Confirm Your Password" require/>
        <input id="account_status" type="hidden" name="account_status" value="active" require/>
        <input type="submit" name="submit" value="Register" class="form-btn"/>
      </form>
		</div>
	</section>
</body>
</html>