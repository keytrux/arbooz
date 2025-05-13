document.addEventListener('DOMContentLoaded', function() {
    const regionSelect = document.getElementById('region');
    const rangeInput = document.querySelector('.range');
    const rangeValue = document.getElementById('rangevalue');
    const rangeLabels = document.querySelectorAll('.label-wrapper label');

    // Функция для обновления range input и подписей
    function updateRangeInput() {
        const selectedOption = regionSelect.options[regionSelect.selectedIndex];
        const maxValue = selectedOption.getAttribute('data-max-processing');

        // Устанавливаем новое максимальное значение
        rangeInput.max = maxValue;

        // Обновляем текущее значение, если оно превышает новый максимум
        if (parseInt(rangeInput.value) > parseInt(maxValue)) {
            rangeInput.value = maxValue;
            rangeValue.value = maxValue;
        }

        // Обновляем подписи
        const midValue = Math.floor(maxValue / 2);
        rangeLabels[0].textContent = '0 тонн';
        rangeLabels[1].textContent = `${midValue} тонн`;
        rangeLabels[2].textContent = `${maxValue}+ тонн`;

        // Обновляем стиль заполнения
        updateRangeStyle();
    }

    // Функция для обновления стиля range input
    function updateRangeStyle() {
        const min = parseInt(rangeInput.min);
        const max = parseInt(rangeInput.max);
        const value = parseInt(rangeInput.value);
        const percentage = ((value - min) / (max - min)) * 100;
        rangeInput.style.backgroundSize = `${percentage}% 100%`;
    }

    // Обработчик изменения региона
    regionSelect.addEventListener('change', updateRangeInput);

    // Обработчик изменения range input
    rangeInput.addEventListener('input', function() {
        rangeValue.value = this.value;
        updateRangeStyle();
    });

    // Инициализация при загрузке
    updateRangeInput();
});

document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.switcher button');

    // Функция для установки активной кнопки
    function setActiveButton(button) {
        // Удаляем класс active у всех кнопок
        buttons.forEach(btn => btn.classList.remove('active'));
        // Добавляем класс active к текущей кнопке
        button.classList.add('active');
    }

    // Обработчик клика для каждой кнопки
    buttons.forEach(button => {
        button.addEventListener('click', function () {
            setActiveButton(this);
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.brand-buttons button');
    // Функция для установки активной кнопки
    function setActiveButton(button) {
        // Удаляем класс active у всех кнопок
        buttons.forEach(btn => btn.classList.remove('active'));
        // Добавляем класс active к текущей кнопке
        button.classList.add('active');
    }

    // Обработчик клика для каждой кнопки
    buttons.forEach(button => {
        button.addEventListener('click', function () {
            setActiveButton(this);
        });
    });
});


document.querySelectorAll('.switcher button').forEach(button => {
    button.addEventListener('click', function() {
        // Удаляем класс active со всех кнопок
        document.querySelectorAll('.switcher button').forEach(btn => btn.classList.remove('active'));

        // Добавляем класс active к нажатой кнопке
        this.classList.add('active');

        // Получаем выбранный тип топлива
        const fuelType = this.getAttribute('data-tab');

        // Скрываем все группы брендов
        document.querySelectorAll('.brands').forEach(group => group.style.display = 'none');

        // Показываем группу брендов для выбранного типа топлива
        document.querySelector(`.brands.${fuelType}`).style.display = 'block';
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const actions = document.querySelectorAll('.action');

    actions.forEach(action => {
        action.addEventListener('click', () => {
            // Сбросить все действия
            actions.forEach(a => a.classList.remove('selected'));

            // Выбрать текущее действие
            action.classList.add('selected');
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {

    const form = document.querySelector(".op-form-request");
    const overlay = document.createElement("div");
    overlay.classList.add("modal-overlay");

    if (!form) {
        console.error("Форма не найдена!");
        return;
    }

    function openModal(event) {
        event.preventDefault();
        document.body.classList.add("modal-open");
        document.body.appendChild(overlay);
        overlay.style.display = "block";
        form.style.display = "block";
    }

    function closeModal() {
        document.body.classList.remove("modal-open");
        overlay.style.display = "none";
        form.style.display = "none";

        if (document.body.contains(overlay)) {
            document.body.removeChild(overlay);
        }
    }

    function disableScroll() {
        document.body.style.overflow = 'hidden';
        document.documentElement.style.overflow = 'hidden';
    }

    function enableScroll() {
        document.body.style.overflow = '';
        document.documentElement.style.overflow = '';
    }

    document.body.addEventListener("click", function (event) {
        if (event.target.closest(".custom-button")) {
            openModal(event);
            disableScroll();
        }
    });

    overlay.addEventListener("click", closeModal);

    document.body.addEventListener("click", function (event) {
        if (event.target.closest(".close-button")) {
            closeModal();
            enableScroll();
        }
    });

});


