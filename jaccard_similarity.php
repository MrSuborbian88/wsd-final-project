<?PHP

function jaccard_similarity($arr1, $arr2)
{

  $s1 = sizeof($arr1);
  $s2 = sizeof($arr2);
  $size = $s1 + $s2;

  foreach ($arr1 as $val)
  {
      if(in_array($val, $arr2)
        {
          $similar++;
        }
  }

  $similarity = 1 - ($similar/$size);
}
?>