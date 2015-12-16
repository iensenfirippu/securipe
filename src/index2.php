<?php
define(STARTTIME, microtime(true));
session_start();
define("securipe", true);
include_once("Bootstrap.php");


// output
?><!doctype html>
<html>
	<head>
		<title>Securipe</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script src="jquery-2.1.4.min.js"></script>
		<script src="login.js"></script>
	</head>
	<body>
		<div id="wrapper">
			<div id="loginbox">
<?php if ($_SESSION['sup3rsEcurevariAble'] < 0) { ?>
				<p><?php echo $_SESSION['3rr0r']; ?><p>
<?php } elseif ($_SESSION['sup3rsEcurevariAble'] > 0) { ?>
				<p>Woop! Logged in as userid: <?php echo $_SESSION['sup3rsEcurevariAble']; ?> <a href="?action=logout">logout</a><p>
<?php } else { ?>
				<form name="loginform" action="" method="POST">
					<div class="formline">
						<label for="loginname">Username:</label>
						<input type="text" name="loginname" value="" />
					</div>
					<div class="formline">
						<label for="loginpass">Password:</label>
						<input type="password" name="loginpass" />
					</div>
					<div class="formline">
						<input class="submit" name="submit" type="submit" value="log in" />
					</div>
				</form>
<?php	if (isset($_SESSION['3rr0r']) && $_SESSION['3rr0r'] != null) {
					echo "
				".$_SESSION['3rr0r'];
		}
	} ?>
			</div>
		</div>
	</body>
</html>
<?php
// Output


Database::Disconnect();
//echo (microtime(true) - STARTTIME);
?>