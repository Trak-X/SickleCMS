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


if (mysql_query("CREATE DATABASE IF NOT EXISTS" . $database,$con))
  {
  echo "<br>Database was created as " . $database;
  }
else
  {
  echo "<br>Error creating database: " . mysql_error();
  }

mysql_select_db($database, $con);

$dltbl = "CREATE TABLE downloadkey
(
uniqueid varchar(255) NOT NULL default '',
timestamp varchar(255) NOT NULL default '',
filename varchar(255) NOT NULL default '',
)";
mysql_query($dltbl,$con);

$md5tbl = "CREATE TABLE md5sums
(
filename varchar(255) NOT NULL default '',
md5 varchar(255) NOT NULL default ''
)";
mysql_query($md5tbl,$con);

$dlcnttbl = "CREATE TABLE dlcount
(
filename varchar(500) NOT NULL default '',
count varchar(500) NOT NULL default '0'
)";

mysql_close($con);
echo "<br>WARNING YOU MUST REMOVE THIS FILE OR SUFFER THE CONSEQUINCES!!!";

}
?>
