<?php
namespace KSN_Site_Konstruktor;

use Elementor\Plugin;

//Test
require_once'widget_test.php';
//Test

//переоапределяем стандартынй common.php который отвечает за вывод панели "Расширенные" во всех виджетах
require_once'custom_common.php';
//все виджеты
require_once'header.php';
require_once'footer.php';
require_once'unifi_blok_1.php';
require_once'parent_uslugi_icon.php';
require_once'parent_uslugi_yellow_ssilki.php';
require_once'glavnaya_gorod_text.php';
require_once'randomayzer.php';
require_once'animate_img_text.php';
require_once'animate_diskont_img_text.php';
require_once'instagram_galery.php';
require_once'razvorot_block.php';
require_once'contact_map_img.php';

//Зарегистрировать виджет
$widgets_manager = Plugin::instance()->widgets_manager;

//Test
$widgets_manager->register_widget_type( new Widget\Elementor_Test_Widget() );
//Test

//переоапределяем стандартынй common.php который отвечает за вывод панели "Расширенные" во всех виджетах
$widgets_manager->register_widget_type( new Widget\Widget_Common() );
//регистрируем все виджеты 
$widgets_manager->register_widget_type( new Widget\header_widget() );
$widgets_manager->register_widget_type( new Widget\footer_widget() );
$widgets_manager->register_widget_type( new Widget\unifi_blok_1() );
$widgets_manager->register_widget_type( new Widget\parent_uslugi_icon() );;
$widgets_manager->register_widget_type( new Widget\parent_uslugi_yellow_ssilki() );
$widgets_manager->register_widget_type( new Widget\Glavnaya_gorod_text() );
$widgets_manager->register_widget_type( new Widget\Randomayzer() );
$widgets_manager->register_widget_type( new Widget\animate_img_text() );
$widgets_manager->register_widget_type( new Widget\animate_diskont_img_text() );
$widgets_manager->register_widget_type( new Widget\Instagram_Galery() );
$widgets_manager->register_widget_type( new Widget\razvorot_block() );
$widgets_manager->register_widget_type( new Widget\contact_map_img() );

//поскольку не получается отключить категорию theme-elements-single (подкатегория theme-elements) я решил просто отменить регистрацию всех виджетов этой подкатегории чтоб урать её из меню (элементор автоматически скрывает категории без виджетов)
$widgets_manager->unregister_widget_type('theme-post-title');
$widgets_manager->unregister_widget_type('theme-post-excerpt');
$widgets_manager->unregister_widget_type('theme-post-featured-image');
$widgets_manager->unregister_widget_type('table-of-contents');
$widgets_manager->unregister_widget_type('author-box');
$widgets_manager->unregister_widget_type('post-comments');
$widgets_manager->unregister_widget_type('post-navigation');
$widgets_manager->unregister_widget_type('post-info');

//поскольку не получается отключить категорию theme-elements (подкатегория theme-elements) я решил просто отменить регистрацию всех виджетов этой подкатегории чтоб урать её из меню (элементор автоматически скрывает категории без виджетов)
//данные виджеты появляются при редактировании верха и низа сайта, в момент изменения их содержимого
$widgets_manager->unregister_widget_type('site-logo');
$widgets_manager->unregister_widget_type('theme-site-logo');
$widgets_manager->unregister_widget_type('site-title');
$widgets_manager->unregister_widget_type('theme-site-title');
$widgets_manager->unregister_widget_type('page-title');
$widgets_manager->unregister_widget_type('theme-page-title');
$widgets_manager->unregister_widget_type('nav-menu');
$widgets_manager->unregister_widget_type('search-form');
$widgets_manager->unregister_widget_type('sitemap');