<?php
function isTypeCedula($cedula)
{
  $regex = "/^(v|e|p|j|g)-[0-9]{7,9}$/i";
  return preg_match($regex, $cedula);
}

function isTypeExpediente($expediente)
{
  $regex = "/^([a-z]{3}(p)?)-[0-9]{3}-[0-9]{5}((p|v|i|s)?)$/i";
  return preg_match($regex, $expediente);
}

function isTypeSede($sede)
{
  $regex = "/^(mora i?i|np|invepuny)$/i";
  return preg_match($regex, $sede);
}

function isTypeMaterial($prestamo)
{
  $regex = "/^(informe pasantia( cd)?|tesis( cd)?|libro|material referencial|servicio internet)$/i";
  return preg_match($regex, $prestamo);
}

function isTypePrestamo($prestamo)
{
  $regex = "/^(in|ex)terno$/i";
  return preg_match($regex, $prestamo);
}

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

function isTypeEstado($estado)
{
  $regex = "/^(prest|entreg)ado$/i";
  return preg_match($regex, $estado);
}

function isTypeEstatus($estatus)
{
  $regex = "/^(activ|suspendid|retirad)o$/i";
  return preg_match($regex, $estatus);
}

function isTypeTipoUsuario($estatus)
{
  $regex = "/^(usuarios avanzados2?|administrador)$/i";
  return preg_match($regex, $estatus);
}

function isTypeReporte($report)
{
  $regex = "/^(made|outstanding(all)?|audit)$/i";
  return preg_match($regex, $report);
}

function isTypeEmail($email)
{
  $regex = "/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/i";
  return preg_match($regex, $email);
}
