<?php
require_once('functions.php');


$connect = mysqli_connect('localhost', 'root', 'rootpassword', 'doingsdone');
mysqli_set_charset($connect, "utf8");

$sql = 'SELECT `title`, `project_id` FROM projects WHERE user_id = 2';
$result = mysqli_query($connect, $sql);
  if ($result) {
    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
  }

$sql_tasks = 'SELECT tasks.`title`, `deadline`, tasks.`project_id`, `completed` FROM tasks JOIN projects ON (projects.project_id = tasks.project_id) WHERE projects.user_id = 2';
$tasks_result = mysqli_query($connect, $sql_tasks);
if ($tasks_result) {
  $tasks = mysqli_fetch_all($tasks_result, MYSQLI_ASSOC);
}

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
