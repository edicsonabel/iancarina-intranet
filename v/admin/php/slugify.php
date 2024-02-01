<?php
function slugify($text)
{
  // Reemplazar caracteres especiales y espacios con guiones
  $text = preg_replace('/[^\p{L}\p{Nd}]+/u', '-', $text);

  // Convertir el texto a minúsculas y eliminar guiones al principio y al final
  $text = trim(strtolower($text), '-');

  // Reemplazar las vocales con tildes por sus equivalentes sin tilde
  $text = str_replace(
    ['á', 'é', 'í', 'ó', 'ú', 'ü', 'ñ'],
    ['a', 'e', 'i', 'o', 'u', 'u', 'n'],
    $text
  );

  return $text;
}
