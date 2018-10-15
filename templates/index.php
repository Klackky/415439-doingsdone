<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="post">
  <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">
  <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
  <nav class="tasks-switch">
    <a href="/doingsdone" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
    <a href="/doingsdone?filter_type=today" class="tasks-switch__item">Повестка дня</a>
    <a href="/doingsdone?filter_type=tomorrow" class="tasks-switch__item">Завтра</a>
    <a href="/doingsdone?filter_type=overdue" class="tasks-switch__item">Просроченные</a>
  </nav>

  <label class="checkbox">
    <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
    <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?php if ($show_completed_tasks): ?> checked<?php endif; ?>>
    <span class="checkbox__text">Показывать выполненные</span>
  </label>
</div>

<table class="tasks">
  <?php foreach ($tasks as $task): ?>
    <?php if (!$task['completed'] || ($show_completed_tasks && $task['completed'])): ?>
      <tr class="tasks__item task
      <?php if (calculate_time_left_to_date($task['deadline'])): ?> task--important<?php endif; ?>
      <?php if ($task['completed']): ?> task--completed<?php endif; ?>
      ">
        <td class="task__select">
          <label class="checkbox task__checkbox">
            <input class="checkbox__input visually-hidden task__checkbox<?php if($task['completed']):?> checked<?php endif; ?>" type="checkbox" value="<?= $task['task_id']; ?>">
            <span class="checkbox__text">
              <?= htmlspecialchars($task['title']); ?></span>
          </label>
        </td>

        <td class="task__file">
          <a class="download-link" href="#">Home.psd</a>
        </td>

        <td class="task__date">
          <?= htmlspecialchars(convert_time($task['deadline'])); ?>
        </td>
      </tr>
    <?php endif; ?>

  <?php endforeach; ?>

</table>
