<?php
session_start();
include("config.php");
include("lib/db.php");
include("lib/includes.php");

$aid = $_GET['aid'];
$result=get_article($dbconn, $aid);
$row = pg_fetch_array($result, 0);
#echo "aid=".$aid."<br>";
if (!isset($_SESSION['username']) || ($_SESSION['username'] == 'admin') || ($_SESSION['username']==$row['author'])){
    #Ensure that only admin/article author is able to delete an article.
    if (delete_article($dbconn, $aid) == True) {
        logger("Article deleted", "INFO");
    } else {
        logger("Article failed to be deleted", "ERROR");
    }
}
#echo "result=".$result."<br>";
# Check result
header("Location: /index.php");

?>
