<?PHP

function keywords_similarity($keywords1, $keywords2)
{

  $words1 = sizeof($keywords1);
  $words2 = sizeof($keywords2);
  $totalwords = $words1 + $words2;

  foreach ($keywords1 as $val)
  {
      if(in_array($val, $keywords2)
        {
          $simwords++;
        }
  }

  $similarity = 1 - ($simwords/$totalwords);
}
?>