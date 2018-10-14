<div class="content">
  <section class="content__side">
    <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>

    <a class="button button--transparent content__side-button" href="form-authorization.html">Войти</a>
  </section>

  <main class="content__main">
    <h2 class="content__main-heading">Регистрация аккаунта</h2>

    <form class="form" action="register.php" method="post">
      <div class="form__row">
        <label class="form__label" for="email">E-mail <sup>*</sup></label>

        <input class="form__input<?php if (isset($errors['email'])): ?>form__input--error<?php endif; ?>" type="text" name="email" id="email" value="<?php if (isset($_POST['email'])): ?><?= $_POST['email']?> <?php endif; ?>" placeholder="Введите e-mail">
        <?php if (isset($errors['email'])) : ?>
          <p class="form__message">E-mail введён некорректно</p>
        <?php endif; ?>
      </div>

      <div class="form__row">
        <label class="form__label" for="password">Пароль <sup>*</sup></label>

        <input class="form__input<?php if (isset($errors['password'])): ?>form__input--error<?php endif; ?>" type="password" name="password" id="password" value="" placeholder="Введите пароль">
      </div>

      <div class="form__row">
        <label class="form__label" for="name">Имя <sup>*</sup></label>

        <input class="form__input<?php if (isset($errors['name'])): ?>form__input--error<?php endif; ?>" type="text" name="name" id="name" value="<?php if (isset($_POST['name'])): ?><?= $_POST['name']?> <?php endif; ?>" placeholder="Введите имя">
      </div>

      <div class="form__row form__row--controls">
      <?php if (!empty($errors)) {
        echo ('<p class="error-message">Пожалуйста, исправьте ошибки в форме</p>')
        ;}
      ?>

        <input class="button" type="submit" name="" value="Зарегистрироваться">
      </div>
    </form>
  </main>
</div>