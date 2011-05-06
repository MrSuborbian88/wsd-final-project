<?php
 function find_center($distances, $threshold)
 {
 $center = -1;
 $center_points = -1;
 foreach ($distances as $user1 => $user1_distances)
  {
   $points = 0;
   foreach ($user1_distances as $user2_distance)
   {
    if($user2_distance < $threshold && $user2_distance >= 0)
	$points++;
   }
    if($points > $center_points)
    {
     $center_points = $points;
     $center = $user1;
    }
  }
  if ($center_points > 1) return $center;
  else return -1;
 }
 function get_cluster_users($distances, $threshold, $center)
 {
 $cluster = array();
 foreach ($distances[$center] as $user => $user_distance)
 {
  if($user_distance < $threshold && $user_distance >= 0)
   $cluster[$user] = $center;
 }
  return $cluster;
 }
 function test($a)
 {
  unset($a[1]);
 }
 include 'jaccard_similarity.php';
 set_time_limit(1000000);
 require_once('dbcon.php');
 //reset clusters
 $sql = 'UPDATE users SET cluster = 0;';
 mysql_query($sql);
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
  $total_clusters = 0;
  $threshold = .1;
  $center = 0;
  while($center <= 0 && $threshold < 1)
  {
   $center = find_center($user_distances, $threshold);
   $threshold += .1;
  }
  while($center > 0 && count($user_distances) > 0 && $threshold < 1)
  {
   $user_cluster = get_cluster_users($user_distances, $threshold, $center);
/*
	print_r( $user_cluster);
	echo "<br />";
*/
   if(count($user_cluster) <= 1)
     {
	$threshold += .1;
//	echo strval(count($user_cluster) ) . "<br />";           
     }
   else
   {
   $total_clusters += 1;
   foreach ($user_cluster as $user => $cluster_center)
   {
    $sql = 'UPDATE users SET cluster = '. strval($cluster_center) . ' WHERE id = ' . strval($user) .';';
    mysql_query($sql);
    echo mysql_error();
    unset($user_distances[$user]);
    foreach ($user_distances as $user1 => $user1_distances)
	unset($user1_distances[$user]);
   }
   $center = find_center($user_distances, $threshold);
   if($center <= 0 && $threshold < .9)
   {
	$threshold += .1;
	$center = find_center($user_distances, $threshold);
   }	
   }
  }
  echo $total_clusters;
?>
