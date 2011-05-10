<?php
require_once('../dbcon.php');

$article = mysql_real_escape_string($_POST['id']);
$user = mysql_real_escape_string($_POST['user']);

$q = "INSERT INTO clicks (user_id, article_id) SELECT DISTINCT $user, $article FROM clicks c WHERE NOT EXISTS (SELECT 1 FROM clicks WHERE user_id = $user AND article_id = $article)";
mysql_query($q);
