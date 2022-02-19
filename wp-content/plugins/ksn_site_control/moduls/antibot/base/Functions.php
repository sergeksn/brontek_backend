<?php 
namespace KsnPlugin\moduls\antibot\base;

use KsnPlugin\KsnPlugin;
use KsnPlugin\moduls\Plagin_Moduls_Meneger;

class Functions extends Plagin_Moduls_Meneger{

	//функция подключает/отключает антибот в файле wp-config.php
	public function antibot_include($value){
		if($value === "yes"){
			KsnPlugin::$instance->main_func->wp_config_fill_edit('ksn_antibot/code/include.php', 'if($_SERVER[\'HTTP_USER_AGENT\'] !== "KSN_site_caching_mobile" && $_SERVER[\'HTTP_USER_AGENT\'] !== "KSN_site_caching_tablet" && $_SERVER[\'HTTP_USER_AGENT\'] !== "KSN_site_caching_desktop"){ require_once($_SERVER[\'DOCUMENT_ROOT\'].\'/wp-content/plugins/'.KSN_PLAGIN_NAME.'/moduls/antibot/ksn_antibot/code/include.php\'); }// KSN ANTIBOT');//включаем антибот
		}

		if($value === "no"){
			KsnPlugin::$instance->main_func->wp_config_fill_edit('ksn_antibot/code/include.php');
		}
	}
	//функция подключает/отключает антибот в файле wp-config.php
}

?>