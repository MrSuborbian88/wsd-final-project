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
 /*
 //Temporary, get 5 most recent articles
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
  */
 //Get user's most recent clicks
 $user_id = 0; //CHANGE TO GET ACTUAL USER
 $sql = 'SELECT DISTINCT user_id, article_id FROM clicks WHERE user_id = ' . strval($user_id) . ' ORDER BY clicktime DESC LIMIT 5;';
 $results = mysql_query($sql);
 $row = mysql_fetch_array( $results);
 while($row != null)
	{
	$sql = 'SELECT * FROM rss_articles WHERE id = '. strval($row['article_id']) . ';';
	$article_result = mysql_query($sql);
	$article_row = mysql_fetch_array($article_result);
	while($article_row != null)
	{
        $title = $article_row['title'];
	if($title == null || $title == '')
		$title = $article_row['url']; //After testing, change to $article_row['title']
	$abridged_title = substr($title, 0, 27);
	if(strlen($title) > 26)
		$abridged_title .= '...';
	echo '<li><a href="'.$article_row['url'].'" title="'.$title.'">'.$abridged_title."</a></li>";
		$article_row = mysql_fetch_array( $article_result );
	}
	$row = mysql_fetch_array( $results );
	}
  ?>
     </ul>
  </div>
  </div>
</body>
</html>
