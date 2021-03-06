<?php
require_once('config.php');
if (!empty($_SESSION['user'])) {
  $project_id = false;
  if (isset($_GET['project_id'])) {
    $filtered_project = true;

    $project_id = $_GET['project_id'] ? (int) $_GET['project_id'] : 0;
    $request_project = "SELECT `title`, `project_id` FROM projects WHERE project_id = $project_id and user_id = $user_id";
    $filtered_project = get_array_from_sql($connect, $request_project);


    if(!$filtered_project) {
      http_response_code(404);
    }
  }

  $filter_type = null;
  if (isset($_GET['filter_type'])) {
    $filter_type = $_GET['filter_type'];
  }

  $show_completed_tasks = 0;
  if (isset($_GET['show_completed'])) {
    $show_completed_tasks = $_GET['show_completed'];

  }

  if (isset($_GET['task_id'])) {
    intval($_GET['task_id']);
    $result = update_task_status($connect, $_GET['task_id']);
    if ($result) {
      header("Location: index.php");
    }
  }


  $sql_tasks = get_tasks_array_by($user_id, $project_id, $show_completed_tasks, $filter_type);
  $tasks = get_array_from_sql($connect, $sql_tasks);

  if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    if (!empty($search)) {
      $result = search_tasks($connect, $search, $user_id);
      $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
  }

  $content = include_template('index.php', [
    'tasks' => $tasks,
    'project_id' => $project_id,
    'show_completed_tasks' => $show_completed_tasks,
  ]);

  $sidebar = include_template('sidebar.php', [
    'projects' => $projects,
    'default_tasks' => $default_tasks,
  ]);

  $layout_content = include_template('layout.php', [
    'content' => $content,
    'sidebar' => $sidebar,
    'tasks' => $tasks,
  	'title' => 'Дела в порядке - Главная страница'
  ]);
}

else {
  $content = include_template('guest.php', []);
  $layout_content = include_template('layout.php', [
    'content' => $content,
    'title' => 'Дела в порядке - Главная страница'
  ]);
}

print($layout_content);
?>
