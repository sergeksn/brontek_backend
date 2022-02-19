<?php 
namespace KsnPlugin\moduls\main_seo;

use KsnPlugin\moduls\Plagin_Moduls_Meneger;

class Main_Seo extends Plagin_Moduls_Meneger {

	protected $modul = 'main_seo';
	
	protected $modul_grup = [
		'id' => 'seo', 
		'title' => 'SEO',
		'index_number' => '2'
	];

	protected $modul_name = [
		'id' => 'seo_main', 
		'title' => 'Основные',
		'index_number' => '1'
	];
	
	public function top_script_data(){

	}
}
?>