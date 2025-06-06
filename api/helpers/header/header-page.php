<head>
  <link rel="stylesheet" href="../../../css/header.css">
</head>
<header>

  <div class="container">
    <nav>
      <div class="logo-container">
        <a href="../../../modules/home-page/controllers/home.php">
          <img src="../../../images/logo.png" alt="HealthSync" class="logo-img">
        </a>
        <a href="../../../modules/home-page/controllers/home.php" class="logo">Health<span>Sync</span></a>
      </div>

      <div class="nav-links">
        <a href="../../../modules/doctor-search/controllers/doctor-search.php">Онлайн запис</a>
        <a href="#" id="feedback-link">Зворотній зв’язок</a>
        <a href="../../../modules/about-us/controllers/about-us.php">Про нас</a>
        <?php if($isLoggedIn && $_SESSION['user']['user_type'] == "patient"): ?>
            <a href="../../../modules/profile-page/controllers/profile.php">Профіль</a>
        <?php endif; ?>
        <?php if($isLoggedIn && $_SESSION['user']['user_type'] == "doctor"): ?>
            <a href="../../../modules/profile-page/controllers/profile-doctor.php">Профіль</a>
        <?php endif; ?>
      </div>

      <div class="header-buttons">
        <?php if ($isLoggedIn): ?>
            <button id="messages-btn" class="icon-btn" aria-label="Повідомлення">
              <img src="../../../images/message.png" alt="Повідомлення" class="messages-icon">
            </button>
            <!-- Кнопка «Вихід» ведёт на скрипт logout.php -->
            <a href="../../../modules/register-form/controllers/logout.php" class="login-btn">Вихід</a>
        <?php else: ?>
          <!-- Кнопка «Увійти» открывает модалку логина -->
          <button id="login-btn" class="login-btn">Увійти</button>
        <?php endif; ?>
      </div>
    </nav>
  </div>
</header>

<!-- Feedback Modal -->
<div id="feedback-modal" class="modal">
  <div class="modal-content">
    <button class="close-btn">&times;</button>
    <div class="modal-header">
      <h2>Надіслати звернення в службу підтримки HealthSync</h2>
    </div>
    <form id="feedback-form" method="POST" action="">
      <div class="form-group">
        <label for="fullname" class="required-field">Ваше ім'я та прізвище</label>
        <input type="text" id="fullname" name="fullname" required placeholder="Вкажіть ваше ім'я та прізвище">
      </div>
      <div class="form-group">
        <label for="email" class="required-field">Електронна пошта</label>
        <input type="email" id="email" name="email" required placeholder="Вкажіть ваш Email">
      </div>
      <div class="form-group">
        <label for="phone" class="required-field">Ваш телефон</label>
        <input type="tel" id="phone" name="phone" required placeholder="Вкажіть ваш телефон">
      </div>
      <div class="form-group">
        <label for="subject" class="required-field">Тема звернення</label>
        <select id="subject" name="subject" required>
          <option value="" disabled selected>Оберіть тему</option>
          <option value="registration">Реєстрація / вхід</option>
          <option value="appointment">Запис на прийом</option>
          <option value="technical">Технічні питання</option>
          <option value="other">Інше</option>
        </select>
      </div>
      <div class="form-group">
        <label for="message" class="required-field">Повідомлення</label>
        <textarea id="message" name="message" required placeholder="Текст вашого звернення" rows="5"></textarea>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Надіслати звернення</button>
      </div>
    </form>
  </div>
</div>

<?php if (! $isLoggedIn): ?>
<!-- Login Modal (только для гостей) -->
<div id="login-modal" class="modal">
    <div class="modal-content">
        <button class="close-btn">&times;</button>
        <div class="modal-header">
            <h2>Вхід в акаунт</h2>
            <p>Увійдіть, щоб отримати доступ до всіх можливостей</p>
        </div>
        <form action="../../../modules/register-form/controllers/login.php" id="login-form" method="POST">
            <div class="form-group">
                <label for="login-email" class="required-field">Електронна пошта</label>
                <input type="email" id="login-email" name="email" required placeholder="Ваша електронна пошта">
            </div>
            
            <div class="form-group">
                <label for="login-password" class="required-field">Пароль</label>
                <input type="password" id="login-password" name="password" required placeholder="Ваш пароль">
            </div>
            
            <div class="remember-me">
                <input type="checkbox" id="remember" name="checkbox">
                <label for="remember">Запам'ятати мене</label>
            </div>
            
            <div class="forgot-password">
                <a href="#" id="forgot-password-link">Забули пароль?</a>
            </div>
            
            <button type="submit" class="btn btn-primary">Увійти</button>
            
            <div class="divider">або</div>
            
            <div class="social-login">
                <div class="social-buttons">
                    <a href="../../../modules/register-form/controllers/google-oauth.php" class="social-btn google">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="Google" width="18">
                        Google
                    </a>
                    <a href="#" class="social-btn facebook">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook" width="18">
                        Facebook
                    </a>
                </div>
            </div>
            
            <div class="auth-switch">
                Ще не маєте акаунта? <a href="../../../modules/register-form/controllers/registration.php" id="switch-to-register">Зареєструватися</a>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- Скрипт управления модалками -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Открытие окна «Зворотній зв’язок»
  document.getElementById('feedback-link').addEventListener('click', e => {
    e.preventDefault();
    document.getElementById('feedback-modal').style.display = 'block';
  });

  <?php if (! $isLoggedIn): ?>
  // Открытие окна логина
  document.getElementById('login-btn').addEventListener('click', () => {
    document.getElementById('login-modal').style.display = 'block';
  });
  <?php endif; ?>

  // Закрытие любой модалки по кнопке ×
  document.querySelectorAll('.close-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      btn.closest('.modal').style.display = 'none';
    });
  });
});
</script>
