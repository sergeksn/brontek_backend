<?php 
namespace KsnPlugin\moduls\main_site_settings;

use KsnPlugin\moduls\Plagin_Moduls_Meneger;

class Main_Site_Settings extends Plagin_Moduls_Meneger {

	protected $modul = 'main_site_settings';
	
	protected $modul_grup = [
		'id' => 'base_settings', 
		'title' => 'Базовые настройки',
		'index_number' => '1'
	];

	protected $modul_name = [
		'id' => 'nastroyki_site', 
		'title' => 'Настройки сайта',
		'index_number' => '1'
	];

	public function top_script_data(){
		ob_start();//запуск буферизации вывода
		echo "\r\ndata_ksn.wait_before_save_settings = {};//если нужно чего-то дождаться перед сохранением настроек";
		echo "\r\ndata_ksn.errors = {};//тут будут записываться ошибки";
		echo "\r\ndata_ksn.errors.was_color_input_error = {};//тут будут записываться ошибки в воде цвета";
		echo "\r\ndata_ksn.errors.was_color_empty_input_error = {};//тут будут записываться ошибки когда был задан пустой цвет";

		return ob_get_clean();//получаем всё содержимое буфера и очищаем его, возвращаем полученый код скрипта
	}

}

?>