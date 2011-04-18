<?php

//words with a frequency below this number are simply ignored;
$relevant = .005;

//must have this percentage increase over the frequency in the table to be a keyword
$tolerance = .05;

require_once('frequency.php');
require_once('dbcon.php');


function keywords ($check = 0)
{
	//get URLS to check.  if $check is < 0 check all otherwise check most recent.
	$q = 'SELECT * from totalwords where 1';
	$r = mysql_query($q);
	$arr = mysql_fetch_array();
	$total = $arr[0];
	
	
	$q = sprintf('SELECT url, id from rss_articles ORDER BY id desc LIMIT %d', $check);
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
		$updates = array();
		$insert = array();
		$keywords = array();

		//foreach word found
		foreach ($counts as $word => $num)
		{
			//if its freq is above relevant
			$freq = $num / $count;
			if ($freq >= $relevant)
			{
				$found = false;
				
				//if the keyword is already in the db
				foreach (mysql_fetch_assoc($result) as $keyword)
				{
					if ($keyword['word'] == $word)
					{
						$found = true;
						$update[$word] = $keyword['appearances'] + 1;

						
						//if the % difference between frequency from all articles and this article is greater than tolerance include it.
						$kFreq = $keyword['appearances'] / $total;
						if (($freq - $keyFreq) / $freq >= $tolerance)
							$keywords[] = $keyword['id'];
					
						break;
					}
				
				}
				
				//if the word was not found in the db include it;
				if (!$found)
				{
					$insert[$word] = $num;
				}
			
			
			}
		}
		
		//update the words to be updated.
		foreach ($updates as $word => $num)
		{
			$q = sprintf('UPDATE keywords SET appearances = %d WHERE word = %s', $num, $word);
			mysql_query($q);
		}
		
		//insert the new keywords
		foreach ($insert as $word => $num)
		{
			$q = sprintf('INSERT INTO keywords (word, appearances) VALUES (%s, %d)', $word, $num);
			mysql_query($q);
			$keywords[] = mysql_insert_id();
		}
		
		//update total words
		mysql_query(sprintf('UPDATE totalwords SET number = %d where 1', $total + $count));
		
		//DO SOMETHING WITH FOUND KEYWORDS HERE!
		foreach ($keywords as $id)
		{
			$q = sprintf('INSERT INTO article_keywords(article_id, keyword_id) VALUES(%d, %d)', $row['id'], $id);
			mysql_query($q);
		
		}
		
		
	}
}