<?php 
namespace KsnPlugin\moduls\wp_settings;

use KsnPlugin\moduls\Plagin_Moduls_Meneger;

class WP_Settings extends Plagin_Moduls_Meneger {

	protected $modul = 'wp_settings';
	
	protected $modul_grup = [
		'id' => 'base_settings', 
		'title' => 'Базовые настройки',
		'index_number' => '1'
	];

	protected $modul_name = [
		'id' => 'nastroyki_wp', 
		'title' => 'Настройки вордпресса',
		'index_number' => '2'
	];

	public function top_script_data(){
		return;
	}
}
?>