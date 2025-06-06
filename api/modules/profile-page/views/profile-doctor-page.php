<!DOCTYPE html>
<html lang="uk">

<?php require_once __DIR__ . '/../../../helpers/header/header.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кабінет лікаря | HealthSync</title>
    <link rel="stylesheet" href="../../../css/profile.css">
</head>
<body>
<main class="container_profile" style="flex: 1 0 auto;">
    <div class="profile-container" style="display:flex; gap:20px; margin-top:30px; max-width:1200px; margin-left:auto; margin-right:auto; padding:0 20px;">
        <!-- Боковая навигация -->
        <aside class="profile-nav" style="width:250px; background:#fff; border-radius:10px; padding:20px; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
            <div class="user-name" style="font-size:20px; font-weight:600; color:#2c3e50; margin-bottom:15px;">
                <?= htmlspecialchars($user['last_name'] . ' ' . $user['first_name'] . ' ' . ($user['middle_name'] ?? '')) ?>
            </div>
            <ul class="nav-tabs" style="list-style:none; padding:0; margin:0;">
                <li class="nav-tab" data-tab="calendar" style="padding:12px 15px; cursor:pointer; margin-bottom:5px; border-radius:6px;">Календар прийомів</li>
                <li class="nav-tab" data-tab="patients" style="padding:12px 15px; cursor:pointer; margin-bottom:5px; border-radius:6px;">Мої пацієнти</li>
                <li class="nav-tab" data-tab="messages" style="padding:12px 15px; cursor:pointer; margin-bottom:5px; border-radius:6px;">Повідомлення</li>
                <li class="nav-tab" data-tab="notifications">Сповіщення</li>
                <li class="nav-tab" data-tab="card" style="padding:12px 15px; cursor:pointer; margin-bottom:5px; border-radius:6px;">Карточка</li>
                <li class="nav-tab" data-tab="profile" style="padding:12px 15px; cursor:pointer; border-radius:6px;">Профіль</li>
            </ul>
        </aside>

        <section class="profile-content" style="flex:1; background:#fff; border-radius:10px; padding:30px; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
            
            <div class="profile-section" id="calendar-section">
                <h3 style="margin-top:0; color:#2c3e50; font-size:22px;">календар прийомів</h3>
                <?php if (empty($appointments)): ?>
                    <div style="color:#888; margin:20px 0;">записів поки немає.</div>
                <?php else: ?>
                <?php foreach ($appointments as $item): ?>
                <div class="appointment-card" style="background:#f9f9f9; border-left:4px solid #3498db; border-radius:8px; padding:20px; margin-bottom:15px;">
                    <div class="appointment-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                        <h4 style="margin:0; color:#2c3e50;">
                            пацієнт: <?= htmlspecialchars($item['last_name'] . ' ' . $item['first_name']) ?>
                        </h4>
                        <span class="status planned" style="background:#e1f5fe; color:#2980b9; padding:5px 10px; border-radius:4px; font-weight:500; font-size:14px;">
                            <?= htmlspecialchars($item['status']) ?>
                        </span>
                    </div>
                    <div class="appointment-details" style="display:grid; grid-template-columns:repeat(3,1fr); gap:10px;">
                        <div class="detail-row" style="display:flex; gap:10px;">
                            <span class="detail-label" style="font-weight:500; color:#555;">дата:</span>
                            <span class="detail-value" style="color:#333;"><?= htmlspecialchars($item['created_at']) ?></span>
                        </div>
                        <div class="detail-row" style="display:flex; gap:10px;">
                            <span class="detail-label" style="font-weight:500; color:#555;">час:</span>
                            <span class="detail-value" style="color:#333;"><?= htmlspecialchars($item['duration_minutes']) ?></span>
                        </div>
                        <div class="detail-row" style="display:flex; gap:10px;">
                            <span class="detail-label" style="font-weight:500; color:#555;">адреса:</span>
                            <span class="detail-value" style="color:#333;"><?= htmlspecialchars($item['patient_address']) ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <!-- Пацієнти -->
            <div class="profile-section" id="patients-section">
                <h3 style="margin-top:0; color:#2c3e50; font-size:22px;">Мої пацієнти</h3>
                <?php if (empty($patients) || $patients->num_rows === 0): ?>
                    <div style="color:#888; margin:20px 0;">Пацієнтів поки немає.</div>
                <?php else: ?>
                    <ul style="padding:0; margin:0;">
                        <?php foreach ($patients as $pat): ?>
                        <li style="background:#f9f9f9; border-radius:7px; margin-bottom:12px; padding:15px 20px; box-shadow:0 1px 6px rgba(52,152,219,0.03); display:flex; justify-content:space-between; align-items:center;">
                            <span><?= htmlspecialchars($pat['last_name'] . ' ' . $pat['first_name']) ?></span>
                            <span style="color:#888; font-size:15px;"><?= htmlspecialchars($pat['phone']) ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <!-- Повідомлення -->
            <div class="profile-section" id="messages-section">
                <h3 style="margin-top:0; color:#2c3e50; font-size:22px;">Повідомлення</h3>

                <?php if (empty($patientsWithMessages) || $patientsWithMessages->num_rows === 0): ?>
                    <div style="color:#888; margin:20px 0;">Поки немає нових повідомлень.</div>
                <?php else: ?>
                    <ul style="list-style:none; padding:0;">
                        <?php foreach ($patientsWithMessages as $patient): ?>
                            <li style="background:#f9f9f9; border-radius:8px; margin-bottom:12px; padding:15px 20px; box-shadow:0 1px 5px rgba(0,0,0,0.03);">
                                <a href="../controllers/chat.php?patient_id=<?= $pat['user_id'] ?>"><?= htmlspecialchars($pat['first_name'] . ' ' . $pat['last_name']) ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
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

            <!-- Карточка -->
            <div class="profile-section" id="card-section">
                <h3 style="margin-top:0; color:#2c3e50; font-size:22px;">Карточка</h3>
                <form action="../controllers/save_doctor_card.php" method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="specialty">Спеціальність:</label>
                        <select name="specialty" id="specialty" class="form-control" required>
                            <option value="" disabled selected>Оберіть спеціальність</option>
                            <?php while ($spec = $specializations->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($spec['specialization_id']) ?>">
                                    <?= htmlspecialchars($spec['name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Ціна прийому (грн):</label><br>
                        <input type="number" name="price" placeholder="100" min="0" required>
                    </div>

                    <div class="form-group">
                        <label>Тип клініки:</label><br>
                        <select name="clinic_type" required>
                            <option value="Державна клініка">Державна клініка</option>
                            <option value="Приватна клініка">Приватна клініка</option>
                            <option value="Інша">Інша</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="clinic">Назва клініки:</label>
                        <select name="clinic" id="clinic" class="form-control" required>
                            <option value="" disabled selected>Оберіть клініку</option>
                            <?php while ($clinic = $clinics->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($clinic['clinic_id']) ?>">
                                    <?= htmlspecialchars($clinic['name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Місто:</label><br>
                        <input type="text" name="city" placeholder="Харків" required>
                    </div>

                    <div class="form-group">
                        <label>Виберіть картинку: <input type="file" name="image" accept="image/*" required></label><br>
                    </div>

                    <div class="save-btn-container">
                        <button type="submit" value="Submit" class="save-btn">Зберегти карточку</button>
                    </div>

                </form>
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
        </section>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const tabs = document.querySelectorAll('.nav-tab');
    const sections = document.querySelectorAll('.profile-section');

    // По умолчанию активируем "Календар"
    if (tabs.length && sections.length) {
        tabs.forEach(t => t.classList.remove('active'));
        sections.forEach(s => s.classList.remove('active'));
        tabs[0].classList.add('active');
        sections[0].classList.add('active');
    }

    tabs.forEach(function(tab, i){
        tab.addEventListener('click', function(){
            tabs.forEach(t => t.classList.remove('active'));
            sections.forEach(s => s.classList.remove('active'));
            tab.classList.add('active');
            const targetId = tab.getAttribute('data-tab') + '-section';
            document.getElementById(targetId).classList.add('active');
        });
    });
});
</script>
</body>

<?php require_once __DIR__ . '/../../../helpers/footer/footer-page.php'; ?>

</html>
