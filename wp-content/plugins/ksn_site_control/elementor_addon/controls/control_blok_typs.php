<?php
namespace KSN_Site_Konstruktor\Control;

use Elementor\Base_Data_Control;

class Control_blok_typs extends Base_Data_Control {


	const control_blok_typs = 'control_blok_typs';

    public function get_type() {
        return 'control_blok_typs';
    }

	public function enqueue() {
		wp_register_style( 'control_blok_typs', KSN_ELEMENTOR_ADDON_URL.'/controls/assets/css/control_blok_typs.css', array(), '1', 'all');
        wp_enqueue_style( 'control_blok_typs' );
	}


	public function content_template() {
		$img_url = KSN_ELEMENTOR_ADDON_URL.'/controls/assets/img';
		$control_uid = $this->get_control_uid();
		?>
		<# if ( data.label ) { #>
		<div class="elementor-control-title">{{{ data.label }}}</div>
		<br>
		<# } #>
		<div class="elementor-control-field">
			<div id="wrap_blok_tip" class="elementor-control-input-wrapper">
			<# if ( data.value.length ) { #>
                <# _.each( data.value, function( item ) { #>
                	<input id="input_blok_tip_{{ data.name }}_{{item}}" name="input_blok_tip_{{ data.name }}" type="{{ data.input_type }}" value="{{item}}" data-setting="{{ data.name }}">
					<label for="input_blok_tip_{{ data.name }}_{{item}}">
						<div class="img_select_block_type">
							<img src="<?php echo $img_url; ?>/{{data.papka_s_img}}/{{item}}.jpg">
						</div>
				    </label>
                <# }); #>
            <# } #>	
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}


	protected function get_default_settings() {
		return [
			'input_type' => 'radio',
		];
	}

}