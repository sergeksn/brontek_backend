<?php 
namespace KsnPlugin\moduls\caching;

use KsnPlugin\KsnPlugin;
use KsnPlugin\moduls\Plagin_Moduls_Meneger;

class Caching extends Plagin_Moduls_Meneger {

	protected $modul = 'caching';

	protected $modul_grup = [
		'id' => 'caching_settings', 
		'title' => 'Кеширование',
		'index_number' => '4'
	];

	protected $modul_name = [
		'id' => 'nastroyki_cecha', 
		'title' => 'Настройка кеша',
		'index_number' => '1'
	];

	public function top_script_data(){
		ob_start();
		echo "\r\ndata_ksn.cache = {};//сюда записываем всё для кеширования";
		echo "\r\ndata_ksn.cache_need_to_update = {
			'settings_update': '".KsnPlugin::$instance->main_func->get_ksn_site_settings_data("cache", "settings_update")."'//показывает сообщение что нужно обновить кеш
		};";
		if(KsnPlugin::$instance->main_func->get_redis("status", "ksn_cache") && KsnPlugin::$instance->main_func->get_redis("status", "ksn_cache") !== "finishid"){
			$redis = KsnPlugin::$instance->main_func->connect_redis(); 
			$length = $redis->hLen("ksn_log_caching");

			echo "\r\ndata_ksn.load_pri_starte_page = 'yes';";
			echo "\r\ndata_ksn.cache = {
				'amount': ".KsnPlugin::$instance->main_func->get_redis("amount", "ksn_cache").",//number 
				'progress': ".KsnPlugin::$instance->main_func->get_redis("progress", "ksn_cache").",//number
				 'log': {";

				 	for($i = 0; $i < $length; $i++){
				 		$log = KsnPlugin::$instance->main_func->get_redis("$i", "ksn_log_caching"); 
				 		echo "$i : \"$log\",\n";
				 	}
			echo "\r\n}";//log
			echo "\r\n};";//data_ksn.cache
		}
		
		echo "\r\ndata_ksn.cache_last_update = '".KsnPlugin::$instance->main_func->get_ksn_site_settings_data("cache", "cache_last_update_time")."';//дата последнего успешного кеширования";
		
		return ob_get_clean();
	}
}
?>