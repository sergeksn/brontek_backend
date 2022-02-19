<?php 
namespace KsnPlugin\base\events;

use KsnPlugin\KsnPlugin;
use KsnPlugin\moduls\caching\base\Functions as Caching_Functions;

class Activation {
	static public function run(){
		global $wpdb;
		// задаем название таблицы
		$table_name = KSN_DB_TABLE;
		// проверяем есть ли в базе таблица с таким же именем, если нет - создаем.
		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			// устанавливаем кодировку
			$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";
			// подключаем файл нужный для работы с bd
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			// запрос на создание
			$sql = "CREATE TABLE {$table_name} (
			id int(11) unsigned NOT NULL auto_increment,
			setting_name varchar(255) NOT NULL,
			data longtext NOT NULL,
			PRIMARY KEY  (id),
			KEY setting_name (setting_name)
			) {$charset_collate};";
			// Создать таблицу.
			dbDelta($sql);

			$settings = json_decode(file_get_contents(KSN_PLAGIN_DIR."/data/settings.json"));//файл json с настройками по умолчанию

			//записываем в таблицу $table_name (wp_data_site) данные по умолчанию
			foreach ($settings as $name_setting => $data_setting) {
			    $data_setting = json_encode($data_setting);
			    $wpdb->query( "INSERT INTO $table_name ( setting_name, data ) VALUES ( '$name_setting', '$data_setting' ) " );
			}
			//записываем в таблицу $table_name (wp_data_site) данные по умолчанию
		}

		$cache_active = KsnPlugin::$instance->main_func->get_ksn_site_settings_data("cache", "cache_active");//проверяем нужно ли включить кеш
		$antibot_active = KsnPlugin::$instance->main_func->get_ksn_site_settings_data("security", "antibot_active");//проверяем нужно ли включить антибот
		$mobile_version = KsnPlugin::$instance->main_func->get_ksn_site_settings_data("site_settings", "site_mobile_version");//нужно ли выдавать отдельную мобильную версию сайта
		$tablet_version = KsnPlugin::$instance->main_func->get_ksn_site_settings_data("site_settings", "site_tablet_version");//нужно ли выдавать отдельную планшетную версию сайта

		KsnPlugin::$instance->main_func->create_page_list();//записываем все url страниц и записей в файл page_list.json, т.к. за время отключения плагина могла поменяться структура страниц

		KsnPlugin::$instance->main_func->wp_config_fill_edit("'WP_DEBUG'", 'define( \'WP_DEBUG\', false ); // KSN');//отключаем дебаг режим

		KsnPlugin::$instance->main_func->wp_config_fill_edit("'WP_AUTO_UPDATE_CORE'", 'define( \'WP_AUTO_UPDATE_CORE\', false ); // KSN');//отключаем автообновления вордпресса

		//если нужно включить кеш
		if($cache_active === "yes"){
			KsnPlugin::$instance->main_func->wp_config_fill_edit("'WP_CACHE'", 'define( \'WP_CACHE\', true ); // KSN');//включаем кеш

			$file = untrailingslashit( WP_CONTENT_DIR ) . '/advanced-cache.php';//находим файл advanced-cache.php
			//если файл advanced-cache.php в папке wp-content существует, есть вероятность что он создан другим плагином
			if (file_exists($file)) {
				KsnPlugin::$instance->main_func->advanced_cache_fill_action("delete");//удаляем файл advanced-cache.php в папке wp-content
			}
			//если файл advanced-cache.php в папке wp-content существует, есть вероятность что он создан другим плагином

			KsnPlugin::$instance->main_func->advanced_cache_fill_action("create");//создаём файл advanced-cache.php в папке wp-content

			$planned_cache_value = KsnPlugin::$instance->main_func->get_ksn_site_settings_data("cache", "cache_planed_update");//получаем из бд значение настройки планового кеширования
			(new Caching_Functions())->active_planed_caching($planned_cache_value);//если нужно включаем плановое кеширование
		}
		//если нужно включить кеш

		//если нужно включить антибот
		if($antibot_active === "yes"){
			KsnPlugin::$instance->main_func->wp_config_fill_edit('ksn_antibot/code/include.php', 'if($_SERVER[\'HTTP_USER_AGENT\'] !== "KSN_site_caching_mobile" && $_SERVER[\'HTTP_USER_AGENT\'] !== "KSN_site_caching_tablet" && $_SERVER[\'HTTP_USER_AGENT\'] !== "KSN_site_caching_desktop"){ require_once($_SERVER[\'DOCUMENT_ROOT\'].\'/wp-content/plugins/'.KSN_PLAGIN_NAME.'/moduls/antibot/ksn_antibot/code/include.php\'); }// KSN ANTIBOT');//включаем антибот
		}
		//если нужно включить антибот

		//нужно ли выдавать отдельную мобильную версию сайта
		if($mobile_version === "yes"){
			KsnPlugin::$instance->main_func->wp_config_fill_edit("'KSN_MOBILE_SITE_VERSIONS'", 'define( \'KSN_MOBILE_SITE_VERSIONS\', true ); // KSN мобильная версия сайта');//включаем мобильную версию
		} else {
			KsnPlugin::$instance->main_func->wp_config_fill_edit("'KSN_MOBILE_SITE_VERSIONS'", 'define( \'KSN_MOBILE_SITE_VERSIONS\', false ); // KSN мобильная версия сайта');//выключаем мобильную версию
		}
		//нужно ли выдавать отдельную мобильную версию сайта

		//нужно ли выдавать отдельную планшетную версию сайта
		if($tablet_version === "yes"){
			KsnPlugin::$instance->main_func->wp_config_fill_edit("'KSN_TABLET_SITE_VERSIONS'", 'define( \'KSN_TABLET_SITE_VERSIONS\', true ); // KSN планшетная версия сайта');//включаем планшетную версию
		} else {
			KsnPlugin::$instance->main_func->wp_config_fill_edit("'KSN_TABLET_SITE_VERSIONS'", 'define( \'KSN_TABLET_SITE_VERSIONS\', false ); // KSN планшетная версия сайта');//выключаем планшетную версию
		}
		//нужно ли выдавать отдельную планшетную версию сайта

		KsnPlugin::$instance->main_func->wp_config_fill_edit(KSN_PLAGIN_NAME.'/inc/Mobile_Detect.php', 'require_once($_SERVER[\'DOCUMENT_ROOT\'].\'/wp-content/plugins/'.KSN_PLAGIN_NAME.'/inc/Mobile_Detect.php\');// KSN Mobile Detect');///включаем проверку типов устройств пользователя
	}
}

?>