<h2 class="content__main-heading">Добавление проекта</h2>

<form class="form" action="add-project.php" method="post">
  <div class="form__row">
    <label class="form__label" for="project_name">Название <sup>*</sup></label>

    <input class="form__input <?php if (isset($errors['title'])): ?>form__input--error<?php endif; ?>" type="text" name="title" id="project_name" value="" placeholder="Введите название проекта">
  </div>

  <div class="form__row form__row--controls">
    <input class="button" type="submit" name="submit" value="Добавить">
  </div>
</form>
