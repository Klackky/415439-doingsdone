<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<h1>Срок выполнения задач истекает</h1>

<p>Уважаемый <?= $user_name; ?> установленный срок выполнения ваших задач истекает </p>

<table>
    <thead>
    <tr>
        <th>У вас запланирована задача</th>
        <th>На время</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($user_tasks as $value => $task): ?>
        <tr>
           <td><?= strip_tags($task['task_name']); ?></td>
           <td><?= strip_tags($task["task_deadline"]); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
