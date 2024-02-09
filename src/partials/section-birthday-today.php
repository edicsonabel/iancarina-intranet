<?php
require_once __DIR__ . '/../api/birthday/functions.php';

$sort = $sort ?? 'fecha_nacimiento';
$title = $title ?? 'Cumpleañeros de hoy';

$birthdayToday = getBirthdayToday();
