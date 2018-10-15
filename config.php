<?php
require_once('functions.php');
require_once('sql-requests.php');
$connect = new mysqli('localhost', 'root', 'rootpassword', 'doingsdone');
mysqli_set_charset($connect, "utf8");

if (!$connect) {
  $error = mysqli_connect_error();
  $content = include_template('error.php', ['error' => $error]);
}

session_start();

if(isset($_SESSION['user'])) {
  $user_id = $_SESSION['user']['user_id'];
  $user = $_SESSION['user'];

  $sql_projects = get_projects_array($user_id);
  $projects = get_array_from_sql($connect, $sql_projects);
  $sql_tasks = get_tasks_array($user_id);
  $tasks = get_array_from_sql($connect, $sql_tasks);

}
?>
