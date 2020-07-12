<?php

	session_start();

	include_once('../includes/connection.php');
	include_once('../includes/article.php');

	$article = new Article;

	if (isset($_SESSION['logged_in'])) {
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$query = $pdo -> prepare("SELECT * FROM articles WHERE article_id = ?");

			$query -> bindValue(1, $id);
			$query -> execute();

			$row = $query -> fetch(PDO::FETCH_ASSOC);

			if (isset($_POST['title'], $_POST['content'])) {
				$title = $_POST['title'];
				$content = nl2br($_POST['content']);

				if (empty($title) or empty($content)) {
					$error = "All fields are required!";
				}
				else {
					$query = $pdo -> prepare("UPDATE articles SET article_title = ?, article_content = ? WHERE article_id = ?");

					$query -> bindValue(1, $title);
					$query -> bindValue(2, $content);
					$query -> bindValue(3, $id);

					$query -> execute();

					header("Location: ./edit.php");
				}
			}
		}

		$articles = $article -> fetch_all();
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

				<h4>Select an article to edit</h4>

				<form action="./edit.php" method="get">
					<select onchange="this.form.submit();" name="id">
					<?php foreach ($articles as $article) { ?>
						<option value="" selected disabled hidden>Choose here</option>
						<option value="<?php echo $article['article_id']; ?>"><?php echo $article['article_title']; ?></option>
					<?php } ?>
					</select>
				</form>

				<?php if (isset($row)) { ?>

					<?php if (isset($error)) { ?>
						<div class="error-container"><small class="error"><?php echo $error; ?></small></div>
					<?php } ?>

					<form method="post" autocomplete="off">
						<input type="text" name="title" placeholder="Title" value="<?php echo $row['article_title']; ?>" class="add-title">
						<textarea rows="15" cols="20" placeholder="Content" name="content" class="add-content"><?php echo $row['article_content']; ?></textarea>
						<input type="submit" value="Save Changes">
					</form>

				<?php } ?>

				<br>

				<a href="./index.php">&larr; Back</a>
			
			</div>
		</body>
		</html>

		<?php
	}
	else {
		header("Locaion: ./index.php");
	}

?>