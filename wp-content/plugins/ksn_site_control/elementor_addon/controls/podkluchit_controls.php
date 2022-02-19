<?php
namespace KSN_Site_Konstruktor;

use Elementor\Plugin;	

//test
require_once 'test_control.php';
//test

//создаёт подобии галереи
require_once 'media_podborka.php';
//заменяет стандартный REPEATER
require_once 'custom_repeater.php';
//заменяет стандартный URL
require_once 'custom_url.php';
//Новый медиа загрузчик
require_once 'custom_media_uploader.php';
//заменяет стандартный POPOVER_TOGGLE
require_once 'custom_popover_toggle.php';
//добавляет выбор в виде картинок, каждая картинка является input ratio полем и задаёт своё значение
require_once 'control_blok_typs.php';
//добавляет выбор в виде вертикальных блоков
require_once 'control_vibor_shablona_bloka.php';
//кастомный свичер, переключатель типа да/нет
require_once 'custom_switcher.php';
//контролирует отображение блока на разных устройствах
require_once 'control_show_block_on_device.php';

//Register control
$controls_manager = Plugin::$instance->controls_manager;

//test
$controls_manager->register_control( 'test_control', new Control\Test_control() );
//test

//создаёт подобии галереи
$controls_manager->register_control( 'media_podborka', new Control\Media_Podborka() );
//заменяет стандартный REPEATER
$controls_manager->register_control( 'repeater', new Control\Custom_Repeater() );
//заменяет стандартный URL
$controls_manager->register_control( 'url', new Control\Custom_URL() );
//Новый медиа загрузчик
$controls_manager->register_control( 'custom_media_uploader', new Control\Custom_Media_Uploader() );
//заменяет стандартный POPOVER_TOGGLE
$controls_manager->register_control( 'popover_toggle', new Control\Custom_Popover_Toggle() );
//добавляет выбор в виде картинок, каждая картинка является input ratio полем и задаёт своё значение
$controls_manager->register_control( 'control_blok_typs', new Control\Control_blok_typs() );
//добавляет выбор в виде вертикальных блоков
$controls_manager->register_control( 'control_vibor_shablona_bloka', new Control\Control_vibor_shablona_bloka() );
//кастомный свичер, переключатель типа да/нет
$controls_manager->register_control( 'custom_switcher', new Control\Custom_switcher() );
//контролирует отображение блока на разных устройствах
$controls_manager->register_control( 'control_show_block_on_device', new Control\Control_show_block_on_device() );