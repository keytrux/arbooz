<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!defined('ABSPATH')) {
    exit;
}

function get_fuel_data($fuelType) {
    $data = [
        'fuel' => ['price' => 500200, 'brands' => ['Роснефть', 'Лукойл', 'Татнефть']],
        'gas' => ['price' => 200100, 'brands' => ['Shell', 'Газпром', 'Башнефть']],
        'dt' => ['price' => 320700, 'brands' => ['Татнефть', 'Лукойл']]
    ];
    return $data[$fuelType] ?? null;
}

function get_tariff($fuelType, $volume) {
    switch ($fuelType) {
        case 'fuel':
            if ($volume < 100) return 'Эконом';
            elseif ($volume < 300) return 'Избранный';
            else return 'Премиум';

        case 'gas':
            if ($volume < 200) return 'Эконом';
            elseif ($volume < 700) return 'Избранный';
            else return 'Премиум';

        case 'dt':
            if ($volume < 150) return 'Эконом';
            elseif ($volume < 350) return 'Избранный';
            else return 'Премиум';

        default:
            return 'Эконом';
    }
}

function get_promo_options($tariff) {
    $options = [
        'Эконом' => [2, 5],
        'Избранный' => [5, 20],
        'Премиум' => [20, 50]
    ];
    return $options[$tariff] ?? [];
}

function get_promo_discount($tariff) {
    $options = get_promo_options($tariff);
    return !empty($options) ? max($options) : 0;
}

function calculate_fuel_cost($fuelType, $volume, $tariff, $promoDiscount) {
    $prices = [
        'fuel' => 500200,
        'gas' => 200100,
        'dt' => 320700
    ];

    if (!isset($prices[$fuelType])) {
        return ['error' => 'Неизвестный тип топлива'];
    }

    $tariffDiscounts = [
        'Эконом' => 3,
        'Избранный' => 5,
        'Премиум' => 7
    ];

    // Базовая стоимость без скидок
    $baseCost = ($prices[$fuelType] * $volume) / 1000;

    // Общая скидка (%)
    $totalDiscountPercent = ($tariffDiscounts[$tariff] ?? 0) + $promoDiscount;

    // Итоговая стоимость со скидкой
    $finalCost = $baseCost * (1 - $totalDiscountPercent / 100);

    // Расчёт экономии
    $monthlySavings = $baseCost * ($totalDiscountPercent / 100);
    $annualSavings = $monthlySavings * 12;

    return [
        'base_cost' => $baseCost,
        'tariff_discount' => $tariffDiscounts[$tariff] ?? 0,
        'promo_discount' => $promoDiscount,
        'total_discount' => $totalDiscountPercent,
        'final_cost' => $finalCost,
        'monthly_savings' => $monthlySavings,
        'annual_savings' => $annualSavings
    ];
}