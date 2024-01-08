<?php
function trimObject(&$obj)
{
  unset($obj['row']);
  $keys = array_map('trim', array_keys($obj));
  $values = array_map('trim', $obj);
  $obj = array_combine($keys, $values);
  return $obj;
}

function trimArray(&$array)
{
  $newArray = array();
  foreach ($array as $obj) {
    array_push($newArray, trimObject($obj));
  }
  return $newArray;
}
