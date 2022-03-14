<?php include("templates/page_header.php");?>
<?php include("lib/auth.php") ?>
<?php include("lib/includes.php") ?>
<?php

if($_SERVER['REQUEST_METHOD'] == 'GET') {
	$aid = $_GET['aid'];	
	$result=get_article($dbconn, $aid);
	$row = pg_fetch_array($result, 0);
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$intoken = $_POST['csrftoken'];
	if(!$intoken || $intoken!=$_SESSION['csrftoken']){
		#check to make sure there is a csrf token, and that it is valid.
		header('Location: index.php');
		exit;
	}
	$title = $_POST['title'];
	$content = $_POST['content'];
	$aid = $_POST['aid'];
	$result=update_article($dbconn, htmlspecialchars($title,ENT_QUOTES,'UTF-8'), 
	htmlspecialchars($content,ENT_QUOTES,'UTF-8'), htmlspecialchars($aid,ENT_QUOTES,'UTF-8'));

	if ($result == True) {
		logger("Article modified", "INFO");
	} else {
		logger("Article failed to be modified", "ERROR");
	}

	#Added the htmlspecialchars to userinput, preventing XSS attacks by disabling special html characters
	Header ("Location: /");
}
?>

<!doctype html>
<html lang="en">
<head>
	<title>New Post</title>
	<?php include("templates/header.php"); ?>
</head>
<body>
	<?php include("templates/nav.php"); ?>
	<?php include("templates/contentstart.php"); ?>

<h2>New Post</h2>
<?php 
		$token = bin2hex(random_bytes(16)); 
		$_SESSION['csrftoken'] = $token;
		#Generate CSRF token, store in session.
?>
<form action='#' method='POST'>
	<input type="hidden" value="<?php echo $row['aid'] ?>" name="aid">
	<div class="form-group">
	<input type="hidden" name="csrftoken" value=<?php echo $token?> />
	<label for="inputTitle" class="sr-only">Post Title</label>
	<input type="text" id="inputTitle" required autofocus name='title' value="<?php echo $row['title'] ?>">
	</div>
	<div class="form-group">
	<label for="inputContent" class="sr-only">Post Content</label>
	<textarea name='content' id="inputContent"><?php echo $row['content'] ?></textarea>
	</div>
	<input type="submit" value="Update" name="submit" class="btn btn-primary">
</form>
<br>
	<?php include("templates/contentstop.php"); ?>
	<?php include("templates/footer.php"); ?>
</body>
</html>
