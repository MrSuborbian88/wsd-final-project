<?php

//words with a frequency below this number are simply ignored;
$relevant = .005;

//must have this percentage increase over the frequency in the table to be a keyword
$tolerance = .05;

require_once('frequency.php');
require_once('dbcon.php');


function keywords ()
{
	//get URLS to check.  if $check is < 0 check all otherwise check most recent.
	$q = 'SELECT * from totalwords where 1';
	$r = mysql_query($q);
	$arr = mysql_fetch_array();
	$total = $arr[0];
	
		$q = "TRUNCATE TABLE article_keywords";
		mysql_query($q);
		
		$q = 'SELECT url, id from rss_articles ORDER BY id desc';
		$r = mysql_query($q);
	
	
	//get keywords for each article
	foreach(mysql_fetch_assoc($r) as $row)
	{
		//get existing keywords
		$q = "SELECT * FROM keywords WHERE 1";
		$result = mysql_query($q);
		
		
		//get frequencies of each word in the article
		$array = getKeywords($row['url']);
		$count = $array[0];
		$counts = $array[1];
		$keywords = array();

		//foreach word found
		foreach ($counts as $word => $num)
		{
			//if its freq is above relevant
			$freq = $num / $count;
			if ($freq >= $relevant)
			{
				bool $found = false;
				
				//if the keyword is already in the db
				foreach (mysql_fetch_assoc($result) as $keyword)
				{
					if ($keyword['word'] == $word)
					{

						//if the % difference between frequency from all articles and this article is greater than tolerance include it.
						$kFreq = $keyword['appearances'] / $total;
						if (($freq - $keyFreq) / $freq >= $tolerance)
							$keywords[] = $keyword['id'];
					
						break;
					}
				
				}
				
			
			
			}
		}
		
		foreach ($keywords as $id)
		{
			$q = sprintf('INSERT INTO article_keywords(article_id, keyword_id) VALUES(%d, %d)', $row['id'], $id);
			mysql_query($q);
		
		}
		
		
	}
}