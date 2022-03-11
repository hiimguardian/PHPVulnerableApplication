<?php
session_start();
include("config.php");
include("lib/db.php");
include("lib/includes.php");

$aid = $_GET['aid'];
#echo "aid=".$aid."<br>";
if (delete_article($dbconn, $aid) == True) {
    logger("Article deleted", "INFO");
} else {
    logger("Article failed to be deleted", "ERROR");
}
#echo "result=".$result."<br>";
# Check result
header("Location: /admin.php");

?>
