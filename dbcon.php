<?

$user = 'websysfinal';
$pw = 'websysfinal';
$host = 'localhost';
$db = 'websysfinal';


mysql_connect($host, $user, $pw) or die ('db error!');
mysql_select_db($db);
