<?php 
namespace KsnPlugin\moduls\meta_settings;

use KsnPlugin\moduls\Plagin_Moduls_Meneger;

class Meta_Settings extends Plagin_Moduls_Meneger {

	protected $modul = 'meta_settings';

	protected $modul_grup = [
		'id' => 'seo', 
		'title' => 'SEO',
		'index_number' => '2'
	];

	protected $modul_name = [
		'id' => 'seo_meta', 
		'title' => 'Мета-настройки',
		'index_number' => '2'
	];

	public function top_script_data(){
		return;
	}
}
?>