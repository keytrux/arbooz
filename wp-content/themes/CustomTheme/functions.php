<?php
ini_set('log_errors', true);
ini_set('error_log', dirname(__FILE__) . '/debug.log');
// Поддержка миниатюр
add_theme_support('post-thumbnails');
// Регистрация меню
register_nav_menus([
    'menu' => "Меню"
]);
// Убрать span из CF7
add_filter('wpcf7_form_elements', function($content) {
    $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);
    return $content;
});

// Подключение css и js
function my_theme_scripts(){
    wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/style.css');

    // Подключение JS
     wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), null, true);

    // Подключение JS
    wp_enqueue_script(
        'calculator-ajax',
        get_template_directory_uri() . '/assets/js/calculator-ajax.js',
        ['jquery'],
        null,
        true
    );

    // Локализация ajaxurl
    wp_localize_script('calculator-ajax', 'calculatorAjax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('fuel_calculator_nonce')
    ]);
}
add_action('wp_enqueue_scripts', 'my_theme_scripts');


// Обработчик AJAX
add_action('wp_ajax_calculate_fuel_cost', 'handle_calculator_ajax');
add_action('wp_ajax_nopriv_calculate_fuel_cost', 'handle_calculator_ajax');

function handle_calculator_ajax() {
    require_once get_template_directory() . '/ajax-handler.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    check_ajax_referer('fuel_calculator_nonce', 'security');

    $data = $_POST;

    if (!isset($data['fuelType'], $data['volume'], $data['brand'])) {
        wp_send_json_error(['message' => 'Недостающие данные']);
    }

    $fuelType = sanitize_text_field($data['fuelType']);
    $volume = floatval($data['volume']);
    $brand = sanitize_text_field($data['brand']);
    $promoDiscount = isset($data['promoDiscount']) ? floatval($data['promoDiscount']) : 0;

    $tariff = get_tariff($fuelType, $volume);
    if (!$tariff) {
        wp_send_json_error(['message' => 'Ошибка определения тарифа']);
    }

    $calculation = calculate_fuel_cost($fuelType, $volume, $tariff, $promoDiscount);

    wp_send_json_success([
        'tariff' => $tariff,
        'promo_options' => array_map('floatval', get_promo_options($tariff)),
        'promo_selected' => floatval($promoDiscount),
        'cost_monthly' => round($calculation['final_cost']),
        'total_discount' => $calculation['total_discount'],
        'monthly_savings' => round($calculation['monthly_savings']),
        'annual_savings' => round($calculation['annual_savings'])
    ]);
}

add_action('wp_ajax_send_calculator_email', 'handle_send_email');
add_action('wp_ajax_nopriv_send_calculator_email', 'handle_send_email');

function handle_send_email() {
    check_ajax_referer('fuel_calculator_nonce', 'security');

    $data = $_POST;

    // Для отладки:
    error_log("Данные из формы: " . print_r($data, true));

    $to = sanitize_email($data['email'] ?? '');
    if (!is_email($to)) {
        wp_send_json_error(['message' => 'Неверный email']);
    }

    $subject = "Запрос по тарифу";

    // Получаем доп.услуги
    $services = $data['services'] ?? [];
    $additionalServices = is_array($services) ? implode(', ', $services) : $services;

    $message = "
    <html>
    <body>
        <h2>Данные запроса:</h2>
        <p><strong>Номер ИНН:</strong> {$data['inn']}</p>
        <p><strong>Телефон:</strong> {$data['phone']}</p>
        <p><strong>Email:</strong> {$data['email']}</p>
        <hr>
        <p><strong>Регион:</strong> {$data['region']}</p>
        <p><strong>Прокачка:</strong> {$data['volume']} тонн</p>
        <p><strong>Тип топлива:</strong> {$data['fuelType']}</p>
        <p><strong>Бренд:</strong> {$data['brand']}</p>
        <p><strong>Доп. услуги:</strong> {$additionalServices}</p>
        <p><strong>Промо-скидка:</strong> {$data['promoDiscount']}%</p>
        <p><strong>Тариф:</strong> {$data['tariff']}</p>
        <p><strong>Стоимость в месяц:</strong> {$data['cost_monthly']} ₽</p>
        <p><strong>Общая скидка:</strong> {$data['total_discount']}%</p>
        <p><strong>Экономия в месяц:</strong> {$data['monthly_savings']} ₽</p>
        <p><strong>Экономия в год:</strong> {$data['annual_savings']} ₽</p>
    </body>
    </html>
    ";

    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: admin@arbooz.keytrux.ru'
    ];

    $sent = wp_mail($to, $subject, $message, $headers);

    if ($sent) {
        wp_send_json_success(['message' => 'Письмо отправлено']);
        error_log("Результат wp_mail: " . var_export($sent, true));
        error_log("Данные для письма: " . print_r($data, true));
    } else {
        wp_send_json_error(['message' => 'Ошибка отправки письма']);
        error_log("Результат wp_mail: " . var_export($sent, true));
        error_log("Данные для письма: " . print_r($data, true));
    }
}

function theme_setup() {
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'theme_setup');


function custom_homepage_title($title) {
    if (is_front_page()) {
        $title['title'] = 'Главная страница';
    }
    return $title;
}
add_filter('document_title_parts', 'custom_homepage_title');

?>