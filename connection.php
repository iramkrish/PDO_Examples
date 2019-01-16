<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "posts";

// setting DSN
// A data source name (DSN) is a data structure that contains the information
// about a specific database that an Open Database Connectivity ( ODBC )
// driver needs in order to connect to it.

$dsn = "mysql:host=". $host .";dbname=". $dbname ;

// creating pdo instance
// Connections are established by creating instances of the PDO base class.
// It doesn't matter which driver you want to use; you always use the PDO class name.
// The constructor accepts parameters for specifying the database source (known as the DSN)
// and optionally for the username and password (if any).
// https://secure.php.net/manual/en/pdo.connections.php
$connection = new PDO($dsn,$user="root",$password);

// https://secure.php.net/manual/en/pdo.setattribute.php
$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);

// pdo query
// Executes an SQL statement, returning a result set as a PDOStatement object
// https://secure.php.net/manual/en/pdo.query.php
$statement = $connection->query("SELECT * FROM daily_posts");


// looping through the query result
// https://secure.php.net/manual/en/pdostatement.fetch.php

// example FETCH_OBJ
// default fetch mode set through setAttribute method in line 26
while($row = $statement->fetch(PDO::FETCH_OBJ)){
    echo $row->title;
}

// example FETCH_ASSOC
// default fetch mode set through setAttribute method in line 26 is overloaded
while($row = $statement->fetch(PDO::FETCH_ASSOC)){
    echo $row['title'];
}

// setting variables for testing purpose
$author = 'cricketnext';

// positional params
$sql_query = "SELECT * FROM daily_posts WHERE author=?";
$stmt = $connection->prepare($sql_query);
$stmt->execute([$author]);
$posts = $stmt->fetchAll();
var_dump($posts);

// named params
$sql_query = "SELECT * FROM daily_posts WHERE author=:author";
$stmt = $connection->prepare($sql_query);
// associative array
$stmt->execute(['author'=>$author]);
// default fetch mode set through setAttribute method in line 26
$posts = $stmt->fetchAll();
var_dump($posts);

// INSERT DATA
$title = "email";
$body = "Ram Krishnan - iramkrish95@gmail.com";
$author = "ram";
$is_published = 1;

$sql_insert = "INSERT INTO daily_posts(title,body,author,is_published) VALUES (:title,:body,:author,:is_published)";
$stmt_insert = $connection->prepare($sql_insert);
$stmt_insert->execute(["title"=>$title,"body"=>$body,"author"=>$author,"is_published"=>$is_published]);
echo "inserted";

// UPDATE DATA
$author = "ram krishnan";
$id = 2;
$sql_insert = "UPDATE daily_posts SET author=:author WHERE id=:id";
$stmt_insert = $connection->prepare($sql_insert);
$stmt_insert->execute(["id"=>$id,"author"=>$author]);
echo "updated";
?>