<?php
 $server = 'localhost';
 $user = 'pma';
 $password = '';
 $database = 'test';
 $db = mysql_connect($server, $user , $password);
 mysql_select_db($database);
 echo mysql_error();

$row = 1;
if (($handle = fopen("dump.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
	$sql = 'INSERT INTO users(username, cluster) VALUES(\''.mysql_real_escape_string($data[0]).'\', 0);';
	mysql_query($sql);
	echo mysql_error();
	$sql = 'INSERT INTO rss_articles(guid, url) VALUES(\''.mysql_real_escape_string($data[1]).'\', \''.mysql_real_escape_string($data[1]).'\');';
	mysql_query($sql);
	echo mysql_error();
	$sql = 'SELECT * FROM users WHERE username=\''.mysql_real_escape_string($data[0]).'\';';
	$result = mysql_query($sql);
	$uid = 0;
	while ($row = mysql_fetch_array($result))
	{
		$uid = $row['id'];
	}
	$sql = 'SELECT * FROM rss_articles WHERE guid=\''.mysql_real_escape_string($data[1]).'\';';
	$result = mysql_query($sql);
	$aid = 0;
	while ($row = mysql_fetch_array($result))
	{
		$aid = $row['id'];
	}
	$sql = 'INSERT INTO clicks(user_id, article_id) VALUES('.strval($uid).','.strval($aid).');';
	mysql_query($sql);
	echo mysql_error();
        for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "<br />\n";
        }
    }
    fclose($handle);
}
?>
