<?php include("templates/page_header.php");?>
<?php
//First, check to see if we got an article id to lookup.
//If there was no article id suppled, redirect to homepage.
//Since we're potentially doing a redirect, this has to come before ANY html content.
	if (!isset($_GET['aid'])) {
		header("Location: /"); 
	}
	$aid = $_GET['aid'];
	$result=get_article($dbconn, $aid);
	$row = pg_fetch_array($result, 0); //There should only be one row
?>
<!doctype html>
<html lang="en">
<head>
<title><?php echo $row['title'] ?></title>
	<?php include("templates/header.php"); ?>



</head>
<body>
	<?php include("templates/nav.php"); ?>
	<?php include("templates/contentstart.php"); ?>

	<h3 class="pb-4 mb-4 font-italic border-bottom">
        Off the dome. Here we go ... 
      	</h3>

	<div class="blog-post">
	<h2 class="blog-post-title"><?php echo htmlspecialchars($row['title'],ENT_QUOTES,'UTF-8') ?></h2>
	<p class="blog-post-meta">
		<?php echo htmlspecialchars(substr($row['date'], 0, 10),ENT_QUOTES,'UTF-8')
		." by ".htmlspecialchars($row['author'],ENT_QUOTES,'UTF-8') ?>
	</p><p>
		<?php echo htmlspecialchars($row['content'],ENT_QUOTES,'UTF-8') ?>
		<?php
			if (!isset($_SESSION['username']) || ($_SESSION['username'] == 'admin') || ($_SESSION['username']==$row['author'])) : ?>
				<body><br>Delete Article</body>
				<a href="/deletearticle.php?aid=<?php echo $row['aid'] ?>"><i class="fa fa-times fa-2x" aria-hidden="true"></i></a>	
		
		<?php endif; ?>
		<!-- escape XSS in the display specific article page -->
	</p>
      </div><!-- /.blog-post -->
	<?php include("templates/contentstop.php"); ?>
	<?php include("templates/footer.php"); ?>
</body>
</html>
