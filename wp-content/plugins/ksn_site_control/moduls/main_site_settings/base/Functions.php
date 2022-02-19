<?php 
namespace KsnPlugin\moduls\main_site_settings\base;

use KsnPlugin\KsnPlugin;
use KsnPlugin\moduls\Plagin_Moduls_Meneger;

class Functions extends Plagin_Moduls_Meneger{

	//включаем/выключаем мообильную версию сайта
	public function switch_mobile_site_version($value){
		if($value === "yes"){
			KsnPlugin::$instance->main_func->wp_config_fill_edit("'KSN_MOBILE_SITE_VERSIONS'", 'define( \'KSN_MOBILE_SITE_VERSIONS\', true ); // KSN мобильная версия сайта');//включаем мобильную версию
		}

		if($value === "no"){
			KsnPlugin::$instance->main_func->wp_config_fill_edit("'KSN_MOBILE_SITE_VERSIONS'", 'define( \'KSN_MOBILE_SITE_VERSIONS\', false ); // KSN мобильная версия сайта');//выключаем мобильную версию
		}
	}
	//включаем/выключаем мообильную версию сайта

	//включаем/выключаем планшетную версию сайта
	public  function switch_tablet_site_version($value){
		if($value === "yes"){
			KsnPlugin::$instance->main_func->wp_config_fill_edit("'KSN_TABLET_SITE_VERSIONS'", 'define( \'KSN_TABLET_SITE_VERSIONS\', true ); // KSN планшетная версия сайта');//включаем планшетную версию
		}

		if($value === "no"){
			KsnPlugin::$instance->main_func->wp_config_fill_edit("'KSN_TABLET_SITE_VERSIONS'", 'define( \'KSN_TABLET_SITE_VERSIONS\', false ); // KSN планшетная версия сайта');//выключаем планшетную версию
		}
	}
	//включаем/выключаем планшетную версию сайта

}

?>