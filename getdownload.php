<?php
// A script to generate unique download keys for the purpose of protecting downloadable goods

require_once __DIR__ . '/admin/dbconnect.php';

	// Get the filename given by directory linker
	$fileget = $_GET["file"];

	// Prevent downloading outside of directory listing bounds
	if (substr($fileget, 0, 1) == '/') {
		$file = substr($fileget, 1);
	} else {
		$file = $fileget;
	}

	if(empty($_SERVER['REQUEST_URI'])) {
    	$_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
	}

	// Strip off query string so dirname() doesn't get confused
	$url = preg_replace('/\?.*$/', '', $_SERVER['REQUEST_URI']);
	$folderpath = 'http://'.$_SERVER['HTTP_HOST'].'/'.ltrim(dirname($url), '/');

	// Add some salt
        $s1 = md5('GetFilesToday134364529193sad5He%#ll##@@!oSa#ltmy12!@$@');
        $s2 = rand();
        $s3 = $s1.md5($s2.rand().$s1).$s1;
	// Generate the unique download key
	$key = $s1.$s3.uniqid(md5(rand())).$s2;

	// Get the activation time
	$time = date('U');

// Write the key and activation time to the database as a new row.
	$registerid = mysql_query("INSERT INTO downloadkey (uniqueid,timestamp,filename) 
                                   VALUES(\"$key\",\"$time\",\"$file\")") or die(mysql_error());

// Create the filename
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

?>

<!DOCTYPE html>
  <head>
    <title>SickleCMS</title>

    <script type="text/javascript">
      window.setTimeout(function() {
        location.href = 'index.php';
      }, 10000);
    </script>

  </head>
  <body>
    <center>
      <p>Click here if you are not redirected automatically in 10 seconds
      <br><a href="index.php">Get More Files</a></p>
      <?php
        echo '<META HTTP-EQUIV="Refresh" Content="2; URL=download.php?id=' . $key . '">';
      ?>
  </body>
</html>
