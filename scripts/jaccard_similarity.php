<?php

function jaccard_similarity($arr1, $arr2)
{
  $s1 = sizeof($arr1);
  $s2 = sizeof($arr2);
  $d1 = sizeof(array_diff($arr1, $arr2)); //Set Difference
  $d2 = sizeof(array_diff($arr2, $arr1)); //Set Difference
  $union = $s1 + $d2;  //Set Union
  $intersection = ($union) - ($d1 + $d2); //Set Intersection
  if($union == 0) //Both sets empty
   return -1;
  $distance = 1 - ($intersection/$union);
  return $distance;
}
?>

