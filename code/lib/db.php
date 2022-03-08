<?php

$dbconn = pg_pconnect("host=$pg_host port=$pg_port dbname=$pg_dbname user=$pg_dbuser password=$pg_dbpassword") or die("Could not connect");

if ($debug) {
	echo "host=$pg_host, port=$pg_port, dbname=$pg_dbname, user=$pg_dbuser, password=$pg_dbpassword<br>";
	$stat = pg_connection_status($dbconn);
	if ($stat === PGSQL_CONNECTION_OK) {
		echo 'Connection status ok';
	} else {
		echo 'Connection status bad';
	}    
}

function run_query($dbconn, $query, $inArray) {
	if ($debug) {
		echo "$query<br>";
	}
	if($inArray!=NULL){
		$result = pg_query_params($dbconn, $query, $inArray);
		#run_query is now edited to take a prepared statement as an input variable, with an array of inputs
		#This statement will be executed if the given task takes any user input
	}
	else{
		$result = pg_query($dbconn, $query);
		#This will be executed if no userinput is taken, such as the get_article function
	}
	

	if ($result == False and $debug) {
		echo "Query failed<br>";
	}
	return $result;
}

//database functions
function get_article_list($dbconn){
	$query= 
		"SELECT 
		articles.created_on as date,
		articles.aid as aid,
		articles.title as title,
		authors.username as author,
		articles.stub as stub
		FROM
		articles
		INNER JOIN
		authors ON articles.author=authors.id
		ORDER BY
		date DESC";
return run_query($dbconn, $query,NULL);
}

function get_article($dbconn, $aid) {
	$query = 'SELECT 
	articles.created_on as date,
	articles.aid as aid,
	articles.title as title,
	authors.username as author,
	articles.stub as stub,
	articles.content as content
	FROM 
	articles
	INNER JOIN
	authors ON articles.author=authors.id
	WHERE
	aid=$1
	LIMIT 1';
	return run_query($dbconn,$query,array($aid));

}

function delete_article($dbconn, $aid) {
	$query= "DELETE FROM articles WHERE aid=$1";

	return run_query($dbconn, $query,array($aid));
}

function add_article($dbconn, $title, $content, $author) {
	$stub = substr($content, 0, 30);
	$aid = str_replace(" ", "-", strtolower($title));
	$query="
		INSERT INTO
		articles
		(aid, title, author, stub, content) 
		VALUES
		($1, $2, $3, $4, $5)";
	return run_query($dbconn, $query,array($aid,$title,$author,$stub,$content));
}

function update_article($dbconn, $title, $content, $aid) {
	$query=
		"UPDATE articles
		SET 
		title=$1,
		content=$2
		WHERE
		aid=$3";
	return run_query($dbconn, $query,array($title,$content,$aid));
}

function authenticate_user($dbconn, $username, $password) {
	$query=
		"SELECT
		authors.id as id,
		authors.username as username,
		authors.password as password,
		authors.role as role
		FROM
		authors
		WHERE
		username=$1
		AND
		password=$2
		LIMIT 1";

	return run_query($dbconn, $query,array($_POST['username'],$_POST['password']));
}	
?>
