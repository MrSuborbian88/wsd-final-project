<?PHP

$aStopWords = array (
	'about',
	'all',
	'alone',
	'also',
	'am',
	'and',
	'as',
	'at',
	'because',
	'before',
	'beside',
	'besides',
	'between',
	'but',
	'by',
	'etc',
	'for',
	'i',
	'of',
	'on',
	'other',
	'others',
	'so',
	'than',
	'that',
	'the',
	'though',
	'to',
	'too',
	'trough',
	'until',
	'rpi',
	'rensselaer',
	'polytechnic',
	'institute',
	'it',
	'&nbsp;',
	'read',
	'more',
	
);


function getKeywords ($url)
{
	global $aStopWords;
// Init


	$str = strip_tags(file_get_contents($url));
	
	// total character count
	$iCharCount = strlen($str);

	// remove line breaks
	$sText = preg_replace("[\r\t\n]", ' ', $str);

	// decode UTF-8
	$sText = utf8_decode($sText);

	// convert to lowercase
	$sText = strtolower($sText);

	// remove peculiars
	$sText = preg_replace('/[^a-z0-9äöüß&;#]/', ' ', $sText);

	// total word count
	$aWords = explode(" ", $sText);
	$iWordCount = count($aWords);
	$iCharCountWithout = 0;



	// remove stop words
	for ($m = 0; $m < count($aStopWords); $m++) {
		$sText = str_replace(' ' . $aStopWords[$m] . ' ', ' ', $sText);
	}

	// reduce spaces
	$sText = preg_replace('/^\s*$/', ' ', $sText);

	// explode to array of words
	$aWords = explode(" ", $sText);

	$aKeywords = array_count_values($aWords);

	// sort
	unset($aKeywords['']);
	arsort($aKeywords);
	return array($iWordCount, $aKeywords);
}