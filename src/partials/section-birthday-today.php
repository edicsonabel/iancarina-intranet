<?php
require_once __DIR__ . '/../api/birthday/functions.php';

$dep = $dep ?? 'all';
$sort = $sort ?? 'fecha_nacimiento';
$title = $title ?? 'Cumpleaños';

$birthday = getBirthday($dep);
