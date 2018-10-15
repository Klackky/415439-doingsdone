<?php
function get_projects_array($user_id) {
  intval($user_id);
  $sql_projects = "SELECT projects.title, projects.project_id,
                  (SELECT COUNT(*) from tasks WHERE projects.project_id = tasks.project_id)
                  AS tasks_amount
                  FROM projects
                  WHERE projects.user_id = $user_id";
  return $sql_projects;
}

function get_tasks_array ($user_id) {
  intval($user_id);
  $sql_tasks = "SELECT `title`, `deadline`, `project_id`, `completed`
               FROM tasks
               WHERE user_id = $user_id";
  return $sql_tasks;
}


