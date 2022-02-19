<?php
/*
Plugin Name: KSN контролер сайта
Description: Данный плагин позволит контролировать Ваш сайт полностью, предоставит возможность редактировать в режиме реального времени, а так же обеспечит максимальную производительность при работе сайта =)
Version: 1.0.0
Author: Серёга KSN
*/

namespace KsnPlugin;

use KsnPlugin\core\Main_Func;
use KsnPlugin\moduls\Plagin_Moduls_Meneger;
use KsnPlugin\base\admin\Admin;
use KsnPlugin\base\site\Site_Settings;
use KsnPlugin\base\events\Activation;
use KsnPlugin\base\events\Diactivation;
use KsnPlugin\base\posts_srttings\Rus_To_Lat;

if ( ! defined( 'ABSPATH' ) ) { exit; }//завершить скрипт при прямом доступе к файлу, в обход движка вордпресса

date_default_timezone_set("Europe/Moscow");//временная зона по умолчанию

global $wpdb;

//определяем константы
define( 'KSN_DB_TABLE', $wpdb->prefix.'data_site' );//таблица в базе данных
define( 'KSN_PLAGIN_NAME', 'ksn_site_control' );//папка плагина
define( 'WP_PLUGINS_DIR', rtrim(__DIR__, KSN_PLAGIN_NAME));//возвращает полный серверный путь D:\OpenServer\domains\peter.ru\wp-content\plugins\
define( 'KSN_PLAGIN_URL', plugins_url().'/'.KSN_PLAGIN_NAME );//возвращает http://домен.ru/wp-content/plugins/ksn_site_control не подходит для подключения PHP файлов
define( 'KSN_PLAGIN_DIR', __DIR__ );//возвращает полный серверный путь E:\1SERVER\domains\peter.ru\wp-content\plugins\ksn_site_control, подходит для подключения PHP файлов
define( 'KSN_ELEMENTOR_ADDON_FOLDER', 'elementor_addon' );//папка дополнений для элементора
define( 'KSN_ELEMENTOR_ADDON_URL', KSN_PLAGIN_URL.'/'.KSN_ELEMENTOR_ADDON_FOLDER );//возвращает http://домен.ru/wp-content/plugins/ksn_site_control/elementor_addon не подходит для подключения PHP файлов
define( 'KSN_ELEMENTOR_ADDON_DIR', KSN_PLAGIN_DIR.'/'.KSN_ELEMENTOR_ADDON_FOLDER );//возвращает полный серверный путь E:\1SERVER\domains\peter.ru\wp-content\plugins\ksn_site_control/elementor_addon, подходит для подключения PHP файлов
define( 'KSN_PROJEKT_FOLDER', 'mr_cap_ural_cities' );//текущий проэкт
define( 'KSN_PROJEKT_URL', KSN_PLAGIN_URL.'/projekts/'.KSN_PROJEKT_FOLDER );//возвращает http://домен.ru/wp-content/plugins/ksn_site_control/projekts/mr_cap_ural_cities не подходит для подключения PHP файлов
define( 'KSN_PROJEKT_DIR', KSN_PLAGIN_DIR.'/projekts/'.KSN_PROJEKT_FOLDER );//возвращает полный серверный путь E:\1SERVER\domains\peter.ru\wp-content\plugins\ksn_site_control/projekts/mr_cap_ural_cities, подходит для подключения PHP файлов
define( 'KSN_ASSETS_URL', KSN_PLAGIN_URL.'/assets' );//возвращает http://домен.ru/wp-content/plugins/ksn_site_control/assets не подходит для подключения PHP файлов
define( 'KSN_ASSETS_DIR', KSN_PLAGIN_DIR.'/assets' );//возвращает полный серверный путь E:\1SERVER\domains\peter.ru\wp-content\plugins\ksn_site_control/assets, подходит для подключения PHP файлов
define( 'CACHE_DIR', WP_CONTENT_DIR.'/cache/ksn_cache');//возвращает путь к поке хранения кеша E:\1SERVER\domains\peter.ru/wp-content/cache
//определяем константы

class KsnPlugin {
    //тут будем хранить экземпляр нашего класса
    public static $instance = null;

    public $main_func;//тут хранится и обновляется экземпляр объекта всех основных функций плагина

    public $moduls_meneger;//тут будут хранится все данные модулей

    //создаём экземпляр нашего класса, а если он уже создан возвращаем его
    public static function instance() {
        if ( is_null( self::$instance ) ) {//если $instance свойство не равно null то значит мы в него уже записали наш экземпляр класа
            self::$instance = new self();//если $instance пусто то записываем в него новый экземпляр нашего класса
        }

        return self::$instance;//функция должна вернуть экземпляр нашего класса
    }

    //создаём автозагрузку классов, для автоматического их подключения при обнаружении нового класса интерпретатором PHP

    private function register_autoloader() {
        require_once KSN_PLAGIN_DIR . '/core/autoloader.php';//подключаем файл автозагрузчика классов

        Autoloader::run();
    }

    public function init(){
        $this->moduls_meneger = new Plagin_Moduls_Meneger();
        $this->moduls_meneger->run();
        new Admin;
        (new Site_Settings)->run();//основные функции для сайта
        new Rus_To_Lat;
    }

    public function activation(){
        Activation::run();
    }

    public function diactivation(){
        Diactivation::run();
    }

    private function __construct() {
        $this->register_autoloader();//регистрируем функции автозагрузки классов
        require_once KSN_PLAGIN_DIR . '/core/Main_Func.php';//подключаем файл со всеми основоными функциями плагина, такими как соединение с редисом и поиск по базе данных
        $this->main_func = new Main_Func;
        register_activation_hook(__FILE__, [$this, 'activation']);//выполнится в момент активации плагина
        register_deactivation_hook(__FILE__, [$this, 'diactivation']);//выполнится в момент диактивации плагина  
        add_action( 'init', [ $this, 'init' ], 0 );//запускаем наш плагин
    }

}

KsnPlugin::instance();//инициализируем наш класс

require_once( KSN_ELEMENTOR_ADDON_DIR.'/elementor_addon.php' );//подключаем расширение которое позволит редактировать сайт в элементоре


//require_once( KSN_PLAGIN_DIR . '/inc/simple_html_dom.php' );//парсер HTML



