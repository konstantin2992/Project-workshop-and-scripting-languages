<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запис до лікаря</title>
    <link rel="stylesheet" href="../../../css/doctor-search.css">
</head>
<body>
    <?php
        require_once __DIR__ . '/../../../helpers/header/header.php';
    ?>
<main>
    <div class="container">
        <div class="sidebar">
            <h2>Фільтри</h2>
            <a class="reset-filters">Скинути всі</a>
            
            <h3>Місто</h3>
            <div class="filter-section">
            
                <select id="citySelect" class="city-select">
                    <option value="all">Усі міста</option>
                    <option value="kyiv">Київ</option>
                    <option value="kharkiv" selected>Харків</option>
                    <option value="odesa">Одеса</option>
                    <option value="lviv">Львів</option>
                    <option value="dnipro">Дніпро</option>
                    <option value="vinnytsia">Вінниця</option>
                    <option value="zhytomyr">Житомир</option>
                </select>
            </div>
            
            <div class="filter-option">
                <input type="checkbox" id="online">
                <label for="online">Онлайн консультація</label>
            </div>
            
            <h3>Тип клініки</h3>
            <div class="filter-option">
                <input type="checkbox" id="state">
                <label for="state">Державні</label>
            </div>
            <div class="filter-option">
                <input type="checkbox" id="private">
                <label for="private">Приватні</label>
            </div>
            
            <h3>Стать лікаря</h3>
            <div class="filter-option">
                <input type="checkbox" id="male">
                <label for="male">Чоловік</label>
            </div>
            <div class="filter-option">
                <input type="checkbox" id="female">
                <label for="female">Жінка</label>
            </div>
            
            <h3>Стаж лікаря</h3>
            <div class="filter-option">
                <input type="checkbox" id="exp1">
                <label for="exp1">від 0 до 5 років</label>
            </div>
            <div class="filter-option">
                <input type="checkbox" id="exp2">
                <label for="exp2">від 6 до 10 років</label>
            </div>
            <div class="filter-option">
                <input type="checkbox" id="exp3">
                <label for="exp3">від 11 до 15 років</label>
            </div>
            <div class="filter-option">
                <input type="checkbox" id="exp4">
                <label for="exp4">від 16 років</label>
            </div>
            
            <h3>Оцінювання пацієнтами</h3>
            <div class="filter-option">
                <input type="checkbox" id="rating0">
                <label for="rating0">Без оцінювань</label>
            </div>
            <div class="filter-option">
                <input type="checkbox" id="rating1">
                <label for="rating1">Нормально</label>
            </div>
            <div class="filter-option">
                <input type="checkbox" id="rating2">
                <label for="rating2">Добре</label>
            </div>
            <div class="filter-option">
                <input type="checkbox" id="rating3">
                <label for="rating3">Дуже добре</label>
            </div>
            
            <h3>Кваліфікація лікаря</h3>
            <table class="qualification-table">
                <tr>
                    <td>Не обрана</td>
                    <td class="selected">✔</td>
                </tr>
            </table>
        </div>
        
        <div class="main-content">
            <div class="search-container">
                <div class="search-bar">
                    <input type="text" placeholder="Пошук лікаря або спеціальності">
                    <button type="submit">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M21 21L16.65 16.65" stroke="#666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <h2>Записатися до лікаря на консультацію • <?php echo($result->num_rows); ?> лікаря</h2>
            
<div class="doctors-container">
    <?php while ($row = $result->fetch_assoc()): ?>
        <?php
            $stmt = $mysqli->prepare("SELECT file_path FROM pictures WHERE photo_id = ?");
            $stmt->bind_param("i", $row['photo_id']);
            $stmt->execute();
            $photo = $stmt->get_result()->fetch_assoc();;
        ?>

        <?php $row['docName'] = $row['last_name'] . $row['first_name']; ?>
        <div class="doctor-card">
            <div class="doctor-info-container">
                <div class="doctor-header">
                    <img src="<?= htmlspecialchars($photo['file_path']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="doctor-photo">
                    <div class="doctor-info-main">
                        <div class="doctor-specialty"><?= htmlspecialchars($row['name']) ?></div>
                        <div class="doctor-name"><?= htmlspecialchars($row['docName']) ?></div>
                        <div class="doctor-details">
                            <div class="detail-group">
                                <span class="detail-label">Умови прийому</span>
                                <span class="detail-value doctor-price">Від <?= (int)$row['price'] ?> грн</span>
                            </div>
                            <div class="detail-group">
                                <span class="detail-label">Клініка</span>
                                <span class="detail-value clinic-type"><?= htmlspecialchars($row['clinic_type']) ?></span>
                                <span class="clinic-name"><?= htmlspecialchars($row['clinic_name']) ?></span>
                            </div>
                            <div class="detail-group">
                                <span class="detail-label">Місто</span>
                                <span class="detail-value city"><?= htmlspecialchars($row['city']) ?></span>
                            </div>
                        </div>
                        <div class="doctor-rating">
                            <span class="rating-value"><?= number_format($row['rating'], 1) ?></span>
                            <span class="rating-count">(<?= (int)$row['review_count'] ?> відгуки)</span>
                        </div>
                    </div>
                </div>
            </div>
            <form action="../controllers/payment.php" method="POST" id="appointment-form" class="appointment-form">

            <input type="hidden" name="doctor_id" value="<?= $row['doctor_id'] ?>">
            <input type="hidden" name="doctor_name" value="<?= $row['docName'] ?>">
            <input type="hidden" name="selected_date" class="selected-date">
            <input type="hidden" name="selected_time" class="selected-time">

            <div class="date-time-container">
                <div class="date-time-selection">
                    <div class="date-selector">
                        <?php
                        $days = ['Сьогодні', 'Завтра', 'Після завтра', 'Після після завтра'];
                        $dayDates = [
                            date('d M'),
                            date('d M', strtotime('+1 day')),
                            date('d M', strtotime('+2 days')),
                            date('d M', strtotime('+3 days')),
                        ];
                        foreach ($days as $i => $dayName):
                        ?>
                            <div class="date-option<?= $i === 0 ? ' active' : '' ?>">
                                <div class="day-name"><?= $dayName ?></div>
                                <div class="day-date"><?= $dayDates[$i] ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="time-slots-container">
                        <?php foreach (['08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00'] as $time): ?>
                            <button type="button" class="time-slot" data-time="<?= $time ?>"><?= $time ?></button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            </form>
        </div>
    <?php endwhile; ?>
</div>
</main>
<script>
document.querySelectorAll('.doctor-card').forEach(card => {
    const dateOptions = card.querySelectorAll('.date-option');
    const timeSlots = card.querySelectorAll('.time-slot');
    const dateInput = card.querySelector('.selected-date');
    const timeInput = card.querySelector('.selected-time');
    const form = card.querySelector('form'); // Assume each card wraps its own form

    // Default date
    const active = card.querySelector('.date-option.active');
    if (active) {
        dateInput.value = active.querySelector('.day-date').innerText;
    }

    dateOptions.forEach(option => {
        option.addEventListener('click', () => {
            dateOptions.forEach(o => o.classList.remove('active'));
            option.classList.add('active');
            const selected = option.querySelector('.day-date');
            if (selected) {
                dateInput.value = selected.innerText;
            }
        });
    });

    timeSlots.forEach(slot => {
        slot.addEventListener('click', () => {
            timeInput.value = slot.dataset.time;

            // Now submit the form manually
            form.submit();
        });
    });
});
</script>

</body>

<?php
    require_once __DIR__ . '/../../../helpers/footer/footer-page.php';
?>

</html>

