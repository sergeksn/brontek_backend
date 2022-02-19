<?php 
namespace KsnPlugin\base\events;

use KsnPlugin\KsnPlugin;

class Diactivation {
	static public function run(){
		$file = untrailingslashit( WP_CONTENT_DIR ) . '/advanced-cache.php';//находим файл advanced-cache.php

		//если файл advanced-cache.php в папке wp-content существует
		if (file_exists($file)) {
			KsnPlugin::$instance->main_func->advanced_cache_fill_action("delete");//удаляем файл advanced-cache.php в папке wp-content
		}
		//если файл advanced-cache.php в папке wp-content существует

		if(wp_next_scheduled('caching_and_new_page_list')){ wp_clear_scheduled_hook('caching_and_new_page_list'); }//если в кроне есть задача caching_and_new_page_list удаляем её

		KsnPlugin::$instance->main_func->wp_config_fill_edit('ksn_antibot/code/include.php');//оключаем антибот

		KsnPlugin::$instance->main_func->wp_config_fill_edit(KSN_PLAGIN_NAME.'/inc/Mobile_Detect.php');//оключаем проверку типов устройств пользователя

		KsnPlugin::$instance->main_func->wp_config_fill_edit("'WP_CACHE'", 'define( \'WP_CACHE\', false ); // KSN');//отключаем кеш
		KsnPlugin::$instance->main_func->wp_config_fill_edit("'WP_DEBUG'", 'define( \'WP_DEBUG\', false ); // KSN');//отключаем дебаг режим
		KsnPlugin::$instance->main_func->wp_config_fill_edit("'KSN_MOBILE_SITE_VERSIONS'");//удаляем константу мобильной весий сайта
		KsnPlugin::$instance->main_func->wp_config_fill_edit("'KSN_TABLET_SITE_VERSIONS'");//удаляем константу планшетной весий сайта
	}
}

?>