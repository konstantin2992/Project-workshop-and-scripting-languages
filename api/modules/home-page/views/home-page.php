<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthSync - Запис до лікаря</title>
    <link rel="stylesheet" href="../../../css/home-page.css">
</head>

<?php
    require_once __DIR__ . '/../../../helpers/header/header.php';
?>

<body>
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h2>Запишіться на прийом до потрібного вам лікаря за декілька хвилин</h2>
                    <p>За допомогою нашого сервісу ви зможете легко обрати лікаря, що вам довподоби, записався до нього на прийом у зручний для вас час і все це не виходячи із дому.</p>
                    <button class="find-doctor-btn">Знайти лікаря</button>
                </div>
                <div class="doctor-image">
                    <img src="../../../images/doctor-home-page.png" alt="Лікар">
                </div>
            </div>
        </div>
    </section>
    
    <section class="benefits">
        <div class="container">
            <h2>Переваги сервісу</h2>
            
            <div class="benefits-container">
                <div class="benefit-card">
                    <h3>Запис до лікаря у зручний для вас час та без черги</h3>
                    <p>Заплануйте візит до лікаря онлайн та не витрачайте час на черги</p>
                </div>
                
                <div class="benefit-card">
                    <h3>Система відгуків</h3>
                    <p>За допомогою системи відгуків ви зможете побачити, чи були інші пацієнти задоволені прийомом лікаря</p>
                </div>
                
                <div class="benefit-card">
                    <h3>Особистий кабінет пацієнта</h3>
                    <h4>Чат з лікарем</h4>
                    <p>Перед записом на прийом до лікаря ви можете домовитись про онлайн консультацію, або запитати турбуючі вас питання</p>
                </div>
            </div>
        </div>
    </section>

    <?php
        require_once __DIR__ . '/../../../helpers/footer/footer-page.php';
    ?>

</body>
</html>
