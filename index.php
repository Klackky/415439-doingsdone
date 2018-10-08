<?php
require_once('functions.php');


$sql = 'SELECT `title`, `project_id` FROM projects WHERE user_id = 2';
$projects = get_array_from_sql($connect, $sql);

$sql_tasks = 'SELECT tasks.`title`, `deadline`, tasks.`project_id`, `completed` FROM tasks JOIN projects ON (projects.project_id = tasks.project_id) WHERE projects.user_id = 2';
$default_tasks = get_array_from_sql($connect, $sql_tasks);

if (isset($_GET['project_id'])) {
  $project_id = intval($_GET['project_id']);
  $request_project = "SELECT `title`, `project_id` FROM projects WHERE `project_id` = $project_id";
  $filtered_project = get_array_from_sql($connect, $request_project);
  if(!$filtered_project) {
    http_response_code(404);
  } else {
  $tasks_request = "SELECT`title`, `deadline`, `project_id`, `completed` FROM tasks WHERE project_id = $project_id";
  $tasks = get_array_from_sql($connect, $tasks_request);
  }
}
else {
   $tasks = $default_tasks;
}

$page_content = include_template('index.php', [
  'tasks' => $tasks,
  'show_completed_tasks' => $show_completed_tasks,
]);

$layout_content = include_template('layout.php', [
  'content' => $page_content,
  'projects' => $projects,
  'tasks' => $tasks,
  'default_tasks' => $default_tasks,
	'title' => 'Дела в порядке - Главная страница'
]);


print($layout_content);
?>
