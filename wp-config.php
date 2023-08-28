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
define( 'DB_NAME', 'beautykiss_woo' );

/** Имя пользователя базы данных */
define( 'DB_USER', 'beautykiss_woo' );

/** Пароль к базе данных */
define( 'DB_PASSWORD', 'WoocommerceAka123' );

/** Имя сервера базы данных */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         '4#{eS9$=BLZ6;}@wl9[&fK`&+**V6/TCQwd9 3m$oCm8uL12uB=17Wx%e5?9G`x4' );
define( 'SECURE_AUTH_KEY',  'L(BN68X2,zk) :62 r!ey-o6ldlx=of?n7{K[<)|AT!uSI!khko}ztV3/%g-Lijx' );
define( 'LOGGED_IN_KEY',    'L4^PfLhjZ9o=`9vDreg[R~r{{w~TeF94_*q<-LdHu52IPH`cne0-X?xWqV>L&oeT' );
define( 'NONCE_KEY',        'WmBD`=sXHdQI?=XMEWN~9~~ls^:zY/lrciY^!mXLD4|Y67eISuO)0DuIUripNtRE' );
define( 'AUTH_SALT',        'KHT<WoR-x&tPwv!D]+#b8)/LIgb-5<Ov;<M0nn|Z b+.<U`6cIPiOX4J-/u)T&#t' );
define( 'SECURE_AUTH_SALT', '&Q3q%**9d,(fP&}upWK{7n&/s_k+Y<*Y!sb0,`uM+dG3!`A6lygKt#{7]V]X5Ji:' );
define( 'LOGGED_IN_SALT',   '0T5`>Y ~8 9#ZDAA5_<FxuRk)>+T:$73X=b}~$>;{nXf~R-W_2Z)%)G6nnD-1a#E' );
define( 'NONCE_SALT',       'S9.p>u$vYT*fq^d%h(`4x/;$Fb`yIvck-cPfbm(<q->[XjE+%guG*0a31~ZhTA;.' );

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

/* Произвольные значения добавляйте между этой строкой и надписью "дальше не редактируем". */

define('FORCE_SSL_ADMIN', true);

if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') 
$_SERVER['HTTPS']='on';;

define('WP_HOME','https://woocommerce.gridkit.ru');
define('WP_SITEURL','https://woocommerce.gridkit.ru');

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
