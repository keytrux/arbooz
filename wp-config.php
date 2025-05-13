<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать файл в "wp-config.php"
 * и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки базы данных
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры базы данных: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', "u2835836_arbooz" );

/** Имя пользователя базы данных */
define( 'DB_USER', "u2835836_arbooz" );

/** Пароль к базе данных */
define( 'DB_PASSWORD', "qB5aR9sS4zyD7sP1" );

/** Имя сервера базы данных */
define( 'DB_HOST', "localhost" );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу. Можно сгенерировать их с помощью
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}.
 *
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными.
 * Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '+I[R3XMjlwF8xFYc$6AHrG:fBM[uL}O2o2mg0Y{njh2s!U.yPmv|xwVVf{d5P@1v' );
define( 'SECURE_AUTH_KEY',  'pe*$71~C@uxbSZoo`X|2hjnk%@E_Kf1G.?dG:CQiG8cy8^I))dV&zd pceaO*J<J' );
define( 'LOGGED_IN_KEY',    'n=w1#*^YB5GTivD)BDPXvv.(seCUmY|G;c3$Z*GO}>G49SUf{:Ftq:w=<9SD1Df@' );
define( 'NONCE_KEY',        '[2~}2g/LZCA*R^[wpet}lT_@Dr.SR.8}13mZuaW0i79jBw1c&$` >P+/h?QgE=*|' );
define( 'AUTH_SALT',        '!YVf{D_R/[wT)o PwDf{s5sq|94(r`XlzSYM?H?uXW>@^V+wxeeN_{[g]/mQX50c' );
define( 'SECURE_AUTH_SALT', '9NAE$OFIaC0mfI_CA!_5uin]zBv4D4p_RHij%[`(84 w}p%6W{(%{Z^Ak1 b UL7' );
define( 'LOGGED_IN_SALT',   'KPY>U?eN~CUM^6+QR&<3#0b<&,[bJGvpmYP7y&e?~UUfRNSpXrG$|`.`[mg)Ci(F' );
define( 'NONCE_SALT',       'fbb&XQD!M%;59]e~H>bC_R;C*8{0c8(~ibwQaf`LA)Cd`Bz:aB?I%J-5M+Z.xDQL' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );
define('WPCF7_AUTOP', false);

/* Произвольные значения добавляйте между этой строкой и надписью "дальше не редактируем". */



/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
define( 'DUPLICATOR_AUTH_KEY', 'd/UWqq]CICi~8B:b@!k4qL(%z2 <F%ss-a0RtaUv=f%cPonF6D]*dQFXilD5BDd2' );
define( 'WP_PLUGIN_DIR', '/var/www/u2835836/data/www/arbooz.keytrux.ru/wp-content/plugins' );
define( 'WPMU_PLUGIN_DIR', '/var/www/u2835836/data/www/arbooz.keytrux.ru/wp-content/mu-plugins' );
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
