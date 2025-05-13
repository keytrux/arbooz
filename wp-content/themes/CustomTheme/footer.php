
<div class="op-form-request" id="op-form-request" data-open="request">
    <div class="modal-content request">
        <div class="close-button">
        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 1L14 14M14 14L1 27M14 14L27 27M14 14L27 1" stroke="#636363" stroke-width="2"/>
        </svg>

        </div>
        <p>Заказать тариф «Избранный»</p>
        <form id="request-form">
            <input type="text" name="inn" placeholder="Номер ИНН" required>
            <input type="text" name="phone" placeholder="Телефон для связи" required>
            <input type="text" name="email" placeholder="E-mail для связи" required>
            <label class="custom-checkbox">
                <input type="checkbox" name="personal_data_agreement" value="1" required>
                <span>Согласен с обработкой персональных данных</span>
            </label>
            <button type="submit" class="btn-request">
                Заказать тариф «Избранный»
            </button>
            <div class="form-response"></div>
        </form>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>