(function($) {
    let total_discount = 0;
    const fuelTypeMap = {
        'fuel': 'Бензин',
        'gas': 'Газ',
        'dt': 'ДТ'
    };
    function sendCalcRequest(data) {
        $.ajax({
            url: calculatorAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'calculate_fuel_cost',
                security: calculatorAjax.nonce,
                region: data.region,
                volume: data.volume,
                fuelType: data.fuelType,
                brand: data.brand,
                promoDiscount: data.promoDiscount ?? 0
            },
            dataType: 'json',
            success: function(response) {
                console.log("Ответ от сервера:", response);

                if(response.success) {
                    $('#tariff').text(response.data.tariff.toLocaleString());
                    $('.saving-p:eq(0)').text('от ' + response.data.annual_savings.toLocaleString() + ' ₽');
                    $('.saving-p:eq(1)').text('от ' + response.data.monthly_savings.toLocaleString() + ' ₽');
                    $('.custom-button').show();

                    total_discount = response.data.total_discount;

                    updatePromoActions(response.data.promo_options, response.data.promo_selected);
                } else {
                    console.error('Ошибка:', response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("XHR Response Text:", xhr.responseText); // ← Это важно!
                alert('Ошибка при расчете: ' + error);
            }
        });
    }

    $(document).ready(function () {
        let lastData = {};

        function collectFormData() {
            const services = [];
            $('.service.active').each(function () {
                services.push($(this).data('service'));
            });

            const fuelType = $('.switcher button.active').data('tab');
            const brand = $('.brand-buttons .active').data('tab');
            const promoDiscount = $('.action.selected').data('value');

            return {
                region: $('#region').val() || '',
                volume: parseInt($('#rangevalue').text()) || 0,
                fuelType: fuelType || '',
                brand: brand || '',
                promoDiscount: promoDiscount,
            };
        }

        function triggerCalculation() {
            const formData = collectFormData();

            if (formData.volume <= 0) return;

            lastData = formData;
            sendCalcRequest(formData);
        }

        // При изменении региона или объема
        $('#region, .range').on('change input', function () {
            const selectedOption = $('#region option:selected');
            const maxValue = selectedOption.data('max-processing');
            $('.range').attr('max', maxValue);
            $('#rangevalue').text($('.range').val());
            triggerCalculation();
        });

        // При выборе топлива
        $('.switcher button').on('click', function () {
            $('.switcher button').removeClass('active');
            $(this).addClass('active');
            triggerCalculation();
        });

        // При выборе бренда
        $('.brand-buttons button').on('click', function () {
            $('.brand-buttons button').removeClass('active');
            $(this).addClass('active');
        });

        // При выборе доп. услуг
        $('.service').on('click', function () {
            const $this = $(this);
            const service = $this.data('service');

            if ($this.hasClass('active')) {
                $this.removeClass('active');
            } else {
                if ($('.service.active').length < 4) {
                    $this.addClass('active');
                } else {
                    alert('Можно выбрать максимум 4 услуги');
                    return;
                }
            }
        });

        // При выборе промо-акции
        $('.action').on('click', function () {
            $('.action').removeClass('selected');
            $(this).addClass('selected');
            triggerCalculation();
        });

        $('#request-form').on('submit', function(e) {
            e.preventDefault();

            const formData = collectFormData(); // Данные калькулятора
            const formFields = $(this).serializeArray();
            const $responseDiv = $('.form-response');
            const $checkbox = $('input[name="personal_data_agreement"]:checked');

            const data = {};
            $.each(formFields, function(index, field) {
                data[field.name] = field.value;
            });

            const services = [];
            $('.service.active').each(function () {
                services.push($(this).data('service'));
            });

            // Добавляем данные калькулятора
            Object.assign(data, {
                region: formData.region,
                volume: formData.volume,
                fuelType: fuelTypeMap[formData.fuelType] || formData.fuelType,
                brand: formData.brand,
                promoDiscount: formData.promoDiscount,
                tariff: $('#tariff').text(),
                cost_monthly: $('.saving-p:eq(1)').text().replace(/[^0-9]/g, ''),
                total_discount: total_discount,
                monthly_savings: $('.saving-p:eq(1)').text().replace(/[^0-9]/g, ''),
                annual_savings: $('.saving-p:eq(0)').text().replace(/[^0-9]/g, ''),
                services: services
            });

            console.log("Данные для отправки:", data);

            // --- Валидация ---
            let error = '';

            if (!data.inn || !/^\d{12}$/.test(data.inn)) {
                error = 'ИНН должен содержать ровно 12 цифр';
            } else if (!data.phone || !/^(\+7|8)\d{10}$/.test(data.phone.replace(/\D/g, ''))) {
                error = 'Введите корректный телефон (например, 89991234567)';
            } else if (!isEmailValid(data.email)) {
                error = 'Введите корректный email';
            } else if (!$checkbox.length) {
                error = 'Вы должны дать согласие на обработку данных';
            }

            if (error) {
                $responseDiv.html(`<div style="color: red;">${error}</div>`).show();
                return;
            }

            $.ajax({
                url: calculatorAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'send_calculator_email',
                    security: calculatorAjax.nonce,

                    // Все параметры плоские, а не вложенные
                    inn: data.inn,
                    phone: data.phone,
                    email: data.email,
                    region: data.region,
                    volume: data.volume,
                    fuelType: data.fuelType,
                    brand: data.brand,
                    promoDiscount: data.promoDiscount,
                    tariff: data.tariff,
                    cost_monthly: data.cost_monthly,
                    total_discount: data.total_discount,
                    monthly_savings: data.monthly_savings,
                    annual_savings: data.annual_savings,
                    services: data.services
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#request-form')[0].reset();
                        $('.service').removeClass('active');
                        $responseDiv.html('<div style="color: green;">Спасибо! Успешно отправлено.</div>').show();
                    } else {
                        $responseDiv.html('<div style="color: red;">Ошибка: ' + response.data.message + '</div>').show();
                    }
                },
                error: function(xhr) {
                    console.error("XHR Response Text:", xhr.responseText);
                    $responseDiv.html('<div style="color: red;">Произошла ошибка</div>').show();
                }
            });
        });
    });

    function isEmailValid(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function updatePromoActions(promoOptions, selectedValue = null) {
        const promoContainer = $('.actions');

        // Если нет опций - скрываем все акции
        if (!promoOptions || promoOptions.length === 0) {
            promoContainer.find('.action').hide();
            return;
        }

        console.log(selectedValue);
        console.log(Math.max(...promoOptions));

        // Берём максимальную скидку по умолчанию, если не передана
        let defaultSelected = selectedValue !== 0 ? parseFloat(selectedValue) : Math.max(...promoOptions);

        if (Math.max(...promoOptions) > selectedValue)
        {
            defaultSelected = Math.max(...promoOptions);
        }

        // Скрываем все акции и очищаем класс 'selected'
        promoContainer.find('.action')
            .hide()
            .removeClass('selected');

        // Показываем только доступные промо-акции
        promoOptions.forEach(value => {
            const actionDiv = promoContainer.find(`.action[data-value='${parseFloat(value)}']`);
            if (actionDiv.length > 0) {
                actionDiv.show(); // Показываем
                if (parseFloat(actionDiv.attr('data-value')) === parseFloat(defaultSelected)) {
                    actionDiv.addClass('selected');
                }
            }
        });
    }

    $(document).ready(function () {
        let lastData = {};
        function collectFormData() {
            const services = [];
            $('.service.active').each(function () {
                services.push($(this).data('service'));
            });

            const fuelType = $('.switcher button.active').data('tab');
            const brand = $('.brand-buttons .active').data('tab');
            const promoDiscount = $('.action.selected').data('value');

            return {
                region: $('#region').val(),
                volume: parseInt($('#rangevalue').text()),
                fuelType: fuelType,
                brand: brand,
                additionalServices: services,
                promoDiscount: promoDiscount,
            };
        }

        // Функция для запуска расчета
        function triggerCalculation() {
            const formData = collectFormData();

            if (formData.volume <= 0) return;

            lastData = formData;
            sendCalcRequest(formData);
        }

        // Вызываем расчет при загрузке страницы
        $(window).on('load', function () {
            triggerCalculation();
        });

        setTimeout(() => {
            triggerCalculation();
        }, 500);
    });

})(jQuery);