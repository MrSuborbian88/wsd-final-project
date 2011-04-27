<?php include('CAS-1.2.1/CAS.php');
 phpCAS::client(CAS_VERSION_2_0,'login.rpi.edu',443,'/cas');
 require_once('dbcon.php');
 ?>
 <?php
if (!isset($_COOKIE['user_id'])) {
setcookie("user_id", uniqid(), mktime()+(86400*1000000), "/") or die("Could not set cookie");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>MorningMail Recommender</title>
<link rel="stylesheet" type="text/css" href="final_project.css" />
<script language="javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script language="javascript">
	$(document).ready(function(){
		$('.article').live('click', function(){
			$.post('click.php', {'id' : $(this).attr('id')});
			alert('hi');
			return false;
		});
	
	});
</script>
</head>
<body>
  <div id="wrap">
  <div id = "login">
  <?php
    if (phpCAS::isAuthenticated())
	{
	   $user_name=phpCAS::getUser();
           echo '<a href = "CAS_RPI_logout.php">'.$user_name.' Logout</a>';
	}
    else
	{
	   $user_name = '$_COOKIE["user_id"]';
	   echo '<a href = "CAS_RPI.php">Login</a>';
	}
  ?>
  </div>
  <div id="header">
  <h1>Morning Mail Recommender <span class = "span_header">RENSSELAER POLYTECHNIC INSTITUTE - Troy, NY, USA</span></h1>
  </div>
  <div id="content">
  <?php
 $existing_user = mysql_query('SELECT * FROM users WHERE username=\''.$user_name.'\'');
 if(mysql_num_rows($existing_user)==0 && $user_name != '')
 {
   $sql = 'INSERT INTO users(username, cluster) VALUES(\''.$user_name.'\', 0);';
   mysql_query($sql);
   echo mysql_error();
 }
 $cluster = -1;
 $user_id = -1;
 $sql = 'SELECT id, cluster FROM users WHERE username=\'' . $user_name .'\';';
 $results = mysql_query($sql);
 $row = mysql_fetch_array( $results);
 while($row != null)
 {
        $user_id = $row['id'];
	$cluster = $row['cluster'];
	$row = mysql_fetch_array( $results );
 }
 //User not clustered, show 10 most recent
 if($cluster <= 0)
 {
 $sql = 'SELECT * FROM rss_articles ORDER BY pubdate DESC LIMIT 5';
 $results = mysql_query($sql);
 $row = mysql_fetch_array($results);
  while($row != null)
	{
		echo '<h3>'.'<a class="article" id="'.$row['id'].'" href="'.$row['url'].'">'.$row['title'].'</a>'.'</h3>';
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
		echo '<h3>'.'<a class="article" id="'.$row['article_id'].'" href="'.$row['url'].'">'.$row['title'].'</a>'.'</h3>';
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
 if($user_id < 0)
 {
 //Not logged in, get 5 most recent articles
 $sql = 'SELECT * FROM rss_articles ORDER BY pubdate DESC LIMIT 5;';
 $results = mysql_query($sql);
 $row = mysql_fetch_array( $results);
 while($row != null)
	{
        $title = $row['title'];
	if($title == null || $title == '')
		$title = $row['url'];
	$abridged_title = substr($title, 0, 27);
	if(strlen($title) > 26)
		$abridged_title .= '...';
	echo '<li><a href="'.$row['url'].'" title="'.$title.'">'.$abridged_title."</a></li>";
	$row = mysql_fetch_array( $results );
	}
 }
 else
 {
 //Get user's most recent clicks
 $sql = 'SELECT DISTINCT user_id, article_id FROM clicks WHERE user_id = \'' . strval($user_id) . '\' ORDER BY clicktime DESC LIMIT 5;';
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
  }
  ?>
     </ul>
  </div>
  </div>
</body>
</html>
