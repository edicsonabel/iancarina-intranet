<?php
require_once __DIR__ . '/../../api/e-learning/functions.php';

$id = isset($_GET['id']) ? trim($_GET['id']) : false;
$page = isset($_GET['page']) ? trim($_GET['page']) : 1;
$page = $page < 1 ? 1 : $page;

$dep = 'all';
include __DIR__ . '/../../partials/section-e-learning.php';
