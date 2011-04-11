<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Find Keyword Analysis Tool</title>
</head>
<body>
<?PHP


// Init
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
	'until'
);
$aWords = array ();
$aKeywords = array ();


	// total character count
	$iCharCount = strlen($_POST["text"]);

	// remove line breaks
	$sText = preg_replace("/[\r\t\n]/", ' ', $_POST["text"]);

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

	// count words
	for ($x = 0; $x < count($aWords); $x++) {
		$iCharCountWithout += strlen($aWords[$x]);
	}

	unset ($aWords);

	// remove stop words
	for ($m = 0; $m < count($aStopWords); $m++) {
		$sText = str_replace(' ' . $aStopWords[$m] . ' ', ' ', $sText);
	}

	// reduce spaces
	$sText = preg_replace('/^\s*$/', ' ', $sText);

	// explode to array of words
	$aWords = explode(" ", $sText);

	// every word
	for ($x = 0; $x < count($aWords); $x++) {
		// if already in array
		if (isset ($aKeywords[$aWords[$x]])) {
			// then increase count of this word
			$aKeywords[$aWords[$x]]++;
		}

		// if not counted yet
		else {
			if (trim($aWords[$x]) != '') {
				$aKeywords[$aWords[$x]] = 1;
			}
		}
	}

	// sort
	arsort($aKeywords);

	// result
	echo '<table><tr><th>Count</th><th>Percentage</th><th>Found keyword</th></tr>';

	$x = 0;
	while ($iNumber = current($aKeywords)) {
		$iNumber = intval($iNumber);
		$sKey = key($aKeywords);
		$fQuotient = number_format(round(100 * ($iNumber / $iWordCount), 2), 2);
		echo '<tr><td>' . $iNumber . ' </td><td>' . $fQuotient . ' %</td><td>' . $sKey . '</td></tr>';
		$x++;
		next($aKeywords);
	}
	echo '</table>';
?>
</body>
</html>