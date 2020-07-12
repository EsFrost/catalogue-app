<?php

	session_start();

	include_once('../includes/connection.php');

	if (isset($_SESSION['logged_in'])) {
		?>

		<!DOCTYPE html>
		<html lang="en">
		<head>
			<title>CMS Tutorial</title>
			<meta charset="utf-8">

			<link rel="stylesheet" type="text/css" href="../style.css">
		</head>
		<body>
			<div class="container">
				<a href="../index.php" id="logo">CMS</a>

				<ol>
					<li><a href="./add.php">Add article.</a></li>
					<li><a href="./delete.php">Delete article</a></li>
					<li><a href="./edit.php">Edit article</a></li>
					<li><a href="./logout.php">Logout</a></li>
				</ol>

				<a href="../index.php">&larr; Back</a>	
			</div>
		</body>
		</html>

		<?php
	}
	else {
		if (isset($_POST['username'], $_POST['password'])) {
			$username = $_POST['username'];
			$password = md5($_POST['password']);

			if (empty($username) or empty($password)) {
				$error = "All fields are required!";
			}
			else {
				$query = $pdo -> prepare("SELECT * FROM users WHERE user_name = ? AND user_password = ?");
				
				$query -> bindValue(1, $username);
				$query -> bindValue(2, $password);
				$query -> execute();

				$num = $query -> rowCount();

				if ($num == 1) {
					$_SESSION['logged_in'] = true;
					header("Location: ./index.php");
					exit();
				}
				else {
					$error = "Incorrect credentials. Try again.";
				}
			}
		}
		?>
		
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<title>CMS Tutorial</title>
			<meta charset="utf-8">

			<link rel="stylesheet" type="text/css" href="../style.css">
		</head>
		<body>
			<div class="container">
				<a href="../index.php" id="logo">CMS</a>

				<?php if (isset($error)) { ?>
					<div class="error-container"><small class="error"><?php echo $error; ?></small></div>
				<?php } ?>

				<form action="./index.php" method="post" autocomple="off">
					<input type="text" name="username" placeholder="Username">
					<input type="password" name="password" placeholder="Password">
					<input type="submit" value="Login">
				</form>

				<a href="../index.php">&larr; Back</a>			
			</div>
		</body>
		</html>

		<?php
	}

?>