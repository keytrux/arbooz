<?php

/**
 * Template Name: Главная страница
 */
get_header(); ?>



<section class="section-calculator">
    <div class="container">
        <div class="calculator-wrapper">
            <div class="calculator">
                <h1>Калькулятор тарифов</h1>

                <?php $regions = get_field('regions'); ?>
                <?php if (!empty($regions)) : ?>
                    <div class="custom-select">
                        <label for="region">Укажите регион передвижения</label>
                        <select id="region" name="region">
                            <?php foreach ($regions as $region): ?>
                                <option value="<?= esc_attr($region['name']); ?>" data-max-processing="<?= esc_attr($region['max_processing']); ?>">
                                    <?= esc_html($region['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="range-container">
                    <div class="range-output">
                        <label>Прокачка</label>
                        <output id="rangevalue">200</output>
                    </div>
                    <input type="range" class="range" value="200" name="processing" min="0" max="500" oninput="rangevalue.value = this.value" />
                    <div class="label-wrapper">
                        <label>0 тонн</label>
                        <label>250 тонн</label>
                        <label>500+ тонн</label>
                    </div>
                </div>

                <div class="switcher">
                    <button data-tab="fuel" class="active">Бензин</button>
                    <button data-tab="gas">Газ</button>
                    <button data-tab="dt">ДТ</button>
                </div>

                <div class="brands fuel" style="display: block;">
                    <label>Укажите любимый бренд</label>
                    <?php $brands = get_field('brands'); ?>
                    <?php if (!empty($brands)) : ?>
                        <div class="brand-buttons">
                            <?php $first = true; ?>
                            <?php foreach ($brands as $brand): ?>
                                <?php if ($brand['category'] === 'Бензин'): ?>
                                <button data-tab="<?= esc_html($brand['name']); ?>" <?= $first ? 'class="active"' : ''; ?>>
                                    <?= $brand['code_icon']; ?>
                                    <span><?= esc_html($brand['name']); ?></span>
                                    <?php $first = false; ?>
                                </button>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="brands gas" style="display: none;">
                    <label>Укажите любимый бренд</label>
                    <?php $brands = get_field('brands'); ?>
                    <?php if (!empty($brands)) : ?>
                        <div class="brand-buttons">
                            <?php $first = true; ?>
                            <?php foreach ($brands as $brand): ?>
                                <?php if ($brand['category'] === 'Газ'): ?>
                                    <button data-tab="<?= esc_html($brand['name']); ?>" <?= $first ? 'class="active"' : ''; ?>>
                                        <?= $brand['code_icon']; ?>
                                        <span><?= esc_html($brand['name']); ?></span>
                                        <?php $first = false; ?>
                                    </button>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="brands dt" style="display: none;">
                    <label>Укажите любимый бренд</label>
                    <?php $brands = get_field('brands'); ?>
                    <?php if (!empty($brands)) : ?>
                        <div class="brand-buttons">
                            <?php $first = true; ?>
                            <?php foreach ($brands as $brand): ?>
                                <?php if ($brand['category'] === 'ДТ'): ?>
                                    <button data-tab="<?= esc_html($brand['name']); ?>" <?= $first ? 'class="active"' : ''; ?>>
                                        <?= $brand['code_icon']; ?>
                                        <span><?= esc_html($brand['name']); ?></span>
                                        <?php $first = false; ?>
                                    </button>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="additional-services">
                    <label>Дополнительные услуги</label>
                    <?php $services = get_field('services'); ?>
                    <?php if (!empty($services)) : ?>
                        <div class="services">
                            <?php foreach ($services as $service): ?>
                            <div class="service" data-service="<?= esc_html($service['name']); ?>">
                                <?= $service['code_icon']; ?>
                                <p><?= esc_html($service['name']); ?></p>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
            <div class="order">
                <div class="order-wrapper">
                    <div class="card">
                        <label>Подходящий тариф <label id="tariff"></label></label>
                        <img src="/wp-content/themes/CustomTheme/assets/img/images/card.png">
                        <a href="#">Сеть АЗС на карте</a>
                    </div>
                    <div class="promo-action">
                        <p>Выберите промо-акцию:</p>
                        <div class="actions">
                            <div class="action" data-value="50">
                                <div class="circle">
                                    <span class="checkmark"></span>
                                    <span class="percentage">50%</span>
                                </div>
                                <span class="label">Экономия на штрафах</span>
                            </div>
                            <div class="action" data-value="20">
                                <div class="circle">
                                    <span class="checkmark"></span>
                                    <span class="percentage">20%</span>
                                </div>
                                <span class="label">Возврат НДС</span>
                            </div>
                            <div class="action" data-value="5">
                                <div class="circle">
                                    <span class="checkmark"></span>
                                    <span class="percentage">5%</span>
                                </div>
                                <span class="label">Скидка на мойку</span>
                            </div>
                            <div class="action" data-value="2">
                                <div class="circle">
                                    <span class="checkmark"></span>
                                    <span class="percentage">2%</span>
                                </div>
                                <span class="label">Скидка на топливо</span>
                            </div>
                        </div>
                    </div>
                    <div class="savings">
                        <div class="container">
                            <div class="saving-text">
                                <p class="saving-title">Ваша экономия:</p>
                                <div>
                                    <label>экономия в год</label>
                                    <p class="saving-p"><p>
                                </div>
                                <div>
                                    <label>экономия в месяц</label>
                                    <p class="saving-p"><p>
                                </div>
                            </div>
                            <button class="custom-button">
                                Заказать тариф «Избранный» →
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>