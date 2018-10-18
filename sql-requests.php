<?php

require_once('mysql_helper.php');

/**
 * function forms sql request for projects
 *
 * @param int $user_id
 * @return string sql request
*/

function get_projects_array($user_id) {
  intval($user_id);
  $sql_projects = "SELECT projects.title, projects.project_id,
                  (SELECT COUNT(*) from tasks WHERE completed = 0 AND projects.project_id = tasks.project_id)
                  AS tasks_amount
                  FROM projects
                  WHERE projects.user_id = $user_id";
  return $sql_projects;
}

/**
 * function forms sql request for tasks
 *
 * @param int $user_id
 * @return string sql request
*/

function get_tasks_array ($user_id) {
  intval($user_id);
  $sql_tasks = "SELECT `title`, `deadline`, `project_id`, `completed`
               FROM tasks
               WHERE user_id = $user_id";
  return $sql_tasks;
}

/**
 * function forms sql request for tasks depends on filter
 *
 * @param int $user_id
 * @param int|boolean $project_id
 * @param boolean|null $completed
 * @param string|null $filter_type
 * @return string sql request
*/

function get_tasks_array_by($user_id, $project_id = false, $completed = null, $filter_type = null) {
  intval($user_id);
  $sql_part = '';

  if ($project_id === 0) {
      $sql_part .= ' AND project_id IS NULL';
  }
  elseif ($project_id) {
      $sql_part .= " AND project_id = $project_id";
  }
  if ($filter_type === 'today') {
      $sql_part .= ' AND deadline = \'' . \date('Y-m-d')."'";
  }
  elseif ($filter_type === 'tomorrow') {
      $sql_part .= ' AND deadline = \'' . \date('Y-m-d', strtotime('+1 day'))."'";
  }
  elseif ($filter_type === 'overdue') {
      $sql_part .= ' AND deadline <= \'' . \date('Y-m-d', strtotime('-1 day'))."'";
  }
  if ($completed === 1) {
      $sql_part .= " AND completed = {$completed}";
  }
  $sql_tasks = "SELECT `task_id`, `title`, `deadline`, `project_id`, `completed`, `link`
               FROM tasks WHERE user_id = $user_id $sql_part";

  return $sql_tasks;
}

/**
 * function responsible for fulltext search
 * @param object $connect
 * @param string $search_word word we are searching for
 * @param int $user_id id of current user
 * @return boolean result
 */
function search_tasks($connect, $search_word, $user_id) {
  intval($user_id);
  $sql = "SELECT * FROM tasks
          WHERE user_id = $user_id AND MATCH (title) AGAINST (?)";
  $stmt = db_get_prepare_stmt($connect, $sql, [$search_word]);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return $result;
}

