<?php
require_once 'vendor/autoload.php';
require_once 'config.php';
require_once 'sql-requests.php';

$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");

$mailer = new Swift_Mailer($transport);

$logger = new Swift_Plugins_Loggers_ArrayLogger();
$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));


$result = get_tasks_with_expired_date($connection);

if ($result && mysqli_num_rows($result)) {
  $expired_tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
  $recipients = [];

  foreach ($expired_tasks as $user) {
    $users[$user['user_id']] [] =
    [
        'name' => $user['name'],
        'email' => $user['email'],
        'title' => $user['title'],
        'deadline' => $user['deadline']
    ];
  }

  foreach ($users as $key => $value) {
    $user_id = $key;
    $user_tasks = $value;
    $recipients = $value[0]['email'];
    $user_name = $value[0]['name'];
    $message = new Swift_Message();
    $message->setSubject("Уведомление от сервиса «Дела в порядке»");
    $message->setFrom(['keks@phpdemo.ru' => 'DoingsDone']);
    $message->setBcc($recipients);
    $msg_content = include_template('email.php', ['user_name' => $user_name, 'user_tasks' => $user_tasks]);
    $message->setBody($msg_content, 'text/html');
    $mailer_result = $mailer->send($message);
  }
}

if ($result) {
  print('Рассылка успешно отправлена');
} else {
  print('Не удалось отправить рассылку: ' . $logger->dump());
}
