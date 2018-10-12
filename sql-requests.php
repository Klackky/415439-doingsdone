<?php
function get_projects_array($user_id) {
    intval($user_id);
    $sql_projects = "SELECT `project_id`, `title` FROM projects WHERE user_id = $user_id";
    return $sql_projects;
}

function get_tasks_array ($user_id) {
  intval($user_id);
  $sql_tasks = 'SELECT tasks.`title`, `deadline`, tasks.`project_id`, `completed`
    FROM tasks
    JOIN projects
    ON (projects.project_id = tasks.project_id)
    WHERE projects.user_id = 2';
  return $sql_tasks;
}
