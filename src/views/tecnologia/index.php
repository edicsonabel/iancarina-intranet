<?php

$id = isset($_GET['id']) ? trim($_GET['id']) : false;
$page = isset($_GET['page']) ? trim($_GET['page']) : 1;
$page = $page < 1 ? 1 : $page;

$dep = 'tecnologia';
$limit = 9;
include __DIR__ . '/../../partials/section-news.php';

$title = 'Documentos de tecnología';
include __DIR__ . '/../../partials/section-docs.php';
