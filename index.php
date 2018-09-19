<?php
require_once('functions.php');
require_once('data.php');

$page_content = include_template('index.php', [
  'tasks' => $tasks,
  'show_complete_tasks' => $show_complete_tasks,
]);

$layout_content = include_template('layout.php', [
  'content' => $page_content,
  'projects' => $projects,
  'tasks' => $tasks,
	'title' => 'Дела в порядке - Главная страница'
]);


print($layout_content);
?>
