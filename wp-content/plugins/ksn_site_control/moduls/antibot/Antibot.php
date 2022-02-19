<?php 
namespace KsnPlugin\moduls\antibot;

use KsnPlugin\moduls\Plagin_Moduls_Meneger;

class Antibot extends Plagin_Moduls_Meneger {

	protected $modul = 'antibot';
	
	protected $modul_grup = [
		'id' => 'security', 
		'title' => 'Безопасность',
		'index_number' => '3'
	];

	protected $modul_name = [
		'id' => 'antibot', 
		'title' => 'Антибот',
		'index_number' => '1'
	];

	public function top_script_data(){
		return;
	}
}
?>