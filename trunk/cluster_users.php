<?php
 include 'jaccard_similarity.php';
 $server = 'localhost';
 $user = '';
 $password = '';
 $database = 'test';
 $db = mysql_connect($server, $user , $password);
 mysql_select_db($database);
 echo mysql_error();
 
 $sql = 'SELECT id FROM users';
 $user_result = mysql_query($sql);
 $user_row = mysql_fetch_array($user_result);
 $user_keywords = array();
 while($user_row != null)
 {
  $sql = 'SELECT DISTINCT k.keyword_id FROM article_keywords k WHERE EXISTS (SELECT 1 FROM clicks c  WHERE c.article_id = k.article_id AND c.user_id = '.strval($user_row['id']).');';
  $keyword_results = mysql_query($sql);
  $keyword_row = mysql_fetch_array( $keyword_results );
  $keywords = array();
  while($keyword_row != null)
  {
   $keywords[sizeof($keywords)] = $keyword_row['keyword_id'];
   $keyword_row = mysql_fetch_array( $keyword_results );
  }
  $user_keywords[$user_row['id']] = $keywords;
  $user_row = mysql_fetch_array( $user_result );
 }
 $array1 = array("a" => "green", "red", "blue", "red", "red", "blue");
 $array2 = array("b" => "green", "yellow", "red");
 $result = jaccard_similarity($array1,$array2);
 $user_distances = array();
 foreach ($user_keywords as $user1 => $keywords1)
 {
  $distances = array();
  foreach ($user_keywords as $user2 => $keywords2)
  {
   $distances[$user2] = jaccard_similarity($keywords1,$keywords2);
  }
  $user_distances[$user1] = $distances;
 }
?>
