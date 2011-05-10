<?php
 /***********************
 Inserts RSS articles
 into the rss_articles table.
 ************************/
 require_once('dbcon.php');
 $rss_address = 'http://morningmail.rpi.edu/rss';
 $rss = simplexml_load_file($rss_address);

 foreach($rss->channel->item as $item)
 {
   $sql = 'INSERT INTO rss_articles(guid, url,title,description,pubdate) VALUES (\''.mysql_real_escape_string($item->guid).'\',\''.mysql_real_escape_string($item->link).'\',\''.mysql_real_escape_string($item->title).'\',\''.strip_tags(mysql_real_escape_string($item->description)).'\',\''.date("Y-m-d h:i:s",strtotime(mysql_real_escape_string($item->pubDate))).'\');';
 mysql_query($sql);
 echo mysql_error();
 }

?>
