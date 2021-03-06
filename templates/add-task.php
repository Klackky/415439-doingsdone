<h2 class="content__main-heading">Добавление задачи</h2>

<form class="form" action="add.php" method="post" enctype="multipart/form-data">
  <div class="form__row">
    <label class="form__label" for="name">Название <sup>*</sup></label>

    <input class="form__input <?php if (isset($errors['title'])): ?>form__input--error<?php endif; ?>" type="text" name="title" id="name" value="<?php if (isset($_POST['title'])): ?><?= htmlspecialchars($_POST['title'])?><?php endif; ?>" placeholder="Введите название">
    <?php if (isset($errors['title'])) : ?>
      <p class="form__message"><span class ="form__message error-message"><?=$errors['title']?></span></p>
    <?php endif; ?>
  </div>

  <div class="form__row">
    <label class="form__label" for="project">Проект <sup>*</sup></label>

    <select class="form__input form__input--select" name="project_id" id="project">
    <option value=""></option>
    <?php foreach ($projects as $project): ?>
      <option value="<?=$project['project_id'] ?>"<?=isset($_POST['project_id']) && ($_POST['project_id'] === $project['project_id']) ? 'selected' : ''?>><?=$project['title']?> </option>
    <?php endforeach;?>
    </select>
    <?php if (isset($errors['project'])) : ?>
      <p class="form__message"><span class ="form__message error-message"><?=$errors['project']?></span></p>
    <?php endif; ?>
  </div>

  <div class="form__row">
    <label class="form__label" for="date">Дата выполнения</label>

    <input class="form__input form__input--date <?= (isset($errors['deadline'])) ? 'form__input--error' : ''?>" type="date" name="deadline" id="date" value="<?php if (isset($_POST['deadline'])): ?><?= htmlspecialchars($_POST['deadline'])?><?php endif; ?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
    <?php if (isset($errors['deadline'])) : ?>
      <p class="form__message"><span class ="form__message error-message"><?=$errors['deadline']?></span></p>
    <?php endif; ?>
  </div>

  <div class="form__row">
    <label class="form__label" for="preview">Файл</label>

    <div class="form__input-file">
      <input type="hidden" name="uploaded_file" value="<?= $uploaded_file ?>">
      <input type="hidden" name="path" value="<?= $path ?>">
      <input class="visually-hidden <?= (isset($errors['file'])) ? 'form__input--error' : ''?>" type="file" name="preview" id="preview" value="">

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
