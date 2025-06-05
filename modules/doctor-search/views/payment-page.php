<header>

<link rel="stylesheet" href="../../../css/doctor-search.css">

</header>

<?php
    require_once __DIR__ . '/../../../helpers/header/header.php';
?>
<div class="modal-overlay">
<div class="step-content" data-step="2">
    <div class="modal-header">
        <h3 class="modal-title">Оплата прийому</h3>
        <span class="close-btn">&times;</span>
    </div>
    <div class="modal-body">
        <div class="payment-section">
            <div class="payment-title">Спосіб оплати</div>
            <div class="payment-options">
                <div class="payment-option selected" data-payment="card">
                    <img src="https://cdn-icons-png.flaticon.com/512/196/196566.png" alt="Картка">
                    <div>Карткою</div>
                </div>
                <div class="payment-option" data-payment="googlepay">
                    <img src="https://cdn-icons-png.flaticon.com/512/825/825454.png" alt="Google Pay">
                    <div>Google Pay</div>
                </div>
                <div class="payment-option" data-payment="applepay">
                    <img src="https://cdn-icons-png.flaticon.com/512/825/825482.png" alt="Apple Pay">
                    <div>Apple Pay</div>
                </div>
            </div>

            <!-- Card Payment Form -->
            <div class="card-form" id="cardForm">
                <div class="card-input-group">
                    <label for="cardNumber">Номер картки</label>
                    <input type="text" id="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19">
                </div>
                <div class="card-row">
                    <div class="card-col">
                        <label for="cardExpiry">Термін дії</label>
                        <input type="text" id="cardExpiry" placeholder="ММ/РР" maxlength="5">
                    </div>
                    <div class="card-col">
                        <label for="cardCvc">CVC/CVV</label>
                        <input type="text" id="cardCvc" placeholder="123" maxlength="3">
                    </div>
                </div>
                <div class="card-input-group">
                    <label for="cardName">Ім'я на картці</label>
                    <input type="text" id="cardName" placeholder="Як вказано на картці">
                </div>
            </div>

            <div class="total-amount">До сплати: <span id="appointmentPrice">300</span> грн</div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary prev-step" data-prev="1">Назад</button>
        <button class="btn btn-primary next-step" data-next="3" onclick="goToConfirmation()">Далі: Підтвердження</button>
    </div>
</div>

<!-- Step 3: Confirmation -->
<div class="step-content" data-step="3" style="display: none;">
    <div class="modal-header">
        <h3 class="modal-title">Підтвердження запису</h3>
        <span class="close-btn">&times;</span>
    </div>
    <div class="modal-body">
        <div style="text-align: center; margin-bottom: 20px;">
            <h3 style="color: #2ecc71;">Запис підтверджено!</h3>
        </div>

        <div style="background-color: #f9f9f9; padding: 15px; border-radius: 6px;">
            <div style="display: flex; justify-content: space-between;">
                <span>Лікар:</span>
                <span id="confirmDoctor"><?= htmlspecialchars($doctorName) ?></span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span>Дата та час:</span>
                <span id="confirmDateTime"><?= htmlspecialchars($date . ' о ' . $time) ?></span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span>Сума оплати:</span>
                <span>300 грн</span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span>Код запису:</span>
                <span>#A7B9C2</span>
            </div>
        </div>

        <p style="text-align: center; font-size: 14px;">
            Деталі запису було відправлено на вашу електронну адресу.
        </p>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" onclick="finishAppointment()">Завершити</button>
    </div>
</div>
</div>

<script>
function goToConfirmation() {
    document.querySelector('[data-step="2"]').style.display = 'none';
    document.querySelector('[data-step="3"]').style.display = 'block';
}

function finishAppointment() {
    window.location.href = '/modules/home-page/controllers/home.php'; // or another page
}

// Real-time card number formatting (1234 5678 9012 3456)
document.getElementById('cardNumber').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, ''); // remove all non-digits
    value = value.substring(0, 16); // limit to 16 digits
    let formatted = '';
    for (let i = 0; i < value.length; i++) {
        if (i > 0 && i % 4 === 0) {
            formatted += ' ';
        }
        formatted += value[i];
    }
    e.target.value = formatted;
});

// Real-time expiry formatting (MM/YY)
document.getElementById('cardExpiry').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '').substring(0, 4); // MMYY
    if (value.length >= 3) {
        e.target.value = value.substring(0, 2) + '/' + value.substring(2);
    } else {
        e.target.value = value;
    }
});

// Optional: restrict CVC to digits only
document.getElementById('cardCvc').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, '').substring(0, 4);
});

['cardNumber', 'cardExpiry', 'cardCvc'].forEach(id => {
    document.getElementById(id).addEventListener('paste', function (e) {
        let pasted = e.clipboardData.getData('text');
        if (/\D/.test(pasted)) {
            e.preventDefault();
        }
    });
});

</script>

<?php
    require_once __DIR__ . '/../../../helpers/footer/footer-page.php';
?>
