<?php
require_once('config.php');
// показывать или нет выполненные задачи
$show_completed_tasks = rand(0, 1);


/**
* Function calculates total tasks in each project
*
* @param array $tasks_array— array of tasks
* @param string $project_id— id of current project
* @return number — number of total tasks for current project
*/

function calculate_total_tasks($tasks_array, $project_id) {
  $total_tasks = 0;
  foreach($tasks_array as $task) {
    if ($task['project_id'] === $project_id) {
      $total_tasks++;
    }
  }
  return $total_tasks;
}

/**
 * function returns rendered template
 *
 * @param string $name name of template
 * @param array $data data we use inside template
 * @return string rendered template
 */

function include_template($name, $data) {
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

function calculate_time_left_to_date($date) {
  $current_time = time();
  $time_to_task = strtotime($date);
  $secs_in_day = 86400;
  $time_left = $time_to_task - $current_time;
  $hours_until_end = floor($time_left / $secs_in_day) * 24;

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

function convert_time ($date) {
  if ($date) {
    $timestamp = strtotime($date);
    $mydate = date('d.m.y', $timestamp);
    return $mydate;
  }
}

/**
 * function converts sql format to array
 *
 * @param object $connect
 * @param string $result string with sql request
 * @return array $array array from sql request
*/

function get_array_from_sql ($connect, $result) {
  mysqli_set_charset($connect, "utf8");
  $result = mysqli_query($connect, $result);
  $array = null;
  if ($result) {
    $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
  }
  return $array;
}

?>
