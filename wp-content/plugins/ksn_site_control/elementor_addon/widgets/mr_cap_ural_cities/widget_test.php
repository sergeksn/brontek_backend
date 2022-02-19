<?php
namespace KSN_Site_Konstruktor\Widget;

use KSN_Site_Konstruktor\Control\Custom_Media_Uploader;
use KSN_Site_Konstruktor\Control\Media_Podborka;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Elementor_Test_Widget extends Widget_Base {
	public function get_name() {
		return 'test_wijet';
	}
	public function get_title() {
		return 'TEST';
	}
	public function get_icon() {
		return 'eicon-image-bold';
	}
	public function get_categories() {
		return [ 'shablon_sayta' ];
	}
	
	protected function register_controls() {


		$this->start_controls_section(
			'setting_blok_section',
			[
				'label' => 'Настройка шаблона',
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'test',
			[
				'label' => 'custom_media_uploader',
				'type' => Custom_Media_Uploader::custom_media_uploader,
				'default' => [],
				'description' => 'Текст название города',
			]
		);
		$this->add_control(
			'test2',
			[
				'label' => 'custom_media_uploader2',
				'type' => Custom_Media_Uploader::custom_media_uploader,
				'default' => [],
				'description' => 'Текст название города',
			]
		);
		$this->add_control(
			'test_2',
			[
				'label' => 'media_podborka',
				'type' => Media_Podborka::media_podborka,
				'default' => [],
				'description' => 'Текст название города',
			]
		);
		$this->add_control(
			'image',
			[
				'label' => 'MEDIA',
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
			]
		);
		$this->add_control(
			'image2',
			[
				'label' => 'MEDIA2',
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
			]
		);
		$this->add_control(
			'gallery',
			[
				'label' => 'GALLERY',
				'type' => Controls_Manager::GALLERY,
				'default' => [],
			]
		);
		$this->end_controls_section();


	}

	protected function render() {//render
		$settings = $this->get_settings_for_display();
		//print_r($settings['selected_icon']);
		//print_r($settings['selected_icon_2']);
	?>

	<div class="stroka_1"><?php //echo $settings['text']; ?></div>

	




<?php }//render

protected function _content_template() { ?>


		<?php
	}//_content_template

	
}	