<?php
namespace KSN_Site_Konstruktor\Control;

use Elementor\Control_Base_Multiple;

class Media_Podborka extends Control_Base_Multiple {

	const media_podborka = 'media_podborka';
	
	public function get_type() {
		return 'media_podborka';
	}

    public function enqueue() {
        wp_enqueue_media();
        wp_enqueue_script( 'thickbox' );
        wp_enqueue_style( 'thickbox' );
        wp_register_script( 'media_podborka', KSN_ELEMENTOR_ADDON_URL.'/controls/assets/js/media_podborka.js', [ 'jquery' ], true );
        wp_enqueue_script( 'media_podborka', array( 'jquery' ) );
        wp_register_style( 'media_podborka', KSN_ELEMENTOR_ADDON_URL.'/controls/assets/css/media_podborka.css', array(), '1', 'all');
        wp_enqueue_style( 'media_podborka' );
    }

    public function get_default_value() {
        return [];
    }


    protected function get_default_settings() {
        return [
            'button_text' => 'Выбрать картинку',
            'toggle' => true,
            'media_type' => 'image'
        ];
    }

	public function content_template() {
        $control_uid = $this->get_control_uid();
        ?>
		<div class="elementor-control-field">
			<div class="elementor-control-title">{{{ data.label }}}</div>
			<div class="elementor-control-input-wrapper">
				<div class="elementor-control-media__content elementor-control-tag-area">
					<div class="elementor-control-gallery-status elementor-control-dynamic-switcher-wrapper">
						<span class="elementor-control-gallery-status-title"></span>
						<span class="elementor-control-gallery-clear elementor-control-unit-1"><i class="eicon-trash-o" aria-hidden="true"></i></span>
					</div>
					<div class="elementor-control-gallery-content">
						<div class="elementor-control-gallery-thumbnails"></div>
						<div class="elementor-control-gallery-edit"><span><i class="eicon-pencil" aria-hidden="true"></i></span></div>
						<button class="elementor-button elementor-control-gallery-add" title="Добавить изображения"><i class="eicon-plus-circle" aria-hidden="true"></i></button>
					</div>
				</div>
			</div>
			<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
			<# } #>
		</div>



        <?php
    }

}
