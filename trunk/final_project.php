<?php include('CAS-1.2.1/CAS.php'); 
 phpCAS::client(CAS_VERSION_2_0,'login.rpi.edu',443,'/cas');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>MorningMail Recommender</title>
<link rel="stylesheet" type="text/css" href="final_project.css" />
</head>
<body>
  <div id="wrap">
  <div id = "login">
    <a href = "CAS_RPI.php">Login</a>
    <a href = "CAS_RPI_logout.php">Logout</a>
  </div>
  <div id="header">
  <h1>Morning Mail Recommender <span class = "span_header">RENSSELAER POLYTECHNIC INSTITUTE - Troy, NY, USA</span></h1>
  </div>
  <div id="content">
  <?php

 if (phpCAS::isAuthenticated())
 {
   $user_id=phpCAS::getUser();
 }
 else
 {
   $user_id = 'id';
 }
 $server = 'localhost';
 $user = 'websysfinal';
 $password = 'websysfinal';
 $database = 'websysfinal';
 $db = mysql_connect($server, $user , $password) or die('db error');
 mysql_select_db($database);
 echo mysql_error();
<<<<<<< .mine
 $existing_user = mysql_query('SELECT * FROM users WHERE username=\''.$user_id.'\'');
 if(mysql_num_rows($existing_user)==0)
 {
   $sql = 'INSERT INTO users(username, cluster) VALUES(\''.$user_id.'\', 0);';
   mysql_query($sql);
   echo mysql_error();
 }
=======
 $username = ""; //However we're getting username
 $cluster = -1;
 $sql = 'SELECT cluster FROM users WHERE username=\'' . $username .'\';';
 $results = mysql_query($sql);
 $row = mysql_fetch_array( $results);
 while($row != null)
 {
	$cluster = $row['cluster'];
	$row = mysql_fetch_array( $results );
 }
 //User not clustered, show 10 most recent
 if($cluster <= 0)
 {
>>>>>>> .r23
 $sql = 'SELECT * FROM rss_articles ORDER BY pubdate DESC LIMIT 5';
 $results = mysql_query($sql);
 $row = mysql_fetch_array($results);
  while($row != null)
	{
		echo '<h3>'.'<a href="'.$row['url'].'">'.$row['title'].'</a>'.'</h3>';
		echo '<p>'.$row['description'].'</p>';
		$row = mysql_fetch_array( $results );
	}
 }
 else
 {
 $sql = 'SELECT article_id, a.title, a.url, a.description, count(*) FROM clicks c INNER JOIN rss_articles a ON c.article_id = a.id WHERE EXISTS (SELECT 1 FROM users u WHERE u.cluster = '.strval($cluster).') GROUP BY c.article_id ORDER BY count(*) DESC LIMIT 5';
 $results = mysql_query($sql);
 $row = mysql_fetch_array( $results);
  while($row != null)
	{
		echo '<h3>'.'<a href="'.$row['url'].'">'.$row['title'].'</a>'.'</h3>';
		echo '<p>'.$row['description'].'</p>';
		$row = mysql_fetch_array( $results );
	}
 }
  ?>
    </div>
    <div id="nav">
    <h4>Recently Viewed</h4>
    <ul>
<?php
<<<<<<< .mine

=======
>>>>>>> .r23
 /*
 //Temporary, get 5 most recent articles
 $sql = 'SELECT * FROM rss_articles ORDER BY pubdate DESC LIMIT 5';                                                                                                                                                  
 $row = mysql_fetch_array( $results);
 while($row != null)
	{
	$title = $row['title'];
	$abridged_title = substr($title, 0, 27);
 $results = mysql_query($sql);
	if(strlen($title) > 26)
		$abridged_title .= '...';
	echo '<li><a href="'.$row['url'].'" title="'.$title.'">'.$abridged_title."</a></li>";
		$row = mysql_fetch_array( $results );
	}
  */
 //Get user's most recent clicks
<<<<<<< .mine
 $user_id = $_GET['id']; //CHANGE TO GET ACTUAL USER
 $sql = 'SELECT DISTINCT user_id, article_id FROM clicks WHERE user_id = ' . strval($user_id) . ' ORDER BY clicktime DESC LIMIT 5;';
=======
 $user_id = 1; //CHANGE TO GET ACTUAL USER
 $sql = 'SELECT DISTINCT user_id, article_id FROM clicks WHERE user_id = ' . strval($user_id) . ' ORDER BY clicktime DESC LIMIT 5';
>>>>>>> .r25
 $results = mysql_query($sql);
 $row = mysql_fetch_array($results);
 while($row != null)
	{
	$sql = 'SELECT * FROM rss_articles WHERE id = '. strval($row['article_id']) . ';';
	$article_result = mysql_query($sql);
	$article_row = mysql_fetch_array($article_result);
	while($article_row != null)
	{
        $title = $article_row['title'];
	if($title == null || $title == '')
		$title = $article_row['url'];
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
