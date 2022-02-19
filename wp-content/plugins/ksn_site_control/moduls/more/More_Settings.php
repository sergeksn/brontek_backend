<?php 
namespace KsnPlugin\moduls\more;

use KsnPlugin\moduls\Plagin_Moduls_Meneger;

class More_Settings extends Plagin_Moduls_Meneger {

	protected $modul = 'more';

	protected $modul_grup = [
		'id' => 'more_settings', 
		'title' => 'Дополнительно',
		'index_number' => '6'	];

	protected $modul_name = [
		'id' => 'nastroyki_css_js', 
		'title' => 'Настройка CSS, JS',
		'index_number' => '1'
	];

	public function top_script_data(){
		return;
	}
}
?>