<?php include("templates/page_header.php");?>
<?php include("lib/auth.php") ?>
<?php include("lib/includes.php") ?>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$intoken = $_POST['csrftoken'];
		if(!$intoken || $intoken!=$_SESSION['csrftoken']){
			logger($intoken,'INFO');
			logger($_SESSION['csrftoken'],'INFO');
			header('Location: index.php');
			exit;
		}
		$author = $_SESSION['id'];	
		if (add_article($dbconn, $_POST['title'], $_POST['content'], $author) == True) {
			logger("New article created", "INFO");
		} else {
			logger("Acticle failed to create", "ERROR");
		}
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

<h2>New Article</h2>
<?php 
		$token = bin2hex(random_bytes(16)); 
		$_SESSION['csrftoken'] = $token;
?>

<form action='#' method='POST'>
	<div class="form-group">
	<label for="inputTitle" class="sr-only">Post Title</label>
	<input type="hidden" name="csrftoken" value=<?php echo $token?> />
	<input type="text" id="inputTitle" placeholder="Title" required autofocus class="form-control" name='title'>
	</div>
	<div class="form-group">
	<label for="inputContent" class="sr-only">Post Content</label>
	<textarea name='content' class="form-control" id="inputContent" placeholder="Content" rows='10'></textarea>
	</div>
	<input type="submit" value="Publish" name="submit" class="btn btn-primary">
</form>
<br>

	<?php include("templates/contentstop.php"); ?>
	<?php include("templates/footer.php"); ?>
</body>
</html>
