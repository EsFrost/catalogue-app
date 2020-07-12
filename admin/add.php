<?php

	session_start();

	include_once('../includes/connection.php');

	if (isset($_SESSION['logged_in'])) {
		if (isset($_POST['title'], $_POST['content'])) {
			$title = $_POST['title'];
			$content = nl2br($_POST['content']);

			if (empty($title) or empty($content)) {
				$error = "All fields are required!";
			}
			else {
				$query = $pdo -> prepare("INSERT INTO articles (article_title, article_content, article_timestamp) VALUES (?,?,?)");

				$query -> bindValue(1, $title);
				$query -> bindValue(2, $content);
				$query -> bindValue(3, time());

				$query -> execute();

				header("Location: ./index.php");
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

				<h4 class="article-title">Add Article</h4>

				<?php if (isset($error)) { ?>
					<div class="error-container"><small class="error"><?php echo $error; ?></small></div>
				<?php } ?>

				<form action="./add.php" method="post" autocomplete="off">
					<input type="text" name="title" placeholder="Title" class="add-title">
					<textarea rows="15" cols="20" placeholder="Content" name="content" class="add-content"></textarea>
					<input type="submit" value="Add Article">
				</form>
				
				<br>

				<a href="./index.php">&larr; Back</a>
			</div>
		</body>
		</html>

		<?php
	}
	else {
		header('Location: ./index.php');
	}

?>