<?php

/**
* Function calculates total tasks in each project
*
* @param array $tasksArray — array of tasks
* @param string $projectName — name of current project
* @return number — number of total tasks for current project
*/

function calculateTotalTasks($tasksArray, $projectName) {
  $totalTasks = 0;
  foreach($tasksArray as $task) {
    if ($task['type'] === $projectName) {
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

function include_template($name, $data) {
  $name = 'templates/' . $name;
  $result = '';

  if (!file_exists($name)) {
      return $result;
  }

  ob_start();
  extract($data);
  require_once $name;

  $result = ob_get_clean();

return $result;
}

/**
 * function returns string filtered from special characters
 *
 * @param string string we are got from user
 * @return string string safe for use on our website
 */

function esc($string)  {
  return htmlspecialchars($string);
}

?>
