<?php

function isTypeSQLInjection($str)
{
  $regex = "/(-{2,}|'?(\s+)?\w(\s+)?'?(\s+)?=(\s+)?'?(\s+)?\w(\s+)?'?|alter(\s+)|create(\s+)|delete(\s+)|drop(\s+)?|exec(ute){0,1}(\s+)|insert( +into){0,1}|merge(\s+)|select(\s+)|update(\s+)|union( +all){0,1})/i";
  return preg_match($regex, $str);
}

function isTypeFechaISO($fecha)
{
  $regex = "/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}.\d{3}$/";
  return preg_match($regex, $fecha);
}

function isTypeFecha($fecha)
{
  $regex = "/^\d{4}-\d{2}-\d{2}$/";
  return preg_match($regex, $fecha);
}

function isTypeHora($hora)
{
  $regex = "/^\d{2}:\d{2}:\d{2}$/";
  return preg_match($regex, $hora);
}

function isTypeEmail($email)
{
  $regex = "/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/i";
  return preg_match($regex, $email);
}
