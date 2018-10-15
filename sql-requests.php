<?php
function get_projects_array($user_id) {
  intval($user_id);
  $sql_projects = "SELECT projects.title, projects.project_id, COUNT(task_id)
                  AS tasks_amount
                  FROM tasks
                  JOIN projects
                  ON tasks.project_id= projects.project_id
                  WHERE projects.user_id = $user_id  GROUP BY tasks.project_id;";
  return $sql_projects;
}

function get_tasks_array ($user_id) {
  intval($user_id);
  $sql_tasks = "SELECT `title`, `deadline`, `project_id`, `completed`
               FROM tasks
               WHERE user_id = $user_id";
  return $sql_tasks;
}

$sql_projects = get_projects_array($user_id);
$projects = get_array_from_sql($connect, $sql_projects);
$sql_tasks = get_tasks_array($user_id);
$tasks = get_array_from_sql($connect, $sql_tasks);

