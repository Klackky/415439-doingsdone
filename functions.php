<?php
// показывать или нет выполненные задачи
$showCompletedTasks = rand(0, 1);

/**
* Function calculates total tasks in each project
*
* @param array $tasksArray — array of tasks
* @param string $projectName — id of current project
* @return number — number of total tasks for current project
*/

function calculateTotalTasks($tasksArray, $project_id) {
  $totalTasks = 0;
  foreach($tasksArray as $task) {
    if ($task['project_id'] === $project_id) {
      $totalTasks++;
    }
  }
  return $totalTasks;
}

/**
 * function returns rendered template
 *
 * @param string $name name of template
 * @param array $data data we use inside template
 * @return string rendered template
 */

function includeTemplate($name, $data) {
  $name = 'templates/' . $name;
  $result = '';

  if (!is_readable($name)) {
      return $result;
  }

  ob_start();
  extract($data);
  require_once $name;

  $result = ob_get_clean();

return $result;
}


//time functions
/**
 * function responsible for calculating time remaining
 *
 * @param string $date date
 * @return boolean returns true if remaining time less than 24 hours
 */

function calculateTimeLeftToDate($date) {
  $currentTime = time();
  $timeToTask = strtotime($date);
  $secs_in_day = 86400;
  $timeLeft = $timeToTask - $currentTime;
  $hours_until_end = floor($timeLeft / $secs_in_day) * 24;

  if ($date and $hours_until_end < 24) {
    return true;
  }
  return false;
}
/**
 * function converts sql format date to d/m/y
 *
 * @param string $date date
 * @return number date in new format
 */

function convertTime ($date) {
  if ($date) {
    $timestamp = strtotime($date);
    $mydate = date('d.m.y', $timestamp);
    return $mydate;
  }
}

?>
