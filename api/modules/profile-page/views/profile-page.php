<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthSync - Профіль</title>
    <link rel="stylesheet" href="../../../css/profile.css">
</head>
<body>
    <?php
        require_once __DIR__ . '/../../../helpers/header/header.php';
    ?>

    <div class="container">
        <div class="profile-container">
            <div class="profile-nav">
                <div class="user-name" id="user-name">
                    <?php
                        echo($user['first_name'] . " " . $user['last_name']);
                    ?>
                </div>
                <ul class="nav-tabs">
                    <li class="nav-tab" data-tab="appointments">Історія прийомів</li>
                    <li class="nav-tab" data-tab="messages">Історія повідомлень</li>
                    <li class="nav-tab" data-tab="medical-card">Медична картка</li>
                    <li class="nav-tab" data-tab="notifications">Сповіщення</li>
                    <li class="nav-tab active" data-tab="profile">Профіль</li>
                </ul>
            </div>
            
            <div class="profile-content">
                <!-- Історія прийомів -->
                <div class="profile-section" id="appointments-section">
                    <h3>Майбутні прийоми</h3>

                    <?php if (empty($upcomingAppointments)): ?>
                        <div style="color:#888; margin:20px 0;">У вас немає майбутніх записів.</div>
                    <?php else: ?>
                        <?php foreach ($upcomingAppointments as $appt): ?>
                            <div class="appointment-card" style="margin-bottom: 15px;">
                                <div class="appointment-header" style="display:flex; justify-content:space-between;">
                                    <h4>Прийом у лікаря <?= htmlspecialchars($appt['first_name'] . ' ' . $appt['last_name']) ?></h4>
                                    <span class="status <?= strtolower($appt['status']) ?>"><?= htmlspecialchars($appt['status']) ?></span>
                                </div>

                                <div class="appointment-details" style="margin-top: 10px;">
                                    <div class="detail-row">
                                        <span class="detail-label">Дата:</span>
                                        <span class="detail-value"><?= date("d.m.Y", strtotime($appt['appointment_date'])) ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Час:</span>
                                        <span class="detail-value"><?= htmlspecialchars($appt['duration_minutes']) ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>                
                <!-- Історія повідомлень -->
                <div class="profile-section" id="messages-section">
                    <h3 style="margin-top:0; color:#2c3e50; font-size:22px;">Повідомлення</h3>
                    
                    <?php if (empty($doctors)): ?>
                        <div style="color:#888; margin:20px 0;">Немає повідомлень або призначених лікарів.</div>
                    <?php else: ?>
                        <ul style="padding:0; margin:0;">
                            <?php foreach ($doctors as $doc): ?>
                                <li style="background:#f9f9f9; border-radius:7px; margin-bottom:12px; padding:15px 20px; box-shadow:0 1px 6px rgba(52,152,219,0.03); display:flex; justify-content:space-between; align-items:center;">
                                    <a href="../controllers/chat.php?patient_id=<?= urlencode($doc['user_id']) ?>" style="text-decoration:none; color:#2c3e50;">
                                        <?= htmlspecialchars($doc['first_name'] . ' ' . $doc['last_name']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <!-- Медична картка -->
                <div class="profile-section" id="medical-card-section">
                    <h3>Медична картка</h3>
                    
                    <div class="medical-card-info">
                        <div class="card-number">
                            <p>Номер вашої медичної картки:</p>
                            <div class="number-display">
                                <a href="<?php echo $code; ?>">Посилання на карточку<a>
                            </div>
                            <img src="<?php echo $qrCodeResult->getDataUri(); ?>" alt="QR Code" style="margin-top: 10px; max-width: 100px;">
                        </div>
                    </div>
                </div>


                <!-- Сповіщення -->
                <div class="profile-section" id="notifications-section">
                <h3>Сповіщення</h3>

                <?php if ($reminders->num_rows === 0): ?>
                    <p>Немає нагадувань.</p>
                <?php else: ?>
                    <?php while ($reminder = $reminders->fetch_assoc()): ?>
                        <div class="notification-card">
                            <div class="notification-header">
                                <span class="notification-date"><?= date('d.m.Y H:i', strtotime($reminder['scheduled_time'])) ?></span>
                                <span class="notification-badge">Нагадування (<?= htmlspecialchars($reminder['reminder_type']) ?>)</span>
                            </div>
                            <div class="notification-content">
                                <?php
                                if ($reminder['appointment_id']) {
                                    echo "У вас нагадування про прийом (ID: " . intval($reminder['appointment_id']) . ").";
                                } else {
                                    echo "У вас нагадування.";
                                }
                                ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
                </div>
                
                <!-- Профіль -->
                <div class="profile-section active" id="profile-section">
                    <h3>Профіль</h3>
                    <form method="POST" class="profile-form">
                        <div class="form-group">
                            <label for="last-name">Прізвище</label>
                            <input type="text" id="last-name" class="form-control" placeholder="Введіть прізвище" value="<?php echo($_SESSION['user']['last_name']); ?>" name="last-name">
                        </div>
                        
                        <div class="form-group">
                            <label for="first-name">Ім'я</label>
                            <input type="text" id="first-name" class="form-control" placeholder="Введіть ім'я" value="<?php echo($_SESSION['user']['first_name']); ?>" name="first-name">
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Номер телефону</label>
                            <input type="tel" id="phone" class="form-control" value="<?php echo($user['phone']); ?>" name="phone">
                        </div>

                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="password" id="password" class="form-control" value="" placeholder="New password" name="password">
                        </div>

                        <div class="form-group">
                            <label for="address">Адреса проживання</label>
                            <input id="address" class="form-control" value="<?php echo($user['address']); ?>" placeholder="Введіть адресу" name="address">
                        </div>

                        <div class="form-group">
                            <label for="email">Електронна адреса</label>
                            <input id="email" class="form-control" value="<?php echo($user['email']); ?>" placeholder="Введіть електронну адресу" name="email">
                        </div>

                    <div class="birth-gender-container">
                    <div class="form-group">
                        <label>Дата народження</label>
                        <div class="form-row">
                            <input type="text" class="form-control" name="birth_day" placeholder="День" value="<?php echo($birthParts[2]); ?>" required>
                            <select class="form-control" name="birth_month"required>
                                <option value="01" <?php if($birthParts[1] == "01") echo("selected"); ?> >Січень</option>
                                <option value="02"<?php if($birthParts[1] == "02") echo("selected"); ?>>Лютий</option>
                                <option value="03"<?php if($birthParts[1] == "03") echo("selected"); ?>>Березень</option>
                                <option value="04"<?php if($birthParts[1] == "04") echo("selected"); ?>>Квітень</option>
                                <option value="05"<?php if($birthParts[1] == "05") echo("selected"); ?>>Травень</option>
                                <option value="06"<?php if($birthParts[1] == "06") echo("selected"); ?>>Червень</option>
                                <option value="07"<?php if($birthParts[1] == "07") echo("selected"); ?>>Липень</option>
                                <option value="08"<?php if($birthParts[1] == "08") echo("selected"); ?>>Серпень</option>
                                <option value="09"<?php if($birthParts[1] == "09") echo("selected"); ?>>Вересень</option>
                                <option value="10"<?php if($birthParts[1] == "10") echo("selected"); ?>>Жовтень</option>
                                <option value="11"<?php if($birthParts[1] == "11") echo("selected"); ?>>Листопад</option>
                                <option value="12"<?php if($birthParts[1] == "12") echo("selected"); ?>>Грудень</option>
                            </select>
                            <input type="text" class="form-control" name="birth_year" placeholder="Рік" value="<?php echo($birthParts[0]); ?>" required>
                        </div>
                    </div>
                    
                    <div class="gender-options">
                        <label>Стать</label>
                        <div class="gender-option">
                            <input type="radio" id="male" name="gender" value="male"<?php if($user['gender'] == "male") echo("checked"); ?>>
                            <label for="male">Чоловіча</label>
                        </div>
                        <div class="gender-option">
                            <input type="radio" id="female" name="gender" value="female"<?php if($user['gender'] == "female") echo("checked"); ?>>
                            <label for="female">Жіноча</label>
                        </div>
                    </div>
                </div>

                        <div class="form-group">
                            <label for="password">Підтвердіть зміни теперішнім паролем</label>
                            <input type="password" id="password-confirm" class="form-control" value="" placeholder="Old password" name="password-confirm">
                        </div>
                        
                        <div class="save-btn-container">
                            <button type="submit" value="Submit" class="save-btn">Зберегти зміни</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Перемикання між вкладками
        document.querySelectorAll('.nav-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Видаляємо активний клас у всіх вкладках
                document.querySelectorAll('.nav-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.profile-section').forEach(s => s.classList.remove('active'));
                
                // Додаємо активний клас до обраної вкладки
                this.classList.add('active');
                
                // Показуємо відповідний розділ
                const tabId = this.getAttribute('data-tab');
                document.getElementById(`${tabId}-section`).classList.add('active');
            });
        });

        // Оновлення імені користувача при зміні даних
        const firstNameInput = document.getElementById('first-name');
        const lastNameInput = document.getElementById('last-name');
        const userNameElement = document.getElementById('user-name');
        firstNameInput.addEventListener('input', updateUserName);
        lastNameInput.addEventListener('input', updateUserName);
    </script>

    <?php
        require_once __DIR__ . '/../../../helpers/footer/footer-page.php';
    ?>
</body>
</html>
