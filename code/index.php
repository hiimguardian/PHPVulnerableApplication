<?php include("templates/page_header.php");?>
<!doctype html>
<html lang="en">
<head>
	<title>Home</title>
	<?php include("templates/header.php"); ?>
</head>
<body>
	<?php include("templates/nav.php"); ?>
	<?php include("templates/contentstart.php"); ?>

	<h3 class="pb-4 mb-4 font-italic border-bottom">Articles</h3>

	<?php
		$result = get_article_list($dbconn);
		while ($row = pg_fetch_array($result)) {
	?>

<div class="blog-post">
<h2 class="blog-post-title"><?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') ?></h2>
<p class="blog-post-meta"><?php echo htmlspecialchars(substr($row['date'],0,10),ENT_QUOTES,'UTF-8')." by ".
	htmlspecialchars($row['author'], ENT_QUOTES, 'UTF-8') ?></p>
<p><?php echo htmlspecialchars($row['stub'],ENT_QUOTES,'UTF-8') ?><br><a href='article.php?aid=
<?php echo htmlspecialchars($row['aid'], ENT_QUOTES, 'UTF-8') ?>'>Read more...</a></p>
</div><!-- escape XSS in the display all the articles-->

	<?php } //close while loop ?>

	<?php include("templates/contentstop.php"); ?>
	<?php include("templates/footer.php"); ?>
</body>
</html>
