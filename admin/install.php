<!DOCTYPE html>
<head>
  <title>Install File Lister</title>
</head>
<body>
  <p>Please input MySQL info and continue</p>
  <form action="install.php" method="post">
    Username: <input type="text" name="user" value="root">
    <br>Password: <input type="password" name="password">
    <br>Host: <input type="text" name="host" value="localhost">
    <br>Database Name <input type="text" name="database" valuse="SickleCMS">
    <br><input type="submit" value="Start Install!">
  </form>
</body>
</html>

<?php
$hostname = $_POST['host'];
$username = $_POST['user'];
$password = $_POST['password'];
$database = $_POST['database'];

if ($password == "")
{
  echo "<br>Password must not be empty!";
}

if ($username != "" && $hostname != "" && $password != "") {
$con = mysql_connect($hostname,$username,$password);
if (!$con)
{
  die('Could not connect: ' . mysql_error());
}


if (mysql_query("CREATE DATABASE IF NOT EXISTS " . $database, $con))
{
  echo "<br>Database was created as " . $database;
} else {
  echo "<br>Error creating database: " . mysql_error();
}

mysql_select_db($database, $con);

if (mysql_query("CREATE TABLE downloadkey
(
uniqueid varchar(500) NOT NULL default '',
timestamp varchar(100) NOT NULL default '',
filename varchar(255) NOT NULL default '',
downloads varchar(100) NOT NULL default '0'
)", $con))
{
      echo "<br> Created table downloadkey";
    } else {
      echo "<br> Error creating table downloadkey. " . mysql_error();
}

if (mysql_query("CREATE TABLE md5sums
(
filename varchar(255) NOT NULL default '',
md5 varchar(255) NOT NULL default ''
)", $con))
{
    echo "<br> Created table md5sums";
} else {
    echo "<br> Error creating table md5sums " . mysql_error();
}

if (mysql_query("CREATE TABLE dlcount
(
filename varchar(500) NOT NULL default '',
count varchar(500) NOT NULL default '0'
)", $con))
{
    echo "<br> Created table dlcount";
} else {
    echo "<br> Error creating table dlcount " . mysql_error();
}

mysql_close($con);

echo "<br>WARNING YOU MUST REMOVE THIS FILE OR SUFFER THE CONSEQUINCES!!!";
}
?>
