<section class="content__side">
  <?php if(isset($_SESSION['user'])) : ?>
  <h2 class="content__side-heading">Проекты</h2>

  <nav class="main-navigation">
    <ul class="main-navigation__list">
      <li class="main-navigation__list-item">
        <a class="main-navigation__list-item-link" href="index.php?project_id=0">Без проекта</a>
        <span class="main-navigation__list-item-count">
          <?= calculate_unsorted_tasks($default_tasks)?></span>
      </li>
      <?php foreach ($projects as $project): ?>
      <li class="main-navigation__list-item">
        <a class="main-navigation__list-item-link" href="index.php?project_id=<?= $project['project_id'] ?>">
          <?= $project['title']; ?></a>
        <span class="main-navigation__list-item-count">
          <?= $project['tasks_amount'] ?></span>
      </li>
      <?php endforeach; ?>
    </ul>
  </nav>

  <a class="button button--transparent button--plus content__side-button" href="add-project.php" target="project_add">Добавить
    проект</a>
  <?php else: ?>
  <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>

  <a class="button button--transparent content__side-button" href="auth.php">Войти</a>
  <?php endif; ?>
</section>
