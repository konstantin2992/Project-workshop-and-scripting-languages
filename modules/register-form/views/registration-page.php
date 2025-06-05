<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthSync – Запис до лікаря</title>

    <!-- Вынесённые CSS -->
    <link rel="stylesheet" href="../../../css/registration.css">
</head>

<?php include __DIR__ . '/../../../helpers/header/header.php'; ?>

<body>
<main class="container_main">
  <section class="registration-section">
    <div class="modal-content">

      <!-- Заголовок -->
      <div class="modal-header">
        <h2>Створення акаунта</h2>
        <p>Зареєструйтеся, щоб отримати доступ до всіх можливостей</p>
      </div>

      <!-- Ошибки -->
      <?php if (!empty($errors)): ?>
      <ul class="errors">
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>

      <!-- Форма -->
      <form id="registration-form" method="POST" action="">
        <input type="hidden" name="register-submit" value="1">

        <div class="form-group">
          <label for="first-name" class="required-field">Ім’я</label>
          <input type="text" id="first-name" name="first-name" required placeholder="Ваше ім'я">
        </div>

        <div class="form-group">
          <label for="last-name" class="required-field">Прізвище</label>
          <input type="text" id="last-name" name="last-name" required placeholder="Ваше прізвище">
        </div>

        <div class="form-group">
          <label for="email" class="required-field">Email</label>
          <input type="email" id="email" name="email" required placeholder="example@gmail.com">
        </div>

        <div class="form-group">
          <label for="phone">Телефон (Приклад: 123-456-7890)</label>
          <input type="tel" id="phone" name="phone" placeholder="123-456-7890" maxlength="12" required>
        </div>

        <div class="birth-gender-container">
            <div class="form-group">
                <label>Дата народження</label>
                <div class="form-row">
                    <input type="text" class="form-control" name="birth_day" placeholder="День" value="27" required>
                    <select class="form-control" name="birth_month"required>
                        <option value="01" selected>Січень</option>
                        <option value="02">Лютий</option>
                        <option value="03">Березень</option>
                        <option value="04">Квітень</option>
                        <option value="05">Травень</option>
                        <option value="06">Червень</option>
                        <option value="07">Липень</option>
                        <option value="08">Серпень</option>
                        <option value="09">Вересень</option>
                        <option value="10">Жовтень</option>
                        <option value="11">Листопад</option>
                        <option value="12">Грудень</option>
                    </select>
                    <input type="text" class="form-control" name="birth_year" placeholder="Рік" value="2000" required>
                </div>
            </div>
            
            <div class="gender-options">
                <label>Стать</label>
                <div class="gender-option">
                    <input type="radio" id="male" name="gender" value="male" checked>
                    <label for="male">Чоловіча</label>
                </div>
                <div class="gender-option">
                    <input type="radio" id="female" name="gender" value="female">
                    <label for="female">Жіноча</label>
                </div>
            </div>
        </div>

        <div class="form-group">
          <label for="address">Адреса</label>
          <input type="text" id="address" name="address" placeholder="Місто, вулиця, будинок" required>
        </div>

        <div class="form-group">
          <label for="password" class="required-field">Пароль</label>
          <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
          <label for="confirm-password" class="required-field">Підтвердіть пароль</label>
          <input type="password" id="confirm-password" name="confirm-password" required>
        </div>

        <button type="submit" class="btn btn-primary">Зареєструватися</button>

        <div class="divider">або</div>

        <div class="auth-switch">
          Вже маєте акаунт? <a href="../../../modules/register-form/controllers/login.php" id="switch-to-login">Увійти</a>
        </div>
      </form>
    </div>
  </section>
</main>
