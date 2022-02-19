<?php 
namespace KsnPlugin\moduls\integrations_chat;

use KsnPlugin\moduls\Plagin_Moduls_Meneger;

class Online_Chat extends Plagin_Moduls_Meneger {

	protected $modul = 'integrations_chat';
	
	protected $modul_grup = [
		'id' => 'integrations', 
		'title' => 'Интеграции',
		'index_number' => '5'	];

	protected $modul_name = [
		'id' => 'online_chat', 
		'title' => 'Онлайн чат',
		'index_number' => '1'
	];

	public function top_script_data(){
		return;
	}
}
?>