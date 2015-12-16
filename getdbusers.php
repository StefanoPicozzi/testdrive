<?php

/*** begin our session ***/
session_start();

$mysql_hostname = '192.168.99.100';
$mysql_port     = '3306';
$mysql_username = 'sa';
$mysql_dbname   = 'nudgedb';
$mysql_password = 'password';
  
$mysql_service_host = getenv('MYSQL_SERVICE_HOST');
if (! empty($mysql_service_host) ) {
  $mysql_hostname = getenv('MYSQL_SERVICE_HOST');
  $mysql_port     = getenv('MYSQL_SERVICE_PORT');
  $mysql_username = getenv('MYSQL_USER');
  $mysql_dbname   = getenv('MYSQL_DATABASE');
  $mysql_password = getenv('MYSQL_PASSWORD');
}

try {
   
   ini_set('mysql.connect_timeout', 5); 
   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);

   /*** set the error mode to excptions ***/
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   /*** prepare the select statement ***/
   $stmt = $dbh -> prepare('
      SELECT 
         username AS :username
      FROM user');
      
   /*** bind the parameters ***/
   $username = '';
   $stmt -> bindParam(':username', $username, PDO::PARAM_STR);
            
   /*** execute the prepared statement ***/
   $stmt -> execute();
   $pucount = $stmt->rowCount();
   $row = $stmt->fetch(PDO::FETCH_NUM);   
            
   if ( $pucount > 0 ) {
   	    print "<pre>";
   		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
     		print "  Found username ". $row[0].PHP_EOL;   
		}
		print "</pre>";
   } else {
       $_SESSION['message'] = 'No user records found.';
   }
   
} catch(Exception $e) {
   $_SESSION['message'] = 'We are unable to process your request. Please try again later...'.$e;
   print $e;
 //  header('Location: error.php');
}

?>

<html lang='en'>
<head>
   <title>KIE Server Container Scanner POST Page</title>
   
   <meta charset='utf-8'>
   <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
   
   <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.css" />
   <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
   <script src="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.js"></script>

<style>
</style>

<body>

</body>
</html>