<h2 class="content__main-heading">Добавление задачи</h2>

<form class="form" action="add.php" method="post" enctype="multipart/form-data">
  <div class="form__row">
    <label class="form__label" for="name">Название <sup>*</sup></label>

    <input class="form__input <?php if (isset($errors['title'])): ?>form__input--error<?php endif; ?>" type="text" name="title" id="name" value="<?php if (isset($_POST['title'])): ?><?= $_POST['title']?><?php endif; ?>" placeholder="Введите название">
    <?php if (isset($errors['title'])) : ?>
      <p class="form__message"><span class ="form__message error-message"><?=$errors['title']?></span></p>
    <?php endif; ?>
  </div>

  <div class="form__row">
    <label class="form__label" for="project">Проект <sup>*</sup></label>

    <select class="form__input form__input--select" name="project_id" id="project">
    <option value=""></option>
    <?php foreach ($projects as $project): ?>
      <option value="<?=$project['project_id'] ?>"><?=$project['title']?></option>
    <?php endforeach;?>
    </select>
  </div>

  <div class="form__row">
    <label class="form__label" for="date">Дата выполнения</label>

    <input class="form__input form__input--date <?php if (isset($errors['deadline'])): ?>form__input--error<?php endif; ?>" type="date" name="deadline" id="date" value="<?= $_POST['deadline'] ?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
    <?php if (isset($errors['date'])) : ?>
      <p class="form__message"><span class ="form__message error-message"><?=$errors['date']?></span></p>
    <?php endif; ?>
  </div>

  <div class="form__row">
    <label class="form__label" for="preview">Файл</label>

    <div class="form__input-file">
      <input class="visually-hidden <?php if (isset($errors['file'])): ?>form__input--error<?php endif; ?>" type="file" name="preview" id="preview" value="">

      <label class="button button--transparent" for="preview">
        <span>Выберите файл</span>
      </label>
      <?php if (isset($errors['file'])) : ?>
        <p class="form__message"><span class ="form__message error-message"><?=$errors['file']?></span></p>
      <?php endif; ?>
    </div>
  </div>

  <div class="form__row form__row--controls">
    <input class="button" type="submit" name="submit" value="Добавить">
  </div>
</form>
