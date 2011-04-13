<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>MorningMail Recommender</title>
<link rel="stylesheet" type="text/css" href="final_project.css" />
</head>
<body>
  <div id="wrap">
  <div id="header">
  <h1>Morning Mail Recommender <span class = "span_header">RENSSELAER POLYTECHNIC INSTITUTE - Troy, NY, USA</span></h1>
  </div>
  <div id="content">
  <?php
 $server = 'localhost';
 $user = '';
 $password = '';
 $database = 'test';
 $db = mysql_connect($server, $user , $password);
 mysql_select_db($database);
 echo mysql_error();
 $sql = 'SELECT * FROM rss_articles ORDER BY pubdate DESC LIMIT 5';
 $results = mysql_query($sql);
 $row = mysql_fetch_array( $results);
 while($row != null)
	{
		echo '<h3>'.'<a href="'.$row['url'].'">'.$row['title'].'</a>'.'</h3>';
		echo '<p>'.$row['description'].'</p>';
		$row = mysql_fetch_array( $results );
	}
  ?>
    </div>
    <div id="nav">
    <h4>Recently Viewed</h4>
    <ul>
<?php
 $server = 'localhost';
 $user = '';
 $password = '';
 $database = 'test';
 $db = mysql_connect($server, $user , $password);
 mysql_select_db($database);
 echo mysql_error();
 $sql = 'SELECT * FROM rss_articles ORDER BY pubdate DESC LIMIT 5';
 $results = mysql_query($sql);
 $row = mysql_fetch_array( $results);
 while($row != null)
	{
	$title = $row['title'];
	$abridged_title = substr($title, 0, 27);
	if(strlen($title) > 26)
		$abridged_title .= '...';
	echo '<li><a href="'.$row['url'].'" title="'.$title.'">'.$abridged_title."</a></li>";
		$row = mysql_fetch_array( $results );
	}
  ?>
     </ul>
  </div>
  </div>
</body>
</html>
