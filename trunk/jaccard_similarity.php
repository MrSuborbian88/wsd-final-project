<?php

function jaccard_similarity($arr1, $arr2)
{

  $s1 = sizeof($arr1);
  $s2 = sizeof($arr2);
  $d1 = sizeof(array_diff($arr1, $arr2));
  $d2 = sizeof(array_diff($arr2, $arr1));
  $union = $s1 + $d2;  //Set Difference
  $intersection = ($union) - ($d1 + $d2); //Set Intersection
  $distance = 1 - ($intersection/$union);
  return $distance;
}
?>



