<?php
require_once('functions.php');
require_once('data.php');

$pageContent = includeTemplate('index.php', [
  'tasks' => $tasks,
  'showCompletedTasks' => $showCompletedTasks,
]);

$layoutContent = includeTemplate('layout.php', [
  'content' => $pageContent,
  'projects' => $projects,
  'tasks' => $tasks,
	'title' => 'Дела в порядке - Главная страница'
]);


print($layoutContent);
?>
