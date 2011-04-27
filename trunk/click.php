<?php
require_once('dbcon.php');

$article = mysql_real_escape_string($_POST['id']);
$user = mysql_real_escape_string($_POST['user']);

$q = "INSERT INTO clicks (user_id, article_id) VALUES ($user, $article)";
mysql_query($q);