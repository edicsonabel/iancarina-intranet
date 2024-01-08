<?php
function getVersion()
{
  $pkgJSON =  json_decode(file_get_contents(__DIR__ . '/../../../package.json'), true);
  return $pkgJSON['version'];
}
