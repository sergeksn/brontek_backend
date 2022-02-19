<?php 
namespace KsnPlugin\moduls\recapcha;

use KsnPlugin\moduls\Plagin_Moduls_Meneger;

class Recapcha extends Plagin_Moduls_Meneger {

	protected $modul = 'recapcha';

	protected $modul_grup = [
		'id' => 'security', 
		'title' => 'Безопасность',
		'index_number' => '3'
	];

	protected $modul_name = [
		'id' => 'recarcha', 
		'title' => 'Рекапча',
		'index_number' => '2'
	];

	public function top_script_data(){
		return;
	}
}
?>