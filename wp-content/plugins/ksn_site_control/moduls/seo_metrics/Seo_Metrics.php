<?php 
namespace KsnPlugin\moduls\seo_metrics;

use KsnPlugin\moduls\Plagin_Moduls_Meneger;

class Seo_Metrics extends Plagin_Moduls_Meneger {

	protected $modul = 'seo_metrics';
	
	protected $modul_grup = [
		'id' => 'seo', 
		'title' => 'SEO',
		'index_number' => '2'
	];

	protected $modul_name = [
		'id' => 'seo_metrics', 
		'title' => 'Метрики',
		'index_number' => '3'
	];

	public function top_script_data(){
		return;
	}
}
?>