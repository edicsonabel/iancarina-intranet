<?php
function tailwindConfig()
{
  $twConfig =  file_get_contents(__DIR__ . '/../../../tailwind.config.js');
  $twConfig = str_replace('module.exports', 'tailwind.config', $twConfig);
  echo "<script>$twConfig</script>";
}
