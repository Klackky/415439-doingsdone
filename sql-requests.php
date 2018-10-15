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

function get_tasks_array_by($user_id, $project_id = false, $completed = null, $deadline_filter_type = null) {
        intval($user_id);
        $sql_part = '';
        if ($project_id === null) {
            $sql_part .= ' AND project_id IS NULL';
        } elseif ($project_id) {
            $sql_part .= " AND project_id = $project_id";
        }
        if ($deadline_filter_type === 'today') {
            $sql_part .= ' AND deadline = \'' . \date('Y-m-d')."'";
        }
        elseif ($deadline_filter_type === 'tomorrow') {
            $sql_part .= ' AND deadline = \'' . \date('Y-m-d', strtotime('+1 day'))."'";
        }
        elseif ($deadline_filter_type === 'overdue') {
            $sql_part .= ' AND deadline < \'' . \date('Y-m-d', strtotime('-1 day'))."'";
        }
        if ($completed !== null) {
            $sql_part .= " AND completed = {$completed}";
        }

        $sql_tasks = "SELECT `task_id`, `title`, `deadline`, `project_id`, `completed`
                     FROM tasks WHERE user_id = $user_id $sql_part";

        return $sql_tasks;
    }


