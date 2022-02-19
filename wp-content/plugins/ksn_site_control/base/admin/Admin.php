<?php 
namespace KsnPlugin\base\admin;

use KsnPlugin\base\admin\PlaginAdminPage;


class Admin {

	//Добавляем новый пункт меню в админке вордпресса
	public function ksn_add_admin_link(){
		//global $wpdb;
		//if ($wpdb->get_var("SHOW TABLES LIKE '".KSN_DB_TABLE."'") === KSN_DB_TABLE) {//создаём раздел плагина в админке вордпреса только после того как была создана таблица в базе данных для работы данного плагина
			add_menu_page(
				'Контроллер сайта', // Заголовк страниц $page_title
				'Контроллер', // Название меню в админке $menu_title
				'manage_options', // Требование к возможности видеть ссылку, права пользователя  $capability
				KSN_PLAGIN_NAME, // $menu_slug уникальное название (slug), по которому затем можно обращаться к этому меню.
				[$this, 'render_plagin_admin_page'], // $function название функции, которая выводит контент страницы пункта меню.
				KSN_ASSETS_URL.'/img/icon_menu.svg',//$icon_url адрес иконки
				'61' //$position очерёжность вывода пункта, 61 сразу после внешний вид в админ панели
			);
		//}
	}

	//отображаем страницу плагина в админке
	public function render_plagin_admin_page(){
		(new PlaginAdminPage())->render_page();//рендерим страницу
	}

	//Загрузка необходимых стилей и скриптов на странице плагина в админке вордпресса
	public function include_css_js_files(){
		$page_hook_suffix =  add_menu_page( '', '', '', KSN_PLAGIN_NAME );
	    add_action('admin_print_styles-' . $page_hook_suffix, [$this, 'plagin_css']);
	    add_action('admin_print_scripts-' . $page_hook_suffix, [$this, 'plagin_js']);
	}

	public function plagin_css() {
	    wp_register_style( 'plagin_admin_page_css', KSN_ASSETS_URL.'/css/settings_page.css', [], '1', 'all' );
	    wp_enqueue_style( 'plagin_admin_page_css');
	    wp_enqueue_style( 'wp-color-picker' );//Подключаем Iris Color Picker
	}

	public function plagin_js() {
	    wp_register_script( 'base_func_js', KSN_ASSETS_URL.'/js/base_func.js', array('jquery'), '1', true );
	    wp_enqueue_script( 'base_func_js');
	    wp_register_script( 'cache_control_js', KSN_ASSETS_URL.'/js/cache_control.js', array('jquery', 'base_func_js'), '1', true );
	    wp_enqueue_script( 'cache_control_js');
	    wp_register_script( 'plagin_admin_page_js', KSN_ASSETS_URL.'/js/settings_page.js', array('jquery', 'base_func_js'), '1', true );
	    wp_enqueue_script( 'plagin_admin_page_js');
	    wp_enqueue_script( 'wp-color-picker' );//Подключаем Iris Color Picker
	}
	//Загрузка необходимых стилей и скриптов на странице плагина в админке вордпресса

	//тут мы изменяем отображение данных картинок в медиатеке, когда мы открываем картинку нажав на неё , этот шаблон меняет данные её полей алт, тайт и другие
	public function modified_attachments_details_two_column(){
		require_once KSN_PLAGIN_DIR.'/wp_custom_temp/tmpl_attachment_details_two_column_custom.php';
	}

	//менят вывод данных картинки при выборе её в медиатеке, данные меняются справа. ВАЖНО: менят данные не в фулскрине картинки , а просто при выборе картинки в медиатеке
	public function modified_attachments_details_template() {
		require_once KSN_PLAGIN_DIR.'/wp_custom_temp/tmpl_attachment_details_custom.php';
	}

	public function __construct(){
		add_action( 'admin_menu', [ $this, 'ksn_add_admin_link'] );//создаём пункт плагина в админ меню вордпресса
		add_action( 'admin_init', [ $this, 'include_css_js_files'] );//подключаем в на странице плагина в админке нужэные стили и скрипты
		add_action( 'admin_footer-upload.php', [ $this, 'modified_attachments_details_two_column'] );//тут мы изменяем отображение данных картинок в медиатеке, когда мы открываем картинку нажав на неё , этот шаблон меняет данные её полей алт, тайт и другие
		add_action( 'admin_footer-post.php', [ $this, 'modified_attachments_details_template'] );//менят вывод данных картинки при выборе её в медиатеке, данные меняются справа. ВАЖНО: менят данные не в фулскрине картинки , а просто при выборе картинки в медиатеке
	}

}

?>