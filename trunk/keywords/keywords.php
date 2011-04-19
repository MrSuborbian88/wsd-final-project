<?php

//words with a frequency below this number are simply ignored;
$relevant = .005;

//must have this percentage increase over the frequency in the table to be a keyword
$tolerance = .05;

require_once('frequency.php');
require_once('dbcon.php');


function keywords ($check = 0)
{
	global $relevant;
	global $tolerance;
	
	//get URLS to check.  if $check is < 0 check all otherwise check most recent.
	$q = 'SELECT * from totalwords where 1';
	$r = mysql_query($q);
	$arr = mysql_fetch_array($r);
	$total = $arr[0];
	$thisTotal = 0;
	
	$q = sprintf('SELECT url, id from rss_articles ORDER BY id desc LIMIT %d', $check);
	$r = mysql_query($q);
	
	
	//get keywords for each article
	while($row = mysql_fetch_assoc($r))
	{
		//get existing keywords

		//get frequencies of each word in the article
		$array = getKeywords($row['url']);
		$count = $array[0];
		$counts = $array[1];
		array_splice($counts, 10);
		$updates = array();
		$insert = array();
		$keywords = array();
		$keys = array_keys($counts);
		$keys = implode("','", $keys);
		
		$q = "SELECT * FROM keywords WHERE word in ('$keys')";
		$result = mysql_query($q);
		$words = array();
		
		while ($keyword = mysql_fetch_assoc($result))
			$words[] = $keyword;
		
		
		//foreach word found
		foreach ($counts as $word => $num)
		{
			$thisTotal += $num;
			//if its freq is above relevant
			$freq = $num / $count;
			if ($freq >= $relevant)
			{
				$found = false;
				
				//if the keyword is already in the db
				foreach($words as &$keyword)
				{
					if ($keyword['word'] == $word)
					{
						$found = true;
						$update[$word] = $keyword['appearances'] + $num;

						
						//if the % difference between frequency from all articles and this article is greater than tolerance include it.
						$kFreq = $keyword['appearances'] / $total;
						if (($freq - $kFreq) / $freq >= $tolerance)
							$keywords[] = $keyword['id'];
						
						unset($keyword);
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
			$q = sprintf('UPDATE keywords SET appearances = %d WHERE word = \'%s\'', $num, $word);
			mysql_query($q);
		}
		
		//insert the new keywords
		foreach ($insert as $w => $num)
		{	
			$q = sprintf('INSERT INTO keywords (word, appearances) VALUES (\'%s\', %d)', $w, $num);
			mysql_query($q);
			$keywords[] = mysql_insert_id();
		}
		
		//update total words
		mysql_query(sprintf('UPDATE totalwords SET number = %d where 1', $total + $thisTotal));
		
		//DO SOMETHING WITH FOUND KEYWORDS HERE!
		
		foreach ($keywords as $id)
		{
			$q = sprintf('INSERT INTO article_keywords(article_id, keyword_id) VALUES(%d, %d)', $row['id'], $id);
			mysql_query($q);
		
		}
		
		
	}
}

keywords(100);